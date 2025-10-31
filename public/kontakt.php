<?php
// Composer Autoloader einbinden
require_once __DIR__ . '/../vendor/autoload.php';

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
    
    // HTML-E-Mail-Inhalt erstellen
    $emailBody = "
        <h2>Neue Kontaktanfrage</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>E-Mail:</strong> {$email}</p>
        <p><strong>Betreff:</strong> {$betreff}</p>
        <p><strong>Nachricht:</strong></p>
        <p>{$nachricht}</p>
    ";
    
    // MailService-Instanz erstellen und E-Mail senden
    $mailService = new MailService();
    
    // In einer echten Anwendung würden wir hier die E-Mail tatsächlich senden
    // $success = $mailService->sendEmail('empfaenger@example.com', 'Kontaktanfrage: ' . $betreff, $emailBody, $name, $email);
    
    // Für dieses Beispiel simulieren wir einen erfolgreichen Versand
    $success = true;
    
    if ($success) {
        $message = "Vielen Dank für deine Nachricht, $name! Deine Anfrage wurde erfolgreich gesendet.";
    } else {
        $message = "Es gab ein Problem beim Versenden deiner Nachricht. Bitte versuche es später erneut.";
    }
}
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
    </div>
</body>
</html>