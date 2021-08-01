<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ControladorCorreo
{
    static public function ctrEnviarCorreo($correo,$nombre,$subject,$msg,$idCurso,$img)
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
                    // $mail->addStringAttachment(file_get_contents($dominio.'vistas/img/rsc/'), "ref-pago.jpeg");
                    $path = '';
                    
                    $idC = ["idCurso"=>$idCurso];
                    $curso = ModeloFormularios::mdlSelecReg("Cursos", array_keys($idC), $idC);

                    if($img==1){
                        // $path = dirname(__DIR__).'/controladores/docs/ft-'.$idCurso.'.docx';
                        $mail->addEmbeddedImage(dirname(__DIR__).'/vistas/img/rsc/ref-pago.jpeg','imagen','ref-pago.jpeg');
                    }else{
                        // $path = ;
                        $mail->AddAttachment(dirname(__DIR__).'/controladores/docs/Protocolo_covid19_UPA.pdf');
                        $mail->AddAttachment(dirname(__DIR__).'/vistas/img/flyers/'.$curso[0]["flyer"]);
                        $mail->AddAttachment(dirname(__DIR__).'/controladores/docs/ft-'.$idCurso.'.docx');
                        $mail->AddAttachment(dirname(__DIR__).'/controladores/docs/bc-'.$idCurso.'.docx');
                    }
                    
                    $mail->Body=$msg;

                    $mail->send();
                    if($img==0){
                        unlink(dirname(__DIR__).'/controladores/docs/ft-'.$idCurso.'.docx');
                        unlink(dirname(__DIR__).'/controladores/docs/bc-'.$idCurso.'.docx');
                    }
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
