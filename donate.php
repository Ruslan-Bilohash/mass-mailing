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

<div class="donate-page text-center">
    <div class="card mx-auto shadow-lg" style="max-width: 600px;">
        <div class="card-body">
            <h1 class="mb-4"><i class="bi bi-heart-fill text-danger me-2"></i> <?php echo $l['donate_title']; ?></h1>
            <p class="donate-text mb-4"><?php echo $l['donate_text']; ?></p>
            <h3 class="mb-3"><i class="bi bi-credit-card me-2"></i>Choose Payment Method</h3>
            <div class="d-grid gap-2">
                <a href="https://buymeacoffee.com/bilohash" target="_blank" class="btn btn-outline-primary">
                    <i class="bi bi-cup-hot me-2"></i> BuyMeACoffee
                </a>
                <a href="https://wise.com/pay/me/ruslanb933" target="_blank" class="btn btn-outline-success">
                    <i class="bi bi-globe me-2"></i> Wise
                </a>
                <a href="https://www.paypal.com/donate/?hosted_button_id=GSS6YYMXZ3J4N" target="_blank" class="btn btn-outline-info">
                    <i class="bi bi-paypal me-2"></i> PayPal
                </a>
                <button id="vipps-btn" class="btn btn-outline-warning">
                    <i class="bi bi-phone me-2"></i> Vipps <small>+47 462 55 885</small>
                </button>
                <div class="btn btn-outline-secondary">
                    <img src="https://edukvam.com/seo/QR-kode-paypal.png" alt="PayPal QR" class="img-thumbnail" style="max-width: 100px;">
                    <span> PayPal QR</span>
                </div>
            </div>
            <div class="other-ways mt-4">
                <p>Or contact me:</p>
                <a href="https://t.me/meistru_lt" target="_blank" class="btn btn-outline-dark">
                    <i class="bi bi-telegram me-2"></i> Telegram @meistru_lt
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('vipps-btn').addEventListener('click', function() {
    navigator.clipboard.writeText('+4746255885');
    alert('Vipps number copied: +47 462 55 885');
});
</script>

<?php require 'footer.php'; ?>