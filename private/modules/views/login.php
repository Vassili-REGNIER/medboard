<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connectez-vous à votre compte MedBoard pour accéder à votre espace de gestion médicale">
    <meta name="robots" content="noindex, nofollow">
    <title>Connexion - MedBoard</title>
    <link rel="icon" type="image/svg+xml" href="/_assets/images/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/_assets/images/favicon.ico">
    <link rel="stylesheet" href="/_assets/css/styles.css">
</head>
<body class="light-theme">
    <!-- Header -->
    <header class="header">
        <div class="container">
            <a href="/site/home" class="logo" aria-label="Retour à l'accueil">
                <img src="/_assets/images/LogoMedBoard.svg" alt="MedBoard" class="logo-light">
                <img src="/_assets/images/LogoMedBoardDarkMode.svg" alt="MedBoard" class="logo-dark">
            </a>
            
            <nav class="nav" aria-label="Navigation principale">
                <a href="/site/home" class="nav-link">Accueil</a>
                <a href="/site/sitemap" class="nav-link">Plan du site</a>
                <a href="/site/legal" class="nav-link">Mentions légales</a>
            </nav>
            
            <div class="header-actions">
                <button class="btn-icon" id="themeToggle" aria-label="Changer le thème">
                    <img src="/_assets/images/lune.svg" alt="" class="moon-icon" aria-hidden="true">
                    <img src="/_assets/images/soleil.svg" alt="" class="sun-icon" aria-hidden="true">
                </button>
                <a href="/auth/login" class="btn-text" aria-current="page">Se connecter</a>
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
    <div class="mobile-menu" id="mobileMenu" role="dialog" aria-modal="true" aria-label="Menu de navigation">
        <div class="mobile-menu-header">
            <a href="/site/home" class="logo" aria-label="Retour à l'accueil">
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
            <nav class="mobile-menu-nav" aria-label="Navigation mobile">
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

                    <?php if (!empty($errors)): ?>
                        <div class="errors" role="alert" style="background:#ffecec; border:1px solid #ffb3b3; color:#a40000; padding:.75rem; border-radius:10px; margin-bottom:1rem;">
                            <ul style="margin:0; padding-left: 1.2rem;">
                                <?php foreach ($errors as $err): ?>
                                    <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="success" role="status" style="background:#e9ffe9; border:1px solid #9ed99e; color:#136b13; padding:.75rem; border-radius:10px; margin-bottom:1rem;">
                            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>

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

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-col">
                    <a href="/site/home" class="logo" aria-label="Retour à l'accueil">
                        <img src="/_assets/images/LogoMedBoard.svg" alt="MedBoard" class="logo-light">
                        <img src="/_assets/images/LogoMedBoardDarkMode.svg" alt="MedBoard" class="logo-dark">
                    </a>
                    <p class="footer-description">
                        La plateforme médicale nouvelle génération qui révolutionne la gestion des soins de santé.
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
                    <nav aria-label="Navigation footer">
                        <ul class="footer-list">
                            <li><a href="/site/home">Accueil</a></li>
                            <li><a href="/site/sitemap">Plan du site</a></li>
                            <li><a href="/site/legal">Mentions légales</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="footer-col">
                    <h3 class="footer-heading">Contact</h3>
                    <ul class="footer-list contact">
                        <li>
                            <img src="/_assets/images/mail.svg" alt="" aria-hidden="true">
                            <a href="mailto:contact@medboard.fr">contact@medboard.fr</a>
                        </li>
                        <li>
                            <img src="/_assets/images/localisation.svg" alt="" aria-hidden="true">
                            <span>413, Avenue Gaston Berger 13100 Aix-en-Provence</span>
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

