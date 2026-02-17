<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'config.php';
$settings = require 'settings.php';
$languages = require 'lang.php';
$lang_code = isset($_GET['lang']) && isset($languages[$_GET['lang']]) ? $_GET['lang'] : 'ua';
$l = $languages[$lang_code];
require 'header.php';
?>
<h2 class="mb-4 text-center"><i class="bi bi-info-circle me-2"></i>About <?php echo APP_NAME; ?></h2>
<div class="card shadow-sm">
    <div class="card-body">
        <p><?php echo $l['description']; ?></p>
        <p>This is a modern, efficient mass email sending application built with PHP and PHPMailer. It emphasizes user consent and prohibits spam. The app is designed for sending emails to recipients who have explicitly agreed to receive them, ensuring compliance with anti-spam laws and ethical standards. It supports various input methods for recipients, attachments, and multilingual interfaces to make it accessible worldwide.</p>
        <p><i class="bi bi-list-check me-2"></i>Key Features:</p>
        <ul>
            <li><i class="bi bi-upload me-2"></i>Manual entry or file upload (TXT, JSON, PHP) for recipients – easily import lists from different formats.</li>
            <li><i class="bi bi-paperclip me-2"></i>Support for attachments – add files to your emails for richer content.</li>
            <li><i class="bi bi-translate me-2"></i>Multilingual interface with 8 languages – English, Russian, Ukrainian, Lithuanian, Polish, Georgian, Norwegian, German.</li>
            <li><i class="bi bi-phone me-2"></i>Responsive design for all devices – works seamlessly on desktops, tablets, and mobiles using Bootstrap.</li>
            <li><i class="bi bi-envelope me-2"></i>Beautifully formatted emails – uses a professional HTML template for sent messages.</li>
            <li><i class="bi bi-check-circle me-2"></i>Consent requirement for no spam and age 18+ – mandatory checkbox to confirm ethical use.</li>
            <li><i class="bi bi-gear me-2"></i>Configurable SMTP settings – edit via settings.php or the dedicated settings page.</li>
            <li><i class="bi bi-bug me-2"></i>Error handling and logging – displays errors and logs issues for debugging.</li>
            <li><i class="bi bi-pages me-2"></i>Additional pages: Feedback form, Terms of Use, Donate options with multiple payment methods.</li>
        </ul>
        <p><i class="bi bi-tag me-2"></i>Version: <?php echo APP_VERSION; ?></p>
        <p>For settings, edit settings.php or use the settings page. Download PHPMailer from <a href="https://github.com/PHPMailer/PHPMailer" target="_blank">GitHub</a> and place in the PHPMailer folder. This app is open-source and can be customized further.</p>
        <p>Developed for educational and legitimate purposes only. Always ensure you have permission from recipients before sending emails.</p>
    </div>
</div>
<?php require 'footer.php'; ?>