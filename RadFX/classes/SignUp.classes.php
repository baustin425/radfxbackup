<?php

class SignUp extends Database {
    private $firstName;
    private $lastName;
    private $email;
    private $phoneNumber;
    private $password;
    private $passwordRepeat;
    
    public function __construct($firstName, $lastName, $email, $phoneNumber, $password, $passwordRepeat) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }

    public function signUpUser() {
        if($this->passwordMatch() === false) {
            header("location: ../SignUp.php?error=passwordmatch");
            exit('Passwords dont match!');
        }
        if($this->passwordFormatCorrect() === false) {
            header("location: ../SignUp.php?error=passwordrequirement");
            exit('Password doesnt meet requirements');
        }
        if($this->checkEmail() === false) {
            header("location: ../SignUp.php?error=emailtaken");
            exit('Email Taken!');
        }

        $this->setUser();
    }

    private function passwordMatch() {
        if($this->password === $this->passwordRepeat) {
            return true;
        } else {
            return false;
        }
    }

    private function passwordFormatCorrect() {
        if(preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,20}$/', $this->password)) {
            return true;
        } else {
            return false;
        }
    }

    private function checkEmail() {
        if(!$this->usernameTaken()) {
            return false;
        } else {
            return true;
        }
    }

    private function usernameTaken() {
        $sql = $this->connect()->prepare("SELECT * FROM user WHERE email = ?;");
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
    
    private function setUser() {
        $sql = $this->connect()->prepare("INSERT INTO user (affiliation_id, first_name, last_name, phone, email, password) VALUES (?, ?, ?, ?, ?, ?);");
        
        $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);

        $aff = 0;
        if(!$sql->execute(array($aff, $this->firstName, $this->lastName, $this->phoneNumber, $this->email, $passwordHash))) {
            $sql = null;
            header("location: ../SignUp.php?error=prepare");
            exit();
        }

        $to = $this->email;
        $subject = "Welcome To RADFX";
        $message = "<html>
        <head>Good evening,</head>
            <body>
                <p style='color:black;'>Thank you for creating a tester account with RADFX.</p>
                <p>Sincerily,</p>
                <p>RadFx Team</p>
            </body>
        </html>";
        $from = "RadFxProject@hotmail.com";
        $headers = "From:" . $from;
        mail($to,$subject,$message,$headers);

        $sql = null;
    }
}