<?php

class Profile extends Database {
    
    private $loggedin;
    private $name;
    private $id;
    private $role;

    public function __construct($_log, $_name, $_id, $_role) {
        $this->loggedin = $_log;
        $this->name = $_name;
        $this->id = $_id;
        $this->role = $_role;
    }

    public function getRequests() {
        $unAp = [];
        
        $conn = $this->connect();
        $sql = $conn->prepare("SELECT user_id, role_id FROM user WHERE email = ?;");
        $sql->execute(array($this->name));

        // logged in user's details
        $user = $sql->fetchAll(PDO::FETCH_ASSOC);

        $sql = $conn->prepare("SELECT * FROM request WHERE user_id = ?;");
        $id = $user[0]["user_id"];
        $sql->execute(array($id));

        // logged in user's requests
        $requests = $sql->fetchAll(PDO::FETCH_ASSOC);

        // ensure no error in query
        if(count($user) == 0) {
            $sql = null;
            //header("location: ./profile.php?error=prepare");
            return null;
            exit();

        } else {
            if($user[0]["role_id"] >= 1){
                // ensure no error in query
                if(count($requests) == 0) {
                    $sql = null;
                    //header("location: ./profile.php?error=prepare2");
                    return null;
                    exit();

                } else {
                    

                    /*
                        loop through user's requests pulling the ions
                        if there is one or more, then convert it to a string
                    */
                    for($x = 0; $x < count($requests); $x++){
                        $sql = $conn->prepare("SELECT * FROM request_ion WHERE request_id = ?;");
                        
                        if(!$sql->execute(array($requests[$x]['request_id']))){
                            $sql = null;
                            //header("location: ./profile.php?error=prepare");
                            return null;
                            exit();
                        } else {
                            $ions = $sql->fetchAll(PDO::FETCH_ASSOC);
                            $sql = null;

                            if(count($ions) > 0 ){
                                $ids;
                                $ion_id = "";
                                $energy = "";
                                for($y = 0; $y < count($ions); $y++){
                                    $ion_id .= $ions[$y]['ion_id']. ",";
                                    if($y == count($ions)-1){
                                        $energy .= $ions[$y]['energy'];
                                    } else{
                                        $energy .= $ions[$y]['energy']. ", ";
                                    }
                                }

                                // set our array element with the request fields
                                $unAp[$x]["request_id"] = $requests[$x]["request_id"];
                                $unAp[$x]["total_hours"] = $requests[$x]["total_hours"];
                                $unAp[$x]["description"] = $requests[$x]["description"];
                                $unAp[$x]["energy_level"] = $energy;
                                $unAp[$x]["ion_id"] = $ion_id;
                                $unAp[$x]["earliest_date"] = $requests[$x]["earliest_date"];
                                $unAp[$x]["facility_id"] = $requests[$x]["facility_id"];
                                $requests[$x]["energy_level"] = $energy;

                            } else{
                                $unAp[$x]["request_id"] = $requests[$x]["request_id"];
                                $unAp[$x]["total_hours"] = $requests[$x]["total_hours"];
                                $unAp[$x]["description"] = $requests[$x]["description"];
                                $unAp[$x]["energy_level"] = "";
                                $unAp[$x]["ion_id"] = "";
                                $unAp[$x]["earliest_date"] = $requests[$x]["earliest_date"];
                                $unAp[$x]["facility_id"] = $requests[$x]["facility_id"];

                            }
                        }
                    }

                $sql = null;
                return $unAp;
                }
            }
        }
    }

