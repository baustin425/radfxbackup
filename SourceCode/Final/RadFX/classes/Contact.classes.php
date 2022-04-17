<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Contact extends Database {
    public function getUser($id) {
        $sql = $this->connect()->prepare("SELECT user_id, first_name, last_name, email FROM user Where user_id = ?;");
        
        if(!$sql->execute(array($id))) {
            $sql = null;
            $location .= "?error=prepare";
            header($location);
            exit();
        }

        $email = $sql->fetchAll(PDO::FETCH_ASSOC);

        $sql = null;
        return $email;
    }

    public function getId($email){
        $sql = $this->connect()->prepare("SELECT user_id FROM user Where email = ?;");
        
        if(!$sql->execute(array($email))) {
            $sql = null;
            $location .= "?error=prepare";
            header($location);
            exit();
        }

        $id = $sql->fetchAll(PDO::FETCH_ASSOC);

        $sql = null;
        return $id;
    }

    public function sendEmail($email, $fullname, $list, $subject, $message){
        // these may need to change depending on your installation folder for phpmailer
        require '../phpmailer/src/Exception.php';
        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/SMTP.php';
        
        

        // passing true in constructor enables exceptions in PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
            $mail->isSMTP();
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            include_once "../../../data/Config.php";
			$config = new Config();
            $mail->Username = $config->getEmailUser(); // YOUR gmail email
            $mail->Password = $config->getEmailPassword(); // YOUR gmail password

            // Sender and recipient settings
            $mail->setFrom(''. $email .'', ''. $fullname .'');
            for($x = 0; $x < count($list); $x++){
                // get user from id
                $user = $this->getUser($list[$x]);
                $mail->addAddress(''. $user[0]['email'] .'', ''. $user[0]['first_name'] .' '. $user[0]['last_name']);
            }
            $mail->addReplyTo(''. $email .'', ''. $fullname .''); // to set the reply to

            // Setting the email content
            
            $mail->IsHTML(false);
            $mail->Subject = $subject;
            $message .= "\n\n\n Message Sent From radfx-a.research.utc.edu ";
            $mail->Body = $message;         

            $mail->send();

            //echo "Email message sent.";

            header("location: ../Profile.php?success");
        } catch (Exception $e) {
            //echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";

            header("location: ../Profile.php?error=senderror");
        }
    }

    public function mailHello($email, $first_name, $last_name){

        // these may need to change depending on your installation folder for phpmailer
        require '../phpmailer/src/Exception.php';
        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/SMTP.php';
                
                

        // passing true in constructor enables exceptions in PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
            $mail->isSMTP();
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            include_once "../../../data/Config.php";
			$config = new Config();
            $mail->Username = $config->getEmailUser(); // YOUR gmail email
            $mail->Password = $config->getEmailPassword(); // YOUR gmail password

            //email user to let them know the account has been created successfully

            $id = $this->getId($email);
            $user = $this->getUser($id[0]['user_id']);

            // Sender and recipient settings

            $mail->setFrom('radfx.no.reply@gmail.com', 'RadFX System');
            $mail->addAddress(''. $user[0]['email'] .'', ''. $user[0]['first_name'] .' '. $user[0]['last_name']);
            $mail->addReplyTo($email, ''. $first_name .''. $first_name .''); // to set the reply to

            // Setting the email content
                
            $mail->IsHTML(false);
            $mail->Subject = "Welcome to RADFX!";
            
            $mail->Body = "Your account was successfully created. \n In order to gain access to test requesting, your account will need to be approved by an administrator. \n Please check for an approval email. \n Welcome To RadFX! \n\n\n Message Sent From radfx-a.research.utc.edu";
            
            $mail->send();

            //echo "Email message sent.";

            header("location: ../Profile.php?success");
        } catch (Exception $e) {
            //echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";

            header("location: ../Profile.php?error=senderror");
        }
    }


    public function mailCustom($id, $subject, $message){

        // these may need to change depending on your installation folder for phpmailer
        require '../phpmailer/src/Exception.php';
        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/SMTP.php';
                
                

        // passing true in constructor enables exceptions in PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
            $mail->isSMTP();
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            include_once "../../../data/Config.php";
			$config = new Config();
            $mail->Username = $config->getEmailUser(); // YOUR gmail email
            $mail->Password = $config->getEmailPassword(); // YOUR gmail password

            //email user to let them know the account has been created successfully

            $user = $this->getUser($id);

            // Sender and recipient settings

            $mail->setFrom('radfx.no.reply@gmail.com', 'RadFX System');
            $mail->addAddress(''. $user[0]['email'] .'', ''. $user[0]['first_name'] .' '. $user[0]['last_name']);
            $mail->addReplyTo(''. $user[0]['email'] .'', ''. $user[0]['first_name'] .' '. $user[0]['last_name']); // to set the reply to

            // Setting the email content
                
            $mail->IsHTML(false);
            $mail->Subject = $subject;
            
            $mail->Body = $message;
            
            $mail->send();


        } catch (Exception $e) {

        }
    }
}

?>
