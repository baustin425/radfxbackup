<?php
/**
 * generates the dynamic forms and tables for the sites based on the tables in the database
 * @author ETurner
 */
class ColumnGenerator extends Database {

    /**
     * echos out a formatted list of rows in a form based on a table in the database
     * @param hidden_list the columns from the database the formatter should ignore
     * @param required_list the columns from the database the formatter must require
     * @param comb_table the table from the database to echo
     * @param id_info string contianing information used to generate a unique id for each input in the table
     * @return new_table an array containing all the names of all input fields generated
     */
    public function getColumns($hidden_list, $required_list, $id_info, $comb_table) {
        $new_table = []; // an array containing all the names of all input fields generated
        //loop through all the table column fields and create an output 
        for($x = 0; $x < count($comb_table); $x++) {
            //the field information for the form entry
            $field = $comb_table[$x];
            //check if the field is not in the ignore list
            if(!in_array($field["Field"], $hidden_list)) {
                //check if the entry is the facility and ion table, if so create a placeholder for the javascript to generate the table
                if($field["Field"] == "facility_and_ion_table") {
                    echo '<div id="facility_and_ion_table"></div>';
                } else {
                    $name = ucwords(str_replace("_", " ", $field["Field"])); //convert databse format for the name into a more readable format
                    echo "<div class='u-form-group u-form-group-7'>";
                    $required = ""; // is the column required?
                    $required_name = "";
                    //if the field is required set it to required and label it with *
                    if(!$field["Null"] || in_array($field["Field"], $required_list) || $field["required"]) {
                        $required = "required='required'";
                        $required_name = "*";
                    } else if(strpos($field["Field"], 'shift') !== false) {//if it is the shift field label it as required
                        $required_name = "*";
                    }
                    echo "<label for='text-53b6' class='u-label'>",$name,"",$required_name,"</label>"; //label the input field with the fields formatted name
                    
                    // Set the type of input box
                    $type = "type='text'"; 
                    if(strpos($field["Type"], 'date') !== false) {
                        $type = "type='date'"; //calanedar 
                    } else if(strpos($field["Field"], 'shift') !== false) {
                        $type = "type='checkbox'";
                    } else if(strpos($field["Type"], 'int(1)') !== false) {
                        $type = "type='checkbox'";
                    } else if(strpos($field["Type"], 'int') !== false || strpos($field["Type"], 'decimal') !== false) {
                        $type = "type='number' step='any'";
                    } else if(strpos($field["Field"], 'color') !== false) {
                        $type = "type='color'";
                    } else {
                        $type = "type='text'";
                    }
                    $id = $id_info.$field["Field"]; // format this input id with the unqiue name and the column name
                    //set the default css class if its not a color box or checkbox
                    $class = "";
                    if($type != "type='color'" && $type != "type='checkbox'") {
                        $class = "u-border-1 u-border-grey-30 u-input u-input-rectangle u-white";
                    } else {
                        echo "<br>";
                    }

                    //generate the shift checkboxes
                    if(strpos($field["Field"], 'shift') !== false) {
                        echo "<br>";
                        echo "<table id='",$id,"'>";
                        echo "<tr>";
                        echo "<th style='text-align:center;'>&nbsp;&nbsp;&nbsp;12:00AM - 8:00AM&nbsp;&nbsp;&nbsp;</th>";
                        echo "<th style='text-align:center;'>&nbsp;&nbsp;&nbsp;8:00AM - 4:00PM&nbsp;&nbsp;&nbsp;</th>";
                        echo "<th style='text-align:center;'>&nbsp;&nbsp;&nbsp;4:00PM - 12:00AM&nbsp;&nbsp;&nbsp;</th>";
                        echo "</tr>";
                        $class = "";
                        echo "<tr>";
                        //generate input box based on provided information
                        echo "<td>";
                        echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='0-8' class='",$class,"' ",$required,">";
                        echo "</td>"; 
                        //generate input box based on provided information
                        echo "<td>";
                        echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='8-16' class='",$class,"' ",$required,">";
                        echo "</td>"; 
                        //generate input box based on provided information
                        echo "<td>";
                        echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='16-24' class='",$class,"' ",$required,">";
                        echo "</td>";
                        echo "</tr>";
                        echo "</table>";
                    } else {
                        if($type == "type='checkbox'") {//create a checkbox entry with a hidden placeholder that store the actual input
                            echo '<input type="hidden" placeholder="',$field["Comment"],'" id="',$id,'" name="',$field["Field"],'" class="',$class,'" ',$required,'>
                            <input type="checkbox" id="',$id,'" name="" onclick="this.previousSibling.previousSibling.value=this.checked?1:0">';
                        } else {
                            //generate input box based on provided information
                            echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='",$field["Field"],"' class='",$class,"' ",$required,">";
                        }
                    }
                    
                    echo "</div>";
                    //put the field name in the form array
                    array_push($new_table, $field);
                }
            }
        }
        return $new_table;
    }

