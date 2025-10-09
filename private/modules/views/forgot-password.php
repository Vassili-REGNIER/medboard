<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Réinitialisez votre mot de passe MedBoard en toute sécurité">
    <meta name="robots" content="noindex, nofollow">
    <title>Mot de passe oublié - MedBoard</title>
    <link rel="icon" type="image/svg+xml" href="/_assets/images/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/_assets/images/favicon.ico">
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
        <!-- Forgot Password Section -->
        <section class="signup-section">
            <div class="signup-container-centered">
                <!-- Back link -->
                <a href="/site/home" class="back-link">
                    <img src="/_assets/images/fleche-gauche.svg" alt="Retour">
                    Retour à l'accueil
                </a>

                <!-- Forgot Password Card -->
                <div class="signup-card-centered">
                    <div class="signup-header">
                        <h1 class="signup-title">Mot de passe oublié</h1>
                        <p class="signup-subtitle">Saisissez votre adresse email pour recevoir un lien de réinitialisation</p>
                    </div>

                    <?php
                        // Flash message
                        require __DIR__ ."/partials/flash_message.php";
                    ?>

                    <form class="signup-form" method="post" action="/auth/forgot-password" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                        <div class="form-group">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" id="email" name="email" class="form-input" placeholder="votre.email@example.com" autocomplete="email" required maxlength="254" value="<?= htmlspecialchars((string)($old['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <button type="submit" class="btn-submit">Envoyer le lien</button>

                        <div class="signup-footer">
                            <p class="signup-link-text">
                                Vous vous souvenez de votre mot de passe ? <a href="/auth/login" class="form-link">Se connecter</a>
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

