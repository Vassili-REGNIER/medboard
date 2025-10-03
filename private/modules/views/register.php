<?php
// private/modules/views/register.php


?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Créer un compte</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 2rem; }
    .container { max-width: 560px; margin: 0 auto; }
    .card { border: 1px solid #ddd; border-radius: 12px; padding: 1.25rem; }
    .field { margin-bottom: 1rem; }
    label { display:block; font-weight:600; margin-bottom: .35rem; }
    input, select { width:100%; padding:.6rem .7rem; border:1px solid #bbb; border-radius:8px; font-size:1rem; }
    .row { display:grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
    .btn { display:inline-block; padding:.75rem 1rem; border-radius:10px; border:0; background:#111; color:#fff; font-weight:600; cursor:pointer; }
    .errors { background:#ffecec; border:1px solid #ffb3b3; color:#a40000; padding:.75rem; border-radius:10px; margin-bottom:1rem; }
    .help { color:#666; font-size:.9rem; margin-top:.25rem; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Inscription</h1>

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
      <form method="post" action="/auth/register/submit" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

        <div class="row">
          <div class="field">
            <label for="firstname">Prénom</label>
            <input id="firstname" name="firstname" type="text" required
                   value="<?= htmlspecialchars($old['firstname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>

          <div class="field">
            <label for="lastname">Nom</label>
            <input id="lastname" name="lastname" type="text" required
                   value="<?= htmlspecialchars($old['lastname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
        </div>

        <div class="field">
          <label for="username">Nom d’utilisateur</label>
          <input id="username" name="username" type="text" required
                 value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          <div class="help">L’identifiant de connexion (unique).</div>
        </div>

        <div class="field">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" required
                 value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="field">
          <label for="specialization">Spécialisation</label>
          <select id="specialization" name="specialization">
            <option value="">-- Aucune --</option>
            <?php
              $current = $old['specialization'] ?? '';
              foreach ($specializations as $id => $label):
                  // Ici $label est en anglais (base en minuscules) :
                  $display = ucfirst($label); // ou mapping/traduction côté vue si tu veux FR
            ?>
              <option value="<?= htmlspecialchars((string)$id, ENT_QUOTES, 'UTF-8') ?>"
                <?= ($current === (string)$id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($display, ENT_QUOTES, 'UTF-8') ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="row">
          <div class="field">
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required minlength="8">
          </div>

          <div class="field">
            <label for="password_confirm">Confirmer le mot de passe</label>
            <input id="password_confirm" name="password_confirm" type="password" required minlength="8">
          </div>
        </div>

        <div class="field">
          <button class="btn" type="submit">Créer mon compte</button>
        </div>
      </form>
    </div>

    <p class="help">En validant, vous acceptez nos conditions d’utilisation.</p>
  </div>
</body>
</html>