    public function getSplitRequests(){
        $unAp = null;
        $r = $this->role;
        //determine users authorization
        if($r == 1){
            $unAp = $this->getRequests();
        } else if($r == 2){
            $unAp = $this->getFacilityRequests();
        } else if($r >= 3){
            $unAp = $this->getAdminRequests();
        }
        
        if($unAp != null){
            date_default_timezone_set('US/Eastern');

            $conn = $this->connect();
            //query all events
            $sql = $conn->prepare("SELECT * FROM calendar_events;");
            $sql->execute(); 
            $events = $sql->fetchAll(PDO::FETCH_ASSOC);

            //query all requests
            $sql = $conn->prepare("SELECT facility_id, name FROM facility;");
            $sql->execute();
    
            $facilities = $sql->fetchAll(PDO::FETCH_ASSOC);

            $sql = null;

            $combined;
            $un = array();
            $ap = array();
            $event = null;
            $fac = "";

            for($y = 0; $y < count($unAp); $y++){             
                $event = null;
                $eventI = array();
                $times = array();

                $today = date('Y-m-d H:i:s');
                $todayY = substr($today, 0, 4);
                $todayMo = substr($today, 5, 2);
                $todayD = substr($today, 8, 2);

                //determine offset for an event that has a calendar event and all event times for a sole request
                for($z = 0; $z < count($events); $z++){
                    if($unAp[$y]['request_id'] == $events[$z]['request_id']){
                        $event = $z;

                        $date = $events[$event]['from'];
                        $dateY = substr($date, 0, 4);
                        $dateMo = substr($date, 5, 2);
                        $dateD = substr($date, 8, 2);
                        if($dateY >= $todayY && ($dateMo > $todayMo || $dateMo == $todayMo && $dateD >= (int)$todayD-7)){
                            array_push($times, array(date('m/d H:i', strtotime($events[$event]['from'])), date('m/d H:i', strtotime($events[$event]['to']))));
                        }
                        //break;
                    }
                }

                //find facility for each request
                for($f = 0; $f < count($facilities); $f++){
                    if($unAp[$y]['facility_id'] == $facilities[$f]['facility_id']){
                        $fac = "".$facilities[$f]['name']."";
                    }
                }

                if($event != null){
                    //date checking for current events
                    $date = $events[$event]['from'];
                    $dateY = substr($date, 0, 4);
                    $dateMo = substr($date, 5, 2);
                    $dateD = substr($date, 8, 2);
                    //requests with calendar events that are unapproved
                    if($unAp[$y]['request_id'] == $events[$event]['request_id'] && $events[$event]['approved'] == 0){
                        //if month of request is later than or equal to current month  
                        //if($dateMo >= $todayMo){
                            //if month of request is later than current month or request is the same month as current and the day is >= todays day of the month
                            if($dateY >= $todayY && ($dateMo > $todayMo || $dateMo == $todayMo && $dateD >= (int)$todayD-7)){
                                //id, from, to, title, description, url, ion, energy, total_hours, location
                                $temp = array($unAp[$y]["request_id"], $unAp[$y]["description"], $unAp[$y]["ion_id"], $unAp[$y]["energy_level"], $times, $unAp[$y]["total_hours"]);
                                array_push($temp, $fac);
                                array_push($temp, $events[$event]['url']);
                                array_push($temp, "Not Approved");
                                array_push($temp, $events[$event]['priority']);
                                array_push($temp, $events[$event]['color']);
                                array_push($temp, $events[$event]['colorBorder']);
                                array_push($un, $temp);
                            }
                       // }
                        //requests with calendar events that are approved
                    } else if($unAp[$y]['request_id'] == $events[$event]['request_id'] && $events[$event]['approved'] == 1){
                        if($dateMo >= $todayMo){
                            if($dateY >= $todayY && ($dateMo > $todayMo || $dateMo == $todayMo && $dateD >= (int)$todayD-7)){
                                $temp = array($unAp[$y]["request_id"], $unAp[$y]["description"], $unAp[$y]["ion_id"], $unAp[$y]["energy_level"], $times, $unAp[$y]["total_hours"]);
                                array_push($temp, $fac);
                                array_push($temp, $events[$event]['url']);
                                array_push($temp, "Approved");
                                array_push($temp, $events[$event]['priority']);
                                array_push($temp, $events[$event]['color']);
                                array_push($temp, $events[$event]['colorBorder']);
                                array_push($un, $temp);
                            }
                        }
                    } 
                } else { //requests with no calendar event that are unapproved
                    /*
                    $date = $unAp[$y]["earliest_date"];
                    $dateY = substr($date, 0, 4);
                    $dateMo = substr($date, 5, 2);
                    $dateD = substr($date, 8, 2);
                    if($dateMo >= $todayMo){
                        if($dateY >= $todayY && ($dateMo > $todayMo || $dateMo == $todayMo && $dateD >= (int)$todayD-7)){
                            $temp = array($unAp[$y]["request_id"], $unAp[$y]["description"], $unAp[$y]["ion_id"], $unAp[$y]["energy_level"], array(array("", "")), $unAp[$y]["total_hours"]);
                            array_push($temp, $fac);
                            array_push($temp, "EditRequest.php?req_id=".$unAp[$y]["request_id"]."");
                            array_push($temp, "No Calendar Event");
                            array_push($temp, "0");
                            array_push($un, $temp);
                        }
                    }*/
                }
                
            }
            //$_SESSION['testing'] = $date." : ".$today. " | ".$dateMo." : ".$todayMo ;
            $combined = array($un, $ap);
            $_SESSION['requests'] = $combined;
        } else {
            $_SESSION['requests'] = array(null, null);
            return null;
        }

    }

