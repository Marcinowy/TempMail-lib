<?php
include 'includes/autoload.php';

$email = new TempMail('jack', 'mailsy.top');
$message = $email->inbox()->getLastEmail();

var_dump($message);