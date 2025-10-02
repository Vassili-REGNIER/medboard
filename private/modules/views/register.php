
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bonjour – Mon Site</title>
    <meta name="description" content="Une simple page d'accueil qui dit bonjour." />
<body>
<form action="data-processing.php" method="post">
    <label for="id">Identifiant</label>
    <input name="id" type="text">
    <br>
    <strong>Civilité</strong>
    <br>
    <label for="male">Homme</label>
    <input name="male" type="radio" checked>
    <label for="female">Femme</label>
    <input name="female" type="radio">
    <br><br>
    <label for="email">E-mail</label>
    <input name="email" type="text">
    <br><br>
    <label for="password">Mot de passe</label>
    <input name="password" type="password">
    <br><br>
    <label for="check-password">Verifiez votre mot de passe</label>
    <input name="check-password" type="password">
    <br><br>
    <label for="phone-number">Téléphone</label>
    <input type="text">
    <br><br>
    <label for="country">Pays</label>
    <select name="country">
        <option>France</option>
        <option>Belgique</option>
        <option>Italie</option>
        <option>Allemagne</option>
        <option>Espagne</option>
        <option>Luxembourg</option>
        <option>Pays-Bas</option>
        <option>Autriche</option>
    </select>
    <br><br>
    <label for="general-conditions">J'accepte les conditions générales</label>
    <input type="checkbox" required>
    <br><br>
    <input type="submit" value="Soumettre" action="mailer">
</form>
</body>
</html>