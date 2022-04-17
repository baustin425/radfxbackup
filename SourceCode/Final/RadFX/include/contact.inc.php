<?php
include "../database.php";
include "../classes/Contact.classes.php";

if(isset($_POST["submit"], $_POST['contactlist'], $_POST['subject'], $_POST['message'])) {
    //new contact object
    $con = new contact();
    session_start();
    $con->sendEmail($_SESSION['name'], $_SESSION['fullname'], $_POST['contactlist'], $_POST['subject'], $_POST['message']);

    /*
    Previous - sendmail with php mail()

    $to = $user[0]['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $from = $_SESSION['name'];
    $headers = "From:" . $from;
    
    //send email

    if(mail($to,$subject,$message,$headers)){
        header("location: ../Profile.php");
    } else{
        header("location: ../index.php");
    }*/
    
} else {
    header("location: ../Profile.php");
}
?>