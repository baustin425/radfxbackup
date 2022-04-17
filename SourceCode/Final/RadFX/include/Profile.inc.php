<?php
include_once "../database.php";
include_once "../classes/Profile.classes.php";
session_start();

if(array_key_exists('prio_submit', $_POST)) {//was this submitted from the edit user roles form?

    $profile = new Profile($_SESSION['loggedin'], $_SESSION['name'], $_SESSION['id'], $_SESSION['role']);

    if(!isset($_POST["password"]) || !$profile->confirmPassword($_POST["password"])) { 
        header("location: ../Profile.php?error=password");
        exit(); 
    }

    //insert call to profile priority submit
    $profile->priorityUpdate($_POST);
    
    header("location: ../Profile.php?success=priority");
} else if(array_key_exists("name_submit", $_POST) && array_key_exists('new_first', $_POST) && array_key_exists('new_last', $_POST)) {

    $profile = new Profile($_SESSION['loggedin'], $_SESSION['name'], $_SESSION['id'], $_SESSION['role']);

    $first = $_POST['new_first'];
    $last = $_POST['new_last'];

    $profile->editName($first, $last);

    header("location: ../Profile.php?success=name");
    
} else if(array_key_exists("pass_submit", $_POST) &&  array_key_exists('rep_prev_pass', $_POST) && array_key_exists('prev_pass', $_POST) && array_key_exists('prev_pass', $_POST)) {

    $profile = new Profile($_SESSION['loggedin'], $_SESSION['name'], $_SESSION['id'], $_SESSION['role']);

    $old = $_POST['prev_pass'];
    $repOld = $_POST['rep_prev_pass'];
    $new = $_POST['new_pass'];

    $profile->edit($old, $repOld, $new);

    header("location: ../Profile.php?success=password");

} else if(array_key_exists("aff_submit", $_POST)) {

    $profile = new Profile($_SESSION['loggedin'], $_SESSION['name'], $_SESSION['id'], $_SESSION['role']);
    $name = $_POST['org_name'];
    $phone = $_POST['org_phone'];
    $email = $_POST['org_email'];
    $dec = $_POST['org_dec'];
    $profile->setOrganization($name, $phone, $email, $dec);

    header("location: ../Profile.php?success=organization");

} else {
    header("location: ../Profile.php?error=prepare");
}