    /**
     * echos out a formatted list of rows in a form based on a table in the database
     * @param hidden_list the columns from the database the formatter should ignore
     * @param table_name the table name from the database to echo
     * @param id_info string contianing information used to generate a unique id for each input in the table
     * @param table_name the table from the database to echo
     * @return new_table an array containing all the names of all input fields generated
     */
    public function getColumnsAffiliation($hidden_list, $required_list, $table_name, $id_info, $table) {
        // get all the column information for the selected table in the database
        $new_table = []; // an array containing all the names of all input fields generated
        //loop through all the table column fields and create an input 
        foreach($table as $field) {
            //check if the field is not in the ignore list
            if(!in_array($field["Field"], $hidden_list)) {
                $name = ucwords(str_replace("_", " ", $field["Field"])); //convert databse format for the name into a more readable format
                echo "<div class='u-form-group u-form-group-7'>";
                echo "<label for='text-53b6' class='u-label'>",$name,"</label>"; //label the input field with the fields formatted name
                $required = ""; // is the column required?
                if(!$field["Null"] || in_array($field["Field"], $required_list)) {
                    $required = "required='required'";
                }

                // Set the type of input box
                $type = "type='text'";
                if(strpos($field["Type"], 'date') !== false) {
                    $type = "type='date'"; //calanedar 
                } else if(strpos($field["Field"], 'shift') !== false) {
                    $type = "type='checkbox'";
                } else if(strpos($field["Type"], 'int(1)') !== false) {
                    $type = "type='checkbox'";
                } else if(strpos($field["Type"], 'int') !== false || strpos($field["Type"], 'decimal') !== false) {
                    $type = "type='number' step='any'";
                } else if(strpos($field["Field"], 'color') !== false) {
                    $type = "type='color'";
                } else {
                    $type = "type='text'";
                }
                $id = $id_info.$field["Field"]; // format this input id with the unqiue name and the column name
                //set the default css class if its not a color box or checkbox
                $class = "";
                if($type != "type='color'" && $type != "type='checkbox'") {
                    $class = "u-border-1 u-border-grey-30 u-input u-input-rectangle u-white";
                } else {
                    echo "<br>";
                }

                //generate the shift checkboxes
                if(strpos($field["Field"], 'shift') !== false) {
                    echo "<br>";
                    echo "<table id='",$id,"'>";
                    echo "<tr>";
                    echo "<th style='text-align:center;'>&nbsp;&nbsp;&nbsp;12:00AM - 8:00AM&nbsp;&nbsp;&nbsp;</th>";
                    echo "<th style='text-align:center;'>&nbsp;&nbsp;&nbsp;8:00AM - 4:00PM&nbsp;&nbsp;&nbsp;</th>";
                    echo "<th style='text-align:center;'>&nbsp;&nbsp;&nbsp;4:00PM - 12:00AM&nbsp;&nbsp;&nbsp;</th>";
                    echo "</tr>";
                    $class = "";
                    echo "<tr>";
                     //generate input box based on provided information
                     echo "<td>";
                    echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='0-8' class='",$class,"' ",$required,">";
                    echo "</td>"; 
                    //generate input box based on provided information
                    echo "<td>";
                    echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='8-16' class='",$class,"' ",$required,">";
                    echo "</td>"; 
                    //generate input box based on provided information
                    echo "<td>";
                    echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='16-24' class='",$class,"' ",$required,">";
                     echo "</td>";
                     echo "</tr>";
                     echo "</table>";
                } else {
                    if($type == "type='checkbox'") {//create a checkbox entry with a hidden placeholder that store the actual input
                        echo '<input type="hidden" placeholder="',$field["Comment"],'" id="',$id,'" name="',$field["Field"],'" class="',$class,'" ',$required,'>
                        <input type="checkbox" id="',$id,'" name="" onclick="this.previousSibling.previousSibling.value=this.checked?1:0">';
                    } else {
                        //generate input box based on provided information
                        echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='",$field["Field"],"' class='",$class,"' ",$required,">";
                    }
                }
                
                echo "</div>";
                //put the field name in the form array
                array_push($new_table, $field);
            }
        }
        return $new_table;
    }

