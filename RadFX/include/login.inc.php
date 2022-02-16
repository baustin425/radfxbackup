<?php

session_start();

if(isset($_POST["submit"])) {
	if ( !isset($_POST['username'], $_POST['password']) ) {
		// Could not get the data that should have been sent.
		exit('Please fill both the username and password fields!');
		}

    include "../database.php";
    include "../classes/Login.classes.php";
    $email = $_POST['username'];
    $password = $_POST['password'];

    $login = new Login($email, $password);


    $login->loginUser();
    header("location: ../Profile.php?error=none");
	echo 'Welcome ' . $_SESSION['name'] . '!';

} else {
    header("location: ../login.php?error=prepare");
}