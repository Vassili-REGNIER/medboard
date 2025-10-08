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
    
    <?php 
    // Header
    if (Auth::check()) {
        require __DIR__ ."/partials/header_user.php";
    } else {
        require __DIR__ ."/partials/header_guest.php";
    }
    ?>

    <main>
        <div class="dashboard-hero">
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <p class="dashboard-greeting">
                        Bonjour, <?= htmlspecialchars($prenom) ?> <?= htmlspecialchars($nom) ?>
                    </p>

                    <?php if (!empty($specialization)) : ?>
                        <p class="dashboard-specialization">
                            <?= htmlspecialchars($specialization) ?>
                        </p>
                    <?php endif; ?>
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

    <?php
        // Footer
        require __DIR__ ."/partials/footer.php";
    ?>

</body>
</html>
