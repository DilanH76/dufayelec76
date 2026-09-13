<?php
// =========================================
// CONFIGURATION GÉNÉRALE DU SITE DufayElec76
// =========================================

/* =========================================
   CHARGEMENT DES VARIABLES D'ENVIRONNEMENT
   ========================================= */
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

/* ==================== INFORMATIONS ENTREPRISE ==================== */
define('SITE_NAME', 'DufayElec76');
define('SITE_URL', $_ENV['SITE_URL'] ?? 'https://www.dufayelec76.fr');

define('ENTREPRISE_NOM', 'Aurélien Dufay');
define('ENTREPRISE_EMAIL', $_ENV['ENTREPRISE_EMAIL'] ?? 'contact@dufayelec76.fr');
define('ENTREPRISE_TELEPHONE', $_ENV['ENTREPRISE_TELEPHONE'] ?? '06 75 33 60 90');
define('ENTREPRISE_ADRESSE', $_ENV['ENTREPRISE_ADRESSE'] ?? '23 RUE DE LA FORGE 76290 SAINT-MARTIN-DU-MANOIR');
define('ENTREPRISE_SIRET', $_ENV['ENTREPRISE_SIRET'] ?? '103 839 122 00019');

/* ==================== CONFIGURATION EMAIL ==================== */
define('MAIL_DESTINATAIRE', ENTREPRISE_EMAIL);
define('MAIL_FROM', 'no-reply@dufayelec76.fr');
define('MAIL_SUBJECT_PREFIX', '[Site Web] Nouvelle demande de contact');

/* ==================== SMTP OVH ==================== */
define('SMTP_HOST', $_ENV['SMTP_HOST'] ?? 'ssl0.ovh.net');
define('SMTP_PORT', $_ENV['SMTP_PORT'] ?? 587);
define('SMTP_USERNAME', $_ENV['SMTP_USERNAME'] ?? ENTREPRISE_EMAIL);
define('SMTP_PASSWORD', $_ENV['SMTP_PASSWORD'] ?? '');   // Important : ne jamais mettre en dur

/* ==================== SÉCURITÉ ==================== */
define('TOKEN_EXPIRATION', 3600); // 1 heure
?>