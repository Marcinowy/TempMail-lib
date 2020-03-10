<?php
include 'includes/autoload.php';

$email = new TempMail('jack', 'mailsy.top');
try {
    $message = $email->inbox()->getLastEmail();
    var_dump($message);
} catch (Exception $e) {
    echo 'Error: ' . $e;
}