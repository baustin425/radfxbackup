<?php
//This class controls the interaction with the calendar_events table in the database
//It controls the events returned to the user and commits the edits made by users
class CalendarControl extends Database {
	
	//Return all calendar_events table entries
	public function getAllEvents(){
		
		$startDate= date("Y-m-d H:i:s",strtotime("-1 month"));
		//Will return Previous month and all future events
		$sql = $this->connect()->prepare('SELECT * FROM calendar_events WHERE DATE(`from`) > ? ORDER BY `from`;');
        
		if(!$sql->execute([$startDate])) {
			$sql = null;
			$location .= "?error=prepare";
			header($location);
			exit();
		}

		$event_table = $sql->fetchAll(PDO::FETCH_ASSOC);

		$sql = null;
		
		return $event_table;
	}
	
	
	//Return Unfulfilled Requests and associated information from multiple tables
	//Template for complex sql statements 
	public function getRequests(){
		
		
		$sql = $this->connect()->prepare("SELECT DISTINCT r.`user_id`, r.`request_id`, r.`total_hours`, r.`purpose_of_test`, c.`priority`, c.`approved`, f.`name`, f.`color` FROM `request` AS r, `calendar_events` AS c, `facility` AS f WHERE r.`request_id` = ANY(SELECT DISTINCT `request_id` FROM `calendar_events` WHERE DATE(`from`) > (current_date()-7)) AND c.`request_id` = r.`request_id` AND f.`facility_id` = r.`facility_id`;");
        
		if(!$sql->execute()) {
			$sql = null;
			$location .= "?error=prepare";
			header($location);
			exit();
		}

		$request_table = $sql->fetchAll(PDO::FETCH_ASSOC);

		$sql = null;
		
		return $request_table;
	}
	
