<?php

class UserApproval extends Database {

    public function changeUserRoles($post_info) {
        for($x = 0; $x < count($post_info) - 1; $x++) {
            $id = array_keys($post_info)[$x];
            $role = $post_info[$id];

            $role_id = 0;
            if($role == "tester") {
                $role_id = 1;
            } else if($role == "integrator") {
                $role_id = 2;
            } else if($role == "admin") {
                $role_id = 3;
            } else if($role == "waiting") {
                $role_id = 0;
            } else if($role == "waiting") {
                $role_id = 0;
            }
            
            if($role == "reject") {
                $sql = $this->connect()->prepare("DELETE FROM user WHERE user_id = ?;");
                
                if(!$sql->execute(array($id))) {
                    $sql = null;
                    header("location: ../SignUp.php?error=prepare");
                    exit();
                }
            } else {
                $sql = $this->connect()->prepare("UPDATE user SET role_id = ? Where user_id = ?;");
                if(!$sql->execute(array($role_id, $id))) {
                    $sql = null;
                    header("location: ../SignUp.php?error=prepare");
                    exit();
                }
            }
            $sql = null;
        }
    }
}