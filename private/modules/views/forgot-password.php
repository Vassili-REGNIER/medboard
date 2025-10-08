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

                    <form class="signup-form" method="post" action="/auth/forgot-password" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                        <div class="form-group">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" id="email" name="email" class="form-input" placeholder="votre.email@example.com" autocomplete="email" required maxlength="254" value="<?= htmlspecialchars((string)($old['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                            <?php if (!empty($errors['email'])): ?>
                                <p class="err" role="alert" style="color:#c33; font-size:.925rem; margin:.25rem 0 0;">
                                    <?= htmlspecialchars(is_array($errors['email']) ? implode(' ', $errors['email']) : $errors['email'], ENT_QUOTES, 'UTF-8') ?>
                                </p>
                            <?php endif; ?>
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

