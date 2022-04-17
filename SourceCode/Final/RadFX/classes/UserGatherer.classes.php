<?php
/**
 * returns users from the database
 * @author ETurner
 */
class UserGatherer extends Database {
    /**
     * fetech all users from the database
     * @param location the page this function is being called from
     * @return users the users fetched
     */
    public function getAllUsers($location) {
        //prepare the fetch statement for the user table
        $sql = $this->connect()->prepare("SELECT * FROM user;");
        //if sql statement fails return to prevous page with error
        if(!$sql->execute()) {
            $sql = null;
            $location .= "?error=prepare";
            header($location);
            exit();
        }

        //fetch users into array
        $users = $sql->fetchAll(PDO::FETCH_ASSOC);

        $sql = null;
        return $users;
    }

    /**
     * get all users without a role assigned from the database
     * @param location the page this function is being called from
     * @return users the users fetched
     */
    public function getWatchers($location) {
        //prepare the fetch statement for the user table
        $sql = $this->connect()->prepare("SELECT * FROM user WHERE role_id = ?;");
        //if sql statement fails return to prevous page with error
        if(!$sql->execute(array("0"))) {
            $sql = null;
            $location .= "?error=prepare";
            header($location);
            exit();
        }
        
        //fetch users into array
        $users = $sql->fetchAll(PDO::FETCH_ASSOC);

        $sql = null;
        return $users;
    }
}