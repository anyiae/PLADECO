<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/PLADECO/pladeco/app/templeates/plugins/vendor/autoload.php';

function enviarCorreo($emailDestino, $nombreUsuario, $asunto, $mensaje, $emailRemitente)
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
    $mail->addAddress($emailDestino, 'Administrador PLADECO'); // Enviar al correo del destinatario configurado

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = $asunto;
    $mail->Body = $mensaje;

    // Enviar correo
    $mail->send();
    return 'Correo enviado correctamente';
  } catch (Exception $e) {
    return "Error al enviar correo: {$mail->ErrorInfo}";
  }
}

// Lógica del formulario de contacto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $receiving_email_address = 'informacionespladeco@gmail.com';  // Reemplaza con la dirección de correo real del administrador
  $nombre = $_POST['name'];
  $email = $_POST['email'];
  $asunto = $_POST['subject'];
  $mensaje = $_POST['message'];

  $mensaje_completo = "Nombre: $nombre<br>Email: $email<br>Mensaje: $mensaje";

  $resultado = enviarCorreo($receiving_email_address, $nombre, $asunto, $mensaje_completo, $email);
  if ($resultado === 'Correo enviado correctamente') {
    echo 'OK'; // Respuesta que el script espera
  } else {
    echo $resultado; // Devolver el mensaje de error en caso de fallo
  }
} else {
  http_response_code(405); // Método no permitido
  echo 'Método de solicitud no soportado';
}
?>