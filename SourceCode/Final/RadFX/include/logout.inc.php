<?php
/*logs the user out, unsets their session variables, destroys their session, and returns the user to the homepage
 * @author ETurner
 */

session_start();
session_unset();
session_destroy();

header("location: ../index.php");
exit();