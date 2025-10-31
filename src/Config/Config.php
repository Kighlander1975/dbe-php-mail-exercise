<?php

namespace App\Config;

use Dotenv\Dotenv;

/**
 * Klasse zum Laden und Verwalten von Konfigurationseinstellungen
 */
class Config
{
    /**
     * Lädt die Umgebungsvariablen aus der .env-Datei
     * 
     * @param string $envFile Name der .env-Datei (ohne Pfad)
     */
    public static function load(string $envFile = '.env'): void
    {
        // Pfad zum Hauptverzeichnis des Projekts
        $basePath = dirname(__DIR__, 2); // Zwei Verzeichnisebenen nach oben (von src/Config zu Projektroot)
        
        // Dotenv initialisieren und angegebene .env-Datei laden
        $dotenv = Dotenv::createImmutable($basePath, $envFile);
        $dotenv->load();
        
        // Optional: Überprüfen, ob erforderliche Umgebungsvariablen vorhanden sind
        $dotenv->required(['APP_ENV', 'APP_URL']);
    }
    
    /**
     * Gibt den Wert einer Umgebungsvariablen zurück
     *
     * @param string $key Der Name der Umgebungsvariablen
     * @param mixed $default Standardwert, falls die Variable nicht existiert
     * @return mixed Der Wert der Umgebungsvariablen oder der Standardwert
     */
    public static function get(string $key, $default = null)
    {
        return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
    }
    
    /**
     * Gibt die Konfiguration für den E-Mail-Versand zurück
     *
     * @return array Die E-Mail-Konfiguration
     */
    public static function getMailConfig(): array
    {
        return [
            'host' => self::get('MAIL_HOST', 'smtp.example.com'),
            'port' => self::get('MAIL_PORT', 587),
            'username' => self::get('MAIL_USERNAME', ''),
            'password' => self::get('MAIL_PASSWORD', ''),
            'encryption' => self::get('MAIL_ENCRYPTION', 'tls'),
            'from_address' => self::get('MAIL_FROM_ADDRESS', 'noreply@example.com'),
            'from_name' => self::get('MAIL_FROM_NAME', 'PHP Mail Übungsprojekt')
        ];
    }
}