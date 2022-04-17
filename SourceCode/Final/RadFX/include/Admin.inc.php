<?php
/**
 * handles all the edit request form submissions and calls the appropriate classes for altering the database
 * @author ETurner
 */


if(isset($_POST["submit_request_form"])) {//was this submitted through the edit request field form?
    include "../database.php";
    include "../classes/Admin.classes.php";

    $admin = new Admin();

    $admin->editColumns($_POST, "request");
    header("location: ../Admin.php?error=request_edit_none");
} else if(isset($_POST["submit_request_field"])) {//was this submitted through the add request field form?
    include "../database.php";
    include "../classes/Admin.classes.php";

    $admin = new Admin();

    $admin->addColumn($_POST['name'], $_POST['type'], $_POST['description'], "request");
    header("location: ../Admin.php?error=request_add_none");
} else { //return error if you reached this page any other way
    header("location: ../Admin.php?error=prepare");
}
