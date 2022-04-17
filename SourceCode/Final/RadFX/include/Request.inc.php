<?php
/*handles all the request form submissions and calls the appropriate classes for altering the databases
 * @author ETurner
 */
session_start();


if(isset($_POST["submit"])) {
	if (!isset($_POST) ) {
        // Could not get the data that should have been sent.
        exit('Please fill out all of the fields!');
	}

    include "../database.php";
    include "../classes/Request.classes.php";

    $Request = new Request();

    $Request->submitRequest($_POST);

    //to indicate within profile that a request needs to be loaded
    $_SESSION["profile"] = "unset";

    include_once "../classes/Contact.classes.php";
    $contact = new Contact();
    $contact->mailCustom($_SESSION['id'],"Request Recieved", "Dear user,\nThank you for submitting your request.\nYour request is now being reviewed. This process may take up to a few days depending on request volume. You will be notified once your request has been approved and published to the schedule.\n\nThank you from the RadFX team! \n\n\nMessage Sent From radfx-a.research.utc.edu");

    //header("location: ../Profile.php?error=none");
    header("location: ../Request.php?error=none");

} else {//return error if you reached this page any other way
    header("location: ../Request.php?error=prepare");
}
