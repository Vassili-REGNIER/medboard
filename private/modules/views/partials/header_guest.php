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