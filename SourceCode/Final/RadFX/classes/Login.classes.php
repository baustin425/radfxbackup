<?php
/**
 * Checks the user for the correct information and logs them in
 * @author ETurner
 */
class Login extends Database {
    private $email;
    private $password;
    
    /**
     * the contructor for the login class
     * @param email the users login
     * @param password the users submitted password attempt
     */
    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * attempt to log the user into their account using the submitted email and password
     */
    public function loginUser() {
        $this->getUser();
    }
    
    /**
     * verify user login and then log them into the account
     */
    protected function getUser() {

        //get all users with the submitted username/email
        $sql = $this->connect()->prepare("SELECT * FROM user WHERE email = ?;");
        //if sql statement fails return to login page with error
        if(!$sql->execute(array($this->email))) {
            $sql = null;
            header("location: ../login.php?error=prepare");
            exit();
        }
        //if no users with the submitted email exist return to login with error
        if($sql->rowCount() == 0) {
            $sql = null;
            header("location: ../login.php?error=infoincorrect");
            exit();
        }

        //get password of the feteched user, hash the submitted password, and then verify if they match
        $user = $sql->fetchAll(PDO::FETCH_ASSOC);
        $passwordHash = $user[0]["password"];
        $verifyPassword = password_verify($this->password, $passwordHash);

        //if they dont match return with error and if they do log the user in then set their name, id, and role for this session
        if($verifyPassword == false) {
            $sql = null;
            header("location: ../login.php?error=infoincorrect");
            exit();
        } else if($verifyPassword == true) {
            session_start();
            //set all session variables for the user
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $user[0]["email"];
            $_SESSION['fullname'] = $user[0]["first_name"] .' '. $user[0]["last_name"];
            $_SESSION['id'] = $user[0]["user_id"];
            $_SESSION['role'] = $user[0]["role_id"];
            $_SESSION['affiliation'] = $user[0]["affiliation_id"];
            $_SESSION['org_name'] = $user[0]["org_name"];
            $_SESSION['org_phone'] = $user[0]["org_phone"];
            $_SESSION['org_email'] = $user[0]["org_email"];
            $_SESSION['org_description'] = $user[0]["org_description"];
            echo 'Welcome ' . $_SESSION['name'] . '!';
        }

        $sql = null;
    }
}