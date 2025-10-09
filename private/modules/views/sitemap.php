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

    <?php
        // Footer
        require __DIR__ ."/partials/footer.php";
    ?>

    <script src="/_assets/js/common.js" defer></script>
</body>
</html>

