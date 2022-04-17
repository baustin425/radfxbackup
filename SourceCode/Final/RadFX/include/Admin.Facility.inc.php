<?php
/**
 * handles all the facility form submissions and calls the appropriate classes for altering the database
 * @author ETurner
 */
if(isset($_POST["submit"])) {//was this submitted from the edit facility form?
    include "../database.php";
    include "../classes/Admin.Facility.classes.php";

    $facility = new Facility();

    $facility->changeFacility($_POST);
    header("location: ../Admin.php?error=change_facility_none");
} else if(isset($_POST["submit_new"])) { //was this submitted from the add facility form?
    include "../database.php";
    include "../classes/Admin.Facility.classes.php";

    $facility = new Facility();

    $facility->addFacility($_POST);
    header("location: ../Admin.php?error=add_facility_none");
}else if(isset($_POST["submit_facility_form"])) { //was this submitted from the add facility form?
    include "../database.php";
    include "../classes/Admin.classes.php";

    $admin = new Admin();

    $admin->editColumns($_POST, "facility");
    header("location: ../Admin.php?error=request_edit_none");
} else if(isset($_POST["submit_facility_field"])) { //was this submitted from the add facility form?
    include "../database.php";
    include "../classes/Admin.classes.php";

    $facility = new Admin();

    $facility->addColumn($_POST['name'], $_POST['type'], $_POST['description'], "facility");
    header("location: ../Admin.php?error=add_facility_field_none");
} else if(isset($_POST["remove"])) { //was this submitted from the remove facility form?
    include "../database.php";
    include "../classes/Admin.Facility.classes.php";
    include "../classes/Admin.classes.php";

    $admin = new Admin();
    if(!isset($_POST["password"]) || !$admin->confirmPassword($_POST["password"])) { 
        header("location: ../Admin.php?error=password");
        exit(); 
    }

    $facility = new Facility();

    $facility->removeFacility($_POST);
    header("location: ../Admin.php?error=remove_facility_none");
}  else { //return error if you reached this page any other way
    header("location: ../Admin.php?error=prepare");
}