<?php
/**
 * edits already submitted request information and updates any calendar events associated with the request
 * @author ETurner
 */
class EditRequest extends Database {
    
     /**
     * attempt to save a request based on user submitted information
     * @param post_info the submitted information
     */
    public function editThisRequest($post_info) {
        $this->saveRequest($post_info);
    }

    /**
     * cancel a submitted request and remove its associated event from the database
     * @param post_info the input information for the request being cancelled
     * @return user_id the id of the user who the request belongs to
     */
    public function cancelRequest($post_info) {
        $req_id = $post_info["request_id"];//the request

        $conn = $this->connect();//the connection to the database
        //remove all calendar events associated with the request
        $sql = $conn->prepare("DELETE FROM calendar_events WHERE request_id = ?;");
                
        //if sql statement fails return to edit request page with error
        if(!$sql->execute(array($req_id))) {
            $sql = null;
            $error_location = "location: ../EditRequest.php?req_id=".$req_id."&error=prepare";
            header($error_location);
            exit();
        }
        $sql = null;

        //get the user id from the database so the mailer can update them their request was canceled/declined
        $sql = $conn->prepare("SELECT user_id FROM request where request_id = $req_id;");
        $sql->execute();

        $user_id = $sql->fetchAll(PDO::FETCH_ASSOC)[0]["user_id"];
        return $user_id;
    }

