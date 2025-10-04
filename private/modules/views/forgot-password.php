<?php
// private/modules/views/forgot-password.php
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Mot de passe oublié</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 2rem; }
    .container { max-width: 480px; margin: 0 auto; }
    .card { border: 1px solid #ddd; border-radius: 12px; padding: 1.25rem; }
    .field { margin-bottom: 1rem; }
    label { display:block; font-weight:600; margin-bottom: .35rem; }
    input { width:100%; padding:.6rem .7rem; border:1px solid #bbb; border-radius:8px; font-size:1rem; }
    .btn { display:inline-block; padding:.75rem 1rem; border-radius:10px; border:0; background:#111; color:#fff; font-weight:600; cursor:pointer; }
    .errors { background:#ffecec; border:1px solid #ffb3b3; color:#a40000; padding:.75rem; border-radius:10px; margin-bottom:1rem; }
    .help { color:#666; font-size:.9rem; margin-top:.25rem; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Mot de passe oublié</h1>

    <?php if (!empty($errors)): ?>
      <div class="errors">
        <ul style="margin:0; padding-left: 1.2rem;">
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="card">
      <form method="post" action="/auth/forgot-password" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

        <div class="field">
          <label for="email">Votre adresse email</label>
          <input id="email" name="email" type="email" required
                 value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="field">
          <button class="btn" type="submit">Envoyer le lien de réinitialisation</button>
        </div>
      </form>
    </div>

    <p class="help">
      <a href="/auth/login">Retour à la connexion</a>
    </p>
  </div>
</body>
</html>
