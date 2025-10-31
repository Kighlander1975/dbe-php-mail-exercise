<?php
// Composer Autoloader einbinden
require_once __DIR__ . '/../vendor/autoload.php';

// Konfiguration laden
use App\Config\Config;
Config::load();

// Beispiel für die Verwendung von PHPMailer (wird nur importiert, nicht ausgeführt)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Umgebungsvariablen für die Anzeige
$appEnv = Config::get('APP_ENV', 'development');
$appUrl = Config::get('APP_URL', 'http://localhost');
$debug = Config::get('APP_DEBUG', false);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Mail Übungsprojekt</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>PHP Mail Übungsprojekt</h1>
        <p>Dieses Projekt demonstriert die Verwendung von:</p>
        <ul>
            <li>Composer für Paketmanagement</li>
            <li>PHPMailer für E-Mail-Funktionalität</li>
            <li>.htaccess für URL-Routing</li>
            <li>Umgebungsvariablen mit phpdotenv</li>
        </ul>
        
        <h2>Verfügbare Seiten:</h2>
        <ul>
            <li><a href="kontakt.php" class="btn">Kontaktformular</a></li>
        </ul>
        
        <?php if ($debug): ?>
        <div style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 5px;">
            <h3>Debug-Informationen:</h3>
            <p><strong>Umgebung:</strong> <?php echo htmlspecialchars($appEnv); ?></p>
            <p><strong>App-URL:</strong> <?php echo htmlspecialchars($appUrl); ?></p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>