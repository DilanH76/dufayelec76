<?php
require_once __DIR__ . '/config.php';
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* =========================================
   1. LE SAS DE SÉCURITÉ
   ========================================= */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../index.php');
  exit;
}

if (!empty($_POST['website'])) {
  header('Location: ../index.php?status=success#contact');
  exit;
}

if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
  $_SESSION['flash_error'] = "Erreur de sécurité : Jeton expiré, veuillez réessayer.";
  header('Location: ../index.php?status=error#contact');
  exit;
}

/* =========================================
   ANTI FLOOD
   ========================================= */

if (
  isset($_SESSION['last_submit'])
  && (time() - $_SESSION['last_submit']) < 30
) {
  $_SESSION['flash_error'] = "Veuillez patienter quelques secondes avant un nouvel envoi.";
  header('Location: ../index.php?status=error#contact');
  exit;
}

/* =========================================
   2. NETTOYAGE DES DONNÉES
   ========================================= */
$nom       = htmlspecialchars(trim($_POST['nom'] ?? ''), ENT_QUOTES, 'UTF-8');
$telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''), ENT_QUOTES, 'UTF-8');
$message   = htmlspecialchars(trim($_POST['message'] ?? ''), ENT_QUOTES, 'UTF-8');
$email     = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

// Sauvegarde pour réafficher en cas d'erreur
$_SESSION['old_inputs'] = [
  'nom'       => $nom,
  'telephone' => $telephone,
  'email'     => $email,
  'message'   => $message
];

/* =========================================
   3. VALIDATION
   ========================================= */

if (empty($nom) || empty($telephone) || empty($email)) {
  $_SESSION['flash_error'] = "Veuillez remplir tous les champs obligatoires (*).";
  header('Location: ../index.php?status=error#contact');
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['flash_error'] = "Le format de l'adresse e-mail n'est pas valide.";
  $_SESSION['error_field'] = 'email';
  header('Location: ../index.php?status=error#contact');
  exit;
}

$regex_telephone = '/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/';
if (!preg_match($regex_telephone, $telephone)) {
  $_SESSION['flash_error'] = "Le numéro de téléphone semble invalide.";
  $_SESSION['error_field'] = 'telephone';
  header('Location: ../index.php?status=error#contact');
  exit;
}

/* =========================================
   4. ASSEMBLAGE DE L'E-MAIL (HTML + texte brut)
   ========================================= */

$sujet = MAIL_SUBJECT_PREFIX . " de " . $nom;
$date  = date('d/m/Y à H:i');


$messageAffiche = !empty($message)
  ? nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'))
  : '<em style="color:#aaa;">Aucun message spécifique laissé.</em>';

$messageTexte = !empty($message) ? $message : "Aucun message spécifique laissé.";

/* --- Version HTML --- */
$corpsHTML = '<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nouvelle demande de contact</title>
</head>
<body style="margin:0;padding:0;background:#f0f2f5;font-family:Arial,Helvetica,sans-serif;">
 
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f2f5;padding:32px 16px;">
  <tr>
    <td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e0e0e0;">
 
        <!-- EN-TÊTE -->
        <tr>
          <td style="background:#0c303e;padding:28px 32px;text-align:center;">
            <p style="margin:0;font-size:22px;font-weight:700;color:#ffffff;letter-spacing:1px;">
              Dufay<span style="color:#8bc939;">Elec76</span>
            </p>
            <p style="margin:6px 0 0;font-size:11px;color:#8bc939;letter-spacing:2px;text-transform:uppercase;">
              Électricien au Havre
            </p>
          </td>
        </tr>
 
        <!-- BANDEAU VERT -->
        <tr>
          <td style="background:#8bc939;padding:14px 32px;">
            <p style="margin:0;color:#0c303e;font-size:14px;font-weight:700;">
              &nbsp; Nouvelle demande de contact reçue
            </p>
          </td>
        </tr>
 
        <!-- CORPS -->
        <tr>
          <td style="padding:28px 32px;">
 
            <p style="margin:0 0 8px;font-size:15px;color:#2c3e50;">
              Bonjour <strong>Aurélien</strong>,
            </p>
            <p style="margin:0 0 24px;font-size:14px;color:#555555;line-height:1.6;">
              Un client vient de soumettre une demande via le formulaire de contact de ton site. Voici les informations :
            </p>
 
            <!-- Titre section coordonnées -->
            <p style="margin:0 0 10px;font-size:11px;font-weight:700;color:#8bc939;text-transform:uppercase;letter-spacing:2px;">
              Coordonnées
            </p>
 
            <!-- Bloc coordonnées -->
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8f9fa;border-left:3px solid #0c303e;border-radius:0 6px 6px 0;margin-bottom:24px;">
              <tr>
                <td style="padding:16px 20px;">
                  <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td style="font-size:12px;color:#888888;padding-bottom:10px;width:120px;">Nom / Société</td>
                      <td style="font-size:14px;color:#2c3e50;font-weight:600;padding-bottom:10px;">' . $nom . '</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px;color:#888888;padding-bottom:10px;width:120px;">Téléphone</td>
                      <td style="font-size:14px;padding-bottom:10px;">
                        <a href="tel:' . preg_replace('/\s/', '', $telephone) . '" style="color:#0c303e;text-decoration:none;font-weight:600;">' . $telephone . '</a>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-size:12px;color:#888888;width:120px;">E-mail</td>
                      <td style="font-size:14px;">
                        <a href="mailto:' . $email . '" style="color:#0c303e;text-decoration:none;font-weight:600;">' . $email . '</a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
 
            <!-- Titre section message -->
            <p style="margin:0 0 10px;font-size:11px;font-weight:700;color:#8bc939;text-transform:uppercase;letter-spacing:2px;">
              Message
            </p>
 
            <!-- Bloc message -->
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8f9fa;border-left:3px solid #8bc939;border-radius:0 6px 6px 0;margin-bottom:28px;">
              <tr>
                <td style="padding:16px 20px;font-size:14px;color:#444444;line-height:1.6;font-style:italic;">
                  &laquo;&nbsp;' . $messageAffiche . '&nbsp;&raquo;
                </td>
              </tr>
            </table>
 
            <!-- Bouton répondre -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
              <tr>
                <td align="center">
                  <a href="mailto:' . $email . '?subject=Re: Votre demande sur DufayElec76"
                     style="display:inline-block;background:#0c303e;color:#ffffff;padding:13px 30px;border-radius:6px;font-size:14px;font-weight:700;text-decoration:none;">
                    Répondre à ' . $nom . ' <span style="color:#8bc939;">→</span>
                  </a>
                </td>
              </tr>
            </table>
 
            <!-- Séparateur -->
            <hr style="border:none;border-top:1px solid #e8e8e8;margin:0 0 16px;">
 
            <p style="margin:0;font-size:12px;color:#aaaaaa;text-align:center;">
              Envoyé le ' . $date . ' &middot; Via dufayelec76.fr
            </p>
 
          </td>
        </tr>
 
        <!-- PIED DE PAGE -->
        <tr>
          <td style="background:#0c303e;padding:18px 32px;text-align:center;">
            <p style="margin:0;color:#8bc939;font-size:12px;">DufayElec76 — Électricien au Havre</p>
            <p style="margin:6px 0 0;color:rgba(255,255,255,0.35);font-size:11px;">
              Cet email est généré automatiquement depuis le formulaire de contact.
            </p>
          </td>
        </tr>
 
      </table>
    </td>
  </tr>