	//Return all published_events table entries
	public function getPublishedEvents(){
		$sql = $this->connect()->prepare("SELECT * FROM published_events;");
        
		if(!$sql->execute()) {
			$sql = null;
			$location .= "?error=prepare";
			header($location);
			exit();
		}

		$event_table = $sql->fetchAll(PDO::FETCH_ASSOC);

		$sql = null;
		
		
		return $event_table;
	}
	
	
	//Return only the events associated with a specific user
	public function getUserEvents($fullname){
		
		
		
		$sql = $this->connect()->prepare("SELECT * FROM published_events WHERE `group` = ?;");
        
		if(!$sql->execute([$fullname])) {
			$sql = null;
			$location .= "?error=prepare";
			header($location);
			exit();
		}

		$event_table = $sql->fetchAll(PDO::FETCH_ASSOC);

		$sql = null;
		
		
		return $event_table;
	}
	
	
	//Return events by facility and ion array
	//This is the primary function used by the active calendar.
	public function getSearchEvents($facility, $ions){
		
		
		
		$ions = json_decode($ions);
		$stmt = "";
		$count = count($ions);
		$insert = array();		
		$index = 0;		
		
		//If any ions were selected, include ions in query
		if ($count > 0){
			array_push($insert, $facility);
			array_push($insert, $ions[$index]);
			$stmt = "SELECT * FROM calendar_events WHERE facility_id = ? AND ";
						
			$stmt .= "request_id = ANY(SELECT request_id FROM request_ion WHERE ion_id = ?";
			$count -= 1;
			$index += 1;
			while($count > 0){
				array_push($insert, $ions[$index]);
				$stmt .= " OR ion_id = ?";
				$count -= 1;
				$index += 1;
			}		
			
			
			$startDate= date("Y-m-d H:i:s",strtotime("-1 month"));
			$stmt .= "); AND DATE(`from`) > ";
			$stmt .= $startDate;
			$stmt .= ";";	
			
			$sql = $this->connect()->prepare($stmt);
			if(!$sql->execute($insert)) {
				$sql = null;
				$location .= "?error=prepare";
				header($location);
				exit();
			}
			$event_table = $sql->fetchAll(PDO::FETCH_ASSOC);
		}elseif ($facility === '0'){
			$startDate= date("Y-m-d H:i:s",strtotime("-1 month"));			
			$stmt = "SELECT * FROM calendar_events WHERE DATE(`from`) > ?";
			$sql = $this->connect()->prepare($stmt);
			if(!$sql->execute([$startDate])) {
				$sql = null;
				$location .= "?error=prepare";
				header($location);
				exit();
			}
			$event_table = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		//If no ions are selected return all events at a specific facility
		}else{
		$startDate= date("Y-m-d H:i:s",strtotime("-1 month"));			
		$stmt = "SELECT * FROM calendar_events WHERE facility_id = ? AND DATE(`from`) > ?";
		$sql = $this->connect()->prepare($stmt);
		if(!$sql->execute([$facility, $startDate])) {
			$sql = null;
			$location .= "?error=prepare";
			header($location);
			exit();
		}
		$event_table = $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		
		
		return $event_table;
		}
		
		
		
	
		
	
	//Commit an array of events returned from the calendar on the client
	//This function is not used
	public function commitEvents ($events) {
		
	  $obj = json_decode($events);  
  
	  foreach($obj as $event){
				
		$this->commitEvent($event, true);
			
			
		}		
	}
	
	
	//Check for valid subevent chains
	//Remove all entries from the published_events table
	//Strip priority color and add approved events from calendar_events table to published_events table.
	//Email all users about a newly updated schedule
	public function publishEvents () {
		
		
				
		$sql = $this->connect()->prepare("SELECT DISTINCT request_id FROM calendar_events");
		if(!$sql->execute()) {
			$sql = null;
			$location .= "?error=prepare";
			header($location);
			exit();
		}

		$requests = $sql->fetchAll(PDO::FETCH_ASSOC);
		$sql = null;
		
		$badEvents = array();
		//check for bad subevent chain, block and notify
		foreach($requests as $request){
			
			$total_seconds = 0;
			$sql = $this->connect()->prepare("SELECT * FROM calendar_events WHERE request_id = ?");
			if(!$sql->execute([$request['request_id']])) {
				$sql = null;
				$location .= "?error=prepare";
				header($location);
				exit();
			}

			$dupEvents = $sql->fetchAll(PDO::FETCH_ASSOC);
			$sql = null;
			$total_hours = $dupEvents[0]['total_hours'];
		
			foreach ($dupEvents as $dupEvent){
				$total_seconds += $this->getTotalSeconds($dupEvent['from'], $dupEvent['to']);
			}
			
			$tolerance = count($dupEvents);
		
		
		
			
			$time_diff = $total_seconds - ($total_hours * 3600);
			if ( $time_diff < (-$tolerance*60)){
				
				array_push($badEvents, $request['request_id']);				
				
			}
			
			if ( $time_diff > 0){
				
				array_push($badEvents, $request['request_id']);				
				
			}
			
		}
		
		
		if (count($badEvents) > 0){
			echo("Trigger There are inconsistent events in the calendar \n");
			echo("Please Inspect The Event Chains With The Following ID(s) \n");
			foreach($badEvents as $badEvent){
				echo($badEvent."\n");
			}
		}else{
		
		
		
		
		
			 $sql = $this->connect()->prepare( "DELETE FROM `radfx`.`published_events`;");
			 $sql->execute();
			 $sql = null;
			 $sql = $this->connect()->prepare("SELECT 
				`calendar_events`.`from`,
				`calendar_events`.`to`,
				`calendar_events`.`title`,
				`calendar_events`.`description`,
				`calendar_events`.`location`,
				`calendar_events`.`color`,
				`calendar_events`.`colorText`,
				`calendar_events`.`colorBorder`,
				`calendar_events`.`group`,
				`calendar_events`.`url`,
				`calendar_events`.`repeatEvery`,
				`calendar_events`.`repeatEveryExcludeDays`,
				`calendar_events`.`seriesIgnoreDates`,
				`calendar_events`.`created`,
				`calendar_events`.`organizerName`,
				`calendar_events`.`organizerEmailAddress`,
				`calendar_events`.`repeatEnds`,
				`calendar_events`.`repeatEveryCustomType`,
				`calendar_events`.`repeatEveryCustomValue`,
				`calendar_events`.`lastUpdated`,
				`calendar_events`.`approved`,
				`calendar_events`.`priority`,
				`calendar_events`.`ion`,
				`calendar_events`.`energy`,
				`calendar_events`.`request_id` ,
				`calendar_events`.`total_hours` ,
				`calendar_events`.`facility_id` 				
			FROM `radfx`.`calendar_events` WHERE `approved`=1 AND DATE(`from`) > ?;");
			$startDate= date("Y-m-d H:i:s",strtotime("-1 month"));
			$sql->execute([$startDate]);
		
			$event_table = $sql->fetchAll(PDO::FETCH_ASSOC);

			
			foreach($event_table as $event){
				$event = json_decode(json_encode($event));
			
				$sql2 = $this->connect()->prepare("INSERT INTO `radfx`.`published_events`
								(`from`,
								`to`,
								`title`,
								`description`,
								`location`,
								`color`,
								`colorText`,
								`colorBorder`,
								`group`,
								`url`,				
								`repeatEvery`,
								`repeatEveryExcludeDays`,
								`seriesIgnoreDates`,
								`created`,
								`organizerName`,
								`organizerEmailAddress`,
								`repeatEnds`,
								`repeatEveryCustomType`,
								`repeatEveryCustomValue`,
								`lastUpdated`,
								`approved`,
								`priority`,
								`ion`,
								`energy`,
								`request_id`,
								`total_hours`,
								`facility_id`)
								VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
							$sql2->execute([$event->from, $event->to, $event->title, 
								$event->description, $event->location, 
								"#08344E", $event->colorText, $event->colorBorder, 
								$event->group, $event->url, $event->repeatEvery,
								$event->repeatEveryExcludeDays , $event->seriesIgnoreDates , $event->created ,
								$event->organizerName , $event->organizerEmailAddress , $event->repeatEnds ,
								$event->repeatEveryCustomType , $event->repeatEveryCustomValue , $event->lastUpdated ,
								$event->approved, "0", $event->ion, 
								$event->request_id, $event->total_hours, $event->facility_id, $event->energy]);   
							$sql2 = null;
			}
			
		}
			
		
			
		
	 
	}
	
	//Used to validate subevent chains
	private function getTotalSeconds($from, $to){
		
		$start = date_create($from);
		$end = date_create($to);		

		
		return($end->getTimestamp() - $start->getTimestamp() ); 
	
	}
	
	
	
	//Commit client side changes to the database
	public function commitEvent ($event, $trigger) {		
		$event = json_decode($event);
			
		
		/**
		*
		* The Following Checks For Subevents and Maintains The Time Consistency
		* Without prohibiting the changes
		* User is alerted to time to add or subtract
		**/
		$sql = $this->connect()->prepare("SELECT * FROM calendar_events WHERE request_id = ? AND id <> ?");
		if(!$sql->execute([$event->request_id, $event->id])) {
			$sql = null;
			$location .= "?error=prepare";
			header($location);
			exit();
		}

		$dupEvents = $sql->fetchAll(PDO::FETCH_ASSOC);
		$sql = null;
		$total_seconds = $this->getTotalSeconds($event->from, $event->to);
		
		foreach ($dupEvents as $dupEvent){
			$total_seconds += $this->getTotalSeconds($dupEvent['from'], $dupEvent['to']);
		}
		
		$tolerance = count($dupEvents)+1;
		
		$time_diff = $total_seconds - ($event->total_hours * 3600);
		if ( $time_diff < (-$tolerance*60)){
			
			echo("The event chain you edited \n does not match the requested hours \n Please re-create subevents \n Or ADD the following to the event chain \n ");
			$dtF = new \DateTime('@0');
			$dtT = new \DateTime("@$time_diff");
			echo $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');				
			
		}
		
		if ( $time_diff > 0){
			
			echo("The event chain you edited \n does not match the requested hours \n Please re-create subevents \n Or SUBTRACT the following from the event chain \n ");
			$dtF = new \DateTime('@0');
			$dtT = new \DateTime("@$time_diff");
			echo $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');				
			
		}
		
		
		
		
		
		//check if it is a new event
		if (strpos($event->id, "-") > 0){
			$trigger = false;
		}
		
		
		//Error Handle for missing attribute
		if (!array_key_exists('repeatEvery', $event)){
			$event->repeatEvery = null;
		}
		if (!array_key_exists('repeatEveryExcludeDays', $event)){
			$event->repeatEveryExcludeDays = null;
		}
		if (!array_key_exists('seriesIgnoreDates', $event)){
			$event->seriesIgnoreDates = null;
		}
		if (!array_key_exists('created', $event)){
			$event->created = null;
		}
		if (!array_key_exists('organizerName', $event)){
			$event->organizerName = null;
		}
		if (!array_key_exists('organizerEmailAddress', $event)){
			$event->organizerEmailAddress = null;
		}
		if (!array_key_exists('repeatEnds', $event)){
			$event->repeatEnds = null;
		}
		if (!array_key_exists('repeatEveryCustomType', $event)){
			$event->repeatEveryCustomType = null;
		}
		if (!array_key_exists('repeatEveryCustomValue', $event)){
			$event->repeatEveryCustomValue = null;
		}
		if (!array_key_exists('lastUpdated', $event)){
			$event->lastUpdated = null;
		}
		if (!array_key_exists('approved', $event)){
			$event->approved = null;
		}
		if (!array_key_exists('priority', $event)){
			$event->priority = null;
		}
		if (!array_key_exists('ion', $event)){
			$event->ion = null;
		}
		if (!array_key_exists('energy', $event)){
			$event->energy = null;
		}
		if (!array_key_exists('request_id', $event)){
			$event->request_id = null;
		}
		if (!array_key_exists('total_hours', $event)){
			$event->total_hours = null;
		}
			if (!array_key_exists('facility_id', $event)){
			$event->facility_id = null;
		}
		
		
				

		//Update if event already exists
		if ($trigger){			
			
			 $sql = $this->connect()->prepare("UPDATE calendar_events
				SET				
				`from` = ?,
				`to` = ?,
				`title` = ?,
				`description` = ?,
				`location` = ?,				
				`color` = ?,
				`colorText` = ?,
				`colorBorder` = ?,
				`group` = ?,
				`url` = ? ,
				`repeatEvery` = ?,
				`repeatEveryExcludeDays` = ?,
				`seriesIgnoreDates` = ?,
				`created` = ?,
				`organizerName` = ?,
				`organizerEmailAddress` = ?,
				`repeatEnds` = ?,
				`repeatEveryCustomType` = ?,
				`repeatEveryCustomValue` = ?,
				`lastUpdated` = ?,
				`approved`= ?,
				`priority` = ?,
				`ion` = ?							
				WHERE `id` = ?;");
			
			$sql->execute([$event->from, $event->to, $event->title, 
							$event->description, $event->location, 
							$event->color, $event->colorText, $event->colorBorder, 
							$event->group, $event->url, $event->repeatEvery,
							$event->repeatEveryExcludeDays , $event->seriesIgnoreDates , $event->created ,
							$event->organizerName , $event->organizerEmailAddress , $event->repeatEnds ,
							$event->repeatEveryCustomType , $event->repeatEveryCustomValue , $event->lastUpdated ,
							$event->approved , $event->priority, $event->ion, $event->id]);  
			$sql = null;
			
			
			$sql = $this->connect()->prepare("SELECT `id` FROM calendar_events WHERE request_id = ?;");
			$sql->execute([$event->request_id]);
			$results = $sql->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($results as $result){
				
				 $sql = $this->connect()->prepare("UPDATE calendar_events
				SET		
				`location` = ?,				
				`color` = ?,
				`colorText` = ?,
				`colorBorder` = ?,				
				`approved`= ?,
				`priority` = ?								
				WHERE `id` = ?;");
			
			$sql->execute([$event->location, $event->color, $event->colorText, $event->colorBorder, 							
							$event->approved, $event->priority, $result['id']]);  
			$sql = null;
				
			}
			
			
		
		
		//Insert if event is added
		}else{			  
			  $sql = $this->connect()->prepare("INSERT INTO `radfx`.`calendar_events`
			(`from`,
			`to`,
			`title`,
			`description`,
			`location`,
			`color`,
			`colorText`,
			`colorBorder`,
			`group`,
			`url`,
			`repeatEvery`,
			`repeatEveryExcludeDays`,
			`seriesIgnoreDates`,
			`created`,
			`organizerName`,
			`organizerEmailAddress`,
			`repeatEnds`,
			`repeatEveryCustomType`,
			`repeatEveryCustomValue`,
			`lastUpdated`,
			`approved`,
			`priority`,
			`ion`,
			`energy`,
			`request_id`,
			`total_hours`,
			`facility_id`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
			$sql->execute([$event->from, $event->to, $event->title, 
							$event->description, $event->location, 
							$event->color, $event->colorText, $event->colorBorder, 
							$event->group, $event->url, $event->repeatEvery,
							$event->repeatEveryExcludeDays , $event->seriesIgnoreDates , $event->created ,
							$event->organizerName , $event->organizerEmailAddress , $event->repeatEnds ,
							$event->repeatEveryCustomType , $event->repeatEveryCustomValue , $event->lastUpdated ,
							$event->approved, $event->priority, $event->ion, $event->energy, 
							$event->request_id, $event->total_hours, $event->facility_id]);   
			 // $sql = null;
		}		
	}
	
	
	//Remove a single event from calendar_events table
	//Checks subevent chain and will prohibit removal of the root event
	public function removeEvent($id){
		
			
		$sql = $this->connect()->prepare("SELECT request_id, total_hours FROM calendar_events WHERE id = ?");
		if(!$sql->execute([$id])) {
			$sql = null;
			$location .= "?error=prepare";
			header($location);
			exit();
		}

		$result = $sql->fetchAll(PDO::FETCH_ASSOC);
		$sql = null;
		$request_id = $result[0]['request_id'];
		$total_hours = $result[0]['total_hours'];	
	
		
		
		/**
		*
		* The Following Checks For Subevents and Maintains The Time Consistency
		* Without prohibiting the changes
		* User is alerted to time to add or subtract
		**/
		$sql = $this->connect()->prepare("SELECT * FROM calendar_events WHERE request_id = ? AND id <> ?");
		if(!$sql->execute([$request_id, $id])) {
			$sql = null;
			$location .= "?error=prepare";
			header($location);
			exit();
		}

		$dupEvents = $sql->fetchAll(PDO::FETCH_ASSOC);
		$sql = null;
		
		//Select the events with the same request_id
		$sql = $this->connect()->prepare("SELECT COUNT(*) FROM calendar_events WHERE request_id = ? AND id <> ?");
		if(!$sql->execute([$request_id, $id])) {
			$sql = null;
			$location .= "?error=prepare";
			header($location);
			exit();
		}

		$result = $sql->fetchAll(PDO::FETCH_ASSOC);
		$sql = null;
		$count = $result[0]['COUNT(*)'];
		
		
		$total_seconds = 0; 
		//If there are additional subevents in the chain, then allow the removal
		if ($count > 0){
			
			$sql2 = $this->connect()->prepare("DELETE FROM calendar_events WHERE id = ?;");
			$sql2->execute([$id]);
			$sql2 = null;
			
			
			foreach ($dupEvents as $dupEvent){
				$total_seconds += $this->getTotalSeconds($dupEvent['from'], $dupEvent['to']);
			}
			
			
			$time_diff = $total_seconds - ($total_hours * 3600);
			if ( $time_diff < 0){
				
				echo("The event chain you edited \n does not match the requested hours \n Please re-create subevents \n Or ADD the following to the event chain \n ");
				$dtF = new \DateTime('@0');
				$dtT = new \DateTime("@$time_diff");
				echo $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');				
				
			}
			
			if ( $time_diff > 0){
				
				echo("The event chain you edited \n does not match the requested hours \n Please re-create subevents \n Or SUBTRACT the following to the event chain \n ");
				$dtF = new \DateTime('@0');
				$dtT = new \DateTime("@$time_diff");
				echo $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');				
				
			}		
		}else{
			//If there is only one event in the chain, then promt admin to cancel request
			echo ("Please Cancel The Request In Order To Remove The Root Event");
		}
		
	}
	
	//Delete a group of subevents from the calendar_events table
	public function removeDupEvent($id){
		$sql = $this->connect()->prepare("SELECT request_id FROM calendar_events WHERE id = ?;");
		$sql->execute([$id]);
		$results = $sql->fetchAll(PDO::FETCH_ASSOC);
		$sql = null;
		$sql = $this->connect()->prepare("DELETE FROM calendar_events WHERE request_id = ?;");
		
		$sql->execute([$results[0]['request_id']]);
	}
	
	
	//Recreate a group of subevents from Request logic
	public function commitDupEvent($event) {
		
		include "Request.classes.php";
		$request = new Request();
		$event = json_decode($event);
		
		
		
		//Recover the shift from database
		$sql = $this->connect()->prepare("SELECT shift FROM request WHERE request_id = ?;");
		$sql->execute([$event->request_id]);
		$results = $sql->fetchAll(PDO::FETCH_ASSOC);		
		$shift = $results[0]['shift'];   
		
		

		//convert the start date to the correct format
		$earliest_date = substr($event->from, 0, -8);
		$total_hours = $event->total_hours; 		
		$organization = (explode(':', $event->title))[1];		
		$purpose_of_test = $event->description;
		$facility_id = $event->facility_id;	
		$request_id = $event->request_id;
		$energy = $event->energy; 
		$ion_string = $event->ion;
		$conn = $this->connect();		
		$schedule_group = $event->group;       
		$request->saveEvent($earliest_date, $total_hours, $organization, $purpose_of_test, $facility_id, $request_id, $energy, $ion_string, $conn, $schedule_group, $shift); 
		
		
       
    } 

	//Recreate subevent chain for edited event
	public function commitEditedEvent($earliest_date, $total_hours, $organization, $purpose_of_test, $facility_id, $request_id, $energy, $ion_string, $conn, $schedule_group) {
		
		include "Request.classes.php";
		$request = new Request();		
		$sql = $this->connect()->prepare("DELETE FROM calendar_events WHERE request_id = ?;");
		$sql->execute([$request_id]);
		$sql = null;
		
		//Recover the shift from database
		$sql = $this->connect()->prepare("SELECT shift FROM request WHERE request_id = ?;");
		$sql->execute([$request_id]);
		$results = $sql->fetchAll(PDO::FETCH_ASSOC);		
		$shift = $results[0]['shift'];   
      
		$request->saveEvent($earliest_date, $total_hours, $organization, $purpose_of_test, $facility_id, $request_id, $energy, $ion_string, $conn, $schedule_group, $shift); 
		
		
       
    } 	
 
	
}
