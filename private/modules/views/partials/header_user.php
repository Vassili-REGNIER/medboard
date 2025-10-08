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
            <form method="POST" action="/auth/logout" style="display: inline;">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                <button type="submit" class="btn-icon logout-icon" aria-label="Déconnexion">
                    <img src="/_assets/images/logout-light.svg" alt="" class="logout-light" aria-hidden="true">
                    <img src="/_assets/images/logout-dark.svg" alt="" class="logout-dark" aria-hidden="true">
                </button>
            </form>
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