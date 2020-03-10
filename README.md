# TempMail PHP library

This unofficial library for PHP uses official [www.tempmailgen.com](https://tempmailgen.com/) API. Features:

  - Get list of all emails in specified inbox
  - Get specified email
  - Get last email in inbox
  - Get full email address based on data passed to constructor

### Usage

Clone repository and create new php file

### Domains

You can find full list of domains on [www.tempmailgen.com](https://tempmailgen.com/)

### Example code
```php
include 'includes/autoload.php';

$email = new TempMail('jack', 'mailsy.top');
$message = $email->inbox()->getLastEmail();

echo $message['text_body'];
```