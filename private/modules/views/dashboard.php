<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Accédez à votre tableau de bord MedBoard pour gérer vos patients, consultations et données médicales">
    <meta name="robots" content="noindex, nofollow">
    <title>Tableau de bord - MedBoard</title>
    <link rel="icon" type="image/svg+xml" href="/_assets/images/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/_assets/images/favicon.ico">
    <link rel="stylesheet" href="/_assets/css/styles.css">
</head>
<body class="light-theme dashboard-page">
    <!-- Header -->
    <header class="header">
        <div class="container">
            <a href="/site/home" class="logo">
                <img src="/_assets/images/LogoMedBoard.svg" alt="MedBoard" class="logo-light">
                <img src="/_assets/images/LogoMedBoardDarkMode.svg" alt="MedBoard" class="logo-dark">
            </a>

            <nav class="nav dashboard-nav">
                <a href="/dashboard/index" class="nav-link active">Tableau de bord</a>
                <a href="/site/home" class="nav-link">Accueil</a>
                <a href="/site/sitemap" class="nav-link">Plan du site</a>
                <a href="/site/legal" class="nav-link">Mentions légales</a>
            </nav>

            <div class="header-actions">
                <button class="btn-icon" id="themeToggle" aria-label="Changer le thème">
                    <img src="/_assets/images/lune.svg" alt="" class="moon-icon" aria-hidden="true">
                    <img src="/_assets/images/soleil.svg" alt="" class="sun-icon" aria-hidden="true">
                </button>
                <button class="btn-icon logout-icon" aria-label="Déconnexion">
                    <img src="/_assets/images/logout-light.svg" alt="" class="logout-light" aria-hidden="true">
                    <img src="/_assets/images/logout-dark.svg" alt="" class="logout-dark" aria-hidden="true">
                </button>
                <button class="btn-profile" aria-label="Profil utilisateur">
                    <span class="profile-initials" id="profileInitials"></span>
                </button>
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
                <a href="/dashboard/index" class="mobile-menu-link">Tableau de bord</a>
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
        </div>
    </div>

    <main>
        <div class="dashboard-hero">
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <p class="dashboard-greeting" id="dashboardGreeting">Bonjour, Demo</p>
                    <p class="dashboard-specialization" id="dashboardSpecialization"></p>
                </div>
                <p class="dashboard-subtitle">Bienvenue sur votre tableau de bord</p>

                <div class="dashboard-grid">
                    <div class="dashboard-card">
                        <div class="card-title">Projets</div>
                        <div class="card-placeholder"></div>
                        <span class="card-badge">En construction</span>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-title">Équipe</div>
                        <div class="card-placeholder"></div>
                        <span class="card-badge">Prochainement</span>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-title">Activité</div>
                        <div class="card-placeholder"></div>
                        <span class="card-badge">En développement</span>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-title">Rapports</div>
                        <div class="card-placeholder"></div>
                        <span class="card-badge">Planifié</span>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-title">Paramètres</div>
                        <div class="card-placeholder"></div>
                        <span class="card-badge">À venir</span>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-title">Notifications</div>
                        <div class="card-placeholder"></div>
                        <span class="card-badge">Bientôt</span>
                    </div>
                </div>

                <p class="dashboard-footer-text">Interface en cours de développement</p>
            </div>
        </div>
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
    <script>
        // Generate user initials and display user information dynamically
        document.addEventListener('DOMContentLoaded', function() {
            // Simulate user data - In production, this would come from the backend/session
            const user = {
                firstName: "Jeremy",
                lastName: "Watripont",
                specialization: "Cardiology"
            };

            // Function to generate initials
            function generateInitials(firstName, lastName) {
                const firstInitial = firstName.charAt(0).toUpperCase();
                const lastInitial = lastName.charAt(0).toUpperCase();
                return firstInitial + lastInitial;
            }

            // Update the profile initials
            const profileInitialsElement = document.getElementById('profileInitials');
            if (profileInitialsElement) {
                profileInitialsElement.textContent = generateInitials(user.firstName, user.lastName);
            }

            // Update the dashboard greeting with full name
            const dashboardGreetingElement = document.getElementById('dashboardGreeting');
            if (dashboardGreetingElement) {
                dashboardGreetingElement.textContent = `Bonjour, ${user.firstName} ${user.lastName}`;
            }

            // Update the specialization display
            const dashboardSpecializationElement = document.getElementById('dashboardSpecialization');
            if (dashboardSpecializationElement && user.specialization) {
                dashboardSpecializationElement.textContent = user.specialization;
            }
        });
    </script>
</body>
</html>
