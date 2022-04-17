<?php
//Calls CalendarControl.classes.php->publishEvents
//Requires role > 2 (Admin Only)
//@param password
header ( "Content-type: application/json;" );

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(isset($_COOKIE["PHPSESSID"]))
	{
		session_start();
		if ($_SESSION['role'] > 2){
			include "database.php";
			include "classes/CalendarControl.classes.php";
			include "classes/Admin.classes.php";
			$admin = new Admin();
			if($admin->confirmPassword($_POST['pass'])){
				$cc = new CalendarControl();
				$result = $cc->publishEvents();
				echo $result;
				//echo "Publish Successful";
			}else{
				echo "Insufficent Access";
			}
		}else{
			echo "Insufficent Access";
		}
	}
		
}
 

  
?>
