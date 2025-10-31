<?php
// Composer Autoloader einbinden
require_once __DIR__ . '/../vendor/autoload.php';

// Konfiguration laden
use App\Config\Config;
Config::load();

// Eigene Klassen importieren
use App\Mail\MailService;

$message = '';
$success = false;

// Wenn das Formular abgesendet wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $betreff = $_POST['betreff'] ?? '';
    $nachricht = $_POST['nachricht'] ?? '';
    
    // MailService-Instanz erstellen
    $mailService = new MailService();
    
    // E-Mail-Konfiguration aus der .env-Datei verwenden
    $recipient = Config::get('TEST_MAIL_RECIPIENT', '');
    
    // 1. E-Mail an den Administrator (dich) senden
    $adminEmailBody = "
        <h2>Neue Kontaktanfrage</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>E-Mail:</strong> {$email}</p>
        <p><strong>Betreff:</strong> {$betreff}</p>
        <p><strong>Nachricht:</strong></p>
        <p>{$nachricht}</p>
    ";
    
    $adminEmailSuccess = $mailService->sendEmail($recipient, 'Kontaktanfrage: ' . $betreff, $adminEmailBody, $name, $email);
    
    // 2. Bestätigungs-E-Mail an den Absender senden
    if ($adminEmailSuccess) {
        $confirmationEmailBody = "
            <h2>Vielen Dank für deine Nachricht!</h2>
            <p>Hallo {$name},</p>
            <p>wir haben deine Kontaktanfrage mit dem Betreff \"{$betreff}\" erhalten und werden uns so schnell wie möglich bei dir melden.</p>
            <p>Hier ist eine Kopie deiner Nachricht:</p>
            <p><em>{$nachricht}</em></p>
            <p>Mit freundlichen Grüßen,<br>Das Team vom PHP Mail Übungsprojekt</p>
        ";
        
        $userEmailSuccess = $mailService->sendEmail(
            $email, 
            'Bestätigung deiner Kontaktanfrage: ' . $betreff, 
            $confirmationEmailBody, 
            Config::get('MAIL_FROM_NAME', 'PHP Mail Übungsprojekt'), 
            Config::get('MAIL_FROM_ADDRESS', '')
        );
        
        $success = $adminEmailSuccess && $userEmailSuccess;
        
        if ($success) {
            $message = "Vielen Dank für deine Nachricht, $name! Deine Anfrage wurde erfolgreich gesendet. Eine Bestätigungs-E-Mail wurde an deine E-Mail-Adresse geschickt.";
        } else if ($adminEmailSuccess) {
            $message = "Deine Nachricht wurde gesendet, aber die Bestätigungs-E-Mail konnte nicht zugestellt werden. Bitte überprüfe deine E-Mail-Adresse.";
            $success = true; // Die Hauptfunktion (Kontaktanfrage) war erfolgreich
        } else {
            $message = "Es gab ein Problem beim Versenden deiner Nachricht. Bitte versuche es später erneut.";
        }
    } else {
        $message = "Es gab ein Problem beim Versenden deiner Nachricht. Bitte versuche es später erneut.";
    }
}

// Debug-Modus aus der Konfiguration
$debug = Config::get('APP_DEBUG', false);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontaktformular - PHP Mail Übungsprojekt</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        form {
            margin-top: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        textarea {
            height: 150px;
        }
        
        .message {
            padding: 10px;
            margin: 20px 0;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            color: #155724;
        }
        
        .message.error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .debug-info {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            font-family: monospace;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kontaktformular</h1>
        
        <a href="index.php" class="btn" style="background-color: #6c757d;">Zurück zur Startseite</a>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $success ? '' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="kontakt.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">E-Mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="betreff">Betreff:</label>
                <input type="text" id="betreff" name="betreff" required>
            </div>
            
            <div class="form-group">
                <label for="nachricht">Nachricht:</label>
                <textarea id="nachricht" name="nachricht" required></textarea>
            </div>
            
            <button type="submit" class="btn">Nachricht senden</button>
        </form>
        
        <?php if ($debug): ?>
        <div class="debug-info">
            <h3>Debug-Informationen:</h3>
            <p><strong>Mail-Host:</strong> <?php echo htmlspecialchars(Config::get('MAIL_HOST')); ?></p>
            <p><strong>Mail-Port:</strong> <?php echo htmlspecialchars(Config::get('MAIL_PORT')); ?></p>
            <p><strong>Mail-Absender:</strong> <?php echo htmlspecialchars(Config::get('MAIL_FROM_NAME')); ?> &lt;<?php echo htmlspecialchars(Config::get('MAIL_FROM_ADDRESS')); ?>&gt;</p>
            <p><strong>Umgebung:</strong> <?php echo htmlspecialchars(Config::get('APP_ENV')); ?></p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>