</table>
 
</body>
</html>';

/* --- Version texte brut (fallback) --- */
$corpsTexte  = "Bonjour Aurélien,\n\n";
$corpsTexte .= "Nouvelle demande de contact depuis DufayElec76.\n\n";
$corpsTexte .= "--- COORDONNÉES ---\n";
$corpsTexte .= "Nom / Entreprise : " . $nom . "\n";
$corpsTexte .= "Téléphone        : " . $telephone . "\n";
$corpsTexte .= "E-mail           : " . $email . "\n\n";
$corpsTexte .= "--- MESSAGE ---\n";
$corpsTexte .= $messageTexte . "\n\n";
$corpsTexte .= "Envoyé le : " . $date . "\n";


/* =========================================
   5. EXPÉDITION PHPMailer
   ========================================= */

try {
  $mail = new PHPMailer(true);

  $mail->isSMTP();
  $mail->Host       = SMTP_HOST;
  $mail->SMTPAuth   = true;
  $mail->Username   = SMTP_USERNAME;
  $mail->Password   = SMTP_PASSWORD;

  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port       = SMTP_PORT;

  $mail->CharSet    = 'UTF-8';
  $mail->Timeout    = 20;

  // Expéditeur
  $mail->setFrom(ENTREPRISE_EMAIL, SITE_NAME);

  // Destinataire + Reply-To
  $mail->addAddress(MAIL_DESTINATAIRE);
  $mail->addReplyTo($email, $nom);

  // HTML activé + fallback texte brut
  $mail->isHTML(true);
  $mail->Subject = $sujet;
  $mail->Body    = $corpsHTML;
  $mail->AltBody = $corpsTexte;

  // =========================================
  // GESTION DES PHOTOS JOINTES (SÉCURISÉE)
  // =========================================
  if (!empty($_FILES['photos']['name'][0])) {
    $typesAutorises = ['image/jpeg', 'image/png', 'image/webp'];
    $maxTaille      = 5 * 1024 * 1024; // 5Mo
    $maxFichiers    = 3;
    $compteur       = 0;

    foreach ($_FILES['photos']['tmp_name'] as $key => $tmp) {
      if ($compteur >= $maxFichiers) break;

      
      if ($_FILES['photos']['error'][$key] !== UPLOAD_ERR_OK) continue;

      $taille = $_FILES['photos']['size'][$key];

      
      if ($taille > $maxTaille) continue;

      
      if (!is_uploaded_file($tmp)) continue;

      
      $type = mime_content_type($tmp);
      if (!in_array($type, $typesAutorises)) continue;

      
      if (@getimagesize($tmp) === false) continue;

      
      $imageInfo = getimagesize($tmp);
      if ($imageInfo[0] > 6000 || $imageInfo[1] > 6000) continue;

    
      $nomFichier = basename($_FILES['photos']['name'][$key]);
      $nomFichier = preg_replace('/[^a-zA-Z0-9._-]/', '_', $nomFichier);

      $mail->addAttachment($tmp, $nomFichier);
      $compteur++;
    }
  }

  $mail->send();

  // Anti-flood + reset token
  $_SESSION['last_submit'] = time();
  $_SESSION['csrf_token']  = bin2hex(random_bytes(32));

  unset($_SESSION['old_inputs']);

  header('Location: ../index.php?status=success#contact');
  exit;

} catch (Exception $e) {
  error_log("PHPMailer Error: " . $e->getMessage());

  $_SESSION['flash_error'] = "Désolé, une erreur technique est survenue. Veuillez réessayer ou me contacter directement.";
  header('Location: ../index.php?status=error#contact');
  exit;
}