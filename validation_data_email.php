<?php

function sanitize($data)
{
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);

    return $data;
}

if ($_POST) {
    $name = isset($_POST['name']) ? sanitize($_POST['name']) : "";
    $email = isset($_POST['email']) ? sanitize($_POST['email']) : "";
    $message = isset($_POST['message?]']) ? sanitize($_POST['message']) : "";
}
