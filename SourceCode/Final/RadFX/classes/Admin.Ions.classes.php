<?php
/**
 * edit the ions for facilities in the system
 * @author ETurner
 */

class Ion extends Database {

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
     * remove ions from the ion table in the database
     * @param post_info post_info[the input name] the associative array containing information submitted by the user through a form
     */
    private function removeIon($post_info) {
        $request_info = []; // the values being entered into the database
        $key_info = array_keys($post_info);
        $name = "ion"; //the table name from the database
        // loop through all the ions submitted
        for($y = 0; $y < count($post_info[$name]); $y++) {
            //the ion name that the user is wanting to edit
            $ion_id = array_keys($post_info[$name])[$y];
            //loop through the ion columns 
            for($x = 0; $x < count($post_info[$name][$ion_id]); $x++) {
                $type_info = array_keys($post_info[$name][$ion_id]);
                $type = $type_info[$x]; //the actual column name
                if($type != "remove") { break; } //if the type is not remove then go to the next ion
                $value = "";
                // if the remove checkbox is on then add the ion to the array of ions that are going to be removed and remove the ion from the submitted info
                if($post_info[$name][$ion_id][$type] == "on") {
                    $value = $ion_id;
                    array_push($request_info, $value);
                    unset($post_info[$name][$ion_id]);
                    $y--;
                    break;
                }
            }
        }

        // if there are ions selected for removal then remove them all
        if(count($request_info) > 0) {
            //format for sql prepare statement
            $column_list = join(',', $request_info);
            // delete all the ions from the ion table with the selected ion_id's
            $sql = $this->connect()->prepare("DELETE FROM ion WHERE ion_id = $column_list;");
            //if sql statement fails return to admin page with error
            if(!$sql->execute()) {
                $sql = null;
                header("location: ../Admin.php?error=ion_del_prepare");
                exit();
            }
            $sql = null;

            // delete all references to the ions from the request_ion table
            $sql = $this->connect()->prepare("DELETE FROM request_ion WHERE ion_id = $column_list;");
            //if sql statement fails return to admin page with error
            if(!$sql->execute()) {
                $sql = null;
                header("location: ../Admin.php?error=req_ion_del_prepare");
                exit();
            }
            $sql = null;
        }

        return $post_info;
    }

    /**
     * edits ions in the selected table
     * @param post_info post_info[the table the columns selected for edit][the column name such as "total_hours" "purpose of test" or "vacuum"][the field type for the column such as "remove" "name" "type or "comment"]the associative multidemensional array containing information submitted by the user through a form
     */
    public function editIons($post_info) {
        //remove any ions selected for removal first
        $post_info = $this->removeIon($post_info);

        $request_info = []; // the information being entered into the columns
        $name_info = [];  // the name of the columns
        $key_info = array_keys($post_info);
        //$name = $key_info[1]; //the table name from the database
        $name = "ion";
        // go through all the ions and edit them according to the values input into the form
        for($y = 0; $y < count($post_info[$name]); $y++) {
            $ion_id = array_keys($post_info[$name])[$y]; //the name of the ion
            //loop through all the ion columns
            for($x = 0; $x < count($post_info[$name][$ion_id]); $x++) {
                $type_info = array_keys($post_info[$name][$ion_id]);
                $type = $type_info[$x];//the name of the column
                $value = "";
                if($post_info[$name][$ion_id][$type] == "") {
                    $value = NULL; // any blank input is set to null in the database
                } else {
                    $value = $post_info[$name][$ion_id][$type]; // the values put into the form
                }
                //check if the user input has any incorrect characters
                if(!$this->formatCorrect(strtolower(str_replace(" ", "_", $type))) || !$this->confirmFormat(str_replace(" ", "_",$value))) {
                    header("location: ../Admin.php?error=input_check");
                    exit();
                }
                // format for sql staatement "column_name = ?"
                $type_str = $type.'=?';
                //push the column name and the value into their respective arrays
                array_push($request_info, $value);
                array_push($name_info, $type_str);
                
            }
            // format ion names for sql prepare statement
            $column_list = join(',', $name_info);

            
            //upate the selected ions with the inputted values
            $sql = $this->connect()->prepare("UPDATE ion SET $column_list Where ion_id = $ion_id;");
            //if sql statement fails return to admin page with error
            if(!$sql->execute($request_info)) {
                $sql = null;
                header("location: ../Admin.php?error=edit_ion_prepare");
                exit();
            }
            $sql = null;
            $request_info = [];
            $name_info = [];
        }
    }

    /**
     * add ions to the ion table in the database
     * @param post_info post_info[the input name] the associative array containing information submitted by the user through a form
     */
    public function addIon($post_info) {
        $request_info = []; // the information being entered into the columns
        $name_info = [];  // the name of the columns
        $key_info = array_keys($post_info);
        $value_str = "";
        // go through all the columns and edit them according to the values input into the form
        for($x = 0; $x < count($post_info) - 1; $x++) {
            $name = $key_info[$x];// the name of the column
            $value = "";// the value being entered into the column
            if($post_info[$name] == "on") {// convert any checkboxes into binary true
                $value = "1";
            } else if($post_info[$name] == "") {//any blank input is set to null in the database
                $value = NULL;
            } else {
                $value = $post_info[$name];// the values put into the form
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

        // inset the new ion into the ion table with the inputted values
        $sql = $this->connect()->prepare("INSERT INTO ion ($column_list) VALUES ($value_str);");
        //if sql statement fails return to admin page with error
        if(!$sql->execute($request_info)) {
            $sql = null;
            header("location: ../Admin.php?error=add_ion_prepare");
            exit();
        }
        $sql = null;
    }
}