    public function getAdminRequests() {
        $unAp = [];

        $conn = $this->connect();
        $sql = $conn->prepare("SELECT user_id, role_id FROM user WHERE email = ?;");
        $sql->execute(array($this->name));

        // logged in user's details
        $user = $sql->fetchAll(PDO::FETCH_ASSOC);

        $sql = $conn->prepare("SELECT * FROM request");
        $sql->execute();
        // logged in user's requests
        $requests = $sql->fetchAll(PDO::FETCH_ASSOC);

        // ensure no error in query
        if(count($user) == 0) {
            $sql = null;
            //header("location: ./profile.php?error=prepare");
            return null;
            exit();

        } else {
            if($user[0]["role_id"] >= 3){
                // ensure no error in query
                if(count($requests) == 0) {
                    $sql = null;
                    //header("location: ./profile.php?error=prepare2");
                    return null;
                    exit();

                } else {
                    /*
                        loop through user's requests pulling the ions
                        if there is one or more, then convert it to a string
                    */
                    for($x = 0; $x < count($requests); $x++){
                        $sql = $conn->prepare("SELECT * FROM request_ion WHERE request_id = ?;");
                        
                        if(!$sql->execute(array($requests[$x]['request_id']))){
                            $sql = null;
                            //header("location: ./profile.php?error=prepare");
                            return null;
                            exit();
                        } else {
                            $ions = $sql->fetchAll(PDO::FETCH_ASSOC);
                            $sql = null;

                            if(count($ions) > 0 ){
                                $ids;
                                $ion_id = "";
                                $energy = "";
                                for($y = 0; $y < count($ions); $y++){
                                    $ion_id .= $ions[$y]['ion_id']. ",";
                                    if($y == count($ions)-1){
                                        $energy .= $ions[$y]['energy'];
                                    } else{
                                        $energy .= $ions[$y]['energy']. ", ";
                                    }
                                }

                                // set our array element with the request fields
                                $unAp[$x]["request_id"] = $requests[$x]["request_id"];
                                $unAp[$x]["total_hours"] = $requests[$x]["total_hours"];
                                $unAp[$x]["description"] = $requests[$x]["description"];
                                $unAp[$x]["energy_level"] = $energy;
                                $unAp[$x]["ion_id"] = $ion_id;
                                $unAp[$x]["earliest_date"] = $requests[$x]["earliest_date"];
                                $unAp[$x]["facility_id"] = $requests[$x]["facility_id"];
                                $requests[$x]["energy_level"] = $energy;

                            } else{
                                $unAp[$x]["request_id"] = $requests[$x]["request_id"];
                                $unAp[$x]["total_hours"] = $requests[$x]["total_hours"];
                                $unAp[$x]["description"] = $requests[$x]["description"];
                                $unAp[$x]["energy_level"] = "";
                                $unAp[$x]["ion_id"] = "";
                                $unAp[$x]["earliest_date"] = $requests[$x]["earliest_date"];
                                $unAp[$x]["facility_id"] = $requests[$x]["facility_id"];

                            }
                        }
                    }

                $sql = null;
                return $unAp;
                }
            }
        }
    }

