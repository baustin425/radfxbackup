<?php
/**
 * takes submitted request information and creates a request and any calendar events associated with the request
 * @author ETurner
 */
class Request extends Database {
    
     /**
     * attempt to lsave a request based on user submitted information
     * @param post_info the submitted information
     */
    public function submitRequest($post_info) {
        $this->saveRequest($post_info);
    }

     /**
     * convert a date from html datetime format to the date format required by the calendar
     * @param ori_date the submitted date
     * @return new_date string: date in the correct format
     */
    private function dateConvert($ori_date) {
        $new_date = $ori_date.".000";
        return $new_date;
    }

    /**
     * create an event for the calendar and submit it to the database
     * @param request_info the information submitted by the user for the calendar event creation
     * @param conn the database connection
     */
    private function createEvent($request_info, $conn) {

        //create calendar event based on the request
        $sql = $conn->prepare("INSERT INTO `calendar_events` (`from`, `to`, `title`, `description`, `location`, `color`, `colorText`, `colorBorder`, `group`, `url`, `repeatEvery`, `created`, `repeatEveryCustomType`, `repeatEveryCustomValue`, `lastUpdated`, `request_id`, `energy`, `ion`, `total_hours`, `facility_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        //if sql statement fails return to request page with error
        if(!$sql->execute($request_info)) {
            $sql = null;
            header("location: ../Request.php?error=event");
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
     * @param shift the selected shifts for the event
     */
    public function saveEvent($earliest_date, $total_hours, $organization, $purpose_of_test, $facility_id, $request_id, $energy, $ion_string, $conn, $schedule_group, $shift) {
       

        $title = $request_id.":".$organization;//generate the title for the event using the request id and the organization name
        $description = $purpose_of_test;//a short description of the event
        
        // preset several of the event fields
        $all_day = 0;
        $color = "#FF0000"; 
        $color_text = "#FFFF00"; 
        $repeat_every = 0; 
        $URL = "EditRequest.php?req_id=".$request_id;
        $created = $this->dateConvert(date("Y-m-d")."T".date("H:i:s"));
        $last_updated = $created;
        $repeat_every_custom_type = 0;
        $repeat_every_custom_value = 1;

        //fetch the facility name
        $sql = $conn->prepare("SELECT * FROM facility where facility_id = $facility_id;");
        $sql->execute();
        $facilities = $sql->fetchAll(PDO::FETCH_ASSOC);


        //set the location and color to the facility feteched
        $location = $facilities[0]["name"];
        $color_border = $facilities[0]["color"]; 
  

		$start_date = $earliest_date;
		
        //create all the shift information variables
        $shift_start;
        $shift_start_string;
		$shift_end_string;
        $shift_end;
        $shift_hours;
		$alternate_end;
		$alternate_start;
        //convert binary to decimal to get shift number
        $shift = bindec($shift);
        //set all shift information
        if($shift == 1) {
            $shift_start = 16.0;
            $shift_start_string = "T16:00:00.000";
            $shift_end  = 24.0;
            //adjust the end time by one minute if it ends at midnight as requested for correct calendar formatting
			$shift_end_string = "T23:59:00.000";
            $shift_hours = 8.0;
        } else if($shift == 2) {
            $shift_start = 8.0;
            $shift_start_string = "T08:00:00.000";
            $shift_end  = 16.0;
			$shift_end_string = "T16:00:00.000";
            $shift_hours = 8.0;
        } else if($shift == 3) {
            $shift_start = 8.0;
            $shift_start_string = "T08:00:00.000";
            $shift_end  = 24.0;
            //adjust the end time by one minute if it ends at midnight as requested for correct calendar formatting
			$shift_end_string = "T23:59:00.000";
            $shift_hours = 16.0;
        } else if($shift == 4) {
            $shift_start = 0.0;
            $shift_start_string = "T00:00:00.000";
            $shift_end  = 8.0;
			$shift_end_string = "T08:00:00.000";
            $shift_hours = 8.0;
        } else if($shift == 5) {
            $shift_start = 16.0;
            $shift_start_string = "T16:00:00.000";
            $shift_end  = 8.0;
			$shift_end_string = "T08:00:00.000";
            $shift_hours = 16.0;
			$alternate_start = "T00:00:00.000";
            //adjust the end time by one minute if it ends at midnight as requested for correct calendar formatting
			$alternate_end = "T23:59:00.000";
        } else if($shift == 6) {
            $shift_start = 0.0;
            $shift_start_string = "T00:00:00.000";
            $shift_end  = 16.0;
			$shift_end_string = "T16:00:00.000";
            $shift_hours = 16.0;
        } else if($shift == 7) {
            $shift_start = 0.0;
            $shift_start_string = "T00:00:00.000";
            $shift_end  = 24.0;
            //adjust the end time by one minute if it ends at midnight as requested for correct calendar formatting
			$shift_end_string = "T23:59:00.000";
            $shift_hours = 24.0;
        }
		
		$hours_left = floatval($total_hours);
		$addition = '';
		$counter = 0;
        //while the request still has enough hours left to fill an entire shit, continue to generate full shift events
		while ($hours_left >= $shift_hours){
            //if not the split shift
			if ($shift != 5){
				$from_date = date("Y-m-d", strtotime($start_date.$addition)).$shift_start_string;
				$to_date = date("Y-m-d", strtotime($start_date.$addition)).$shift_end_string;
				$this->createEvent(array($from_date, $to_date, $title, $description, $location, $color, $color_text, $color_border, $schedule_group, $URL, $repeat_every, $created, $repeat_every_custom_type, $repeat_every_custom_value, $last_updated, $request_id, $energy, $ion_string, $total_hours, $facility_id), $conn);
				
				$counter += 1;
				$addition = '+ '.strval($counter).' days';
				$hours_left -= $shift_hours;
			}else{
				//if the split shift make two events
				$from_date = date("Y-m-d", strtotime($start_date.$addition)).$shift_start_string;
				$to_date = date("Y-m-d", strtotime($start_date.$addition)).$alternate_end;
				$this->createEvent(array($from_date, $to_date, $title, $description, $location, $color, $color_text, $color_border, $schedule_group, $URL, $repeat_every, $created, $repeat_every_custom_type, $repeat_every_custom_value, $last_updated, $request_id, $energy, $ion_string, $total_hours, $facility_id), $conn);
				
				$counter += 1;
				$addition = '+ '.strval($counter).' days';
				
				$from_date = date("Y-m-d", strtotime($start_date.$addition)).$alternate_start;
				$to_date = date("Y-m-d", strtotime($start_date.$addition)).$shift_end_string;
				$this->createEvent(array($from_date, $to_date, $title, $description, $location, $color, $color_text, $color_border, $schedule_group, $URL, $repeat_every, $created, $repeat_every_custom_type, $repeat_every_custom_value, $last_updated, $request_id, $energy, $ion_string, $total_hours, $facility_id), $conn);
								
				
				$hours_left -= $shift_hours;			
			}
			
			
		}

        //if after all full day events generated there are still hours left make one last event
		if ($hours_left > 0){
			$time_diff = $shift_hours - $hours_left;
			
            //if not a split shift
			if ($shift != 5){
                if($shift_end_string == "T23:59:00.000") {
                    $shift_end_string = "T24:00:00.000";
                }
				$addition = '+ '.strval($counter).' days';
				$end_time = explode('T',$shift_end_string)[1];			
				$remainder = intval($time_diff * 60);
				$shift_end_string = date("H:i:s", strtotime($end_time.'- '.$remainder.' mins'));
				$shift_end_string = 'T'.$shift_end_string;
                if($shift_end_string == "T00:00:00") {
                    $shift_end_string = "T23:59:00";
                }
				$from_date = date("Y-m-d", strtotime($start_date.$addition)).$shift_start_string;			
				$to_date = date("Y-m-d", strtotime($start_date.$addition)).$shift_end_string;
				$this->createEvent(array($from_date, $to_date, $title, $description, $location, $color, $color_text, $color_border, $schedule_group, $URL, $repeat_every, $created, $repeat_every_custom_type, $repeat_every_custom_value, $last_updated, $request_id, $energy, $ion_string, $total_hours, $facility_id), $conn);
			
			}else{
				// if a split shift and more than 8 hours left make two final events
				if ($hours_left > 8){
					$addition = '+ '.strval($counter).' days';
					$from_date = date("Y-m-d", strtotime($start_date.$addition)).$shift_start_string;
					$to_date = date("Y-m-d", strtotime($start_date.$addition)).$alternate_end;
					$this->createEvent(array($from_date, $to_date, $title, $description, $location, $color, $color_text, $color_border, $schedule_group, $URL, $repeat_every, $created, $repeat_every_custom_type, $repeat_every_custom_value, $last_updated, $request_id, $energy, $ion_string, $total_hours, $facility_id), $conn);
				
                    $time_diff = 16.0 - $hours_left;
					$counter += 1;
					$addition = '+ '.strval($counter).' days';
					$end_time = explode('T',$shift_end_string)[1];			
					$remainder = intval($time_diff * 60);
					$shift_end_string = date("H:i:s", strtotime($end_time.'- '.$remainder.' mins'));
					$shift_end_string = 'T'.$shift_end_string;
					$from_date = date("Y-m-d", strtotime($start_date.$addition)).$alternate_start;
					$to_date = date("Y-m-d", strtotime($start_date.$addition)).$shift_end_string;
					$this->createEvent(array($from_date, $to_date, $title, $description, $location, $color, $color_text, $color_border, $schedule_group, $URL, $repeat_every, $created, $repeat_every_custom_type, $repeat_every_custom_value, $last_updated, $request_id, $energy, $ion_string, $total_hours, $facility_id), $conn);
								
									
					
				//if a split shift and less than 8 hours left just make one final event	
				}else{
                    if($alternate_end == "T23:59:00.000") {
                        $alternate_end = "T24:00:00.000";
                    }
					$time_diff = 8.0- $hours_left;
					$addition = '+ '.strval($counter).' days';
					$end_time = explode('T',$alternate_end)[1];			
					$remainder = intval($time_diff * 60);
					$alternate_end = date("H:i:s", strtotime($end_time.'- '.$remainder.' mins'));
					$alternate_end = 'T'.$alternate_end;
                    if($alternate_end == "T00:00:00") {
                        $alternate_end = "T23:59:00";
                    }
					$from_date = date("Y-m-d", strtotime($start_date.$addition)).$shift_start_string;			
					$to_date = date("Y-m-d", strtotime($start_date.$addition)).$alternate_end;
					$this->createEvent(array($from_date, $to_date, $title, $description, $location, $color, $color_text, $color_border, $schedule_group, $URL, $repeat_every, $created, $repeat_every_custom_type, $repeat_every_custom_value, $last_updated, $request_id, $energy, $ion_string, $total_hours, $facility_id), $conn);
				
				}
				
			}
		}

		     
        
    }


    /**
     * get the start time based on the start day and the selected shifts
     * @param earliest_date the start date
     * @param shift the selected shifts
     * @return earliest_date the new start date and time
     */
    private function getEarliestDate($earliest_date, $shift) {
        $shift = bindec($shift);
        //set all shift information
        if($shift == 1) {
            $earliest_date = $earliest_date."T16:00";
        } else if($shift == 2) {
            $earliest_date = $earliest_date."T08:00";
        } else if($shift == 3) {
            $earliest_date = $earliest_date."T08:00";
        } else if($shift == 4) {
            $earliest_date = $earliest_date."T00:00";
        } else if($shift == 5) {
            $earliest_date = $earliest_date."T16:00";
        } else if($shift == 6) {
            $earliest_date = $earliest_date."T00:00";
        } else if($shift == 7) {
            $earliest_date = $earliest_date."T00:00";
        }
        return $earliest_date;
    }
    
    /**
     * adds a request to the request table in the database
     * @param post_info post_info[the input name] the associative array containing information submitted by the user through a form
     */
    private function saveRequest($post_info) {

        $request_info = []; // the information being entered into the columns
        $name_info = []; // the name of the columns
        $key_info = array_keys($post_info);
        $value_str = "";
        $energy_level = 0;
        //set the organization of the user submitting the request
        $organization = "none";
        if(array_key_exists("affiliation_name", $post_info)) {
            $organization = $post_info["affiliation_name"];
        }
        //set the name of the user/organization submitting the request
        $schedule_group = "none";
        if($_SESSION["fullname"] != null) {
            $schedule_group = $_SESSION["fullname"];
        }
        //set the start date
        $post_info["earliest_date"] = $this->getEarliestDate($post_info["earliest_date"],$post_info["shift"]);
        
        // go through all the submitted information, edit them to correct submission format, and then put them into arrays for submission
        for($x = 0; $x < count($post_info) - 1; $x++) {
            $name = $key_info[$x];// the name of the column
            $value = "";// the value being entered into the column
            $early_exit = false;
            if($name == "facility") { //if the submission key is facility then set the name of the column to facility_id
                $value = $post_info[$name];
                $name = "facility_id";
            } else if($name == "searchbar" || $name == "ion") {//skip the input if the key is searchbar or ion as they are either not submitted or submitted seperately
                continue;
            }
            else if($post_info[$name] == "on") {// convert any checkboxes into binary true
                $value = "1";
            } else if($post_info[$name] == "") {// convert any checkboxes into binary true
                $value = NULL;
            } else {
                $value = $post_info[$name];// the values put into the form
            }
            if($name == "energy_level") {
                $energy_level = $post_info[$name];
            }
            //check if input has any incorrect characters
            if(!$this->formatCorrect(strtolower(str_replace(" ", "_", $name))) || !$this->confirmFormat(str_replace(" ", "_",$value))) {
                echo $name;
                echo "<br>";
                echo $value;
                exit();
                header("location: ../Request.php?error=input_check");
                exit();
            }
            // formaat the sql statement input (?, ?, ?) for each value
            if($x == 0) {
                $value_str = "?";
            } else {
                $value_str .= ", ?";
            }
            //push the column name and the value into their respective arrays
            array_push($request_info, $value);
            array_push($name_info, $name);
        }


        //add the user id to respective arrays
        array_push($name_info, "user_id");
        array_push($request_info, $_SESSION['id']);
        $value_str .= ", ?";

        //format for sql prepare statement
        $column_list = join(',', $name_info);


        
        // inset the new request into the request table with the inputted values
        $conn = $this->connect();
        $sql = $conn->prepare("INSERT INTO request ($column_list) Values ($value_str);");
        if(!$sql->execute($request_info)) {
            exit();
            $sql = null;
            header("location: ../Request.php?error=request");
            exit();
        }
        // get the id of the last created request
        $req_id = $conn->lastInsertId();


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
                    if(!$this->formatCorrect(strtolower(str_replace(" ", "_", $type))) || !$this->confirmFormat(str_replace(" ", "_",$value))) {
                        header("location: ../Request.php?error=input_check");
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
                    header("location: ../Request.php?error=ion");
                    exit();
                }
                $sql = null;

                //fetch the ion name and add to the ion string
                if($ion_string == "") {
                    //$ion_string = $cur_ion["name"];
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

        //create a calendar event for the new request
        $this->saveEvent($post_info["earliest_date"], $post_info["total_hours"], $organization, $post_info["purpose_of_test"], $post_info["facility"], $req_id, $energy_level, $ion_string, $conn, $schedule_group, $post_info["shift"]);

        $sql = null;
    }

    /**
     * convert the checked box to bindary shift format
     * @param box a check box value that is either on or ""
     * @return num the value converted to binary
     */
    private function binaryConvert($box) {
        if($box == "on") {return "1"; }
        else { return "0"; }
    }
}
