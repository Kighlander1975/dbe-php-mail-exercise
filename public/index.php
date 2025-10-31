<?php
// Composer Autoloader einbinden
require_once __DIR__ . '/../vendor/autoload.php';

// Beispiel für die Verwendung von PHPMailer (wird nur importiert, nicht ausgeführt)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
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
        </ul>
        
        <h2>Verfügbare Seiten:</h2>
        <ul>
            <li><a href="kontakt.php" class="btn">Kontaktformular</a></li>
        </ul>
    </div>
</body>
</html>