    public function getFacilityRequests() {
        $unAp = [];

        $conn = $this->connect();
        $sql = $conn->prepare("SELECT u.user_id, u.role_id, f.facility_id FROM `user` AS u, facility AS f WHERE u.affiliation_id = f.affiliation_id AND email = ?;");
        $sql->execute(array($this->name));

        // logged in user's details

        $user = $sql->fetchAll(PDO::FETCH_ASSOC);

        $fac_id = $user[0]['facility_id'];

        $sql = $conn->prepare("SELECT * FROM request WHERE facility_id = ?;");
        $sql->execute(array($fac_id));
        // facility requests
        $requests = $sql->fetchAll(PDO::FETCH_ASSOC);

        // ensure no error in query
        if(count($user) == 0) {
            $sql = null;
            //header("location: ./profile.php?error=prepare");
            return null;
            exit();

        } else {
            if($user[0]["role_id"] >= 2){
                // ensure no error in query
                if(count($requests) == 0) {
                    $sql = null;
                    //header("location: ./profile.php?error=prepare2");
                    return null;
                    exit();

                } else {
                    /*
                        loop through user's requests pulling the ions
                        if there is one or more, then convert it to a string
                    */
                    for($x = 0; $x < count($requests); $x++){
                        $sql = $conn->prepare("SELECT * FROM request_ion WHERE request_id = ?;");
                        
                        if(!$sql->execute(array($requests[$x]['request_id']))){
                            $sql = null;
                            //header("location: ./profile.php?error=prepare");
                            return null;
                            exit();
                        } else {
                            $ions = $sql->fetchAll(PDO::FETCH_ASSOC);
                            $sql = null;

                            if(count($ions) > 0 ){
                                $ids;
                                $ion_id = "";
                                $energy = "";
                                for($y = 0; $y < count($ions); $y++){
                                    $ion_id .= $ions[$y]['ion_id']. ",";
                                    if($y == count($ions)-1){
                                        $energy .= $ions[$y]['energy'];
                                    } else{
                                        $energy .= $ions[$y]['energy']. ", ";
                                    }
                                }

                                // set our array element with the request fields
                                $unAp[$x]["request_id"] = $requests[$x]["request_id"];
                                $unAp[$x]["total_hours"] = $requests[$x]["total_hours"];
                                $unAp[$x]["description"] = $requests[$x]["description"];
                                $unAp[$x]["energy_level"] = $energy;
                                $unAp[$x]["ion_id"] = $ion_id;
                                $unAp[$x]["earliest_date"] = $requests[$x]["earliest_date"];
                                $unAp[$x]["facility_id"] = $requests[$x]["facility_id"];
                                $requests[$x]["energy_level"] = $energy;

                            } else{
                                $unAp[$x]["request_id"] = $requests[$x]["request_id"];
                                $unAp[$x]["total_hours"] = $requests[$x]["total_hours"];
                                $unAp[$x]["description"] = $requests[$x]["description"];
                                $unAp[$x]["energy_level"] = "";
                                $unAp[$x]["ion_id"] = "";
                                $unAp[$x]["earliest_date"] = $requests[$x]["earliest_date"];
                                $unAp[$x]["facility_id"] = $requests[$x]["facility_id"];

                            }
                        }
                    }

                $sql = null;
                return $unAp;
                }
            }
        }
    }

    public function priorityUpdate($post){

        $conn = $this->connect();
        $sql = $this->connect()->prepare("UPDATE calendar_events SET color = ?, priority = ?  Where request_id = ?;");

        $req = $_SESSION['requests'][0];
        $keys = array_keys($post);
        //p1:#E6783D p2: #C7430A p3: #C2C200 p4: #FFF700 p5: #0C850A p6: #00FF00
        for($x = 0; $x < count($req); $x++){
            for($y = 0; $y < count($keys); $y++){
                if($req[$x][0] == $keys[$y] && $req[$x][9] != $post[$keys[$y]]){
                    $color = "";
                    if($post[$keys[$y]] == 1) $color = "#E6783D";
                    else if($post[$keys[$y]] == 2) $color = "#C7430A";
                    else if($post[$keys[$y]] == 3) $color = "#C2C200";
                    else if($post[$keys[$y]] == 4) $color = "#FFF700";
                    else if($post[$keys[$y]] == 5) $color = "#0C850A";
                    else if($post[$keys[$y]] == 6) $color = "#00FF00";
                    if(!$sql->execute(array($color, $post[$keys[$y]], $keys[$y]))){
                        $sql = null;
                        header("location: ../profile.php?error=editprio");
                        exit();
                    }
                }
            }
        }
        //$_SESSION['testing'] = $keys[0];
    }

