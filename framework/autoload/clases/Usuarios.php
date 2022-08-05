<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'cards/assets/vendor/PHPMailer/src/Exception.php';
    require 'cards/assets/vendor/PHPMailer/src/PHPMailer.php';
    require 'cards/assets/vendor/PHPMailer/src/SMTP.php';

    class usuarios{
        
        public function registroUsuario($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $fecha=date('Y-m-d');
            $user_id = Usuarios::gen_uuid();

            if(isset($datos[5])){
                $sql="INSERT into users (name,
                        email,
                        password,
                        username,
                        fechaCaptura,
                        verify_code,
                        google_id,
                        profile_image)
                    values ('$datos[0]','$datos[1]','$datos[2]', '$datos[3]', '$fecha', '$user_id', '$datos[5]', '$datos[6]')";
            } else {
                $sql="INSERT into users (name,
                        email,
                        password,
                        username,
                        fechaCaptura,
                        verify_code)
                    values ('$datos[0]','$datos[1]','$datos[2]', '$datos[3]', '$fecha', '$user_id')";
            }

            $mail = new PHPMailer(true);

            if(!$datos[4]){
                try {               
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'alex25005.lleida@gmail.com';                     //SMTP username
                    $mail->Password   = 'kuqfygvzxeehygzy';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                    //Recipients
                    $mail->setFrom('alex25005.lleida@gmail.com', 'Collection Saver');
                    $mail->addAddress($datos[1], $datos[2]);     //Add a recipient
                
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Collection Saver: E-mail verification';
                    $mail->Body    = '<body style="background-color: #3f3f3f; color: white;"><i class="bx bx-layer"></i> <h2 style="margin: 20px; padding: 15px;">Collection Saver</h2>
                        <center><h2><span style="background-color: #4723D9; color: white;">Welcome Alex</span>, lets get started!</h2></br>
                        <h3 style="font-weight: normal;">You have to click the button below to verificate your account:</h3></br>
                        <a href="http://localhost:8080/dashboard/'.$user_id.'" style="background-color: #4723D9;
                            border: none;
                            color: white;
                            padding: 13px 28px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 16px;
                            margin: 4px 2px;
                            cursor: pointer;">¡Click here!</a>
                        </center>
                        <div style="background-color: #3f3f3f; color: white; margin: 20px;">
                            <div style="margin-top: 4rem; background-color: #3f3f3f; color: white;">
                                <p>Best regards,</p>
                                <p>Collection Saver team</p>
                                <p>https://collectionsaver.com</p>
                                <p>info@collectionsaver.com</p>
                            </div>
                        </div>
                        <center style="padding-bottom: 3rem;">
                            <hr>
                            <h3 style="margin-top: 1rem;">Follow Us:</h3>
                            <div>
                                <span style="margin-right: 2rem;">Instagram</span> 
                                <span style="margin-right: 2rem;">Twitter</span> 
                                <span>Discord</span>
                            </div>
                        </center>
                    </body>';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                
                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }    
            }
            
            return mysqli_query($conexion, $sql);
        }

        public function updateUser($datos){
            $c=new conectar();
			$conexion=$c->conexion();

            if(sha1($datos[1]) == ($datos[2])){
                $sql="SELECT password FROM users where user_id = '$datos[0]'";

                if ($resultado = mysqli_query($conexion, $sql)) {
    
                    while ($fila = mysqli_fetch_row($resultado)) {
                        if($fila[0] == $datos[5]){
                            $sql="SELECT username FROM users where username = '$datos[3]'";

                            $rs_result=mysqli_query($conexion, $sql);
                            $total_records=mysqli_num_rows($rs_result);

                            if($total_records > 0){
                                return trim("userError");
                            }

                            if(strlen($datos[6]) > 0){
                                $sql="UPDATE users set username='$datos[3]', email='$datos[4]', password='$datos[6]' where user_id = '$datos[0]'";
                            } else {
                                $sql="UPDATE users set username='$datos[3]', email='$datos[4]' where user_id = '$datos[0]'";
                            }
                            
                            $_SESSION["usuario"] = $datos[3];
                            return mysqli_query($conexion,$sql);
                        } else {
                            return trim("passError");
                        }
                    }
                    
                }
                
            } else {
                return 0;
            }
        }

        public function deleteUser($datos){
            $c=new conectar();
			$conexion=$c->conexion();

            if(sha1($datos[1]) == ($datos[2])){
                $sql="DELETE from users where user_id = '$datos[0]'";
                return mysqli_query($conexion,$sql);
            } else {
                return 0;
            }
            
        }

        public function checkSettings($idusuario) {
            $c=new conectar();
			$conexion=$c->conexion();

            $sql="SELECT settings from users where user_id='$idusuario[0]'";

            if ($resultado = mysqli_query($conexion, $sql)) {

                while ($fila = mysqli_fetch_row($resultado)) {
                    $allSettings[] = json_decode($fila[0]);
                }
                
                mysqli_free_result($resultado);
            }
            
            return json_encode($allSettings);
        }

        public function setSettings($datos) {
            $c=new conectar();
			$conexion=$c->conexion();

            $sql="UPDATE users SET settings = '$datos[1]' where user_id='$datos[0]'";

            if ($resultado = mysqli_query($conexion, $sql)) {

                while ($fila = mysqli_fetch_row($resultado)) {
                    $allSettings[] = json_decode($fila[0]);
                }
                
                mysqli_free_result($resultado);
            }
            
            return json_encode($allSettings);
        }

        public function mail_verification($datos){
            $c=new conectar();
			$conexion=$c->conexion();

            $sql="UPDATE users SET verified = 1 WHERE verify_code = '$datos[0]'";
            
            return mysqli_query($conexion, $sql);
        }

        public function getDetails($id_usuario) {
            $model = new userModel();
			$userDetails = $model->findById($id_usuario);
            
            return $userDetails;
        }

        public function generateCode($user_id, $action){
            $c=new conectar();
            $conexion=$c->conexion();  
            
            $sql="SELECT email, username from users where user_id = '$user_id'";

            if ($resultado = mysqli_query($conexion, $sql)) {

                while ($fila = mysqli_fetch_row($resultado)) {
                    $verificationCode = Usuarios::generateRandomString(5);
                    $mail = new PHPMailer(true);

                    try {               
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'alex25005.lleida@gmail.com';                     //SMTP username
                        $mail->Password   = 'kuqfygvzxeehygzy';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    
                        //Recipients
                        $mail->setFrom('alex25005.lleida@gmail.com', 'Collection Saver');
                        $mail->addAddress($fila[0], $fila[1]);     //Add a recipient
                    
                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Collection Saver: '.$action.' Account Code';
                        $mail->Body    = '<body style="background-color: #3f3f3f; color: white; padding: 15px; margin: 20px;"><i class="bx bx-layer"></i> <h2 style="margin: 20px; padding: 15px;">Collection Saver</h2>
                            <p>Here is your e-mail verification code:</p></br>
                            <h3>'.$verificationCode.'</h3></br>
                            <p>If you did not request this action, please change your password immediately, we also recommend to change your e-mail password.</p>
                            
                            <div style="background-color: #3f3f3f; color: white; margin: 20px;">
                                <div style="margin-top: 4rem; background-color: #3f3f3f; color: white;">
                                    <p>Best regards,</p>
                                    <p>Collection Saver team</p>
                                    <p>https://collectionsaver.com</p>
                                    <p>info@collectionsaver.com</p>
                                </div>
                            </div>

                            <center style="padding-bottom: 3rem;">
                                <hr>
                                <h3 style="margin-top: 1rem;">Follow Us:</h3>
                                <div>
                                    <span style="margin-right: 2rem;">Instagram</span> 
                                    <span style="margin-right: 2rem;">Twitter</span> 
                                    <span>Discord</span>
                                </div>
                            </center>
                        </body>';
                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                    
                        $mail->send();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
                
            }
            return sha1($verificationCode);
        }

        public function gen_uuid() {
            return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        
                // 16 bits for "time_mid"
                mt_rand( 0, 0xffff ),
        
                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand( 0, 0x0fff ) | 0x4000,
        
                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand( 0, 0x3fff ) | 0x8000,
        
                // 48 bits for "node"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
            );
        }

        public function generateRandomString($length = 5) {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            return $randomString;
        }
    }

?>