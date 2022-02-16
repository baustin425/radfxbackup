<?php

session_start();

if(isset($_POST["submit"])) {
	if (!isset($_POST['hours'], $_POST['purpose'], $_POST['info'], $_POST['energy'], $_POST['ions'], $_POST['facility'], $_POST['vacuum'], $_POST['date']) ) {
        // Could not get the data that should have been sent.
        exit('Please fill out all of the fields!');
	}

    include "../database.php";
    include "../classes/Request.classes.php";

    $Request = new Request($_POST['hours'], $_POST['purpose'], $_POST['info'], $_POST['energy'], $_POST['ions'], $_POST['facility'], $_POST['vacuum'], $_POST['date']);

    $Request->submitRequest();
    echo "fff";
    header("location: ../Request.php?error=none");

} else {
    header("location: ../Request.php?error=something");
}