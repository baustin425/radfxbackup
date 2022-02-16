<?php

session_start();

if(isset($_POST["submit"])) {
	if ( !isset($_POST['username'], $_POST['password']) ) {
    // Could not get the data that should have been sent.
    exit('Please fill both the username and password fields!');
	}

	require_once 'database.php';
	require_once 'functions.php';
	// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $conn->prepare('SELECT user_id, password FROM user WHERE email = ?')) {	
		//$sql = "SELECT * FROM user WHERE username = ?;";
		//$stmt = mysqli_stmt_init($conn);
		// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		// Store the result so we can check if the account exists in the database.
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$stmt->bind_result($id, $password);
			$stmt->fetch();
			// Account exists, now we verify the password.
			// Note: remember to use password_hash in your registration file to store the hashed passwords.
			if (password_verify($_POST['password'], $password)) {
				// Verification success! User has logged-in!
				// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['username'];
				$_SESSION['id'] = $id;
				header("location: Profile.php?error=none");
				echo 'Welcome ' . $_SESSION['name'] . '!';
			} else {
				// Incorrect password
				header("location: login.php?error=infoincorrect");
				echo 'Incorrect username or password!';
			}
		} else {
			// Incorrect username
			header("location: login.php?error=infoincorrect");
			echo 'Incorrect username or password!';
		}

		$stmt->close();
	}

} else {
	header("location: login.php?error=prepare");
}

