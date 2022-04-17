<?php
/* handles all the facility form submissions and calls the appropriate classes for altering the databases
 * @author ETurner
 */
if(array_key_exists('submit', $_POST)) {//was this submitted from the edit user roles form?
    include "../database.php";
    include "../classes/Admin.UserApproval.Classes.php";
    include "../classes/Admin.classes.php";

    $admin = new Admin();
    if(!isset($_POST["password"]) || !$admin->confirmPassword($_POST["password"])) { 
        header("location: ../Admin.php?error=password");
        exit(); 
    }

    $userApprover = new UserApproval();

    //$userApprover->changeUserRoles($_POST);
    $userApprover->updateUsers($_POST);
    header("location: ../Admin.php?error=user_approval_none");
}else {//return error if you reached this page any other way
    header("location: ../Admin.php?error=prepare");
}