    /**
     * echos out a formatted list of columns in a table format based on a table in the database, specifically generates the alter request form
     * @param hidden_list the columns from the database the formatter should ignore
     * @param table_name the table name from the database to echo
     * @param id_info string contianing information used to generate a unique id for each input in the table
     * @param comb_table the table from the database to echo
     * @return new_table an array containing all the names of all input fields generated
     */
    public function getColumnsAlterRequestForm($hidden_list, $table_name, $id_info, $comb_table) {
        $new_table = [];// an array containing all the names of all input fields generated
        include_once 'classes/FieldController.classes.php';
        $field_controller = new FieldController();//contains information on required and hidden fields

        // generate the table and the header fields
        echo "<table id='",$table_name,"_form_table'>";
        echo "<tr>";
        echo "<th style='text-align:center;'>Remove</th>";
        echo "<th style='text-align:center;'>Name</th>";
        echo "<th style='text-align:center;'>Type</th>";
        if($id_info == "request") {
            echo "<th style='text-align:center;'>Required</th>";
        }
        echo "</tr>";
        echo "<tbody>";
        //loop through all the table column fields and create an input
        for($x = 0; $x < count($comb_table); $x++) {
            //the field information for the form entry
            $field = $comb_table[$x];
            //check if the field is not in the ignore list
            if(!in_array($field["field_name"], $hidden_list)) {
                $name = ucwords(str_replace("_", " ", $field["field_name"])); //convert databse format for the name into a more readable format
                echo "<tr>";
                $id = $id_info."remove"; // format this input id with the unqiue name and the column name
                //generate input checkbox based on provided information
                if(!in_array($field["Field"], $field_controller->getUnbreakableFields($table_name))) {
                    echo '<td style="text-align:center;"><input type="checkbox" id="',$id,'" name="',$table_name,'[',$field["field_name"],'][remove]"></td>';
                    echo "</td>";
                } else {
                    echo '<td></td>';
                    echo "</td>";
                }
                echo "<td>";
                echo "<label for='text-53b6' class='u-label'>",$name,"</label>"; //label the input field with the fields formatted name
                echo "</td>";
                echo '<td style="text-align:center;">';
                $required = ""; // is the column required?
                if(!$field["Null"]) {
                    $required = "required='required'";
                }
                // Set the type of input box
                $type = "type='text'"; // the type of input box
                if(strpos($field["Type"], 'date') !== false) {
                    $type = "type='date'"; //calanedar 
                } else if(strpos($field["Type"], 'int(1)') !== false) {
                    $type = "type='checkbox'";
                } else if(strpos($field["Type"], 'int') !== false || strpos($field["Type"], 'decimal') !== false) {
                    $type = "type='number' step='any'";
                } else if(strpos($field["field_name"], 'color') !== false) {
                    $type = "type='color'";
                } else {
                    $type = "type='text'";
                }
                $id = $id_info.$field["field_name"]; // format this input id with the unqiue name and the column name
                //generate input box based on provided information
                echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='",$table_name,"[",$field["field_name"],"][type]' class='u-border-1 u-border-grey-30 u-input u-input-rectangle u-white' ",$required," disabled=true>";
                //put the field name in the form array
                array_push($new_table, $field);
                echo "</td>";
                if($id_info == "request") {
                    if(!in_array($field["Field"], $field_controller->getRequiredFields($table_name))) {
                        $checked_value = 0;
                        $is_checked = "";
                        if($field["required"] == 1) {
                            $is_checked = "checked";
                            $checked_value = 1;
                        }
                        //create a checkbox entry with a hidden placeholder that store the actual input
                        echo '<td style="text-align:center;">
                        <input type="hidden" id="',$id,'" name="form[',$field["field_name"],'][required]" value="',$checked_value,'">
                        <input type="checkbox" id="',$id,'" name="" ',$is_checked,' onclick="this.previousSibling.previousSibling.value=this.checked?1:0"></td>';
                        echo "</td>";
                    } else {
                        //generate input box based on provided information
                        echo '<td><input type="hidden" id="',$id,'" name="form[',$field["field_name"],'][required]" value="1"></td>';
                    }
                }

                echo "<td>";
                //generate sort order buttons
                echo "<button class='up' type=button>&#8593;</button>";
                echo "<button class='down' type=button>&#8595;</button>";
                echo "</td>";

                echo "</tr>";
                
            }
        }

        echo "</tbody>";
        echo "</table>";
        return $new_table;
    }

