<?php

namespace App\Mail;

use App\Config\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Eine E-Mail-Service-Klasse, die PHPMailer verwendet und Konfigurationen aus .env nutzt
 */
class MailService
{
    /**
     * Sendet eine E-Mail mit den angegebenen Parametern
     * 
     * @param string $to Empfänger-E-Mail-Adresse
     * @param string $subject Betreff der E-Mail
     * @param string $body Inhalt der E-Mail
     * @param string $fromName Absendername (optional, wird aus .env geladen wenn nicht angegeben)
     * @param string $fromEmail Absender-E-Mail-Adresse (optional, wird aus .env geladen wenn nicht angegeben)
     * @return bool True bei Erfolg, False bei Fehler
     */
    public function sendEmail(string $to, string $subject, string $body, string $fromName = '', string $fromEmail = ''): bool
    {
        try {
            // E-Mail-Konfiguration aus .env laden
            $config = Config::getMailConfig();
            
            // PHPMailer-Instanz erstellen
            $mail = new PHPMailer(true);
            
            // Server-Einstellungen
            $mail->isSMTP();
            $mail->Host       = $config['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $config['username'];
            $mail->Password   = $config['password'];
            $mail->SMTPSecure = $config['encryption'];
            $mail->Port       = $config['port'];
            
            // Absender und Empfänger
            $mail->setFrom(
                $fromEmail ?: $config['from_address'], 
                $fromName ?: $config['from_name']
            );
            $mail->addAddress($to);
            
            // Inhalt
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);
            
            // E-Mail senden
            return $mail->send();
        } catch (Exception $e) {
            // Fehlerbehandlung
            error_log('Fehler beim Senden der E-Mail: ' . $e->getMessage());
            return false;
        }
    }
}