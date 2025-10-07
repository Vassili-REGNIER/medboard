<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MedBoard - Plateforme médicale nouvelle génération pour la gestion hospitalière intelligente">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://medboard.alwaysdata.net/">
    <meta property="og:title" content="MedBoard - Plateforme médicale nouvelle génération">
    <meta property="og:description" content="MedBoard révolutionne la gestion hospitalière avec des outils intelligents, un monitoring en temps réel et une interface intuitive pensée pour les professionnels de santé.">
    <meta property="og:image" content="https://medboard.alwaysdata.net/_assets/images/LogoMedBoard.svg">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://medboard.alwaysdata.net/">
    <meta name="twitter:title" content="MedBoard - Plateforme médicale nouvelle génération">
    <meta name="twitter:description" content="MedBoard révolutionne la gestion hospitalière avec des outils intelligents, un monitoring en temps réel et une interface intuitive pensée pour les professionnels de santé.">
    <meta name="twitter:image" content="https://medboard.alwaysdata.net/_assets/images/LogoMedBoard.svg">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://medboard.alwaysdata.net/">

    <title>MedBoard - Plateforme médicale nouvelle génération</title>
    <link rel="icon" type="image/svg+xml" href="/_assets/images/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/_assets/images/favicon.ico">
    <link rel="stylesheet" href="/_assets/css/styles.css">

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "MedicalOrganization",
      "name": "MedBoard",
      "url": "https://medboard.alwaysdata.net",
      "logo": "https://medboard.alwaysdata.net/_assets/images/LogoMedBoard.svg",
      "description": "Plateforme médicale nouvelle génération pour la gestion hospitalière intelligente",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "413, Avenue Gaston Berger",
        "addressLocality": "Aix-en-Provence",
        "postalCode": "13100",
        "addressCountry": "FR"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "email": "contact@medboard.fr",
        "contactType": "customer service"
      }
    }
    </script>
