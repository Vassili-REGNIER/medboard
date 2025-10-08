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
    <!-- Header -->
    <header class="header">
        <div class="container">
            <a href="/site/home" class="logo">
                <img src="/_assets/images/LogoMedBoard.svg" alt="MedBoard" class="logo-light">
                <img src="/_assets/images/LogoMedBoardDarkMode.svg" alt="MedBoard" class="logo-dark">
            </a>
            
            <nav class="nav">
                <a href="/site/home" class="nav-link">Accueil</a>
                <a href="/site/sitemap" class="nav-link">Plan du site</a>
                <a href="/site/legal" class="nav-link">Mentions légales</a>
            </nav>
            
            <div class="header-actions">
                <button class="btn-icon" id="themeToggle" aria-label="Changer le thème">
                    <img src="/_assets/images/lune.svg" alt="" class="moon-icon" aria-hidden="true">
                    <img src="/_assets/images/soleil.svg" alt="" class="sun-icon" aria-hidden="true">
                </button>
                <a href="/auth/login" class="btn-text">Se connecter</a>
                <a href="/auth/register" class="btn-primary">Créer un compte</a>
            </div>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Ouvrir le menu" aria-expanded="false">
                <span class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-header">
            <a href="/site/home" class="logo">
                <img src="/_assets/images/LogoMedBoard.svg" alt="MedBoard" class="logo-light">
                <img src="/_assets/images/LogoMedBoardDarkMode.svg" alt="MedBoard" class="logo-dark">
            </a>
            <button class="mobile-menu-close" id="mobileMenuClose" aria-label="Fermer le menu">
                <img src="/_assets/images/croix-light.svg" alt="" class="close-icon-light" aria-hidden="true">
                <img src="/_assets/images/croix-dark.svg" alt="" class="close-icon-dark" aria-hidden="true">
            </button>
        </div>

        <div class="mobile-menu-content">
            <div class="mobile-menu-section-title">NAVIGATION</div>
            <nav class="mobile-menu-nav">
                <a href="/site/home" class="mobile-menu-link">Accueil</a>
                <a href="/site/sitemap" class="mobile-menu-link">Plan du site</a>
                <a href="/site/legal" class="mobile-menu-link">Mentions légales</a>
            </nav>

            <div class="mobile-menu-theme">
                <span class="mobile-menu-theme-label">Thème</span>
                <button class="mobile-theme-toggle" id="mobileThemeToggle" aria-label="Changer le thème">
                    <img src="/_assets/images/lune.svg" alt="" class="mobile-moon-icon" aria-hidden="true">
                    <img src="/_assets/images/soleil.svg" alt="" class="mobile-sun-icon" aria-hidden="true">
                    <span class="mobile-theme-text">Sombre</span>
                </button>
            </div>

            <div class="mobile-menu-actions">
                <a href="/auth/login" class="btn-text">Se connecter</a>
                <a href="/auth/register" class="btn-primary">Créer un compte</a>
            </div>
        </div>
    </div>

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

                    <?php if (!empty($success)): ?>
                        <div class="success" role="status" style="background:#e9ffe9; border:1px solid #9ed99e; color:#136b13; padding:.75rem; border-radius:10px; margin-bottom:1rem;">
                            <?= htmlspecialchars(is_array($success) ? implode(' ', $success) : $success, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors['global'])): ?>
                        <div class="errors" role="alert" style="background:#ffecec; border:1px solid #ffb3b3; color:#a40000; padding:.75rem; border-radius:10px; margin-bottom:1rem;">
                            <?= htmlspecialchars(is_array($errors['global']) ? implode(' ', $errors['global']) : $errors['global'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>

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
                            <?php if (!empty($errors['password'])): ?>
                                <p class="err" role="alert" style="color:#c33; font-size:.925rem; margin:.25rem 0 0;">
                                    <?= htmlspecialchars(is_array($errors['password']) ? implode(' ', $errors['password']) : $errors['password'], ENT_QUOTES, 'UTF-8') ?>
                                </p>
                            <?php endif; ?>
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
                            <?php if (!empty($errors['password_confirm'])): ?>
                                <p class="err" role="alert" style="color:#c33; font-size:.925rem; margin:.25rem 0 0;">
                                    <?= htmlspecialchars(is_array($errors['password_confirm']) ? implode(' ', $errors['password_confirm']) : $errors['password_confirm'], ENT_QUOTES, 'UTF-8') ?>
                                </p>
                            <?php endif; ?>
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

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-col">
                    <a href="/site/home" class="logo">
                        <img src="/_assets/images/LogoMedBoard.svg" alt="MedBoard" class="logo-light">
                        <img src="/_assets/images/LogoMedBoardDarkMode.svg" alt="MedBoard" class="logo-dark">
                    </a>
                    <p class="footer-description">
                        La plateforme médicale nouvelle génération<br>
                        qui révolutionne la gestion des soins de<br>
                        santé.
                    </p>
                </div>

                <div class="footer-col">
                    <h3 class="footer-heading">Équipe</h3>
                    <ul class="footer-list">
                        <li>Alexis BARBERIS</li>
                        <li>Vassili REGNIER</li>
                        <li>Jérémy WATRIPONT</li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3 class="footer-heading">Navigation</h3>
                    <ul class="footer-list">
                        <li><a href="/site/home">Accueil</a></li>
                        <li><a href="/site/sitemap">Plan du site</a></li>
                        <li><a href="/site/legal">Mentions légales</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3 class="footer-heading">Contact</h3>
                    <ul class="footer-list contact">
                        <li>
                            <img src="/_assets/images/mail.svg" alt="">
                            <a href="mailto:contact@medboard.fr">contact@medboard.fr</a>
                        </li>
                        <li>
                            <img src="/_assets/images/localisation.svg" alt="">
                            <span>413, Avenue Gaston Berger<br>13100 Aix-en-Provence</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>© 2025 MedBoard. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="/_assets/js/common.js" defer></script>
</body>
</html>

