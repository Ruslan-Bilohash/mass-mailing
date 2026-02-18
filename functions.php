<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function sendEmail($to, $subject, $message, $settings, $attachments = []) {
    $mail_method = $settings['mail_method'] ?? 'smtp';

    // Detect if message is likely plain text (simple check for common HTML tags)
    $is_plain = !preg_match('/<html|<body|<div|<p|<br|<table/i', $message);

    $plain_message = strip_tags($message);

    // Enhanced beautiful HTML template with icons (using emoji for email compatibility), changed color to green (#28a745), more script info in header, more links in footer
    $html_message = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($subject) . '</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f4f4f4; }
        .header { background-color: #28a745; color: white; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0; font-size: 14px; }
        .content { background-color: #ffffff; padding: 20px; border-radius: 0 0 8px 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .footer { text-align: center; font-size: 0.8em; color: #666; margin-top: 20px; padding: 10px; border-top: 1px solid #ddd; }
        .footer a { color: #28a745; text-decoration: none; margin: 0 5px; }
        .icon { font-size: 1.2em; margin-right: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1><span class="icon">📧</span> Mass Mailing 1.0</h1>
        <p>A modern PHP-based email sender for consented users. Features: multi-language, file uploads, attachments, responsive design. Strictly no spam!</p>
    </div>
    <div class="content">
        ' . ($is_plain ? nl2br(htmlspecialchars($message)) : $message) . '
    </div>
    <div class="footer">
        Developed by <a href="' . DEVELOPER_URL . '"><span class="icon">👨‍💻</span>' . DEVELOPER_NAME . '</a><br>
        Project: <a href="' . GITHUB_URL . '"><span class="icon">🔗</span>Mass Mailing on GitHub</a><br>
        Other Projects: <a href="https://edukvam.com/"><span class="icon">🌐</span>Edukvam</a>
    </div>
</body>
</html>';
    
    if ($mail_method === 'phpmail') {
        // Implement PHP mail() with multipart/alternative for HTML and plain, plus attachments
        $boundary = md5(time());
        $alt_boundary = md5(time() . 'alt');
        $from_name = $settings['smtp']['from_name'] ?? 'Admin';
        $from_email = $settings['smtp']['from_email'] ?? 'no-reply@example.com';
        $headers = "From: " . $from_name . " <" . $from_email . ">\r\n";
        $headers .= "Reply-To: " . $from_email . "\r\n";
        $headers .= "Return-Path: " . $from_email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n";

        $body = "--" . $boundary . "\r\n";
        $body .= "Content-Type: multipart/alternative; boundary=\"" . $alt_boundary . "\"\r\n\r\n";

        // Plain text part
        $body .= "--" . $alt_boundary . "\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= $plain_message . "\r\n\r\n";

        // HTML part
        $body .= "--" . $alt_boundary . "\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= $html_message . "\r\n\r\n";

        $body .= "--" . $alt_boundary . "--\r\n\r\n";

        // Attachments
        foreach ($attachments as $att) {
            if (isset($att['path'], $att['name']) && file_exists($att['path'])) {
                $file_content = chunk_split(base64_encode(file_get_contents($att['path'])));
                $body .= "--" . $boundary . "\r\n";
                $body .= "Content-Type: application/octet-stream; name=\"" . $att['name'] . "\"\r\n";
                $body .= "Content-Transfer-Encoding: base64\r\n";
                $body .= "Content-Disposition: attachment; filename=\"" . $att['name'] . "\"\r\n\r\n";
                $body .= $file_content . "\r\n";
            } else {
                error_log('Attachment not found: ' . ($att['path'] ?? 'unknown'));
            }
        }

        $body .= "--" . $boundary . "--\r\n";

        if (mail($to, $subject, $body, $headers)) {
            return true;
        } else {
            error_log('PHP mail() failed to send email to ' . $to . '. Check server configuration.');
            return false;
        }
    } else {
        // SMTP with PHPMailer
        if (!isset($settings['smtp'])) {
            error_log('SMTP settings not found');
            return false;
        }
        
        $phpmailer_path = __DIR__ . '/PHPMailer/src/';
        
        if (!file_exists($phpmailer_path . 'PHPMailer.php') ||
            !file_exists($phpmailer_path . 'SMTP.php') ||
            !file_exists($phpmailer_path . 'Exception.php')) {
            error_log('PHPMailer files not found in ' . $phpmailer_path);
            return false;
        }

        require_once $phpmailer_path . 'PHPMailer.php';
        require_once $phpmailer_path . 'SMTP.php';
        require_once $phpmailer_path . 'Exception.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $settings['smtp']['host'] ?? 'smtp.example.com';
            $mail->SMTPAuth = true;
            $mail->Username = $settings['smtp']['username'] ?? 'user@example.com';
            $mail->Password = $settings['smtp']['password'] ?? 'password';
            $mail->SMTPSecure = $settings['smtp']['secure'] ?? 'tls';
            $mail->Port = $settings['smtp']['port'] ?? 587;

            $from_email = $settings['smtp']['from_email'] ?? 'no-reply@example.com';
            $from_name = $settings['smtp']['from_name'] ?? 'Admin';
            $mail->setFrom($from_email, $from_name);
            $mail->addReplyTo($from_email, $from_name);
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html_message;
            $mail->AltBody = $plain_message;

            foreach ($attachments as $att) {
                if (isset($att['path'], $att['name']) && file_exists($att['path'])) {
                    $mail->addAttachment($att['path'], $att['name']);
                } else {
                    error_log('Attachment not found: ' . ($att['path'] ?? 'unknown'));
                }
            }

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
?>
