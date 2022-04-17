<?php
/**
 * Controls the admin functionality for the facility forms
 * @author ETurner
 */
class Facility extends Database {

    /**
     * update events already on the calendar with the new color
     * @param facility_id the facility whose events need updated
     * @param color the new color for the facility
     * @param conn the connection to the database
     */
    function updateEvents($facility_id, $color, $conn) {

        //fetch the facility name
        $sql = $conn->prepare("SELECT * FROM calendar_events where facility_id = $facility_id;");
        $sql->execute();
        $facilities = $sql->fetchAll(PDO::FETCH_ASSOC);

        if($sql->rowCount() == 0) {
            $sql = null;
            header("location: ../Admin.php?error=change_facility_none");
            exit();
        }

        $sql = null;

        //update all events for the selected facility with the new color
        $sql = $conn->prepare("UPDATE calendar_events SET `colorBorder`=? WHERE facility_id = $facility_id;");
        if(!$sql->execute(array($color))) {
            $sql = null;
            header("location: ../Admin.php?error=change_facility_prepare");
            exit();
        }

        $sql = null;
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
     * edits facilities in the facility table in the database
     * @param post_info post_info[the input name] the associative array containing information submitted by the user through a form
     */
    public function changeFacility($post_info) {
        $request_info = []; // the information being entered into the columns
        $name_info = []; // the name of the columns
        $key_info = array_keys($post_info);
        $facility_num = $post_info["facility_id"]; // the name of the facility being edited
        // go through all the columns and edit them according to the values input into the form
        for($x = 1; $x < count($post_info) - 1; $x++) {
            //the name of the column field
            $name = $key_info[$x];
            $value = "";
            if($post_info[$name] == "on") { // convert any checkboxes into binary true
                $value = "1";
            } else if($post_info[$name] == "") { //any blank input is set to null in the database
                $value = NULL;
            } else {
                $value = $post_info[$name]; // the values put into the form
            }
            //check if the user input has any incorrect characters
            if(!$this->formatCorrect(strtolower(str_replace(" ", "_", $name))) || !$this->confirmFormat(str_replace(" ", "_",$value))) {
                header("location: ../Admin.php?error=input_check");
                exit();
            }
            // format for sql statement "column_name = ?"
            $name .= " = ?";
            //push the column name and the value into their respective arrays
            array_push($request_info, $value);
            array_push($name_info, $name);
        }

        //format for sql prepare statement
        $column_list = join(',', $name_info);
        
        $conn = $this->connect();//the databse connection
        //update the facility with the new information
        $sql = $conn->prepare("UPDATE facility SET $column_list Where facility_id = $facility_num;");
        //if sql statement fails return to admin page with error
        if(!$sql->execute($request_info)) {
            $sql = null;
            header("location: ../Admin.php?error=change_facility_prepare");
            exit();
        }
        $sql = null;

        //if the color was changed then update the events on the calendar associated with this facility
        if(array_key_exists("color", $post_info)) {
            $this->updateEvents($facility_num, $post_info["color"], $conn);
        }
    }

    /**
     * add a facility to the facility table in the database
     * @param post_info post_info[the input name] the associative array containing information submitted by the user through a form
     */
    public function addFacility($post_info) {
        $request_info = []; // the information being entered into the columns
        $name_info = [];  // the name of the columns
        $key_info = array_keys($post_info);
        $value_str = "";

        // go through all the columns and edit them according to the values input into the form
        for($x = 0; $x < count($post_info) - 1; $x++) {
            $name = $key_info[$x]; // the name of the column
            $value = ""; // the value being entered into the column
            if($post_info[$name] == "on") { // convert any checkboxes into binary true
                $value = "1";
            } else if($post_info[$name] == "") {//any blank input is set to null in the database
                $value = NULL;
            } else {
                $value = $post_info[$name]; // the values put into the form
            }
            // formaat the sql statement input (?, ?, ?) for each value
            if($x == 0) {
                $value_str = "?";
            } else {
                $value_str .= ", ?";
            }
            //check if the user input has any incorrect characters
            if(!$this->formatCorrect(strtolower(str_replace(" ", "_", $name))) || !$this->confirmFormat(str_replace(" ", "_",$value))) {
                header("location: ../Admin.php?error=input_check");
                exit();
            }
            //push the column name and the value into their respective arrays
            array_push($request_info, $value);
            array_push($name_info, $name);
        }

        //format for sql prepare statement
        $column_list = join(',', $name_info);
        
        // inset the new facility into the facility table with the inputted values
        $sql = $this->connect()->prepare("INSERT INTO facility ($column_list) VALUES ($value_str);");
        //if sql statement fails return to admin page with error
        if(!$sql->execute($request_info)) {
            $sql = null;
            header("location: ../Admin.php?error=add_facility_prepare");
            exit();
        }
        $sql = null;
    }

    /**
     * remove a facility from the facility table in the database
     * @param post_info post_info[the input name] the associative array containing information submitted by the user through a form
     */
    public function removeFacility($post_info) {
        $facility_num = $post_info["facility_id"];//the facility being removed

        //fetch the facilities
        $sql = $this->connect()->prepare("SELECT * FROM facility;");

        //if sql statement fails return to admin page with error
        if(!$sql->execute()) {
            $sql = null;
            header("location: ../Admin.php?error=prepare");
            exit();
        }

        //confirm at least one facility will remain if this one is delted
        if($sql->rowCount() <= 1) {
            $sql = null;
            header("location: ../Admin.php?error=facility_count");
            exit();
        }

        // get all the ions connected to the selected facility from the database
        $sql = $this->connect()->prepare("SELECT * FROM ion WHERE facility_id = $facility_num;");
        
        //if sql statement fails return to admin page with error
        if(!$sql->execute()) {
            $sql = null;
            header("location: ../Admin.php?error=get_facility_ion_prepare");
            exit();
        }

        $ions = $sql->fetchAll(PDO::FETCH_ASSOC); // an associative array of all the ion information

        // delete all requests connected to the selected faacility
        $sql = $this->connect()->prepare("DELETE FROM request WHERE facility_id = $facility_num;");

        //if sql statement fails return to admin page with error
        if(!$sql->execute()) {
            $sql = null;
            header("location: ../Admin.php?error=remove_facility_request_prepare");
            exit();
        }
        $sql = null;

        // loop through all the ions feteched from the database
        foreach($ions as $ion) {
            $ion_id = $ion["ion_id"];
            // delete all references to the feteched ion from request_ion
            $sql = $this->connect()->prepare("DELETE FROM request_ion WHERE ion_id = $ion_id;");

            //if sql statement fails return to admin page with error
            if(!$sql->execute()) {
                $sql = null;
                header("location: ../Admin.php?error=remove_facility_req_ion_prepare");
                exit();
            }
            $sql = null;
        }

        // delete all ions connected to the selected facility
        $sql = $this->connect()->prepare("DELETE FROM ion WHERE facility_id = $facility_num;");

        //if sql statement fails return to admin page with error
        if(!$sql->execute()) {
            $sql = null;
            header("location: ../Admin.php?error=remove_facility_ion_prepare");
            exit();
        }
        $sql = null;

        // delete the facility from the facility table
        $sql = $this->connect()->prepare("DELETE FROM facility WHERE facility_id = $facility_num;");
        //if sql statement fails return to admin page with error
        if(!$sql->execute()) {
            $sql = null;
            header("location: ../Admin.php?error=remove_facility_prepare");
            exit();
        }
        $sql = null;
    }
}