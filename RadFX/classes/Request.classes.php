<?php

class Request extends Database {
    private $hours;
    private $purpose;
    private $info;
    private $energy;
    private $ions;
    private $facility;
    private $vacuum;
    private $date;
    
    
    public function __construct($hours, $purpose, $info, $energy, $ions, $facility, $vacuum, $date) {
        $this->hours = $hours;
        $this->purpose = $purpose;
        $this->info = $info;
        $this->energy = $energy;
        $this->ions = $ions;
        $this->facility = $facility;
        $this->vacuum =$vacuum;
        $this->date = $date;
    }

    public function submitRequest() {

        $this->saveRequest();
    }
    
    private function saveRequest() {
        $sql = $this->connect()->prepare("INSERT INTO purpose (purpose_of_test, description, energy_level, requested_ions, vacuum) VALUES (?, ?, ?, ?, ?);");
        if(!$sql->execute(array($this->purpose, $this->info, $this->energy, $this->ions, $this->vacuum))) {
            $sql = null;
            header("location: ../Request.php?error=prepare");
            exit();
        }

        $sql = null;
        $sql = $this->connect()->prepare("SELECT purpose_id FROM purpose WHERE purpose_of_test = ?;");

        if(!$sql->execute(array($this->purpose))) {
            $sql = null;
            header("location: location: ../Request.php?error=prepare2");
            exit();
        }

        if($sql->rowCount() == 0) {
            $sql = null;
            header("location: location: ../Request.php?error=prepare3");
            exit();
        }

        $purp = $sql->fetchAll(PDO::FETCH_ASSOC);
        $purp_id = $purp[0]["purpose_id"];

        $sql = $this->connect()->prepare("INSERT INTO request (total_hours, facility_id, user_id, earliest_date, purpose_id) VALUES (?, ?, ?, ?, ?);");
        
        $fac_id;
        if($this->facility == "Berkeley") {
            $fac_id = "0";
        } else if($this->facility == "A&M") {
            $fac_id = "1";
        } if($this->facility == "NASA") {
            $fac_id = "2";
        }

        if(!$sql->execute(array($this->hours, $fac_id, $_SESSION["id"], $this->date, $purp_id))) {
            $sql = null;
            header("location: ../Request.php?error=prepare4");
            exit();
        }

        $to = $this->email;
        $subject = "Thank you for submitting your request!";
        $message = "<html>
        <head>Good evening,</head>
            <body>
                <p style='color:black;'>Thank you for submitting your request with RADFX. You will recieve confirmation of approval within a few days and be scheduled shortly pending approval.</p>
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