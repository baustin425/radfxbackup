<?php
//Calls CalendarControl.classes.php->removeEvent
//Requires role > 1
//@param event_id
header ( "Content-type: application/json;" );

if(isset($_COOKIE["PHPSESSID"]))
{
	session_start();
	if ($_SESSION['role'] > 1){
		include "database.php";
		include "classes/CalendarControl.classes.php";
		$cc = new CalendarControl();
		$result = $cc->removeEvent($_POST['id']);
		//echo "Delete Successful";
	}else{
		echo "Insufficent Access";
	}
}
 

  
?>