    /**
     * create an event for the calendar and submit it to the database
     * @param earliest_date the submitted start date
     * @param total_hours the total hours submitted
     * @param organization the affiliation of the user who the request belongs to
     * @param purpose_of_test the submitted name of the test
     * @param facility_id the facility id the test is for
     * @param request_id the request created when the form was submitted
     * @param energy the highest energy level of the request
     * @param ion_string a string containing all the ion information for the request
     * @param conn the database connection
     * @param schedule_group the name of the user/organization submitting the request
     */
    private function editEvent($earliest_date, $total_hours, $organization, $purpose_of_test, $facility_id, $request_id, $energy, $ion_string, $conn, $schedule_group) {
       
		include_once 'CalendarControl.classes.php';
		$cc = new CalendarControl();
		
		$cc->commitEditedEvent($earliest_date, $total_hours, $organization, $purpose_of_test, $facility_id, $request_id, $energy, $ion_string, $conn, $schedule_group);
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
     * adds a request to the request table in the database
     * @param post_info post_info[the input name] the associative array containing information submitted by the user through a form
     */
    private function saveRequest($post_info) {
        $request_info = []; // the information being entered into the columns
        $name_info = []; // the name of the columns
        $req_id = $post_info['request_id'];//the request id
        $facility_id = $post_info['facility'];//the facility for the request
        $key_info = array_keys($post_info["request"][$req_id]);
        $value_str = "";
        $energy_level = $post_info['energy_level'];//the highest energy being submitted
        //set the organization of the user submitting the request
        $organization = "none";
        if(array_key_exists("affiliation_name", $post_info["request"][$req_id])) {
            $organization = $post_info["request"][$req_id]["affiliation_name"];
        }
        //set the name of the user/organization submitting the request
        $schedule_group = "none";
        if($_SESSION["fullname"] != null) {
            $schedule_group = $_SESSION["fullname"];
        }
        // go through all the submitted information, edit them to correct submission format, and then put them into arrays for submission
        for($x = 0; $x < count($post_info["request"][$req_id]); $x++) {
            $name = $key_info[$x];// the name of the column
            $value = "";// the value being entered into the column
            $early_exit = false;
            if($name == "facility") { //if the submission key is facility then set the name of the column to facility_id
                $value = $post_info["request"][$req_id][$name];
                $name = "facility_id";
            } else if($name == "searchbar" || $name == "ion") {//skip the input if the key is searchbar or ion as they are either not submitted or submitted seperately
                continue;
            }
            else if($post_info["request"][$req_id][$name] == "on") {// convert any checkboxes into binary true
                $value = "1";
            }else if($post_info["request"][$req_id][$name] == "") {// convert any checkboxes into binary true
                $value = NULL;
            } else {
                $value = $post_info["request"][$req_id][$name];// the values put into the form
            }
            //check if input has any incorrect characters
            if(!$this->formatCorrect(strtolower(str_replace(" ", "_", $name))) || !$this->confirmFormat(str_replace(" ", "_",$value))) {
                header("location: ../EditRequest.php?error=request_name_check");
                exit();
            }
            // format for sql statement "column_name = ?"
            $name .= " = ?";
            //push the column name and the value into their respective arrays
            array_push($request_info, $value);
            array_push($name_info, $name);
        }
        //add the facility id to respective arrays
        array_push($request_info, $facility_id);
        array_push($name_info, "facility_id=?");
        //add the user id to respective arrays
        array_push($name_info, "user_id=?");
        array_push($request_info, $_SESSION['id']);

        //format for sql prepare statement
        $column_list = join(',', $name_info);

        $conn = $this->connect();//the database connection
        // inset the new request into the request table with the inputted values
        $sql = $conn->prepare("UPDATE request SET $column_list WHERE request_id = $req_id;");
        if(!$sql->execute($request_info)) {
            $sql = null;
            $error_location = "location: ../EditRequest.php?req_id=".$req_id."&error=prepare";
            header($error_location);
            exit();
        }

        $sql = null;


        $sql = $conn->prepare("DELETE FROM request_ion WHERE request_id = $req_id;");
                
        //if sql statement fails return to request page with error
        if(!$sql->execute()) {
            $sql = null;
            $error_location = "location: ../EditRequest.php?req_id=".$req_id."&error=delete_ion";
            header($error_location);
            exit();
        }
        $sql = null;

        $ion_string = "";
        //if any ions were submitted then add them to the request_ion table
        if(array_key_exists("ion", $post_info)) {
            $request_info = []; // clear the information being entered into the columns
            $name_info = [];  // clear the name of the columns
            $name = "ion";
            $ion_ids = array_keys($post_info[$name]);
            $ion_id_list = join(' OR ion_id = ', $ion_ids);

            //get all the selected ions from the ion table
            $sql = $conn->prepare("SELECT * FROM ion where ion_id = $ion_id_list;");
            $sql->execute();
            $ions = $sql->fetchAll(PDO::FETCH_ASSOC);

            //loop through all the ions submitted
            for($y = 0; $y < count($post_info[$name]); $y++) {
                $ion_id = array_keys($post_info[$name])[$y];//the ion_id of submitted ion

                if(array_key_exists("energy", $post_info[$name][$ion_id])) {
                    $energy_level = $post_info[$name][$ion_id]["energy"];
                }

                //push the column name and the value into their respective arrays
                array_push($name_info, "request_id, ion_id");
                array_push($request_info, $req_id);
                array_push($request_info, $ion_id);
                //loop through all the ion fields submitted
                for($x = 0; $x < count($post_info[$name][$ion_id]); $x++) {
                    $type_info = array_keys($post_info[$name][$ion_id]);
                    $type = $type_info[$x];//the field from the request_ion table
                    if($type == "select" && $post_info[$name][$ion_id][$type] != "on") { break; }//if the ion is not selected then skip it
                    if($type == "select") { continue; } //if this is the select input skip ahead to another field on the same ion
                    $value = "";// the value being entered into the column
                    if($post_info[$name][$ion_id][$type] == "") {
                        $value = NULL;//any blank input is set to null in the database
                    } else {
                        $value = $post_info[$name][$ion_id][$type];// the values put into the form
                    }
                     //check if name has any incorrect characters
                    if(!$this->formatCorrect(strtolower(str_replace(" ", "_", $type))) || !$this->confirmFormat(str_replace(" ", "_",$value))) {
                        header("location: ../EditRequest.php?error=request_name_check");
                        exit();
                    }
                    //push the column name and the value into their respective arrays
                    array_push($request_info, $value);
                    array_push($name_info, $type);
                    
                }

                //format for sql prepare statements
                $column_list = join(',', $name_info);
                $input_list = "";
                for($x = 0; $x < count($request_info); $x++) {
                    if($x == 0) {
                        $input_list .= "?";
                    } else {
                        $input_list .= ",?";
                    }
                }

                
                // insert the reference to selected ion into the request_ion table, this is a many to many table that allows a request to have multiple ions
                $sql = $conn->prepare("INSERT INTO request_ion ($column_list) VALUES ($input_list);");
                
                //if sql statement fails return to request page with error
                if(!$sql->execute($request_info)) {
                    $sql = null;
                    $error_location = "location: ../EditRequest.php?req_id=".$req_id."&error=ion";
                    header($error_location);
                    exit();
                }
                $sql = null;

                //fetch the ion name and add to the ion string
                if($ion_string == "") {
                    for($x = 0; $x < count($ions); $x++) {
                        if($ions[$x]["ion_id"] == $ion_id) {
                            $ion_string = $ions[$x]["name"]."-".$energy_level;
                            break;
                        }
                    }
                } else {
                    for($x = 0; $x < count($ions); $x++) {
                        if($ions[$x]["ion_id"] == $ion_id) {
                            $ion_string .= ", ".$ions[$x]["name"]."-".$energy_level;
                            break;
                        }
                    }
                }
                //clear the name and value arrays for next ion
                $request_info = [];
                $name_info = [];
            }
        }

        //edit the calendar event for the submitted request
        $this->editEvent($post_info["request"][$req_id]["earliest_date"], $post_info["request"][$req_id]["total_hours"], $organization, $post_info["request"][$req_id]["purpose_of_test"], $facility_id, $req_id, $energy_level, $ion_string, $conn, $schedule_group);
       
        $sql = null;
    }
}