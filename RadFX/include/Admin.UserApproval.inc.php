<?php

if(isset($_POST["submit"])) {
    include "../database.php";
    include "../classes/Admin.UserApproval.classes.php";

    $userApprover = new UserApproval();

    $userApprover->changeUserRoles($_POST);
    header("location: ../Admin.php?error=usernone");
}