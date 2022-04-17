<?php
/**
 * Controls the admin functionality for managing users in the system.
 * @author ETurner 
 */
class UserApproval extends Database {
    /**
     * @param post_info the associative array containing all the updated user information
     */
    public function updateUsers($post_info) {
        include_once "../classes/Contact.classes.php";
        $contact = new Contact();//the phpmailer
        $conn = $this->connect();//connection to the database

        //get all the admins
        $sql = $this->connect()->prepare("SELECT user_id FROM user where role_id = 3;");

        //if sql statement fails return to admin page with error
        if(!$sql->execute()) {
            $sql = null;
            header("location: ../Admin.php?error=prepare");
            exit();
        }

        //make sure there is at least one admin
        if($sql->rowCount() == 0) {
            $sql = null;
            header("location: ../Admin.php?error=admin_count");
            exit();
        }
        $post_info["last_admin_ids"]= $sql->fetchAll(PDO::FETCH_COLUMN, 0);//the admin ids

        //remove selected users form the database
        $post_info = $this->rejectUsers($post_info, $conn);

        //loop through the submitted users and edit them according to user input
        for($y = 0; $y < count($post_info["user"]); $y++) {
            //the column names that the user is wanting to edit
            $user_id = array_keys($post_info["user"])[$y];
            $request_info = [];// the information being entered into the columns
            $name_info = [];// the name of the columns
            $role_mail = "";
            $aff_mail = "";
            //check if the user has been altered at all
            if(array_key_exists("altered", $post_info["user"][$user_id]) && $post_info["user"][$user_id]["altered"] == 1) {
               //check if user's affiliation was changed and if so update the email message
                if(array_key_exists("affiliation_id", $post_info["user"][$user_id])) {
                    array_push($request_info, $post_info["user"][$user_id]["affiliation_id"]);
                    array_push($name_info, "affiliation_id=?");
                    $aff_mail = "Affiliation changed.\n";
                }
                //check if user's role was changed and if so update the email message
                if(array_key_exists("role_id", $post_info["user"][$user_id])) {
                    array_push($request_info, $post_info["user"][$user_id]["role_id"]);
                    array_push($name_info, "role_id=?");
                    $role_mail = "Role changed.\n";
                    //if user was an admit, temporarily remove them from the admin id list
                    if(in_array($user_id, $post_info["last_admin_ids"])) {
                        unset($post_info["last_admin_ids"][array_search($user_id, $post_info["last_admin_ids"])]);
                    }
                }
            }
            //format sql statement
            $column_list = join(',', $name_info);

            //double check that once all selected admins have been removed that there is at least one left
            if(count($post_info["last_admin_ids"]) <= 0) {
                $sql = null;
                header("location: ../Admin.php?error=admin_count");
                exit();
            }

            //check if any users are left to be edited
            if($column_list != "") {
                //contact user and let them know that a change has occured
                $contact->mailCustom($user_id, "Account Updated", "Dear user,\nThe following changes have been made to your RadFX account: ".$role_mail."".$aff_mail)."Please log into your account to verify these changes at your earliest convenience.\n\nWelcome To RadFX! \n\n\nMessage Sent From radfx.research.utc.edu";
                
                //update the user with the new information
                $sql = $conn->prepare("UPDATE user SET $column_list WHERE user_id = $user_id;");
                if(!$sql->execute($request_info)) {
                    exit();
                    $sql = null;
                    header("location: ../Admin.php?error=prepare");
                    exit();
                }
        
                $sql = null;
            }
        }

    }

    /**
     * remove user from the user table in the database
     * @param post_info the id information submitted by the user through a form
     * @return post_info the remaining users after some have been removed
     */
    public function rejectUsers($post_info, $conn) {
        include_once "../classes/Contact.classes.php";
        $contact = new Contact();// the phpmailer

        $request_info = [];// the information being entered into the columns
        //loop through the users and remove them from the database
        for($y = 0; $y < count($post_info["user"]); $y++) {
            $user_id = array_keys($post_info["user"])[$y];//the selected user's id
            
            // if they were selected to be removed, prepare for their removal
            if(array_key_exists("remove", $post_info["user"][$user_id])) {
                if($post_info["user"][$user_id]["remove"] == "on") {
                    array_push($request_info, $user_id);
                    unset($post_info["user"][$user_id]);
                    $y--;
                    //if user was an admit, temporarily remove them from the admin id list
                    if(in_array($user_id, $post_info["last_admin_ids"])) {
                        unset($post_info["last_admin_ids"][array_search($user_id, $post_info["last_admin_ids"])]);
                    }
                }
            }
        }
        //format sql statement
        $column_list = join(',', $request_info);

        //double check that once all selected admins have been removed that there is at least one left
        if(count($post_info["last_admin_ids"]) <= 0) {
            $sql = null;
            header("location: ../Admin.php?error=admin_count");
            exit();
        }
        
        //check to make sure there are still users that need to be edited
        if($column_list != "") {

            for($y = 0; $y < count($request_info); $y++) {
                $contact->mailCustom($request_info[$y], "Account Rejected", "Dear user,\nAfter some review, your account has been rejected from our RADFX system. If this has been done in error, please contact us regarding your account.\n\n Sorry for the inconvenience! \n\n\n Message Sent From radfx.research.utc.edu");
            }
            
            //delete user with selected id from the database
            $sql = $conn->prepare("DELETE FROM user WHERE user_id IN ($column_list);");
            //if sql statement fails return to admin page with error
            if(!$sql->execute()) {
                $sql = null;
                header("location: ../Admin.php?error=prepare");
                exit();
            }
            $sql = null;

        }

        return $post_info;
    }

    /**
     * edits the users with the desire role
     * @param post_info post_info[the input name] the associative array containing information submitted by the user through a form
     */
    public function changeUserRoles($post_info) {
		
		$keys = array_keys($post_info);
        $id = $post_info["id"];
        $role = $post_info["role"];
		
		
		if($role == "tester") {
			$role_id = 1;
		} else if($role == "integrator") {
			$role_id = 2;
		} else if($role == "admin") {
			$role_id = 3;
		} else if($role == "waiting") {
			$role_id = 0;
		}
		
		//update the user with the selected role
		$sql = $this->connect()->prepare("UPDATE user SET role_id = ? Where user_id = ?;");
		//if sql statement fails return to admin page with error
		if(!$sql->execute(array($role_id, $id))) {
			$sql = null;
			header("location: ../Admin.php?error=prepare");
			exit();
		}
		$sql = null;
		
		
   
    }
}