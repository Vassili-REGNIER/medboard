<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Créez votre compte MedBoard et accédez à la plateforme médicale nouvelle génération">
    <meta name="robots" content="noindex, nofollow">
    <title>Créer un compte - MedBoard</title>
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
                <a href="/auth/login" class="btn-text">Se connecter</a>
                <a href="/auth/register" class="btn-primary" aria-current="page">Créer un compte</a>
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

                    <form class="signup-form">
                        <fieldset>
                            <legend class="sr-only">Informations personnelles</legend>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstName" class="form-label">Prénom <span class="required">*</span></label>
                                    <input type="text" id="firstName" class="form-input" placeholder="Votre prénom" autocomplete="given-name" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastName" class="form-label">Nom <span class="required">*</span></label>
                                    <input type="text" id="lastName" class="form-input" placeholder="Votre nom" autocomplete="family-name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="login" class="form-label">Login <span class="required">*</span></label>
                                <input type="text" id="login" name="login" class="form-input" placeholder="Votre identifiant unique" autocomplete="username" required>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Adresse email <span class="required">*</span></label>
                                <input type="email" id="email" class="form-input" placeholder="votre.email@exemple.com" autocomplete="email" required>
                            </div>

                            <div class="form-group">
                                <label for="specialization" class="form-label">Spécialisation</label>
                                <select id="specialization" class="form-select" autocomplete="off">
                                    <option value="">-- Aucune --</option>
                                    <option value="Cardiology">Cardiology</option>
                                    <option value="Dermatology">Dermatology</option>
                                    <option value="Endocrinology">Endocrinology</option>
                                    <option value="Gastroenterology">Gastroenterology</option>
                                    <option value="General_practice">General_practice</option>
                                    <option value="Neurology">Neurology</option>
                                    <option value="Oncology">Oncology</option>
                                    <option value="Orthopedics">Orthopedics</option>
                                    <option value="Pediatrics">Pediatrics</option>
                                    <option value="Psychiatry">Psychiatry</option>
                                    <option value="Radiology">Radiology</option>
                                    <option value="Urology">Urology</option>
                                </select>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="sr-only">Sécurité</legend>
                            <div class="form-group">
                                <label for="password" class="form-label">Mot de passe <span class="required">*</span></label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-input" id="password" placeholder="Créez un mot de passe sécurisé" autocomplete="new-password" required>
                                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Afficher le mot de passe">
                                        <img src="/_assets/images/oeil-light.svg" alt="" class="eye-light" aria-hidden="true">
                                        <img src="/_assets/images/oeil-dark.svg" alt="" class="eye-dark" aria-hidden="true">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword" class="form-label">Confirmer le mot de passe <span class="required">*</span></label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-input" id="confirmPassword" placeholder="Confirmez votre mot de passe" autocomplete="new-password" required>
                                    <button type="button" class="password-toggle" id="toggleConfirmPassword" aria-label="Afficher le mot de passe">
                                        <img src="/_assets/images/oeil-light.svg" alt="" class="eye-light" aria-hidden="true">
                                        <img src="/_assets/images/oeil-dark.svg" alt="" class="eye-dark" aria-hidden="true">
                                    </button>
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-checkbox">
                            <input type="checkbox" id="terms" required>
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
    <script src="/_assets/js/signup.js" defer></script>
</body>
</html>

