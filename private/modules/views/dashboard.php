<?php
// private/modules/views/index.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 2rem; }
        .container { max-width: 720px; margin: 0 auto; }
        .btn-logout {
            display:inline-block; padding:.6rem 1rem; border-radius:8px;
            border:0; background:#c62828; color:#fff; font-weight:600;
            cursor:pointer; margin-top:1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tableau de bord</h1>
        <p>Bienvenue <?= htmlspecialchars($_SESSION['user']['firstname'] ?? 'Utilisateur', ENT_QUOTES, 'UTF-8') ?> !</p>

        <!-- Formulaire de déconnexion sécurisé -->
        <form method="post" action="/auth/logout" style="display:inline;">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
            <button type="submit" class="btn-logout">Se déconnecter</button>
        </form>
    </div>
</body>
</html>
