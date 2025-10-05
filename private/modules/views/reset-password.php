<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Réinitialiser le mot de passe</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif;margin:0;color:#222}
    .wrap{max-width:520px;margin:6rem auto;padding:0 1rem}
    h1{font-size:1.5rem;margin:0 0 1rem}
    form{border:1px solid #e5e5e5;border-radius:.75rem;padding:1rem}
    label{display:block;font-weight:600;margin:.5rem 0 .25rem}
    input[type=password]{width:100%;padding:.625rem .75rem;border:1px solid #e5e5e5;border-radius:.5rem;font-size:1rem}
    .row{margin-bottom:.75rem}
    .actions{margin-top:1rem}
    button{border:none;background:#0a7;color:#fff;padding:.7rem 1rem;border-radius:.5rem;font-weight:700;cursor:pointer}
    .notice{margin:0 0 1rem;padding:.75rem 1rem;border-radius:.5rem}
    .notice.success{background:#e8fbf5;border:1px solid #b9f1df;color:#055}
    .notice.error{background:#fceaea;border:1px solid #f3c2c2;color:#621}
    .err{color:#c33;font-size:.925rem;margin:.25rem 0 0}
    .muted{color:#666;font-size:.9rem}
  </style>
</head>
<body>
  <main class="wrap" role="main">
    <h1>Définir un nouveau mot de passe</h1>

    <?php if (!empty($success)): ?>
      <div class="notice success" role="status">
        <?= htmlspecialchars(is_array($success) ? implode(' ', $success) : $success, ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($errors['global'])): ?>
      <div class="notice error" role="alert">
        <?= htmlspecialchars(is_array($errors['global']) ? implode(' ', $errors['global']) : $errors['global'], ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <form method="post" action="/auth/reset-password" novalidate>
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
      <input type="hidden" name="token" value="<?= htmlspecialchars((string)($token ?? ''), ENT_QUOTES, 'UTF-8') ?>">
      <input type="hidden" name="uid"   value="<?= htmlspecialchars((string)($uid ?? ''),   ENT_QUOTES, 'UTF-8') ?>">

      <div class="row">
        <label for="password">Nouveau mot de passe</label>
        <input type="password" id="password" name="password" required minlength="8" autocomplete="new-password">
        <?php if (!empty($errors['password'])): ?>
          <p class="err" role="alert">
            <?= htmlspecialchars(is_array($errors['password']) ? implode(' ', $errors['password']) : $errors['password'], ENT_QUOTES, 'UTF-8') ?>
          </p>
        <?php endif; ?>
      </div>

      <div class="row">
        <label for="password_confirm">Confirmer le mot de passe</label>
        <input type="password" id="password_confirm" name="password_confirm" required minlength="8" autocomplete="new-password">
        <?php if (!empty($errors['password_confirm'])): ?>
          <p class="err" role="alert">
            <?= htmlspecialchars(is_array($errors['password_confirm']) ? implode(' ', $errors['password_confirm']) : $errors['password_confirm'], ENT_QUOTES, 'UTF-8') ?>
          </p>
        <?php endif; ?>
      </div>

      <div class="actions">
        <button type="submit">Réinitialiser</button>
        <p class="muted">Le lien est valable 30 minutes. Après validation, tu pourras te connecter.</p>
      </div>
    </form>
  </main>
</body>
</html>
