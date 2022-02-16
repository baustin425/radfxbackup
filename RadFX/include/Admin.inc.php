<?php

session_start();

if(isset($_POST["submit"])) {
    include "../database.php";
    include "../classes/Admin.classes.php";

    $admin = new Admin();

    $admin->addColumns($_POST['name_fields'], $_POST['type_fields'], $_POST['description_fields']);
    header("location: ../Admin.php?error=requestnone");
}