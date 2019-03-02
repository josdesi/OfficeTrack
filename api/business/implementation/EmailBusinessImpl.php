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

    public function sendConfirmEmail($email, $username, $confirmationLink)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $cssPath =  realpath("../../email/A_01/estilo.css"); //ruta de archivo css
        $cssString = file_get_contents($cssPath);; //leer contenido de css

        //Cargar archivo html
        $htmlPath = realpath("../../email/A_01/correo.html");
        $htmlString = file_get_contents($htmlPath);

        // Username a mayusculas
        $username = strtoupper ( $username );
        
        //reemplazar sección de plantilla html con el css cargado y mensaje creado
        $incss = str_replace('<style id="estilo"></style>', "<style>$cssString</style>", $htmlString);
        $inclink = str_replace('{{dinamic_link}}', $confirmationLink, $incss);
        $body = str_replace('{{user_name}}', $username, $inclink);


        if ($email) {
            try {
                // Remitente
                $this->mail->setFrom('erasmo.mendoza@lakmisystems.com.mx', 'Office Track');

                // Destinatario
                $this->mail->addAddress($email); // Añadir destinatario

                //headers
                $this->mail->isHTML(true); // formto HTML para el email
                $this->mail->CharSet = 'UTF-8';

                // Contenido
                $this->mail->Subject = "Confirma tu cuenta";
                $this->mail->Body = $body;

                $this->mail->send();

            } catch (Exception $e) {
                echo $e;
            }
        }
    }

}
