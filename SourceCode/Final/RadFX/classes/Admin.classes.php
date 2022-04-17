<?php
/**
 * Controls the admin functionality for the request form and the admin functionality to add fields to all the forms on the site
 * @author ETurner
 */
class Admin extends Database {

    /**
     * Takes a name, a variable type, and a description and inserts a column to the selected table in the database
     * @param names a string containing what the admin wants to name the column
     * @param types a string containing the type of the new column
     * @param comments a string containing the comment for the selected column
     * @param table the table to be updated in the database
     */
    public function addColumn($name, $type, $comment, $table) {
        //connect to the database
        $conn = $this->connect();
        //check if name has any incorrect characters
        $name = strtolower(str_replace(" ", "_", $name));
        if(!$this->formatCorrect($name)) {
            header("location: ../Admin.php?error=request_name_check");
            exit();
        }
        //check if comment has any incorrect characters
        if(!$this->confirmFormat(strtolower(str_replace(" ", "_",$comment)))) {
            header("location: ../Admin.php?error=request_description_check");
            exit();
        }
        //confirm the column name doesnt already exist in the table
        if($this->checkColumnName($table, $name)) {
            header("location: ../Admin.php?error=request_name_match");
            exit();
        }
        //convert the type to correct format for the database or return an error if input was incorrect
        $type = strtoupper((string)$type);
        if($type == "NUMBER") {
            $type = "decimal(10,2)";
        } else if($type == "VAR") {
            $type = "varchar(60)";
        } else if($type == "DATE") {
            $type = "datetime";
        } else {
            header("location: ../Admin.php?error=request_type_check");
            exit();
        }
        //add column to the selected database table based on provided information
        $sql = $conn->prepare("ALTER TABLE $table ADD $name $type COMMENT '$comment';");
        $sql->execute();
        $sql = null;

        //get the amount of fields already in the table so you can set the default sort number
        $sql = $conn->prepare("SELECT * FROM fields WHERE table_name = '$table';");
        if(!$sql->execute()) {
            $sql = null;
            header("location: ../Admin.php?error=prepare");
            exit();
        }
        $count = $sql->rowCount();

        //add the field to the fields table
        $sql = $conn->prepare("INSERT INTO `fields` (`field_name`, `table_name`, `hidden`, `order_num`) VALUES (?, ?, ?, ?);");

        if(!$sql->execute(array($name, $table, 0, $count))) {
            $sql = null;
            header("location: ../Admin.php?error=prepare");
            exit();
        }
        $sql= null;
    }

