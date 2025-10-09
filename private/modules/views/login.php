<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connectez-vous à votre compte MedBoard pour accéder à votre espace de gestion médicale">
    <meta name="robots" content="noindex, nofollow">
    <title>Connexion - MedBoard</title>
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
        <!-- Login Section -->
        <section class="signup-section" aria-labelledby="login-title">
            <div class="signup-container-centered">
                <!-- Back link -->
                <a href="/site/home" class="back-link">
                    <img src="/_assets/images/fleche-gauche.svg" alt="" aria-hidden="true">
                    Retour à l'accueil
                </a>

                <!-- Login Card -->
                <div class="signup-card-centered">
                    <div class="signup-header">
                        <h1 id="login-title" class="signup-title">Connexion</h1>
                        <p class="signup-subtitle">Accédez à votre espace MedBoard</p>
                    </div>

                    <?php
                        // Flash message
                        require __DIR__ ."/partials/flash_message.php";
                    ?>

                    <form class="signup-form" method="post" action="/auth/login" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                        <div class="form-group">
                            <label for="loginIdentifier" class="form-label">Email ou Login <span class="required">*</span></label>
                            <div class="input-with-icon">
                                <img src="/_assets/images/mail.svg" alt="" class="input-icon" aria-hidden="true">
                                <input type="text" id="loginIdentifier" name="login" class="form-input" placeholder="@email.com ou votre login" required autocomplete="username" value="<?= htmlspecialchars($old['login'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="loginPassword" class="form-label">Mot de passe <span class="required">*</span></label>
                            <div class="password-wrapper">
                                <div class="input-with-icon">
                                    <img src="/_assets/images/lock.svg" alt="" class="input-icon" aria-hidden="true">
                                    <input type="password" id="loginPassword" name="password" class="form-input" placeholder="••••••••" required minlength="8" autocomplete="current-password">
                                </div>
                                <button type="button" class="password-toggle" id="toggleLoginPassword" aria-label="Afficher le mot de passe">
                                    <img src="/_assets/images/oeil-light.svg" alt="" class="eye-light" aria-hidden="true">
                                    <img src="/_assets/images/oeil-dark.svg" alt="" class="eye-dark" aria-hidden="true">
                                </button>
                            </div>
                        </div>

                        <div class="form-checkbox">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember" class="checkbox-label">Se souvenir de moi</label>
                        </div>

                        <button type="submit" class="btn-submit">Se connecter</button>

                        <div class="forgot-password">
                            <a href="/auth/forgot-password" class="forgot-link">Mot de passe oublié ?</a>
                        </div>

                        <div class="login-divider" aria-hidden="true">
                            <span>ou</span>
                        </div>

                        <div class="signup-footer">
                            <p class="signup-link-text">
                                Pas encore de compte ? <a href="/auth/register" class="form-link">Créer un compte</a>
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

