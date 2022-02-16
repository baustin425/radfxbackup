<?php

class UserGatherer extends Database {
    public function getAllUsers($location) {
        $sql = $this->connect()->prepare("SELECT * FROM user;");
        
        if(!$sql->execute()) {
            $sql = null;
            $location .= "?error=prepare";
            header($location);
            exit();
        }

        $users = $sql->fetchAll(PDO::FETCH_ASSOC);

        $sql = null;
        return $users;
    }

    public function getWatchers($location) {
        $sql = $this->connect()->prepare("SELECT * FROM user WHERE role_id = ?;");
        
        if(!$sql->execute(array("0"))) {
            $sql = null;
            $location .= "?error=prepare";
            header($location);
            exit();
        }

        $users = $sql->fetchAll(PDO::FETCH_ASSOC);

        $sql = null;
        return $users;
    }
}