    /**
     * echos out a formatted list of columns in a table format based on a table in the database
     * @param hidden_list the columns from the database the formatter should ignore
     * @param table_name the name of table from the database to echo
     * @param id_info string contianing information used to generate a unique id for each input in the table
     * @param table the table from the database to echo
     * @param comb_table the sorted table from the database to echo
     * @return new_table an array containing all the names of all input fields generated
     */
    public function getColumnsAsRow($hidden_list, $table_name, $id_info, $table, $comb_table) {
         // get all the column information for the selected table in the database
        $new_table = [];// an array containing all the names of all input fields generated
        //loop through all the table column fields and create an input
        for($x = 0; $x < count($comb_table); $x++) {
            $field = $comb_table[$x];
            //check if the field is not in the ignore list
            if(!in_array($field["Field"], $hidden_list)) {
                $name = ucwords(str_replace("_", " ", $field["Field"])); //convert databse format for the name into a more readable format
                $required = "";// is the column required?
                if(!$field["Null"]) {
                    $required = "required='required'";
                }
                // Set the type of input box
                $type = "type='text'";
                if(strpos($field["Type"], 'date') !== false) {
                    $type = "type='date'"; //calanedar 
                } else if(strpos($field["Type"], 'int(1)') !== false) {
                    $type = "type='checkbox'";
                } else if(strpos($field["Type"], 'int') !== false || strpos($field["Type"], 'decimal') !== false) {
                    $type = "type='number' step='any'";
                } else if(strpos($field["Field"], 'color') !== false) {
                    $type = "type='color'";
                } else {
                    $type = "type='text'";
                }
                $id = $id_info.$field["Field"];// format this input id with the unqiue name and the column name
                if($type == "type='checkbox'") {//create a checkbox entry with a hidden placeholder that store the actual input
                    echo '<input type="hidden" placeholder="',$field["Comment"],'" id="',$id,'" name="',$field["Field"],'" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" ',$required,'>
                    <input type="checkbox" id="',$id,'" name="" onclick="this.previousSibling.previousSibling.value=this.checked?1:0">';
                } else {
                    //generate input box based on provided information
                    echo "<td><input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='",$field["Field"],"' class='u-border-1 u-border-grey-30 u-input u-input-rectangle u-white' ",$required,"></td>";
                }
                //put the field name in the form array
                array_push($new_table, $field);
            }
        }
        return $new_table;
    }

    /**
     * echos out a formatted list of columns in a table format based on a table in the database, generates names that can be autopopulated with values from the database
     * @param hidden_list the columns from the database the formatter should ignore
     * @param table_name the table from the database to echo
     * @param id_info string contianing information used to generate a unique id for each input in the table
     * @param entry unique name information used to generate a unique name for the input elements so they can be autopopulated
     * @param table the table from the database to echo
     * @param table_object the actual table from the database with information
     * @param comb_table the sorted table from the database to echo
     * @return new_table an array containing all the names of all input fields generated
     */
    public function getColumnsAsTablePopulated($hidden_list, $table_name, $id_info, $entry, $table, $table_object, $comb_table) {
        // get all the column information for the selected table in the database
        $id_name = $table_name."_id";// format this id with the table name and _id to create the primary key name for the table
        $new_table = [];// an array containing all the names of all input fields generated
        //loop through all the table column fields and create an input
        for($x = 0; $x < count($comb_table); $x++) {
            $field = $comb_table[$x];
            //check if the field is not in the ignore list
            if(!in_array($field["Field"], $hidden_list)) {
                $name = ucwords(str_replace("_", " ", $field["Field"]));//convert databse format for the name into a more readable format
                $required = "";// is the column required?
                if(!$field["Null"]) {
                    $required = "required='required'";
                }
                // Set the type of input box
                $type = "type='text'";
                if(strpos($field["Type"], 'date') !== false) {
                    $type = "type='date'"; //calanedar
                } else if(strpos($field["Type"], 'int(1)') !== false) {
                    $type = "type='checkbox'";
                } else if(strpos($field["Type"], 'int') !== false || strpos($field["Type"], 'decimal') !== false) {
                    $type = "type='number' step='any'";
                } else if(strpos($field["Field"], 'color') !== false) {
                    $type = "type='color'";
                } else {
                    $type = "type='text'";
                }
                $id = $id_info.$field["Field"];// format this input id with the unqiue name and the column name
                if($type == "type='checkbox'") {//create a checkbox entry with a hidden placeholder that store the actual input
                    echo '<td><input type="hidden" placeholder="',$field["Comment"],'" id="',$id,'" name="',$table_name,"[",$entry,"][",$field["Field"],']" value="',$table_object[$field["Field"]],'" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" ',$required,'>
                    <input type="checkbox" id="',$id,'" name="" onclick="this.previousSibling.previousSibling.value=this.checked?1:0"></td>';
                } else {
                    //generate input box based on provided information
                    echo "<td><input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='",$table_name,"[",$entry,"][",$field["Field"],"]' value='",$table_object[$field["Field"]],"' class='u-border-1 u-border-grey-30 u-input u-input-rectangle u-white' ",$required,"></td>";
                }
                //put the field name in the form array
                array_push($new_table, $field);
            }
        }
        return $new_table;
    }

