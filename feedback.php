<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

$settings = require 'settings.php';
$languages = require 'lang.php';
$lang_code = isset($_GET['lang']) && isset($languages[$_GET['lang']]) ? $_GET['lang'] : 'ua';
$l = $languages[$lang_code];
require 'functions.php';

$status = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    $from = $_POST['email'] ?? '';
    $to = $settings['smtp']['from_email'];

    if (filter_var($from, FILTER_VALIDATE_EMAIL) && $subject && $message) {
        $full_message = "Feedback from: $from\n\n$message";
        if (sendEmail($to, $subject, $full_message, [], $settings)) {
            $status = $l['feedback_success'];
        } else {
            $status = $l['feedback_error'];
        }
    } else {
        $status = $l['feedback_fill'];
    }
}

require 'header.php';
?>

<h2 class="mb-4 text-center"><i class="bi bi-chat-dots me-2"></i>Feedback</h2>

<?php if ($status): ?>
    <div class="alert <?php echo strpos($status, 'success') !== false ? 'alert-success' : 'alert-danger'; ?> text-center">
        <?php echo $status; ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label"><i class="bi bi-envelope me-2"></i>Your Email:</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label"><i class="bi bi-type me-2"></i>Subject:</label>
        <input type="text" name="subject" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label"><i class="bi bi-text-paragraph me-2"></i>Message:</label>
        <textarea name="message" class="form-control" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-send me-2"></i>Send Feedback</button>
</form>

<?php require 'footer.php'; ?>