<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';
$settings = require 'settings.php';
$languages = require 'lang.php';
$lang_code = isset($_GET['lang']) && isset($languages[$_GET['lang']]) ? $_GET['lang'] : 'ua';
$l = $languages[$lang_code];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_settings = [
        'smtp' => [
            'host' => $_POST['host'] ?? $settings['smtp']['host'],
            'username' => $_POST['username'] ?? $settings['smtp']['username'],
            'password' => $_POST['password'] ?? $settings['smtp']['password'],
            'port' => (int)($_POST['port'] ?? $settings['smtp']['port']),
            'secure' => $_POST['secure'] ?? $settings['smtp']['secure'],
            'from_email' => $_POST['from_email'] ?? $settings['smtp']['from_email'],
            'from_name' => $_POST['from_name'] ?? $settings['smtp']['from_name'],
        ],
    ];

    file_put_contents('settings_data.php', '<?php return ' . var_export($new_settings, true) . '; ?>');

    $status = 'Settings saved successfully!';
}

require 'header.php';
?>

<h2 class="mb-4 text-center">SMTP Settings</h2>

<?php if (isset($status)): ?>
    <div class="alert alert-success text-center">
        <?php echo $status; ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label">SMTP Host:</label>
        <input type="text" name="host" class="form-control" value="<?php echo htmlspecialchars($settings['smtp']['host']); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">SMTP Username:</label>
        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($settings['smtp']['username']); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">SMTP Password:</label>
        <input type="password" name="password" class="form-control" value="<?php echo htmlspecialchars($settings['smtp']['password']); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">SMTP Port:</label>
        <input type="number" name="port" class="form-control" value="<?php echo $settings['smtp']['port']; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">SMTP Secure:</label>
        <select name="secure" class="form-control">
            <option value="tls" <?php if ($settings['smtp']['secure'] === 'tls') echo 'selected'; ?>>TLS</option>
            <option value="ssl" <?php if ($settings['smtp']['secure'] === 'ssl') echo 'selected'; ?>>SSL</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">From Email:</label>
        <input type="email" name="from_email" class="form-control" value="<?php echo htmlspecialchars($settings['smtp']['from_email']); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">From Name:</label>
        <input type="text" name="from_name" class="form-control" value="<?php echo htmlspecialchars($settings['smtp']['from_name']); ?>" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Save Settings</button>
</form>

<?php require 'footer.php'; ?>