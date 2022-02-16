<?php

function passwordMatch($password, $passwordRepeat) {
    if($password !== $passwordRepeat) {
        return true;
    } else {
        return false;
    }
}
function passwordFormatCorrect($password) {
    if(preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,20}$/', $password)) {
        return false;
    } else {
        return true;
    }
}

function usernameTaken($conn, $username) {
    $sql = "SELECT * FROM user WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: SignUp.php?error=usernametaken");
        exit();
    } 

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $results = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($results)) {
        return $row;
    }
    else {
        $finalResult = false;
        return $finalResult;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $firtname, $lastName, $email, $phoneNumber, $affiliation, $password) {
    $sql = "INSERT INTO user (affiliation_id, first_name, last_name, phone, email, password) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location SignUp.php");
        exit("failed");
    } 

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $aff = 0;
    mysqli_stmt_bind_param($stmt, "ssssss",  $aff, $firtname, $lastName, $phoneNumber, $email, $passwordHash);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: SignUp.php?error=none");
    exit();
}