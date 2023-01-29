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

        public function sendMail($to, $subject, $template) {
            try {               
                //Recipients
                $this->mail->addAddress($to["email"], $to["name"]);     //Add a recipient
               
                //Content
                $this->mail->isHTML(true);
                $this->mail->Subject = $subject;
                $this->mail->Body    = $template;
                
                $this->_parseEmbedImages();

                return $this->mail->send();
            } catch (Exception $e) {
                print_r($this->mail->ErrorInfo);die;
                return false;
            }    
        }

        public function _parseEmbedImages() {
            $pattern = "/src=([\\\"'])((.+?)\.(gif|jpg|png))\\1/im";
            $matches = preg_match_all($pattern, $this->mail->Body, $results, PREG_SET_ORDER);
            $count = 0;
    
            foreach ($results as $result) {
                if(file_exists($results[2])) {
                    $id = "img" . $count;
                    $new = "cid:" . $id;
        
                    $this->mail->Body = preg_replace($result[2], $new, $this->mail->Body);
                    $this->mail->AddEmbeddedImage($result[2], $id, $id . ".png", "base64", "image/png");
        
                    $count++;
                }
            }
        }
    }
?>