     /**
     * echos out a formatted list of columns in a table format based on the request table in the database, generates names that can be autopopulated with values from the database
     * @param hidden_list the columns from the database the formatter should ignore
     * @param table_name the table from the database to echo
     * @param id_info string contianing information used to generate a unique id for each input in the table
     * @param entry unique name information used to generate a unique name for the input elements so they can be autopopulated
     * @param table the table from the database to echo
     * @param comb_table the sorted table from the database to echo
     * @return new_table an array containing all the names of all input fields generated
     */
    public function getColumnsAsRequestTablePopulated($hidden_list, $required_list, $table_name, $id_info, $entry, $table, $comb_table) {
        // get all the column information for the selected table in the database
        $id_name = $table_name."_id";// format this id with the table name and _id to create the primary key name for the table
        // get all database entries from the selected table with the unique id
        $conn = $this->connect();
        $sql = $conn->prepare("SELECT * FROM $table_name WHERE $id_name = $entry;");
        
        if(!$sql->execute()) {

        }

        $table_object = [];
        if($sql->rowCount() != 0) {
            $table_object = $sql->fetchAll(PDO::FETCH_ASSOC)[0];// fetch all the entries taken from the database into an associative arraay
        }
		$sql = null;
        //get all the calendar_events associated with the request
		$sql = $conn->prepare("SELECT `from` FROM `calendar_events` WHERE `request_id` = $entry ORDER BY `from`;");
        $sql->execute();
        //set the earliest date to the first calendar event associated with the request id
        $earliest_date = "";
        if($sql->rowCount() != 0) {
            $temp = $sql->fetchAll(PDO::FETCH_ASSOC)[0]['from'];
            $earliest_day = date("Y-m-d",strtotime($temp));
            $earliest_date = $earliest_day;
        }
		
        $new_table = [];// an array containing all the names of all input fields generated
        //loop through all the table column fields and create an input
        for($x = 0; $x < count($comb_table); $x++) {
            $field = $comb_table[$x];
            //check if the field is not in the ignore list
            if(!in_array($field["Field"], $hidden_list)) {
                if($field["Field"] == "facility_and_ion_table") {
                    echo '<div id="facility_and_ion_table"></div>';
                } else {
                    $name = ucwords(str_replace("_", " ", $field["Field"]));//convert databse format for the name into a more readable format
                    echo "<div class='u-form-group u-form-group-7'>";
                    $required = "";// is the column required?
                    //if the field is required set it to required and label it with *
                    $required_name = "";
                    if(!$field["Null"] || in_array($field["Field"], $required_list) || $field["required"]) {
                        $required = "required='required'";
                        $required_name = "*";
                    } else if(strpos($field["Field"], 'shift') !== false) {
                        $required_name = "*";
                    }
                    echo "<label for='text-53b6' class='u-label'>",$name,"",$required_name,"</label>"; //label the input field with the fields formatted name
                    
                    // Set the type of input box
                    $type = "type='text'";
                    $checked = "";
                    if($field["Field"] == "earliest_date" && strpos($field["Type"], 'date') !== false && $earliest_date != "") {
                        $type = "type='date' value='".$earliest_date."'"; //calanedar 
                    } else if(strpos($field["Type"], 'date') !== false) {
                        if($table_object[$field["Field"]] != null) {
                            $temp_date = date("Y-m-d",strtotime($table_object[$field["Field"]]));
                            $type = "type='date' value='".$temp_date."'";
                        } else {
                            $type = "type='date'";
                        }
                    } else if(strpos($field["Field"], 'shift') !== false) {
                        $type = "type='checkbox'";
                    } else if(strpos($field["Type"], 'int(1)') !== false) {
                        $type = "type='checkbox'";
                        if($table_object[$field["Field"]] == 1) {
                            $checked = "checked";
                        }
                    } else if(strpos($field["Type"], 'int') !== false || strpos($field["Type"], 'decimal') !== false) {
                        $type = "type='number' step='any'";
                    } else if(strpos($field["Field"], 'color') !== false) {
                        $type = "type='color'";
                    } else {
                        $type = "type='text'";
                    }

                    //set the default css class if its not a color box or checkbox
                    $class = "";
                    if($type != "type='color'" && $type != "type='checkbox'") {
                        $class = "u-border-1 u-border-grey-30 u-input u-input-rectangle u-white";
                    } else {
                        echo "<br>";
                    }
                    $id = $id_info.$field["Field"];// format this input id with the unqiue name and the column name
                    
                    //generate the shift checkboxes
                    if(strpos($field["Field"], 'shift') !== false) {
                        $binary_checks = $table_object[$field["Field"]];
                        echo "<br>";
                        echo "<table id='",$field["Field"],"'>";
                        echo "<tr>";
                        echo "<th style='text-align:center;'>&nbsp;&nbsp;&nbsp;12:00AM - 8:00AM&nbsp;&nbsp;&nbsp;</th>";
                        echo "<th style='text-align:center;'>&nbsp;&nbsp;&nbsp;8:00AM - 4:00PM&nbsp;&nbsp;&nbsp;</th>";
                        echo "<th style='text-align:center;'>&nbsp;&nbsp;&nbsp;4:00PM - 12:00AM&nbsp;&nbsp;&nbsp;</th>";
                        echo "</tr>";
                        $class = "";
                        echo "<tr>";
                        //generate input box based on provided information
                        echo "<td>";
                        if($binary_checks[0] == "1") {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        }
                        echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$field["Field"],"' name='0-8' class='",$class,"' ",$required," ",$checked,">";
                        echo "</td>"; 
                        //generate input box based on provided information
                        echo "<td>";
                        if($binary_checks[1] == "1") {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        }
                        echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$field["Field"],"' name='8-16' class='",$class,"' ",$required," ",$checked,">";
                        echo "</td>"; 
                        //generate input box based on provided information
                        echo "<td>";
                        if($binary_checks[2] == "1") {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        }
                        echo "<input ",$type," placeholder='",$field["Comment"],"' id='",$field["Field"],"' name='16-24' class='",$class,"' ",$required," ",$checked,">";
                        echo "</td>";
                        echo "</tr>";
                        echo "</table>";
                    } else {
                        if($type == "type='checkbox'") {//create a checkbox entry with a hidden placeholder that store the actual input
                            echo '<td><input type="hidden" placeholder="',$field["Comment"],'" id="',$id,'" name="',$table_name,"[",$entry,"][",$field["Field"],']" value="',$table_object[$field["Field"]],'" class="',$class,'" ',$required,'>
                            <input type="checkbox" id="',$id,'" name="" onclick="this.previousSibling.previousSibling.value=this.checked?1:0"',$checked,'></td>';
                        } else {
                            //generate input box based on provided information
                            echo "<td><input ",$type," placeholder='",$field["Comment"],"' id='",$id,"' name='",$table_name,"[",$entry,"][",$field["Field"],"]' value='",$table_object[$field["Field"]],"' class='",$class,"' ",$required," ",$checked,"></td>";
                        }
                    }
                    echo "</div>";
                    //put the field name in the form array
                    array_push($new_table, $field);
                }
            }
        }
        return $new_table;
    }

