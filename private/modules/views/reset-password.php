<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Créez un nouveau mot de passe sécurisé pour votre compte MedBoard">
    <meta name="robots" content="noindex, nofollow">
    <title>Nouveau mot de passe - MedBoard</title>
    <link rel="icon" type="image/svg+xml" href="/_assets/images/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/_assets/images/favicon.ico">
    <link rel="stylesheet" href="/_assets/css/styles.css">
</head>
<body class="light-theme change-password-page">
    
    <?php 
    // Header
    if (Auth::check()) {
        require __DIR__ ."/partials/header_user.php";
    } else {
        require __DIR__ ."/partials/header_guest.php";
    }
    ?>

    <main>
        <section class="change-password-section">
            <div class="change-password-container">
                <!-- Back link -->
                <a href="/site/home" class="back-link">
                    <img src="/_assets/images/fleche-gauche.svg" alt="" aria-hidden="true">
                    Retour à l'accueil
                </a>

                <!-- Change Password Card -->
                <div class="change-password-card">
                    <h1 class="change-password-title">Nouveau mot de passe</h1>
                    <p class="change-password-subtitle">Choisissez un mot de passe sécurisé pour votre compte</p>

                    <?php
                        // Flash message
                        require __DIR__ ."/partials/flash_message.php";
                    ?>

                    <form id="changePasswordForm" class="change-password-form" method="post" action="/auth/reset-password" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="token" value="<?= htmlspecialchars((string)($token ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="uid" value="<?= htmlspecialchars((string)($uid ?? ''), ENT_QUOTES, 'UTF-8') ?>">

                        <div class="form-group">
                            <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                            <div class="input-wrapper">
                                <input
                                    type="password"
                                    id="newPassword"
                                    name="password"
                                    class="form-input password-input"
                                    placeholder="••••••••"
                                    required
                                    minlength="8"
                                    autocomplete="new-password"
                                >
                                <button type="button" class="password-toggle" aria-label="Afficher le mot de passe">
                                    <img src="/_assets/images/oeil-light.svg" alt="" class="eye-light">
                                    <img src="/_assets/images/oeil-dark.svg" alt="" class="eye-dark">
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
                            <div class="input-wrapper">
                                <input
                                    type="password"
                                    id="confirmPassword"
                                    name="password_confirm"
                                    class="form-input password-input"
                                    placeholder="••••••••"
                                    required
                                    minlength="8"
                                    autocomplete="new-password"
                                >
                                <button type="button" class="password-toggle" aria-label="Afficher le mot de passe">
                                    <img src="/_assets/images/oeil-light.svg" alt="" class="eye-light">
                                    <img src="/_assets/images/oeil-dark.svg" alt="" class="eye-dark">
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit" id="submitBtn">
                            Modifier le mot de passe
                        </button>

                        <p class="form-footer-text">
                            Vous vous souvenez de votre mot de passe ? <a href="/auth/login">Se connecter</a>
                        </p>
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

