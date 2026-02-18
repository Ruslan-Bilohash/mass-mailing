<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initial settings if file is new
$default_settings = [
    'smtp' => [
        'host' => 'smtp.example.com',
        'username' => 'user@example.com',
        'password' => 'password',
        'port' => 587,
        'secure' => 'tls', // 'tls' or 'ssl'
        'from_email' => 'rbilohash@gmail.com',
        'from_name' => 'Admin',
    ],
    'mail_method' => 'smtp', // 'smtp' or 'phpmail'
];

// Load existing settings if file exists, otherwise use default
if (file_exists('settings_data.php')) {
    $settings = include 'settings_data.php';
} else {
    $settings = $default_settings;
    file_put_contents('settings_data.php', '<?php return ' . var_export($settings, true) . '; ?>');
}

return $settings;
?>
