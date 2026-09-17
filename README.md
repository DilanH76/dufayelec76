<h1 align="center">DufayElec76</h1>

<p align="center">
  Site vitrine d'un artisan électricien, conçu, développé et mis en production.<br>
  <strong><a href="https://www.dufayelec76.fr">www.dufayelec76.fr</a></strong>
</p>

---

## Le projet

Site vitrine réalisé pour un artisan électricien de Seine-Maritime : présentation de l'activité, des services et des réalisations, avec un formulaire de contact qui transmet les demandes directement par e-mail.

Projet mené de bout en bout — recueil du besoin auprès du client, développement, mise en ligne et accompagnement au déploiement sur son hébergement.

**En production depuis 2026.**

## Fonctionnalités

- Page unique structurée en sections : présentation, services, réalisations, contact
- Formulaire de contact avec envoi SMTP transactionnel et protection anti-flood
- Pages légales : mentions légales et politique de confidentialité (conformité RGPD)
- Page 404 personnalisée
- Design responsive, CSS écrit à la main sans framework

## Architecture

Site PHP organisé en composants inclus dans une page principale, ce qui évite la duplication et permet de modifier une section sans toucher au reste.

```
index.php                    <- assemble la page à partir des composants
includes/
  config.php                 <- configuration, chargement des variables d'environnement
  header.php / footer.php    <- structure commune
  hero.php                   <- bannière d'accueil
  services.php               <- prestations
  realizations.php           <- réalisations
  about.php                  <- présentation de l'artisan
  contact-form.php           <- formulaire
  traitement.php             <- validation et envoi de l'e-mail
assets/                      <- CSS, JavaScript, images
mentions-legales.php
politique-confidentialite.php
404.php
```

## Points techniques

**Gestion des secrets.** Aucune donnée sensible n'est écrite dans le code. Les identifiants SMTP et les informations de l'entreprise sont chargés depuis un fichier `.env` exclu du dépôt, via `vlucas/phpdotenv`, avec des valeurs de repli pour les données publiques.

**Envoi d'e-mails.** Le formulaire de contact passe par PHPMailer en SMTP authentifié plutôt que par la fonction `mail()` de PHP — meilleure délivrabilité et moins de risque d'être classé en indésirable.

**Sécurité et performance en production**, via `.htaccess` : redirection HTTPS forcée, redirection canonique vers `www`, compression gzip, cache long sur les ressources statiques, désactivation du listage des dossiers, et en-têtes de sécurité (`X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`).

**Référencement.** Sitemap XML, `robots.txt`, structure sémantique et images optimisées (WebP et JPEG compressés).

> Le fichier `.htaccess.back` est la copie de sauvegarde du `.htaccess` actif en production. Il est renommé `.htaccess` au déploiement.

## Stack

| Domaine | Technologies |
|---|---|
| Back-end | PHP 8, Composer |
| Dépendances | PHPMailer (SMTP), vlucas/phpdotenv (variables d'environnement) |
| Front-end | HTML5, CSS3 écrit à la main (Flexbox, Grid), JavaScript |
| Hébergement | OVH — nom de domaine, hébergement mutualisé, certificat SSL |

## Installation locale

```bash
git clone https://github.com/DilanH76/dufayelec76.git
cd dufayelec76
composer install
```

Créer un fichier `.env` à la racine :

```
SITE_URL=http://localhost/dufayelec76
ENTREPRISE_EMAIL=contact@exemple.fr
ENTREPRISE_TELEPHONE=00 00 00 00 00
ENTREPRISE_ADRESSE=Adresse
ENTREPRISE_SIRET=000 000 000 00000

SMTP_HOST=
SMTP_PORT=587
SMTP_USERNAME=
SMTP_PASSWORD=
```

---

**Dilan Houlbrèque** — Développeur web full-stack, Le Havre · dilan.hlbrq@gmail.com
