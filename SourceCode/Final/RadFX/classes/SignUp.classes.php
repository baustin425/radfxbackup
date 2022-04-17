<?php
/**
 * takes user input, verifies the input, and creates a new user
 * @author ETurner
 */
class SignUp extends Database { 
    private $firstName;
    private $lastName;
    private $email;
    private $phoneNumber;
    private $password;
    private $passwordRepeat;
    private $suggestedRole;
    private $orgName;
    private $orgPhone;
    private $orgEmail;
    private $orgDescription;
    
    /**
     * the contructor for the signup class
     * @param firstName the users first name
     * @param lastName the users last name
     * @param email the users login
     * @param phoneNumber the users phone number
     * @param password the users submitted password 
     * @param passwordRepeat the users submitted password confirmation
     * @param suggestedRole the role the user wants the admin to give them
     * @param orgName the organization name of the user
     * @param orgPhone the organizations phone number
     * @param orgEmail the organizations email
     * @param orgDescription a short description of the organizations
     */
    public function __construct($firstName, $lastName, $email, $phoneNumber, $password, $passwordRepeat, $suggestedRole, $orgName, $orgPhone, $orgEmail, $orgDescription) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
        $this->suggestedRole = $suggestedRole;
        $this->orgName = $orgName;
        $this->orgPhone = $orgPhone;
        $this->orgEmail = $orgEmail;
        $this->orgDescription = $orgDescription;
    }

    /**
     * attempt to sign up the user
     */
    public function signUpUser() {
        // check if the passwords match
        if($this->passwordMatch() === false) {
            header("location: ../SignUp.php?error=passwordmatch");
            exit('Passwords dont match!');
        }
        //check if the password format is correct
        if($this->passwordFormatCorrect() === false) {
            header("location: ../SignUp.php?error=passwordrequirement");
            exit('Password doesnt meet requirements');
        }
        //check if the email exists in the database already
        if($this->checkEmail() === false) {
            header("location: ../SignUp.php?error=emailtaken");
            exit('Email Taken!');
        }

        //create the new user
        $this->setUser();
    }

    /**
     * if the passwords match return true, if not false
     */
    private function passwordMatch() {
        if($this->password === $this->passwordRepeat) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * is the password between 6-20 characters, does it contain a special character, a number, an uppercase letter, and a lowercase letter
     */
    private function passwordFormatCorrect() {
        if(preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,20}$/', $this->password)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check if username is taken
     */
    private function checkEmail() {
        if(!$this->usernameTaken()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * check the databse for the username
     * @return boolean is the username taken?
     */
    private function usernameTaken() {
        //fetech all users with the submitted email
        $sql = $this->connect()->prepare("SELECT * FROM user WHERE email = ?;");
        //if sql statement fails return to signup page with error
        if(!$sql->execute(array($this->email))) {
            $sql = null;
            header("location: ../SignUp.php?error=emailtaken");
            exit();
        }

        if($sql->rowCount() > 0) {
            return false;
        }
        else {
            return true;
        }
    }
    
    /**
     * insert user into the database with submitted information
     */
    private function setUser() {
        //create insert statement
        $sql = $this->connect()->prepare("INSERT INTO `user` (`affiliation_id`, `first_name`, `last_name`, `phone`, `email`, `password`, `suggested_role_id`, `org_name`, `org_phone`, `org_email`, `org_description`) VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?);");
        //hash password for security
        $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);

        $aff = 0;
        //insert user into the database
        if(!$sql->execute(array($aff, $this->firstName, $this->lastName, $this->phoneNumber, $this->email, $passwordHash, $this->suggestedRole,$this->orgName, $this->orgPhone, $this->orgEmail, $this->orgDescription))) {
            $sql = null;
            header("location: ../SignUp.php?error=prepare");
            exit();
        }
    }  
}