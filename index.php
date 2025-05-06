<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$recaptchaSiteKey = $_ENV['RECAPTCHA_KEY_PUBLIC'];
$recaptchaAction = $_ENV['RECAPTCHA_ACTION'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>catchap</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h2 class="text-2xl font-bold text-center mb-6">Formulario de Contacto</h2>

        <form action="send_email.php" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre:</label>
                <input type="text" id="name" name="name" class="w-full p-2 mt-1 border border-gray-300 rounded-md"
                    pattern="[A-Za-záéíóúÁÉÍÓÚÑñ ]+" title="Solo se permiten letras y espacios" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
                <input type="email" id="email" name="email" class="w-full p-2 mt-1 border border-gray-300 rounded-md"
                    required>
            </div>
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700">Asunto</label>
                <input type="text" id="subject" name="subject" class="w-full p-2 mt-1 border border-gray-300 rounded-md"
                    required>
            </div>

            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700">Mensaje:</label>
                <textarea id="message" name="message" rows="4" class="w-full p-2 mt-1 border border-gray-300 rounded-md"
                    required></textarea>
            </div>

            <div class="text-center">
                <input type="hidden" id="recaptcha_response" name="recaptcha_response">

                <button type="submit" id="submitBtn"
                    class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 cursor-pointer">
                    Enviar
                </button>
            </div>
        </form>
    </div>

    <script
        src="https://www.google.com/recaptcha/enterprise.js?render=<?= $recaptchaSiteKey ?>"></script>
    <script>
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submitBtn');

        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            grecaptcha.enterprise.ready(async () => {
                const token = await grecaptcha.enterprise.execute('<?= $recaptchaSiteKey ?>', {
                    action: '<?= $recaptchaAction ?>'
                });
                document.getElementById('recaptcha_response').value = token;
                form.submit(); // solo se envía después de tener el token
            });
        });
    </script>

</body>

</html>