<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ControladorCorreo
{
    static public function ctrEnviarCorreo($correo,$nombre,$subject,$msg)
    {
        if (isset($correo)) {

            if (
                preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $nombre) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $correo) 
                // && preg_match('/^[=\\$\\;\\*\\"\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/',  $_POST["mensajeContacto"])
            ) {

                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'martinezsalasjuan.4a@gmail.com';                     //SMTP username
                    $mail->Password   = 'aRC9BFeFAWvhcfH';                               //SMTP password
                    $mail->SMTPSecure = 'ssl';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 465;                                    //[587]TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                    //Recipients
                    $mail->setFrom('martinezsalasjuan.4a@gmail.com','UPA cursos');
                    $mail->addAddress($correo,$nombre);     //Add a recipient
                    $mail->addReplyTo('martinezsalasjuan.4a@gmail.com','UPA cursos');

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = $subject;
                    $mail->Body=$msg;

                    $mail->send();
                    return "ok";
                } catch (Exception $e) {
                    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    return "error";
                }
            }else{
                return "error-sintaxis";
            }
        }
    }
}
