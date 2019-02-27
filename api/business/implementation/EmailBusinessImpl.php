<?php

// PHPMailer
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

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

    public function sendConfirmEmail($email, $confirmationLink)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ($email) {
            try {
                // Remitente
                $this->mail->setFrom('erasmo.mendoza@lakmisystems.com.mx', 'Office Track');

                // Destinatario
                $this->mail->addAddress($email); // Añadir destinatario

                // Contenido
                $this->mail->isHTML(true); // formto HTML para el email
                $this->mail->Subject = "Confirma tu cuenta";
                $this->mail->Body = "<a href=$confirmationLink>Da click aqui para confirmar tu cuenta</a>";

                return $this->mail->send();

            } catch (Exception $e) {
                echo $e;
            }
        }
    }

}
