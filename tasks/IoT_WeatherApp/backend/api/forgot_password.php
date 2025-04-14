<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

$email = $_POST['email'];
$resetToken = bin2hex(random_bytes(16));

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;
    $mail->Username = 'weatherappiot@gmail.com';
    $mail->Password = 'uwsfieakrancqkge';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('weatherappiot@gmail.com', 'WeatherApp');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Reset hesla pro WeatherApp';
    $mail->Body    = "Klikněte <a href='https://yourdomain.com/reset_password.php?token=$resetToken'>zde</a> pro reset hesla.";
    $mail->AltBody = "Otevřete odkaz: https://yourdomain.com/reset_password.php?token=$resetToken";

    $mail->send();
    echo json_encode(['message' => 'Resetovací e-mail byl odeslán.']);
} catch (Exception $e) {
    echo json_encode(['error' => "E-mail se nepodařilo odeslat. Chyba: {$mail->ErrorInfo}"]);
}
?>
