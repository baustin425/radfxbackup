<?php
header ( "Content-type: application/json;" );
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(isset($_COOKIE["PHPSESSID"]))
	{
		session_start();
		include "database.php";
		include "classes/CalendarControl.classes.php";
		
		if ($_SESSION['role'] > 2){
			
				$cc = new CalendarControl();
				$result = $cc->getAllEvents();
				echo json_encode($result);
				
		}elseif ($_SESSION['role'] >1){			
			
			$cc = new CalendarControl();
			$result = $cc->getSearchEvents($_SESSION['affiliation'], "[]");
			echo json_encode($result);
		
		}else {
			$cc = new CalendarControl();
			$result = $cc->getPublishedEvents();
			echo json_encode($result);
		}			
	}else{
		
		
	}

}



  
?>