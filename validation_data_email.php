<?php

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use ReCaptcha\ReCaptcha;

function sanitize($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

function validateRecaptcha($token)
{
    $recaptcha = new ReCaptcha($_ENV['RECAPTCHA_KEY_SECRET']);
    $response = $recaptcha->verify($token, $_SERVER['REMOTE_ADDR']);

    if (!$response->isSuccess()) {
        throw new Exception("Error de reCAPTCHA: " . implode(", ", $response->getErrorCodes()));
    }
}

if ($_POST) {
    try {
        // Validar reCAPTCHA
        validateRecaptcha($_POST['recaptcha_response']);

        // Validación de los campos del formulario
        $name = isset($_POST['name']) ? sanitize($_POST['name']) : "";
        $email = isset($_POST['email']) ? sanitize($_POST['email']) : "";
        $message = isset($_POST['message']) ? sanitize($_POST['message']) : "";
        $subject = isset($_POST['subject']) ? sanitize($_POST['subject']) : "";
    } catch (Exception $e) {
        // Si hay un error de reCAPTCHA o validación, muestra el error
        echo "Error: " . $e->getMessage();
        exit();
    }
}
