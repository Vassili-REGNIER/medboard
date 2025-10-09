<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Créez votre compte MedBoard et accédez à la plateforme médicale nouvelle génération">
    <meta name="robots" content="noindex, nofollow">
    <title>Créer un compte - MedBoard</title>
    <!-- Favicon moderne (SVG) - prioritaire -->
    <link rel="icon" type="image/svg+xml" href="/_assets/images/favicon.svg">

    <!-- Fallback pour navigateurs qui ne supportent pas SVG -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="/_assets/css/styles.css">
</head>
<body class="light-theme">
    
    <?php 
    // Header
    if (Auth::check()) {
        require __DIR__ ."/partials/header_user.php";
    } else {
        require __DIR__ ."/partials/header_guest.php";
    }
    ?>

    <main>
        <!-- Signup Section -->
        <section class="signup-section" aria-labelledby="signup-title">
            <div class="signup-container-centered">
                <!-- Back link -->
                <a href="/site/home" class="back-link">
                    <img src="/_assets/images/fleche-gauche.svg" alt="" aria-hidden="true">
                    Retour à l'accueil
                </a>

                <!-- Signup Card -->
                <div class="signup-card-centered">
                    <div class="signup-header">
                        <h1 id="signup-title" class="signup-title">Créer un compte</h1>
                        <p class="signup-subtitle">Rejoignez MedBoard et découvrez une nouvelle façon de gérer vos données médicales</p>
                    </div>

                    <?php
                        // Flash message
                        require __DIR__ ."/partials/flash_message.php";
                    ?>

                    <form class="signup-form" method="post" action="/auth/register" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                        <fieldset>
                            <legend class="sr-only">Informations personnelles</legend>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstName" class="form-label">Prénom <span class="required">*</span></label>
                                    <input type="text" id="firstName" name="firstname" class="form-input" placeholder="Votre prénom" autocomplete="given-name" required value="<?= htmlspecialchars($old['firstname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="lastName" class="form-label">Nom <span class="required">*</span></label>
                                    <input type="text" id="lastName" name="lastname" class="form-input" placeholder="Votre nom" autocomplete="family-name" required value="<?= htmlspecialchars($old['lastname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="login" class="form-label">Login <span class="required">*</span></label>
                                <input type="text" id="login" name="username" class="form-input" placeholder="Votre identifiant unique" autocomplete="username" required value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Adresse email <span class="required">*</span></label>
                                <input type="email" id="email" name="email" class="form-input" placeholder="votre.email@exemple.com" autocomplete="email" required value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            </div>

                            <div class="form-group">
                                <label for="specialization" class="form-label">Spécialisation</label>
                                <select id="specialization" name="specialization" class="form-select" autocomplete="off">
                                    <option value="">-- Aucune --</option>
                                    <?php
                                        $current = $old['specialization'] ?? '';
                                        foreach ($specializations as $id => $label):
                                            $display = ucfirst($label);
                                    ?>
                                        <option value="<?= htmlspecialchars((string)$id, ENT_QUOTES, 'UTF-8') ?>"
                                            <?= ($current === (string)$id) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($display, ENT_QUOTES, 'UTF-8') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="sr-only">Sécurité</legend>
                            <div class="form-group">
                                <label for="password" class="form-label">Mot de passe <span class="required">*</span></label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-input" id="password" name="password" placeholder="Créez un mot de passe sécurisé" autocomplete="new-password" required minlength="8">
                                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Afficher le mot de passe">
                                        <img src="/_assets/images/oeil-light.svg" alt="" class="eye-light" aria-hidden="true">
                                        <img src="/_assets/images/oeil-dark.svg" alt="" class="eye-dark" aria-hidden="true">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword" class="form-label">Confirmer le mot de passe <span class="required">*</span></label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-input" id="confirmPassword" name="password_confirm" placeholder="Confirmez votre mot de passe" autocomplete="new-password" required minlength="8">
                                    <button type="button" class="password-toggle" id="toggleConfirmPassword" aria-label="Afficher le mot de passe">
                                        <img src="/_assets/images/oeil-light.svg" alt="" class="eye-light" aria-hidden="true">
                                        <img src="/_assets/images/oeil-dark.svg" alt="" class="eye-dark" aria-hidden="true">
                                    </button>
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-checkbox">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms" class="checkbox-label">
                                J'accepte les <a href="/site/not-found" class="form-link">conditions d'utilisation</a> et la <a href="/site/privacy" class="form-link">politique de confidentialité</a> <span class="required">*</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-submit">Créer mon compte</button>

                        <div class="signup-footer">
                            <p class="signup-link-text">
                                Déjà membre ? <a href="/auth/login" class="form-link">Se connecter</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php
        // Footer
        require __DIR__ ."/partials/footer.php";
    ?>

    <script src="/_assets/js/common.js" defer></script>
</body>
</html>

