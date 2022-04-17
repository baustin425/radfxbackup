<?php
/*handles all the request form submissions and calls the appropriate classes for altering the databases
 * @author ETurner
 */ 
session_start();

if(array_key_exists('submit', $_POST)) {
	if (!isset($_POST) ) {
        // Could not get the data that should have been sent.
        exit('Please fill out all of the fields!');
	}

    include "../database.php";
    include "../classes/EditRequest.classes.php";
	
    $Request = new EditRequest();

    $Request->editThisRequest($_POST);

    //to indicate within profile that a request needs to be loaded
    $_SESSION["profile"] = "unset";

    //header("location: ../Profile.php?error=none");
    if(array_key_exists("request_id",$_POST)) {
        $error_location = "location: ../EditRequest.php?req_id=".$_POST["request_id"]."&error=none";
        header($error_location);
    } else {
        header("location: ../Request.php?error=prepare");
    }
}else if(array_key_exists('cancel', $_POST)) {
	if (!isset($_POST) ) {
        // Could not get the data that should have been sent.
        exit('Please fill out all of the fields!');
	}

    include "../database.php";
    include "../classes/EditRequest.classes.php";

    $Request = new EditRequest();

    $user_id = $Request->cancelRequest($_POST);

    //to indicate within profile that a request needs to be loaded
    $_SESSION["profile"] = "unset";

    include_once "../classes/Contact.classes.php";
    $contact = new Contact();
    if($user_id == $_SESSION['id']) {
        $contact->mailCustom($_SESSION['id'],"Request Cancelled", "Dear user,\n\nYou have successfully cancelled your request.\n\nThank you from the RadFX team! \n\n\nMessage Sent From radfx-a.research.utc.edu");
    } else {
        $contact->mailCustom($user_id,"Request Rejected", "Dear user,\nThank you for submitting your request.\nUnfortunately, your request has been rjected. If you feel this was done in error, please resubmit your request at radfx.research.utc.edu/EditRequest.php?req_id=",$post_info["request_id"]," or contact us for additional information.\n\n\nMessage Sent From radfx-a.research.utc.edu");
    }

    header("location: ../Request.php?error=deleted");
} else {//return error if you reached this page any other way
    header("location: ../Request.php?error=prepare");
}