    /**
     * echos out a formatted list of columns in a table format based on a table in the database
     * @param hidden_list the columns from the database the formatter should ignore
     * @param comb_table the sorted table from the database to echo
     * @param entry_info unique  information used to generate the input elements so they can be autopopulated
     */
    public function getColumnsAsTableEntries($hidden_list, $entry_info, $comb_table) {
        for($x = 0; $x < count($comb_table); $x++) {
            if(!in_array($comb_table[$x]["Field"], $hidden_list)) {
                echo '<td style="text-align:center;">',$entry_info[$comb_table[$x]["Field"]],'</td>';
            }
        }
    }

    /**
     * echos out a formatted list of columns in a table header format based on a table in the database
     * @param hidden_list the columns from the database the formatter should ignore
     * @param table_name the name of table from the database to echo
     * @param table the table from the database to echo
     * @param comb_table the sorted table from the database to echo
     * @return new_table an array containing all the names of all input fields generated
     */
    public function getColumnsAsHeader($hidden_list, $table_name, $table, $comb_table) {
        // get all the column information for the selected table in the database
        $new_table = [];// an array containing all the names of all input fields generated
        //loop through all the table column fields and create an input
        for($x = 0; $x < count($comb_table); $x++) {
            $field = $comb_table[$x];
            //check if the field is not in the ignore list
            if(!in_array($field["Field"], $hidden_list)) {
                $name = ucwords(str_replace("_", " ", $field["Field"]));//convert databse format for the name into a more readable format
                echo "<th class='sortable ",$table_name,"_sort'>".$name."</th>";//label the header field with the fields formatted name
                //put the field name in the form array
                array_push($new_table, $field);
            }
        }
        return $new_table;
    }

