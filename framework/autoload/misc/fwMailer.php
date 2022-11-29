<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'cards/assets/vendor/PHPMailer/src/Exception.php';
require 'cards/assets/vendor/PHPMailer/src/PHPMailer.php';
require 'cards/assets/vendor/PHPMailer/src/SMTP.php';

    class fwMailer{
        private $mail;

        public function __construct() {
            $this->mail = new PHPMailer(true);

            $this->mail->isSMTP();
            $this->mail->Host       = gc::getSetting("mail.host");
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = gc::getSetting("mail.user");
            $this->mail->Password   = gc::getSetting("mail.pass");
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mail->Port       = gc::getSetting("mail.port");
            $this->mail->setFrom(gc::getSetting("mail.user"), gc::getSetting("site.name"));   
        }

        public function sendMail($to, $subject, $body) {
            try {               
                //Recipients
                $this->mail->addAddress($to["email"], $to["name"]);     //Add a recipient
            
                //Content
                $this->mail->isHTML(true);
                $this->mail->Subject = $subject;
                $this->mail->Body    = $body;
            
                $this->mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            }    
        }
    }
?>