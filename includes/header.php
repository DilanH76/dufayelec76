<?php
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$anchorPrefix = (basename($_SERVER['SCRIPT_NAME']) === 'index.php') ? '' : '/';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Électricien au Havre | Dépannage, Installation & Mise aux normes - DufayElec76</title>
    <meta name="description" content="Artisan électricien au Havre (76). Dépannage urgent, installation électrique, mise aux normes, bornes de recharge et domotique. Devis gratuit.">

    <!-- SEO Open Graph -->
    <meta property="og:title" content="DufayElec76 - Électricien professionnel au Havre">
    <meta property="og:description" content="Dépannage urgent, installation, rénovation électrique et bornes de recharge. Artisan local sérieux et disponible.">
    <meta property="og:site_name" content="DufayElec76">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL; ?>">
    <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/img/hero-bg-optimized.jpg">
    <meta property="og:locale" content="fr_FR">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="DufayElec76 - Électricien au Havre">
    <meta name="twitter:description" content="Artisan électricien sérieux au Havre et alentours.">


    <!-- Schema.org -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "DufayElec76",
            "description": "Artisan électricien au Havre spécialisé en dépannage urgent, installation électrique, mise aux normes, bornes de recharge et domotique.",
            "url": "<?php echo SITE_URL; ?>",
            "telephone": "<?php echo ENTREPRISE_TELEPHONE; ?>",
            "email": "<?php echo ENTREPRISE_EMAIL; ?>",
            "taxID": "<?php echo ENTREPRISE_SIRET; ?>",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "23 Rue de la Forge",
                "addressLocality": "Saint-Martin-du-Manoir",
                "postalCode": "76290",
                "addressRegion": "Seine-Maritime",
                "addressCountry": "FR"
            },
            "openingHours": "Mo-Fr 08:00-19:00",
            "areaServed": "Le Havre et agglomération",
            "priceRange": "€€",
            "knowsAbout": [
                "Installation électrique",
                "Dépannage électrique",
                "Mise aux normes électrique",
                "Borne de recharge véhicule électrique",
                "Domotique",
                "Éclairage intérieur et extérieur"
            ],
            "sameAs": [
                "https://www.instagram.com/dufayelec76/"
            ]
        }
    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="assets/img/favdufay.svg">
    <link rel="apple-touch-icon" href="assets/img/favdufay.svg">


    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml">
</head>

<body>


    <!-- Bandeau supérieur -->
    <div class="top-bar">
        <div class="container top-bar-container">
            <div class="top-bar-contact">
                <a href="tel:<?php echo ENTREPRISE_TELEPHONE; ?>" class="top-contact-link" aria-label="Appeler <?php echo ENTREPRISE_TELEPHONE; ?>">
                    <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.09 10.09a16 16 0 0 0 6.5 6.5l1.45-1.45a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    <?php echo ENTREPRISE_TELEPHONE; ?>
                </a>
                <a href="mailto:<?php echo ENTREPRISE_EMAIL; ?>" class="top-contact-link" aria-label="Envoyer un email">
                    <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <path d="m22 7-10 6L2 7"/>
                    </svg>
                    <?php echo ENTREPRISE_EMAIL; ?>
                </a>
            </div>
        </div>
    </div>

    <header>
        <nav class="navbar" role="navigation" aria-label="Menu principal">
            <div class="logo">
                <a href="/" aria-label="Retour à l'accueil - DufayElec76">
                    <img src="assets/img/LogoDufay.svg" alt="Logo DufayElec76" width="180" height="auto">
                </a>
            </div>

            <div class="burger-menu" id="burger-menu" aria-label="Ouvrir le menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <ul class="nav-links" id="nav-links">
                <li><a href="<?php echo $anchorPrefix; ?>#accueil">Accueil</a></li>
                <li><a href="<?php echo $anchorPrefix; ?>#services">Services</a></li>
                <li><a href="<?php echo $anchorPrefix; ?>#apropos">À propos</a></li>
                <li><a href="<?php echo $anchorPrefix; ?>#realisations">Réalisations</a></li>
                <li><a href="<?php echo $anchorPrefix; ?>#contact" class="btn-contact">Demander un devis</a></li>
            </ul>

            <a href="tel:<?php echo ENTREPRISE_TELEPHONE; ?>" class="phone-header" aria-label="Appeler maintenant">
                Appeler
            </a>
        </nav>
    </header>