<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre,$email,$token)
    {
        $this->nombre = $nombre; 
        $this->email = $email;
        $this->token = $token;
            
    }
    public function enviarConfirmacion() {
        //debuguear('estas por enviar email .....');         
        // crear el objeto de emIL
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = 'smtp.mailtrap.io';
         $mail->SMTPAuth = true;
         $mail->Port = 2525;
         $mail->Username = 'ec20f35fbe37c5';
         $mail->Password = '06eced1725d08a';
        
         $mail->setFrom('cuentas@appsalon.com');
         $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
         $mail->Subject = 'Confirma tu cuenta';

       // anexar htnl
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $contenido = "<html>";
         $contenido .= "<p><strong>Hola ". $this->nombre ." </strong> Haz creado tu cuenta en Appsalon, solo debes confirmarla presionando el siguiente enlace</p>";
         $contenido .= "<p>Presiona aqui; <a href='http://localhost:3000/confirmar-cuenta?token=". $this->token ."'>Confirmar Cuenta</a></p>";

         $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar esta cuenta </p>";
         $contenido .= "</html>";

         $mail->Body = $contenido;
       //  enviar email
         $mail->send();

    } // fin eniar confirmacion
    public function enviarInstrucciones(){
          // crear el objeto de emIL
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->Host = 'smtp.mailtrap.io';
          $mail->SMTPAuth = true;
          $mail->Port = 2525;
          $mail->Username = 'ec20f35fbe37c5';
          $mail->Password = '06eced1725d08a';
         
          $mail->setFrom('cuentas@appsalon.com');
          $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
          $mail->Subject = 'Restablece tu password';
 
        // anexar htnl
          $mail->isHTML(TRUE);
          $mail->CharSet = 'UTF-8';
 
          $contenido = "<html>";
          $contenido .= "<p><strong>Hola ". $this->nombre ." </strong> Haz solicitado restablecer tu password, presiona el siguiente enlace</p>";
          $contenido .= "<p>Presiona aqui; <a href='http://localhost:3000/recuperar?token=". $this->token ."'>Restablecer password</a></p>";
 
          $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar esta cuenta </p>";
          $contenido .= "</html>";
 
          $mail->Body = $contenido;
        //  enviar email
          $mail->send();    
    }

}

?>