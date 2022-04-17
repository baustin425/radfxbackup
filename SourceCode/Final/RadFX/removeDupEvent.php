<?php
//Calls CalendarControl.classes.php->removeDupEvent
//Requires role > 1
//@param event_id
header ( "Content-type: application/json;" );

if(isset($_COOKIE["PHPSESSID"]))
{
	session_start();	
	if ($_SESSION['role'] > 2){
		include "database.php";
		include "classes/CalendarControl.classes.php";
		$cc = new CalendarControl();
		$result = $cc->removeDupEvent($_POST['id']);
		
	//spot for extra control of facility manager	
	}elseif ($_SESSION['role'] > 1 ){
		include "database.php";
		include "classes/CalendarControl.classes.php";
		$cc = new CalendarControl();
		$result = $cc->removeDupEvent($_POST['id']);
		
		
	}else{
		echo "Insufficent Access";
	}
}
 

  
?>
