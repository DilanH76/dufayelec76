<section id="contact" class="contact-section">
    <div class="container contact-container">
        <h2 class="section-title">Demander un devis</h2>
        <p class="contact-subtitle">Une urgence ou un projet ? Laissez-moi vos coordonnées, je vous rappelle rapidement.</p>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert alert-success">
                Merci, votre demande a bien été envoyée ! Je vous recontacte très vite.
            </div>

        <?php elseif (isset($_SESSION['flash_error'])): ?>
            <div class="alert alert-error">
                <?php echo $_SESSION['flash_error']; ?>
            </div>
            <?php unset($_SESSION['flash_error']); ?>

        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
            <div class="alert alert-error">
                Une erreur est survenue lors de l'envoi de votre message.
            </div>
        <?php endif; ?>

        <form action="includes/traitement.php" method="POST" class="contact-form" enctype="multipart/form-data">

            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div style="display:none;">
                <label for="website">Laissez ce champ vide</label>
                <input type="text" id="website" name="website" value="" autocomplete="nope" tabindex="-1">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom / Entreprise *</label>
                    <input type="text" id="nom" name="nom" required placeholder="Ex: Prénom Nom"
                        value="<?php echo isset($_SESSION['old_inputs']['nom']) ? htmlspecialchars($_SESSION['old_inputs']['nom']) : ''; ?>">
                </div>

                <div class="form-group <?php echo (isset($_SESSION['error_field']) && $_SESSION['error_field'] === 'telephone') ? 'has-error' : ''; ?>">
                    <label for="telephone">Téléphone *</label>
                    <div class="input-wrapper">
                        <input type="tel" id="telephone" name="telephone" inputmode="tel" required placeholder="Ex: 06 00 00 00 00"
                            value="<?php echo isset($_SESSION['old_inputs']['telephone']) ? htmlspecialchars($_SESSION['old_inputs']['telephone']) : ''; ?>"
                            <?php echo (isset($_SESSION['error_field']) && $_SESSION['error_field'] === 'telephone') ? 'aria-invalid="true"' : ''; ?>>

                        <span class="icon-erreur" aria-hidden="true">❌</span>
                    </div>
                </div>
            </div>

            <div class="form-group <?php echo (isset($_SESSION['error_field']) && $_SESSION['error_field'] === 'email') ? 'has-error' : ''; ?>">
                <label for="email">Adresse e-mail *</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" required placeholder="Ex: exemple@mail.com"
                        value="<?php echo isset($_SESSION['old_inputs']['email']) ? htmlspecialchars($_SESSION['old_inputs']['email']) : ''; ?>"
                        <?php echo (isset($_SESSION['error_field']) && $_SESSION['error_field'] === 'email') ? 'aria-invalid="true"' : ''; ?>>

                    <span class="icon-erreur" aria-hidden="true">❌</span>
                </div>
            </div>

            <div class="form-group">
                <label for="message">Votre message (Facultatif)</label>
                <textarea id="message" name="message" rows="5" placeholder="Décrivez brièvement votre besoin..."><?php echo isset($_SESSION['old_inputs']['message']) ? htmlspecialchars($_SESSION['old_inputs']['message']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label>Joindre des photos (optionnel, max 3 · 5Mo)</label>
                <label for="photos" class="btn-upload">
                    Choisir des photos
                </label>
                <input type="file" id="photos" name="photos[]" multiple accept="image/*">
                <span class="upload-info" id="upload-info">Aucune photo sélectionnée</span>
            </div>

            <button type="submit" class="btn-main btn-submit">Envoyer ma demande</button>

        </form>
    </div>
</section>

<?php
unset($_SESSION['error_field']);
unset($_SESSION['old_inputs']);
?>