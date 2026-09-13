<?php
require_once __DIR__ . '/includes/config.php';
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page introuvable | DufayElec76</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .error-section {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 80px 5%;
            background-color: var(--fond-clair);
        }

        .error-container {
            max-width: 600px;
        }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            line-height: 1;
            color: var(--bleu-marine);
            position: relative;
            display: inline-block;
            margin-bottom: 10px;
        }

        .error-code::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background-color: var(--vert-eco);
            border-radius: 2px;
            margin: 16px auto 0;
        }

        .error-icon {
            margin: 24px auto;
        }

        .error-icon svg {
            width: 70px;
            height: 70px;
            color: var(--vert-eco);
        }

        .error-title {
            font-size: 1.8rem;
            color: var(--bleu-marine);
            margin-bottom: 16px;
            font-weight: 700;
        }

        .error-message {
            font-size: 1.05rem;
            color: var(--texte-sombre);
            line-height: 1.7;
            margin-bottom: 40px;
        }

        .error-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-secondary {
            display: inline-block;
            background-color: transparent;
            color: var(--bleu-marine);
            border: 2px solid var(--bleu-marine);
            padding: 13px 28px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: var(--bleu-marine);
            color: var(--blanc);
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 5.5rem;
            }
            .error-title {
                font-size: 1.4rem;
            }
            .error-actions {
                flex-direction: column;
                align-items: center;
            }
            .btn-main,
            .btn-secondary {
                width: 100%;
                max-width: 300px;
                text-align: center;
            }
        }
    </style>
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
            <ul class="nav-links" id="nav-links">
                <li><a href="/#accueil">Accueil</a></li>
                <li><a href="/#services">Services</a></li>
                <li><a href="/#apropos">À propos</a></li>
                <li><a href="/#realisations">Réalisations</a></li>
                <li><a href="/#contact" class="btn-contact">Demander un devis</a></li>
            </ul>
            <a href="tel:<?php echo ENTREPRISE_TELEPHONE; ?>" class="phone-header" aria-label="Appeler maintenant">
                Appeler
            </a>
            <div class="burger-menu" id="burger-menu" aria-label="Ouvrir le menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <section class="error-section">
        <div class="error-container">

            <div class="error-code">404</div>

            <div class="error-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                </svg>
            </div>

            <h1 class="error-title">Cette page n'existe pas</h1>

            <p class="error-message">
                Le lien que vous avez suivi est peut-être incorrect ou la page a été déplacée.<br>
                Pas d'inquiétude, on va vous remettre sur la bonne voie !
            </p>

            <div class="error-actions">
                <a href="/" class="btn-main">Retour à l'accueil</a>
                <a href="/#contact" class="btn-secondary">Demander un devis</a>
            </div>

        </div>
    </section>

    <footer class="main-footer">
        <div class="container footer-container">
            <div class="footer-info">
                <p>&copy; <?php echo date('Y'); ?> <span>DufayElec76</span>. Tous droits réservés.</p>
            </div>
            <div class="footer-links">
                <a href="mentions-legales.php">Mentions Légales</a>
                <a href="politique-confidentialite.php">Politique de Confidentialité</a>
            </div>
        </div>
    </footer>

    <!-- Bouton Appeler Flottant (mobile) -->
    <a href="tel:<?php echo ENTREPRISE_TELEPHONE; ?>" class="floating-call-btn">
        <span class="call-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.38 2 2 0 0 1 3.62 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6.5 6.5l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
            </svg>
        </span>
    </a>

    <script src="assets/js/script.js"></script>
</body>
</html>
