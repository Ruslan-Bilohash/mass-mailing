<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';  // Added to define constants like DEVELOPER_NAME

$settings = require 'settings.php';
$languages = require 'lang.php';
$lang_code = isset($_GET['lang']) && isset($languages[$_GET['lang']]) ? $_GET['lang'] : 'ua';
$l = $languages[$lang_code];

require 'header.php';
?>

<h2 class="mb-4 text-center"><?php echo $l['terms_heading']; ?></h2>

<div class="alert alert-warning text-center mb-4">
    <strong>IMPORTANT:</strong> This application is STRICTLY for informational purposes and sending emails ONLY to users who have explicitly consented. SPAM IS PROHIBITED UNDER ANY CIRCUMSTANCES.
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-danger text-white">
        <h4><?php echo $l['terms_intro']; ?></h4>
    </div>
    <div class="card-body">
        <p><?php echo $l['terms_intro_text']; ?></p>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h4><?php echo $l['terms_usage']; ?></h4>
    </div>
    <div class="card-body">
        <p><?php echo $l['terms_usage_text']; ?></p>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-info text-white">
        <h4><?php echo $l['terms_consent']; ?></h4>
    </div>
    <div class="card-body">
        <p><?php echo $l['terms_consent_text']; ?></p>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4><?php echo $l['terms_privacy']; ?></h4>
    </div>
    <div class="card-body">
        <p><?php echo $l['terms_privacy_text']; ?></p>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-secondary text-white">
        <h4><?php echo $l['terms_changes']; ?></h4>
    </div>
    <div class="card-body">
        <p><?php echo $l['terms_changes_text']; ?></p>
    </div>
</div>

<?php require 'footer.php'; ?>