</head>
<body class="light-theme">
    <!-- Header -->
    <header class="header">
        <div class="container">
            <a href="/site/home" class="logo">
                <img src="/_assets/images/LogoMedBoard.svg" alt="MedBoard" class="logo-light">
                <img src="/_assets/images/LogoMedBoardDarkMode.svg" alt="MedBoard" class="logo-dark">
            </a>

            <nav class="nav" aria-label="Navigation principale">
                <a href="/site/home" class="nav-link active" aria-current="page">Accueil</a>
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
    <div class="mobile-menu" id="mobileMenu" role="dialog" aria-modal="true" aria-label="Menu de navigation">
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
        <!-- Hero Section -->
        <section class="hero" aria-labelledby="hero-title">
            <picture>
                <source srcset="/_assets/images/banniere_light.avif" type="image/avif">
                <source srcset="/_assets/images/banniere_light.webp" type="image/webp">
                <img src="/_assets/images/banniere_light.jpg" alt="" class="hero-bg hero-bg-light" aria-hidden="true" fetchpriority="high">
            </picture>
            <picture>
                <source srcset="/_assets/images/banniere_dark.avif" type="image/avif">
                <source srcset="/_assets/images/banniere_dark.webp" type="image/webp">
                <img src="/_assets/images/banniere_dark.jpg" alt="" class="hero-bg hero-bg-dark" aria-hidden="true" fetchpriority="high">
            </picture>
            <div class="hero-overlay" aria-hidden="true"></div>

            <div class="container">
                <h1 id="hero-title" class="hero-title">
                    Plateforme médicale <span class="text-highlight">nouvelle génération</span>
                </h1>
                <p class="hero-description">
                    MedBoard révolutionne la gestion hospitalière avec des outils intelligents, un monitoring en temps réel et une interface intuitive pensée pour les professionnels de santé.
                </p>
                <div class="hero-actions">
                    <a href="/auth/register" class="btn-primary">Créer un compte</a>
                    <a href="/auth/login" class="btn-secondary">Se connecter</a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features" aria-labelledby="features-title">
            <div class="container">
                <div class="section-header">
                    <h2 id="features-title" class="section-title">Une plateforme médicale complète</h2>
                    <p class="section-description">
                        Découvrez les fonctionnalités avancées de notre solution développée spécialement pour optimiser les flux de travail médicaux
                    </p>
                </div>

                <div class="features-grid">
                    <article class="feature-card">
                        <div class="feature-icon feature-icon-green" aria-hidden="true">
                            <img src="/_assets/images/features-1.svg" alt="">
                        </div>
                        <h3 class="feature-title">Gestion des patients</h3>
                        <p class="feature-description">
                            Centralisation complète des dossiers médicaux avec historique, allergies et traitements en cours
                        </p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon feature-icon-orange" aria-hidden="true">
                            <img src="/_assets/images/features-2.svg" alt="">
                        </div>
                        <h3 class="feature-title">Monitoring temps réel</h3>
                        <p class="feature-description">
                            Surveillance continue des signes vitaux avec alertes automatiques et tableaux de bord personnalisables
                        </p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon feature-icon-red" aria-hidden="true">
                            <img src="/_assets/images/features-3.svg" alt="">
                        </div>
                        <h3 class="feature-title">Sécurité renforcée</h3>
                        <p class="feature-description">
                            Protection optimale des données sensibles avec chiffrement et conformité aux normes médicales
                        </p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon feature-icon-blue" aria-hidden="true">
                            <img src="/_assets/images/features-4.svg" alt="">
                        </div>
                        <h3 class="feature-title">Planning intelligent</h3>
                        <p class="feature-description">
                            Gestion optimisée des rendez-vous, rotations d'équipes et disponibilités des ressources médicales
                        </p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon feature-icon-cyan" aria-hidden="true">
                            <img src="/_assets/images/features-5.svg" alt="">
                        </div>
                        <h3 class="feature-title">Collaboration médicale</h3>
                        <p class="feature-description">
                            Communication fluide entre services avec messagerie sécurisée et partage d'informations cliniques
                        </p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon feature-icon-orange" aria-hidden="true">
                            <img src="/_assets/images/features-6.svg" alt="">
                        </div>
                        <h3 class="feature-title">Analyses avancées</h3>
                        <p class="feature-description">
                            Rapports détaillés et statistiques médicales pour optimiser les soins et la gestion hospitalière
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq" aria-labelledby="faq-title">
            <div class="container-narrow">
                <div class="section-header">
                    <h2 id="faq-title" class="section-title">Questions fréquentes</h2>
                    <p class="section-description">Trouvez rapidement les réponses à vos questions</p>
                </div>

                <div class="faq-list">
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            <span>Comment s'organise le développement de notre projet R3.01 ?</span>
                            <img src="/_assets/images/fleche-bas.svg" alt="" class="faq-icon" aria-hidden="true">
                        </button>
                        <div class="faq-answer">
                            <p>Nous avons structuré notre travail en plusieurs étapes : analyse du besoin, conception de la base de données, développement front-end et back-end, puis tests et déploiement.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            <span>Où trouver les consignes officielles du rendu ?</span>
                            <img src="/_assets/images/fleche-bas.svg" alt="" class="faq-icon" aria-hidden="true">
                        </button>
                        <div class="faq-answer">
                            <p>Toutes les consignes détaillées sont accessibles dans le document fourni par l'enseignant :</p>
                            <a href="https://www.mickael-martin-nevot.com/univ-amu/iut/but-informatique/developpement-web/?:s24-projet.pdf" class="faq-link" target="_blank" rel="noopener noreferrer">Consignes du projet R3.01</a>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            <span>Quelles technologies utilisons-nous pour ce projet ?</span>
                            <img src="/_assets/images/fleche-bas.svg" alt="" class="faq-icon" aria-hidden="true">
                        </button>
                        <div class="faq-answer">
                            <p>Le projet repose sur un stack HTML, CSS, JavaScript et PHP. La base de données est en MySQL, hébergée chez Alwaysdata.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            <span>Comment gérez-vous la sécurité des données ?</span>
                            <img src="/_assets/images/fleche-bas.svg" alt="" class="faq-icon" aria-hidden="true">
                        </button>
                        <div class="faq-answer">
                            <p>Nous mettons en place une gestion stricte des comptes utilisateurs : mots de passe hachés avec Argon2id, validation des entrées côté serveur, et bonnes pratiques de protection contre les injections SQL ou XSS.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta" aria-labelledby="cta-title">
            <div class="container">
                <h2 id="cta-title" class="section-title">Prêt à commencer ?</h2>
                <p class="section-description">
                    La plateforme médicale nouvelle génération qui révolutionne la gestion des soins de santé.
                </p>
                <div class="cta-actions">
                    <a href="/auth/register" class="btn-primary">Créer un compte</a>
                    <a href="/auth/login" class="btn-secondary">Se connecter</a>
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
    <script src="/_assets/js/script.js" defer></script>
</body>
</html>
