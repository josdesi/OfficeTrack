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
        $this->mail->Username = '@lakmisystems.com.mx'; // usuario SMTP
        $this->mail->Password = ''; // contraseña SMTP
        $this->mail->SMTPSecure = 'tls'; // Habilitar encriptacion TLS
        $this->mail->Port = 587; // Puerto de conexion TCP
    }

    public function sendRegistryConfirmation($email, $username, $confirmationLink)
    {
        try {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            //Cargar estilos para el correo (.css)
            $cssPath = realpath("../../email/A_01/estilo.css"); //ruta de archivo css
            $css = file_get_contents($cssPath); //leer contenido de css

            //Cargar plantilla para el correo (.html)
            $templatePath = realpath("../../email/A_01/correo.html");
            $template = file_get_contents($templatePath);

            //Cambiar username a mayusculas
            $username = strtoupper($username);

            $emailBody = $template;

            $emailBody = str_replace('<style id="estilo"></style>', "<style>$css</style>", $emailBody); //Remplaza CSS
            $emailBody = str_replace('{{dinamic_link}}', $confirmationLink, $emailBody); // Remplaza Link de confirmación
            $emailBody = str_replace('{{user_name}}', $username, $emailBody); // Remplaza Username

            //Agrega destinatario-Remitente
            $this->mail->setFrom('erasmo.mendoza@lakmisystems.com.mx', 'Office Track'); // Añade remitente
            $this->mail->addAddress($email); // Añade destinatario

            //headers
            $this->mail->isHTML(true); // Configura formato HTML para el email
            $this->mail->CharSet = 'UTF-8'; // Configura chartset utf.8

            // Contenido
            $this->mail->Subject = "Confirma tu cuenta"; // Añade asunto
            $this->mail->Body = $emailBody; // Añade el cuerpo del correo

            $this->mail->send();

        } catch (Exception $e) {
            throw new Exception("El mensaje no pudo ser enviado");
        }
    }

    public function sendNewsletterConfirmation($email)
    {
        try {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            //Cargar estilos para el correo (.css)
            $cssPath = realpath("../../email/A_01/estilo.css"); //ruta de archivo css
            $css = file_get_contents($cssPath); //leer contenido de css

            //Cargar plantilla para el correo (.html)
            $templatePath = realpath("../../email/A_01/correo.html");
            $template = file_get_contents($templatePath);

            $emailBody = $template;

            $emailBody = str_replace('<style id="estilo"></style>', "<style>$css</style>", $emailBody); //Remplaza CSS

            //Agrega destinatario-Remitente
            $this->mail->setFrom('erasmo.mendoza@lakmisystems.com.mx', 'Office Track'); // Añade remitente
            $this->mail->addAddress($email); // Añade destinatario

            //headers
            $this->mail->isHTML(true); // Configura formato HTML para el email
            $this->mail->CharSet = 'UTF-8'; // Configura chartset utf.8

            // Contenido
            $this->mail->Subject = "Gracias por suscribirte al newsletter"; // Añade asunto
            $this->mail->Body = $emailBody; // Añade el cuerpo del correo

            $this->mail->send();

        } catch (Exception $e) {
            throw new Exception("El mensaje no pudo ser enviado");
        }
    }

}
