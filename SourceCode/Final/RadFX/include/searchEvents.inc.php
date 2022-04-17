<?php
//This is the main restriction point events returned to the client
//Admin can choose facility
//Facility manager will only recieve events from $_SESSION['affiliation'] facility
//Manager cannot change events outside of assigned facility because they will never recieve them
//User will recieve user specific events from published_events table
//Public will recieve the full published_events table
header ( "Content-type: application/json;" );
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(isset($_COOKIE["PHPSESSID"]))
	{
		session_start();
		include "../database.php";
		include "../classes/CalendarControl.classes.php";
		
		if ($_SESSION['role'] > 2){			
			
			$cc = new CalendarControl();
			$result = $cc->getSearchEvents($_POST['facility'], $_POST['ions']);
			echo json_encode($result);
				

		}elseif ($_SESSION['role'] >1){
			$cc = new CalendarControl();
			$result = $cc->getSearchEvents($_SESSION['affiliation'], $_POST['ions']);
			echo json_encode($result);
		
		}elseif ($_SESSION['role'] >0){
			$cc = new CalendarControl();
			$result = $cc->getUserEvents($_SESSION['fullname']);
			echo json_encode($result);
		
		}else {
			$cc = new CalendarControl();
			$result = $cc->getPublishedEvents();
			echo json_encode($result);
		}
		
	}else{
		$cc = new CalendarControl();
		$result = $cc->getPublishedEvents();
		echo json_encode($result);
		
		}
	
	
}



  
?>
