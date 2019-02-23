<?php

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailBusinessImpl
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = 2; // Habilitar depuracion detallada
        $this->mail->isSMTP(); // Usar SMTP
        $this->mail->Host = 'mail.lakmisystems.com.mx'; // Server desde donde se enviara
        $this->mail->SMTPAuth = true; // Permitir autenticacion SMTP
        $this->mail->Username = 'usuario@lakmisystems.com.mx'; // usuario SMTP
        $this->mail->Password = 'contraseña'; // contraseña SMTP
        $this->mail->SMTPSecure = 'tls'; // Habilitar encriptacion TLS
        $this->mail->Port = 587; // Puerto de conexion TCP
    }

    public function sendConfirmEmail($to, $body)
    {

        $to = filter_var($to, FILTER_SANITIZE_EMAIL);
        $body = filter_var($body, FILTER_SANITIZE_STRING);

        if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
            try {
                // Remitente
                $this->mail->setFrom('erasmo.mendoza@lakmisystems.com.mx', 'Carlos de Lakmi Systems');
                
                // Destinatario
                $this->mail->addAddress($to); // Añadir destinatario

                // Contenido
                $this->mail->isHTML(true); // formto HTML para el email
                $this->mail->Subject = "Confirma tu cuenta";
                $this->mail->Body = $body;

                return $this->mail->send();

            } catch (Exception $e) {
                
            }
        }
    }

}

// $send  = new EmailBusinessImp ();
// var_dump($send->sendEmail("erasmo.mendoza@lakmisystems.com.mx","prueba","Mensaje de prueba"));

?>


