<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set CSP header to allow inline styles and scripts, and eval
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self' data:; connect-src 'self';");
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $l['description']; ?>">
    <meta name="keywords" content="mass mailing, email sender, PHP mailer, bulk email, consented emails, no spam, multilingual email tool">
    <meta name="author" content="<?php echo DEVELOPER_NAME; ?>">
    <title><?php echo $l['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .email-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .nav-links {
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .email-container {
                padding: 10px;
                margin: 10px;
            }
        }
        @media (max-width: 576px) {
            .btn {
                width: 100%;
            }
        }
        .language-section select {
            width: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?lang=<?php echo $lang_code; ?>"><i class="bi bi-envelope-fill me-2"></i><?php echo APP_NAME; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?lang=<?php echo $lang_code; ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php?lang=<?php echo $lang_code; ?>">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php?lang=<?php echo $lang_code; ?>">Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="terms.php?lang=<?php echo $lang_code; ?>">Terms</a></li>
                    <li class="nav-item"><a class="nav-link" href="donate.php?lang=<?php echo $lang_code; ?>">Donate</a></li>
                    <li class="nav-item"><a class="nav-link" href="settings_page.php?lang=<?php echo $lang_code; ?>">Settings</a></li>
                </ul>
                <div class="language-section">
                    <label><?php echo $l['language']; ?></label>
                    <select onchange="window.location.href = this.value ? window.location.pathname + '?lang=' + this.value : window.location.pathname">
                        <option value="ru" <?php echo $lang_code=='ru'?'selected':''; ?>>🇷🇺 Русский</option>
                        <option value="en" <?php echo $lang_code=='en'?'selected':''; ?>>🇬🇧 English</option>
                        <option value="ua" <?php echo $lang_code=='ua'?'selected':''; ?>>🇺🇦 Українська</option>
                        <option value="lt" <?php echo $lang_code=='lt'?'selected':''; ?>>🇱🇹 Lietuvių</option>
                        <option value="pl" <?php echo $lang_code=='pl'?'selected':''; ?>>🇵🇱 Polski</option>
                        <option value="ka" <?php echo $lang_code=='ka'?'selected':''; ?>>🇬🇪 ქართული</option>
                        <option value="no" <?php echo $lang_code=='no'?'selected':''; ?>>🇳🇴 Norsk</option>
                        <option value="de" <?php echo $lang_code=='de'?'selected':''; ?>>🇩🇪 Deutsch</option>
                    </select>
                </div>
            </div>
        </div>
    </nav>
    <div class="email-container">