<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function sendEmail($to, $subject, $message, $attachments = [], $settings) {
    require_once 'PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/src/SMTP.php';
    require_once 'PHPMailer/src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $settings['smtp']['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $settings['smtp']['username'];
        $mail->Password = $settings['smtp']['password'];
        $mail->SMTPSecure = $settings['smtp']['secure'];
        $mail->Port = $settings['smtp']['port'];

        $mail->setFrom($settings['smtp']['from_email'], $settings['smtp']['from_name']);
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        foreach ($attachments as $att) {
            $mail->addAttachment($att['path'], $att['name']);
        }

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log($mail->ErrorInfo);
        return false;
    }
}
?>