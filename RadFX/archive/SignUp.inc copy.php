<?php

session_start();

if(isset($_POST["submit"])) {
	if (!isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['phoneNumber'], $_POST['password'], $_POST['passwordRepeat']) ) {
        // Could not get the data that should have been sent.
        exit('Please fill out all of the fields!');
	}

	require_once 'database.php';
	require_once 'functions.php';

    if(passwordMatch($_POST['password'], $_POST['passwordRepeat'])) {
        header("location: SignUp.php?error=passwordmatch");
        exit('Passwords dont match!');
    }
    if(passwordFormatCorrect($_POST['password'])) {
        header("location: SignUp.php?error=passwordrequirement");
        exit('Password doesnt meet requirements');
    }
    if(usernameTaken($conn, $_POST['email']) !== false) {
        header("location: SignUp.php?error=emailtaken");
        exit('Email Taken!');
    }
    createUser($conn, $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['phoneNumber'], $_POST['affiliation'], $_POST['password']);*/
} else {
    header("location: SignUp.php");
}