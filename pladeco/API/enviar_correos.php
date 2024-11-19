<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/PLADECO/pladeco/app/templeates/plugins/vendor/autoload.php';


function enviarCorreo($emailDestino, $nombreUsuario)
{
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'informacionespladeco@gmail.com';
        $mail->Password = 'geuaqpcljupubjgf';  // Usa la contraseña de la aplicación generada
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('informacionespladeco@gmail.com', 'PLADECO');
        $mail->addAddress($emailDestino, $nombreUsuario);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevas Tareas en PLADECO';
        $mail->Body = '¡Hola ' . $nombreUsuario . '! Tienes nuevas tareas en la plataforma de PLADECO. Ingresa a revisarlas. ¡Saludos!';

        // Enviar correo
        $mail->send();
        echo 'Correo enviado correctamente';
    } catch (Exception $e) {
        echo "Error al enviar correo: {$mail->ErrorInfo}";
    }
}

?>