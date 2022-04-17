<?php
//Uses XLSXWriter Class to generate Excel Sheadsheet from calendar_events
//Requires role > 1
header ( "Content-type: application/json;" );

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(isset($_COOKIE["PHPSESSID"]))
	{
		session_start();
		if ($_SESSION['role'] > 1){
			include "database.php";
			include "classes/CalendarControl.classes.php";
			include_once("classes/xlsxwriter.class.php");
			$cc = new CalendarControl();
			$result = $cc->getAllEvents();			
			$writer = new XLSXWriter();
			
			
			$facilityArray = array();
			$nameArray = array();
			foreach($result as $row) {
				$trigger = true;
				foreach ($facilityArray as $facility){
					if ($facility === $row['facility_id']){
						$trigger = false;
					}
				}
				if ($trigger){
					array_push($facilityArray, $row['facility_id']);
					array_push($nameArray, $row['location']);
				}
			}
			
			
			$headings = array('Request_ID','Date/Time From','Date/Time To','Event Title','Test Requester');
			$styles = array( 'font'=>'Arial','font-size'=>11,'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'widths'=>[15,20,20,20,20,10,10]);	
			
			
			//Must add all sheet headers before $orderedArray loop
			//First Added Will Be First Sheet
			//Add Header for this week
			$writer->writeSheetHeader('This Week', array('Request_ID'=>'string','Date/Time From'=>'MM/DD HH:MM', 'Date/Time To'=>'MM/DD HH:MM','Ions Tested'=>'string','Test Requester'=>'string', 'Title'=>'string', 'Approval'=>'string'), $styles);
			
			
			//Add Header for two week zoom
			$writer->writeSheetHeader('Two Week Zoom', array('Request_ID'=>'string','Date/Time From'=>'MM/DD HH:MM', 'Date/Time To'=>'MM/DD HH:MM','Ions Tested'=>'string','Test Requester'=>'string', 'Title'=>'string', 'Approval'=>'string'), $styles);
			
						
			//Create Headings For All Facilities
			foreach ($nameArray as $name){
			
				$writer->writeSheetHeader($name, array('Request_ID'=>'string','Date/Time From'=>'MM/DD HH:MM', 'Date/Time To'=>'MM/DD HH:MM','Ions Tested'=>'string','Test Requester'=>'string', 'Title'=>'string', 'Approval'=>'string'), $styles);
				
			}	

					
			$orderedArray = array();
			foreach ($facilityArray as $facility){
				$eventByFacility = array();
				foreach ($result as $row){
					
					if ($facility === $row['facility_id']){
						array_push($eventByFacility, $row);
					}
					
				}
				array_push($orderedArray, $eventByFacility);
			}
			
			foreach ($orderedArray as $eventArray){				
				
				
			
				$last = strtotime('0');
				foreach($eventArray as $row) {
						
						
						//Color Object Properly
						$color = '';
						if ($row['priority'] > 0){
							$color = $row['color'];
						}else{
							$color = "#97BACE";
						}
					
						if ($last > strtotime($row['from'])){
							$color = '#FF0000';
						}

						$last = strtotime($row['to']);
						
						
						
						//The Array is sorted and the events are properly colored
						//The logic below adds events to a sheet
						//Sheets with header for facility have been created
						//If you want to add sheets or improve the format 
						//Then please do so here
						//New Sheets are created with new sheet name
						//If you want to add new fuctions then hand it the $writer
						//Call to function example $this->functionName($writer)
						//To compare and control date in $row['from'] or $row['to']
						//Use date object $startDate= date("Y-m-d H:i:s",strtotime("-1 month"));  **month, week, day
						//$endDate= date("Y-m-d H:i:s",strtotime("+1 month"));  ** month, week, day
						//$fromDate= date("Y-m-d H:i:s",strtotime($row['from']));
						//$toDate= date("Y-m-d H:i:s",strtotime($row['to']));
						//date object uses logical comparitors > < == 
						
						$input = [$row['request_id'], $row['from'], $row['to'], $row['ion'], $row['group'], $row['title'], $row['approved'], $row['location']]; 
						$styles1 = array( 'font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>$color, 'halign'=>'center', 'border'=>'left,right,top,bottom');	
						
						
						//Example of adding this week zoom in of all facilities
						$startDate= date("Y-m-d H:i:s",strtotime("yesterday"));  
						$endDate= date("Y-m-d H:i:s",strtotime("+1 week")); 
						$fromDate= date("Y-m-d H:i:s",strtotime($row['from']));
												
						//if event is in range or other parameter do something
						if ($fromDate > $startDate && $fromDate < $endDate){
							//change style of row here							
							$writer->writeSheetRow('This Week', $input, $styles1);
							
						}
						
						//Example of adding 2 week zoom in of all facilities
						$startDate= date("Y-m-d H:i:s",strtotime("-1 week"));  
						$endDate= date("Y-m-d H:i:s",strtotime("+1 week")); 
						$fromDate= date("Y-m-d H:i:s",strtotime($row['from']));
												
						//if event is in range or other parameter do something
						if ($fromDate > $startDate && $fromDate < $endDate){
							//change style of row here							
							$writer->writeSheetRow('Two Week Zoom', $input, $styles1);
							
						}					
						
						
						//All events from -1 month to future in sheets by facility
										
						$writer->writeSheetRow($row['location'], $input, $styles1);
						
						
						
						
						
						
					
				}
			}				
			
			//Send completed file
			$filename = "RadFX_Schedule.xlsx";
			http_response_code(200);
			header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			$writer->writeToStdOut();
		
		}else{
			echo "Insufficent Access";
		}
	}
		
}
 

  




