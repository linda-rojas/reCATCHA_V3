<?php

require 'validation_data_email.php';
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {

    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = $_ENV['SANDBOX_HOST_MAILER'];
    $mail->SMTPAuth   = true;
    $mail->Username = $_ENV['USERNAME_EMAIL_MAILER'];
    $mail->Password = $_ENV['PASSWORD_MAILER'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = $_ENV['PORT_MAILER'];

    //remitente y destinatario
    $mail->setFrom($email, $name);
    $mail->addAddress($_ENV['USERNAME_EMAIL_MAILER'], $_ENV['USERNAME']);

    // Cargar plantilla HTML
    $template = file_get_contents('correo_template.html');

    // Reemplazar las variables en el template
    $body = str_replace(
        ['[Nombre]', '[Email]', '[Asunto]', '[Mensaje]'],
        [$name, $email, $subject, nl2br($message)],  // nl2br para saltos de línea
        $template
    );

    //Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
    header("Location: ./form_success/success.html");
    exit();
} catch (Exception $e) {
    echo "El mensaje no pudo ser enviado. Error de PHPMailer: {$mail->ErrorInfo}";
}
