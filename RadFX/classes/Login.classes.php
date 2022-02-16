<?php

class Login extends Database {
    private $email;
    private $password;
    
    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function loginUser() {
        $this->getUser();
    }
    
    protected function getUser() {
        $sql = $this->connect()->prepare("SELECT * FROM user WHERE email = ?;");
        
        if(!$sql->execute(array($this->email))) {
            $sql = null;
            header("location: ../login.php?error=prepare");
            exit();
        }

        if($sql->rowCount() == 0) {
            $sql = null;
            header("location: ../login.php?error=infoincorrect");
            exit();
        }

        $user = $sql->fetchAll(PDO::FETCH_ASSOC);
        $passwordHash = $user[0]["password"];
        $verifyPassword = password_verify($this->password, $passwordHash);


        if($verifyPassword == false) {
            $sql = null;
            header("location: ../login.php?error=infoincorrect");
            exit();
        } else if($verifyPassword == true) {
            session_start();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $user[0]["email"];
            $_SESSION['id'] = $user[0]["user_id"];
            $_SESSION['role'] = $user[0]["role_id"];
            echo 'Welcome ' . $_SESSION['name'] . '!';
        }

        $sql = null;
    }
}