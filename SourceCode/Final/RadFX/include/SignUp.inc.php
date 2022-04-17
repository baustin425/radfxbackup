<?php
/*handles all the signup form submissions and calls the appropriate classes for altering the databases
 * @author ETurner
 */
session_start();

if(isset($_POST["submit"])) {
	if (!isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['phoneNumber'], $_POST['password'], $_POST['passwordRepeat']) ) {
        // Could not get the data that should have been sent.
        exit('Please fill out all of the fields!');
	}

    include "../database.php";
    include "../classes/SignUp.classes.php";
    include "../classes/Contact.classes.php";
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];
    $suggested_role = $_POST['role'];
    $org_name = $_POST['orgName'];
    $org_phone = $_POST['orgPhone'];
    $org_email = $_POST['orgEmail'];
    $org_description = $_POST['orgDescription'];
    $_SESSION['signup']["firstName"] = $_POST['firstName'];
    $_SESSION['signup']["lastName"] = $_POST['lastName'];
    $_SESSION['signup']["email"] = $_POST['email'];
    $_SESSION['signup']["phoneNumber"] = $_POST['phoneNumber'];
    $_SESSION['signup']["role"] = $_POST['role'];
    $_SESSION['signup']["orgName"] = $_POST['orgName'];
    $_SESSION['signup']["orgPhone"] = $_POST['orgPhone'];
    $_SESSION['signup']["orgEmail"] = $_POST['orgEmail'];
    $_SESSION['signup']["orgDescription"] = $_POST['orgDescription'];

    $signup = new SignUp($firstName, $lastName, $email, $phoneNumber, $password, $passwordRepeat, $suggested_role, $org_name, $org_phone, $org_email, $org_description);

    $signup->signUpUser();

    $contact = new contact();
    $contact->mailHello($email, $firstName, $lastName);
    
    header("location: ../SignUp.php?error=none");

} else {//return error if you reached this page any other way
    header("location: ../SignUp.php?error=prepare");
}