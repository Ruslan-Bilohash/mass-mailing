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
$success_count = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['consent']) || $_POST['consent'] !== 'on') {
        $status = $l['consent_required'];
    } else {
        $subject = htmlspecialchars($_POST['subject'] ?? '');
        $message = $_POST['message'] ?? '';
        $from = $settings['smtp']['from_email'];

        $attachments = [];
        if (!empty($_FILES['attachments']['name'][0])) {
            foreach ($_FILES['attachments']['name'] as $key => $name) {
                if ($_FILES['attachments']['error'][$key] == 0) {
                    $tmp_name = $_FILES['attachments']['tmp_name'][$key];
                    $attachments[] = [
                        'name' => $name,
                        'path' => $tmp_name
                    ];
                }
            }
        }

        $recipients = [];
        if (!empty($_POST['recipients'])) {
            $recipients = array_filter(array_map('trim', preg_split('/[,\n]+/', $_POST['recipients'])));
        }

        if (!empty($_FILES['user_file']['name'])) {
            $file_tmp = $_FILES['user_file']['tmp_name'];
            $file_name = $_FILES['user_file']['name'];
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $file_content = file_get_contents($file_tmp);

            if ($ext === 'txt') {
                $file_emails = array_filter(array_map('trim', explode("\n", $file_content)));
            } elseif ($ext === 'json') {
                $data = json_decode($file_content, true);
                $file_emails = [];
                if (is_array($data)) {
                    foreach ($data as $item) {
                        if (isset($item['email']) && filter_var($item['email'], FILTER_VALIDATE_EMAIL)) {
                            $file_emails[] = $item['email'];
                        }
                    }
                }
            } elseif ($ext === 'php') {
                $data = include $file_tmp;
                $file_emails = is_array($data) ? array_filter(array_map('trim', $data)) : [];
            } else {
                $file_emails = [];
            }

            $recipients = array_merge($recipients, $file_emails);
        }

        $recipients = array_unique(array_filter($recipients, function($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }));

        foreach ($recipients as $to) {
            if (sendEmail($to, $subject, $message, $attachments, $settings)) {
                $success_count++;
            }
        }

        $status = sprintf($l['sent'], $success_count);
    }
}

require 'header.php';
?>

<h2 class="mb-4 text-center">
    <i class="bi bi-envelope-fill me-2"></i><?php echo $l['heading']; ?>
</h2>

<?php if ($status): ?>
    <div class="alert <?php echo $success_count > 0 ? 'alert-success' : 'alert-danger'; ?> text-center">
        <?php echo $status; ?>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-gear me-2"></i><?php echo $l['settings_header']; ?>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-envelope me-2"></i><?php echo $l['sender_email']; ?></label>
                <input type="email" name="from_email" class="form-control"
                       value="<?php echo htmlspecialchars($settings['smtp']['from_email']); ?>" readonly>
                <small class="form-text"><?php echo $l['change_settings']; ?> <a href="settings_page.php?lang=<?php echo $lang_code; ?>"><?php echo $l['settings_link']; ?></a></small>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-people me-2"></i><?php echo $l['recipients_header']; ?>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <textarea name="recipients" class="form-control" rows="5" placeholder="<?php echo $l['recipients_placeholder']; ?>"></textarea>
            </div>
            <div class="mt-2">
                <input type="file" name="user_file" class="form-control" accept=".txt,.json,.php">
                <small class="form-text"><?php echo $l['upload_file']; ?></small>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-chat-text me-2"></i><?php echo $l['message_header']; ?>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-type me-2"></i><?php echo $l['subject']; ?></label>
                <input type="text" name="subject" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-text-paragraph me-2"></i><?php echo $l['message_text']; ?></label>
                <textarea name="message" class="form-control" rows="10"></textarea>
                <small class="form-text"><?php echo $l['message_note']; ?></small>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-paperclip me-2"></i><?php echo $l['attachments']; ?></label>
                <input type="file" name="attachments[]" class="form-control" multiple>
            </div>
        </div>
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" name="consent" class="form-check-input" id="consent" required>
        <label class="form-check-label" for="consent">
            <?php echo $l['consent_label']; ?> <a href="terms.php?lang=<?php echo $lang_code; ?>"><?php echo $l['terms_heading']; ?></a>
        </label>
    </div>
    <button type="submit" class="btn btn-primary btn-lg w-100">
        <i class="bi bi-send me-2"></i><?php echo $l['send']; ?>
    </button>
</form>

<?php require 'footer.php'; ?>