    public function editName($first, $last){
        session_start();
        $sql = $this->connect()->prepare("UPDATE user SET first_name = ?, last_name = ? Where user_id = ?;");
        $id = $_SESSION['id'];
        if(!$sql->execute(array($first, $last, $id))){
            $sql = null;
            header("location: ../profile.php?error=editname");
            exit();
        }
        $sql = null;
        $_SESSION['fullname'] = ''. $first . ' ' . $last . '';
        //session_abort();
    }

    private function editPassword($old, $oldRep, $new){
        session_start();
        $id = $_SESSION['id'];

        $sql = $this->connect()->prepare("SELECT * FROM user WHERE user_id = ?;");
        if(!$sql->execute(array($id))){
            $sql = null;
            header("location: ../profile.php?error=prepare");
            exit();
        } else {
            $user = $sql->fetchAll(PDO::FETCH_ASSOC);
            $sql = null;

            $verifyIn = $old === $oldRep;
            $verify = password_verify($old, $user[0]['password']);

            if($verify == true && $verifyIn){
                $sql = $this->connect()->prepare("UPDATE user SET password = ? Where user_id = ?;");

                if(preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,20}$/', $new) == true){
                    $hash = password_hash($new, PASSWORD_DEFAULT);

                    if(!$sql->execute(array($hash, $id))){
                        $sql = null;
                        header("location: ../profile.php?error=insert");
                        exit();
                    }
                } else {
                    header("location: ../profile.php?error=preg");
                    exit();
                }

            } else {
                $sql = null;
                header("location: ../profile.php?error=verify");
                exit();
            }
        }
        session_abort();
    }

    public function confirmPassword($password) {
        session_start();
        $sql = $this->connect()->prepare("SELECT * FROM user WHERE user_id = ?;");
        //if sql statement fails return to login page with error
        if(!$sql->execute(array($_SESSION['id']))) {
            $sql = null;
            header("location: ../profile.php?error=prepare");
            exit();
        }
        //if no users with the submitted email exist return to login with error
        if($sql->rowCount() == 0) {
            $sql = null;
            header("location: ../profile.php?error=prepare");
            exit();
        }

        //get password of the feteched user, hash the submitted password, and then verify if they match
        $user = $sql->fetchAll(PDO::FETCH_ASSOC);
        $passwordHash = $user[0]["password"];
        $verifyPassword = password_verify($password, $passwordHash);

        //if they dont match return with error and if they do log the user in then set their name, id, and role for this session
        if($verifyPassword == false) {
            $sql = null;
            return false;
        } else if($verifyPassword == true) {
            $sql = null;
            return true;
        }

        $sql = null;
        return false;
    }

    public function edit($old, $repOld, $new){
        $this->editPassword($old, $repOld, $new);
    }

    public function setOrganization($orgName, $orgPhone, $orgEmail, $orgDescription){
        $sql = $this->connect()->prepare("UPDATE user SET org_name = ?, org_phone = ?, org_email = ?, org_description = ? WHERE user_id = ?;");
        if(!$sql->execute(array($orgName, $orgPhone, $orgEmail, $orgDescription, $this->id))){
            $sql = null;
            header("location: ../profile.php?error=prepare");
            exit();
        }
        $sql = null;
    }

    public function getOrganization(){
        $sql = $this->connect()->prepare("SELECT org_name, org_phone, org_email, org_description FROM user WHERE user_id = ?;");
        if(!$sql->execute(array($this->id))){
            $sql = null;
            header("location: ../profile.php?error=prepare");
            exit();
        } 
        if($sql->rowCount() == 0) {
            $sql = null;
            header("location: ../profile.php?error=prepare");
            exit();
        }
        //fetch user org info
        $org = $sql->fetchAll(PDO::FETCH_ASSOC);
        //process info into standard array
        $orgA = array($org[0]['org_name'], $org[0]['org_phone'], $org[0]['org_email'], $org[0]['org_description']);
        return $orgA;
    }
}