<?php
//Calls CalendarControl.classes.php->commitEvent
//Requires role > 1
//@param events [JSON of the calendar_event object]
header ( "Content-type: application/json;" );

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if(isset($_COOKIE["PHPSESSID"]))
	{
		session_start();
		if ($_SESSION['role'] > 1){
			include "database.php";
			include "classes/CalendarControl.classes.php";
			$cc = new CalendarControl();
			$result = $cc->commitEvent($_POST['events'], true);			
			//echo "Commit Successful";
		}else{
			echo "Insufficent Access";
		}
	}
		
}
 

  
?>
