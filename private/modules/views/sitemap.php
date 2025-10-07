<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plan du site MedBoard - Accédez rapidement à toutes les pages de notre plateforme médicale">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://medboard.alwaysdata.net/sitemap">
    <meta property="og:title" content="Plan du site - MedBoard">
    <meta property="og:description" content="Accédez rapidement à toutes les pages de notre plateforme médicale MedBoard">
    <meta property="og:image" content="https://medboard.alwaysdata.net/_assets/images/LogoMedBoard.svg">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="https://medboard.alwaysdata.net/sitemap">
    <meta name="twitter:title" content="Plan du site - MedBoard">
    <meta name="twitter:description" content="Accédez rapidement à toutes les pages de notre plateforme médicale MedBoard">
    <meta name="twitter:image" content="https://medboard.alwaysdata.net/_assets/images/LogoMedBoard.svg">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://medboard.alwaysdata.net/sitemap">

    <title>Plan du site - MedBoard</title>
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
                <a href="/site/sitemap" class="nav-link active">Plan du site</a>
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
        <!-- Sitemap Section -->
        <section class="sitemap-section">
            <div class="sitemap-container">
                <!-- Back link -->
                <a href="/site/home" class="back-link">
                    <img src="/_assets/images/fleche-gauche.svg" alt="Retour">
                    Retour à l'accueil
                </a>

                <!-- Sitemap Header -->
                <div class="sitemap-header">
                    <h1 class="sitemap-title">Plan du site</h1>
                    <p class="sitemap-subtitle">Toutes les pages de MedBoard</p>
                </div>

                <!-- Sitemap Card -->
                <div class="sitemap-card">
                    <h2 class="sitemap-card-title">Pages disponibles</h2>
                    
                    <div class="sitemap-list">
                        <a class="sitemap-item" href="/site/home">
                            <span class="sitemap-page-name">Accueil</span>
                            <span class="sitemap-page-url">/site/home</span>
                        </a>
                        
                        <a class="sitemap-item" href="/auth/register">
                            <span class="sitemap-page-name">Inscription</span>
                            <span class="sitemap-page-url">/auth/register</span>
                        </a>
                        
                        <a class="sitemap-item" href="/auth/login">
                            <span class="sitemap-page-name">Connexion</span>
                            <span class="sitemap-page-url">/auth/login</span>
                        </a>
                        
                        <a class="sitemap-item" href="/auth/forgot-password">
                            <span class="sitemap-page-name">Mot de passe oublié</span>
                            <span class="sitemap-page-url">/auth/forgot-password</span>
                        </a>

                        <a class="sitemap-item" href="/auth/reset-password">
                            <span class="sitemap-page-name">Nouveau mot de passe</span>
                            <span class="sitemap-page-url">/auth/reset-password</span>
                        </a>

                        <a class="sitemap-item" href="/dashboard/index">
                            <span class="sitemap-page-name">Tableau de bord</span>
                            <span class="sitemap-page-url">/dashboard/index</span>
                        </a>
                                               
                        <a class="sitemap-item" href="/site/legal">
                            <span class="sitemap-page-name">Mentions légales</span>
                            <span class="sitemap-page-url">/site/legal</span>
                        </a>
                        
                        <a class="sitemap-item" href="/site/privacy">
                            <span class="sitemap-page-name">Politique de confidentialité</span>
                            <span class="sitemap-page-url">/site/privacy</span>
                        </a>
                        
                        <a class="sitemap-item" href="/site/sitemap">
                            <span class="sitemap-page-name">Plan du site</span>
                            <span class="sitemap-page-url">/site/sitemap</span>
                        </a>
                        
                        <a class="sitemap-item" href="/site/not-found">
                            <span class="sitemap-page-name">Page non trouvée (404)</span>
                            <span class="sitemap-page-url">/site/not-found</span>
                        </a>
                    </div>
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