    /**
     * check if string contains only spaces and lowercase and uppercase letters
     * @param str the string to be checked
     * @return returns true if format is correct
     */
    private function formatCorrect($str) {
        //if(preg_match('/(?!;)[a-zA-Z]$/', $str)) {
        if(preg_match('/^[a-zA-Z_]*$/', $str)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check if string contains only spaces, allowed special characters, and lowercase and uppercase letters
     * @param str the string to be checked
     * @return returns true if format is correct
     */
    private function confirmFormat($str) {
        if(preg_match("/^[-a-zA-Z0-9@,._:#]*$/", $str)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Takes submitted info and checks for the keys for any titled "remove", if it finds any then it removes the field of the selected name from the database
     * @param post_info post_info[the table the columns are being removed from][the column name such as "total_hours" "purpose of test" or "vacuum"][the field type for the column such as "remove" "name" "type or "comment"]the associative multidemensional array containing information submitted by the user through a form
     * @param name the table name
     * @param conn the connection to the database
     * @return post_info the submitted column information minus the newly removed columns
     */
    private function removeColumns($post_info, $name, $conn) {
        //check if the any information regarding the table has been submitted
        if(!array_key_exists($name, $post_info)) {
            return $post_info;
        }
        $request_info = [];// the information being entered into the columns

        //get all the fields that cannot be removed from the table
        include_once 'FieldController.classes.php';
        $field_controller = new FieldController();
        $unbreakable_fields = $field_controller->getUnbreakableFields($name);

        //loop through the submitted information removing columns
        for($y = 0; $y < count($post_info[$name]); $y++) {
            //the column names that the user is wanting to edit
            $column_name = array_keys($post_info[$name])[$y];
            //double check if the field can be removed, return to admin with error if an incorrect field was submitted
            if(in_array($column_name, $unbreakable_fields)) { 
                header("location: ../Admin.php?error=unbreakable_field");
                exit();
            }

            //loop through information associated with the column and edit it
            for($x = 0; $x < count($post_info[$name][$column_name]); $x++) {
                $type_info = array_keys($post_info[$name][$column_name]);
                //the actual field name of the selected column such as "name", "comment","type" or a custom field "remove"
                $type = $type_info[$x];
                if($type != "remove") { break; } //if the type is not remove then go to the next column
                $value = "";
                // if the remove checkbox is on then add the column_name to the array of columns that are going to be removed and remove the column from the submitted info
                if($post_info[$name][$column_name][$type] == "on") {
                    $value = $column_name;
                    array_push($request_info, $value);
                    unset($post_info[$name][$column_name]);
                    $y--;
                    break;
                }
            }
        }

        // if there are columsn selected for removal then remove them all
        if(count($request_info) > 0) {
            //format for sql prepare statement
            $column_list = join(', DROP COLUMN ', $request_info);

            //drop the column
            $sql = $conn->prepare("ALTER TABLE $name DROP COLUMN $column_list;");
            $sql->execute();
            $sql = null;

            $column_list = join(', ', $request_info);
            //remove the column field from the fields table
            for($x = 0; $x < count($request_info); $x++) {


                $field = $request_info[$x];
                $sql = $conn->prepare("DELETE FROM fields WHERE table_name = '$name' AND field_name = '$field';");

                if(!$sql->execute()) {
                    $sql = null;
                    header("location: ../Admin.php?error=prepare");
                    exit();
                }
                $sql= null;
            }
        }

        return $post_info;
    }

    /**
     * edits columns in the selected table
     * @param post_info post_info[the table the columns selected for edit][the column name such as "total_hours" "purpose of test" or "vacuum"][the field type for the column such as "remove" "name" "type or "comment"]the associative multidemensional array containing information submitted by the user through a form
     * @param name the table name
     */
    public function editColumns($post_info, $name) {
        //connect to the database
        $conn = $this->connect();

        //remove any columns selected for removal first
        $post_info = $this->removeColumns($post_info, $name, $conn);

        $request_info = [];// the information being entered into the columns
        $name_info = [];// the name of the columns
        $key_info = array_keys($post_info["form"]);

        //loop through the column fields and edit them
        for($y = 0; $y < count($key_info); $y++) {
            //the column names that the user is wanting to edit
            $field = $key_info[$y];
            //loop through the individual information associated with the field and edit them
            for($x = 0; $x < count($post_info["form"][$field]); $x++) {
                $type_info = array_keys($post_info["form"][$field]);
                //the column names that the user is wanting to edit
                $type = $type_info[$x];
                if($type == "field_name") {continue; }
                $value = "";
                if($post_info["form"][$field][$type] == "") {
                    $value = NULL;
                } else if($post_info["form"][$field][$type] == "on") {
                    $value = 1;
                } else {
                    $value = $post_info["form"][$field][$type];
                }
                //check if the user input has any incorrect characters
                if(!$this->formatCorrect(strtolower(str_replace(" ", "_", $type))) || !$this->confirmFormat(str_replace(" ", "_",$value))) {
                    header("location: ../Admin.php?error=request_name_check");
                    exit();
                }
                array_push($request_info, $value);
                $type_str = "`".$type.'`=?';
                array_push($name_info, $type_str);
                
            }
            //set the new sorting order number for the column field
            array_push($request_info, $y);
            array_push($name_info, '`order_num`=?');

            $column_list = join(',', $name_info);

            //prepare the sql statement
            $sql = $conn->prepare("UPDATE fields SET $column_list WHERE field_name = '$field' AND table_name = '$name';");
            
            //update the fields for the table being edited
            if(!$sql->execute($request_info)) {
                $sql = null;
                header("location: ../Admin.php?error=prepare");
                exit();
            }
            $sql = null;
            $request_info = [];
            $name_info = [];
        }
    }

    /**
     * Check if the column name already exists in the table
     * @param table the table name
     * @param name the column name
     * @return true if the column name already exists in the table
     */
    public function checkColumnName($table, $name) {
        $sql = $this->connect()->prepare("DESCRIBE $table");
        $sql->execute();
        $column_info = $sql->fetchAll(PDO::FETCH_COLUMN);

        if(in_array($name, $column_info)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the field name already exists in the table
     * @param table the table name
     * @param name the column value
     * @param field the field name
     * @param location the page requesting this check
     * @return true if the column name already exists in the table
     */
    public function checkFieldMatch($table, $field, $name, $location) {
        $sql = $this->connect()->prepare("SELECT * FROM $table WHERE $field = $name;");
        
        //if sql statement fails return to appropriate page with error
        if(!$sql->execute()) {
            $sql = null;
            header("location: ../".$location.".php?error=prepare");
            exit();
        }

        if($sql->rowCount() == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param password the submitted admin password
     * @return true if the password matches
     */
    public function confirmPassword($password) {
        session_start();
        $sql = $this->connect()->prepare("SELECT * FROM user WHERE user_id = ?;");
        //if sql statement fails return to admin page with error
        if(!$sql->execute(array($_SESSION['id']))) {
            $sql = null;
            header("location: ../admin.php?error=prepare");
            exit();
        }
        //if no users with the submitted id exist return to admin with error
        if($sql->rowCount() == 0) {
            $sql = null;
            header("location: ../admin.php?error=prepare");
            exit();
        }

        //get password of the feteched user, hash the submitted password, and then verify if they match
        $user = $sql->fetchAll(PDO::FETCH_ASSOC);
        $passwordHash = $user[0]["password"];
        $verifyPassword = password_verify($password, $passwordHash);

        //if they dont match return with error 
        if($verifyPassword == false) {
            $sql = null;
            return false;
        } else if($verifyPassword == true) {
            $sql = null;
            return true;
        }

        $sql = null;
        return false;
    }
}