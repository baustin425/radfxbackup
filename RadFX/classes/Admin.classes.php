<?php

class Admin extends Database {

    public function addColumns($names, $types, $comments) {
        for($x = 0; $x < count($names); $x++) {
            $name = (string)$names[$x];
            if(!$this->formatCorrect($name)) {
                header("location: ../Admin.php?error=requestnamecheck");
                exit();
            }
            $comment = (string)$comments[$x];
            if(!$this->formatCorrect($comment)) {
                header("location: ../Admin.php?error=requestdescriptioncheck");
                exit();
            }
            $type = strtoupper((string)$types[$x]);
            if($type == "INT") {
                $type = "int(10)";
            } else if($type == "VAR") {
                $type = "varchar(60)";
            } else if($type == "DATE") {
                $type = "date";
            } else {
                header("location: ../Admin.php?error=requesttypecheck");
                exit();
            }
            $sql = $this->connect()->prepare("ALTER TABLE request ADD $name $type COMMENT '$comment';");
            $sql->execute();
            $sql = null;
        }
    }

    private function formatCorrect($str) {
        if(preg_match('/(?!;)[a-zA-Z]$/', $str)) {
            return true;
        } else {
            return false;
        }
    }
}