<?php
/*handles all the login form submissions and calls the appropriate classes for verifying and loggin in the user
 * @author ETurner
 */

if(isset($_POST["submit"])) {
	if ( !isset($_POST['username'], $_POST['password']) ) {
		// Could not get the data that should have been sent.
		exit('Please fill both the username and password fields!');
		}

    include "../database.php";
    include "../classes/Login.classes.php";
    $email = $_POST['username'];
    $password = $_POST['password'];

    $login = new Login($email, $password);

    $login->loginUser();
    
    header("location: ../index.php?error=none");
	echo 'Welcome ' . $_SESSION['name'] . '!';

} else {//return error if you reached this page any other way
    header("location: ../login.php?error=prepare");
}