    /**
     * echos out a formatted list of columns in a table header format based on a table in the database
     * @param hidden_list the columns from the database the formatter should ignore
     * @param table_name the table from the database to echo
     * @param table the table from the database to echo
     * @param comb_table the sorted table from the database to echo
     * @return new_table an array containing all the names of all input fields generated
     */
    public function getColumnsAsHeaderUnsortable($hidden_list, $table_name, $table, $comb_table) {
        // get all the column information for the selected table in the database
        $new_table = [];// an array containing all the names of all input fields generated
        //loop through all the table column fields and create an input
        for($x = 0; $x < count($comb_table); $x++) {
            $field = $comb_table[$x];
            //check if the field is not in the ignore list
            if(!in_array($field["Field"], $hidden_list)) {
                $name = ucwords(str_replace("_", " ", $field["Field"]));//convert databse format for the name into a more readable format
                echo "<th class='",$table_name,"_sort'>".$name."</th>";//label the header field with the fields formatted name
                //put the field name in the form array
                array_push($new_table, $field);
            }
        }
        return $new_table;
    }

    /**
     * sort the table fields based on the field table sort numbers
     * @param table_info the fields from the field table
     * @param table the unsorted table
     * @param hidden_list the list of hidden fields
     * @return comb_table the sorted table with the information from the field table
     */
    public function reorderEntries($table_info, $table, $hidden_list) {

        //take the unsorted table and remove all the hidden fields
        $repli_table = array();
        foreach($table as $field) {
            if(!in_array($field["Field"], $hidden_list)) {
                array_push($repli_table, $field);
            }
        }

        //loop through the fields and the unsorted table, sort it and fill in any information from the field table into the associative array
        $comb_table = array();
        foreach($table_info as $field_info) {
            if(!in_array($field_info["field_name"], $hidden_list)) {
                for($x = 0; $x < count($repli_table); $x++) {
                    if($repli_table[$x]["Field"] == $field_info["field_name"]) {
                        $field_info["Field"] = $repli_table[$x]["Field"];
                        $field_info["Type"] = $repli_table[$x]["Type"];
                        $field_info["Comment"] = $repli_table[$x]["Comment"];
                        $field_info["Null"] = $repli_table[$x]["Null"];
                        array_push($comb_table, $field_info);
                    }
                }
                //manually add the ion table at the correct location
                if($field_info["field_name"] == "facility_and_ion_table") {
                    $field_info["Field"] = "facility_and_ion_table";
                    $field_info["Type"] = "text";
                    $field_info["Comment"] = "The location of the facility and ion tables";
                    $field_info["Null"] = "NULL";
                    array_push($comb_table, $field_info);
                }
            }
        }
        return $comb_table;
    }
}