<?php

session_start();

if(isset($_POST["submit"])) {
	if (!isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['phoneNumber'], $_POST['password'], $_POST['passwordRepeat']) ) {
        // Could not get the data that should have been sent.
        exit('Please fill out all of the fields!');
	}

    include "../database.php";
    include "../classes/SignUp.classes.php";
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];

    $signup = new SignUp($firstName, $lastName, $email, $phoneNumber, $password, $passwordRepeat);

    $signup->signUpUser();
    header("location: ../SignUp.php?error=none");

} else {
    header("location: ../SignUp.php");
}