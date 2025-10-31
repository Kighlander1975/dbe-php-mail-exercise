<?php

namespace App\Mail;

/**
 * Eine einfache E-Mail-Service-Klasse, die PHPMailer verwendet
 */
class MailService
{
    /**
     * Sendet eine E-Mail mit den angegebenen Parametern
     * 
     * @param string $to Empfänger-E-Mail-Adresse
     * @param string $subject Betreff der E-Mail
     * @param string $body Inhalt der E-Mail
     * @param string $fromName Absendername (optional)
     * @param string $fromEmail Absender-E-Mail-Adresse (optional)
     * @return bool True bei Erfolg, False bei Fehler
     */
    public function sendEmail(string $to, string $subject, string $body, string $fromName = '', string $fromEmail = ''): bool
    {
        try {
            // PHPMailer-Instanz erstellen
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            
            // Server-Einstellungen
            // $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER; // Debug-Ausgabe aktivieren
            $mail->isSMTP();                                           // SMTP verwenden
            $mail->Host       = 'smtp.example.com';                    // SMTP-Server
            $mail->SMTPAuth   = true;                                  // SMTP-Authentifizierung aktivieren
            $mail->Username   = 'user@example.com';                    // SMTP-Benutzername
            $mail->Password   = 'password';                            // SMTP-Passwort
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS; // TLS aktivieren
            $mail->Port       = 587;                                   // TCP-Port
            
            // Absender und Empfänger
            $mail->setFrom($fromEmail ?: 'from@example.com', $fromName ?: 'Mail Service');
            $mail->addAddress($to);
            
            // Inhalt
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);
            
            // E-Mail senden
            return $mail->send();
        } catch (\Exception $e) {
            // Fehlerbehandlung
            error_log('Fehler beim Senden der E-Mail: ' . $e->getMessage());
            return false;
        }
    }
}