<?php
declare(strict_types=1);

final class PasswordsController
{
    private UserModel $userModel ;
    private PasswordResetModel $passwordResetModel ;

    public function __construct()
    {
        $this->userModel  = new UserModel();
        $this->passwordResetModel = new PasswordResetModel();
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            return $this->store();
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') 
        {
            return $this->create();
        }
        http_response_code(405);
        return ['Méthode non autorisée.'];
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            return $this->update();
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') 
        {
            return $this->edit();
        }
        else
        http_response_code(405);
        return ['Méthode non autorisée.'];
    }

    public function create()
    {
        Auth::requireGuest();
        [$old, $errors, $success] = array_values(Flash::consumeMany(['old','errors','success']));
        require dirname(__DIR__) . '/views/forgot-password.php';
    }

    public function store()
    {
        Auth::requireGuest();
        Csrf::requireValid('/auth/forgot-password', true);

        // 1) Inputs
        $email = Inputs::sanitizeEmail($_POST['email'] ?? '');

        // Conserver pour la vue
        Flash::set('old', ['email' => $email]);

        // 2) Validation
        $errors = [];
        if ($msg = Inputs::validateEmail($email)) {
            $errors['email'] = $msg;
        }

        if ($errors) {
            Flash::set('errors', $errors);
            Http::redirect('/auth/forgot-password');
            return;
        }

        // 3) Recherche utilisateur (ne révèle jamais si l’email existe)
        $user = $this->userModel->findByLogin($email); // à implémenter si absent : retourne array|false

        // 4) Toujours répondre comme si tout s’était bien passé (anti-enum)
        $publicSuccessMsg = 'Si un compte existe pour cette adresse, un e-mail a été envoyé avec un lien de réinitialisation.';

        if (!$user) {
            Flash::set('success', $publicSuccessMsg);
            Http::redirect('/auth/forgot-password');
            return;
        }

        // 5) Génération du token + persistence
        $plainToken = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '='); // URL-safe
        $tokenHash  = hash('sha256', $plainToken);
        $expiresAt  = (new DateTimeImmutable('+30 minutes'))->format('Y-m-d H:i:s');

        // Optionnel : invalider les anciens tokens de cet utilisateur
        $this->passwordResetModel->invalidateForUser((int)$user['user_id']);
        $resetId = $this->passwordResetModel->create([
            'user_id'    => (int)$user['user_id'],
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt,
            'created_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
        ]);

        if (!$resetId) {
            Flash::set('errors', ['global' => 'Une erreur est survenue. Merci de réessayer.']);
            Http::redirect('/auth/forgot-password');
            return;
        }

        // 6) Construction du lien
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $uid    = (int)$user['user_id'];

        $resetLink = sprintf(
            '%s://%s/auth/reset-password?token=%s&uid=%d',
            $scheme,
            $host,
            $plainToken,
            $uid
        );

        // 7) Envoi e-mail via un service
        try {
            $mailer = new MailService();
            $subject = 'Réinitialisation de votre mot de passe';
            $html = <<<HTML
                <p>Bonjour,</p>
                <p>Vous avez demandé la réinitialisation de votre mot de passe. 
                Cliquez sur le lien ci-dessous (valable 30 minutes) :</p>
                <p><a href="{$resetLink}">Réinitialiser mon mot de passe</a></p>
                <p>Si vous n’êtes pas à l’origine de cette demande, vous pouvez ignorer cet e-mail.</p>
            HTML;

            $text = "Bonjour,\n\n".
                    "Pour réinitialiser votre mot de passe (valable 30 minutes), suivez ce lien :\n".
                    $resetLink."\n\n".
                    "Si vous n’êtes pas à l’origine de cette demande, ignorez cet e-mail.";

            $mailer->send(to: $email, subject: $subject, htmlBody: $html, textBody: $text);
            Flash::set('success', $publicSuccessMsg);
        } catch (Throwable $e) {
            error_log($e->getMessage());
            Flash::set('success', $publicSuccessMsg);
        }

        // 8) Redirect
        Http::redirect('/auth/forgot-password');
        return;
    }

    public function edit()
    {
        Auth::requireGuest();

        // Sanitize/validate du token et de l’uid via Inputs
        $token = Inputs::sanitizeBase64UrlToken($_GET['token'] ?? '');
        $uid   = Inputs::sanitizeIntId($_GET['uid'] ?? '');

        $errors = [];
        if ($msg = Inputs::validateBase64UrlToken($token, min: 24, max: 128, label: 'Le lien')) {
            $errors['token'] = $msg;
        }
        if ($msg = Inputs::validateIntId($uid, 'Utilisateur')) {
            $errors['uid'] = $msg;
        }

        if ($errors) {
            Flash::set('errors', $errors);
        }

        [$old, $errs, $success] = array_values(Flash::consumeMany(['old','errors','success']));
        require dirname(__DIR__) . '/views/reset-password.php'; // La vue connait $token et $uid
    }

    public function update()
    {
        Auth::requireGuest();
        Csrf::requireValid('/auth/reset-password', true);

        // 1) Récup + sanitize
        $token = Inputs::sanitizeBase64UrlToken($_POST['token'] ?? '');
        $uid   = Inputs::sanitizeIntId($_POST['uid'] ?? '');
        $pwd   = (string)($_POST['password'] ?? '');
        $pwd2  = (string)($_POST['password_confirm'] ?? '');

        // Conserver valeurs utiles pour la vue (jamais le mot de passe)
        Flash::set('old', ['uid' => $uid]);

        // 2) Validation ciblée
        $errors = [];
        if ($msg = Inputs::validateBase64UrlToken($token, min: 24, max: 128, label: 'Le lien')) {
            $errors['token'] = $msg;
        }
        if ($msg = Inputs::validateIntId($uid, 'Utilisateur')) {
            $errors['uid'] = $msg;
        }
        if ($msg = Inputs::validatePasswordMinBytes($pwd, 8)) {
            $errors['password'] = $msg;
        }
        if ($msg = Inputs::validatePasswordConfirmation($pwd, $pwd2)) {
            $errors['password_confirm'] = $msg;
        }

        if ($errors) {
            Flash::set('errors', $errors);
            Http::redirect('/auth/reset-password?token='.urlencode($token).'&uid='.(int)$uid);
            return;
        }

        // 3) Vérification du token côté modèle (hash en DB + expiration + non utilisé)
        $resetRow = $this->passwordResetModel->findValidByUidAndToken((int)$uid, $token);

        if (!$resetRow) {
            Flash::set('errors', ['global' => 'Lien de réinitialisation invalide ou expiré.']);
            Http::redirect('/auth/reset-password?token='.urlencode($token).'&uid='.(int)$uid);
            return;
        }

        // 4) Hash du nouveau mot de passe
        $hash = password_hash($pwd, PASSWORD_ARGON2ID);
        if ($hash === false || ($msg = Inputs::validateArgon2idPHC($hash))) {
            // log éventuel
            Flash::set('errors', ['global' => 'Erreur interne lors du hachage du mot de passe.']);
            Http::redirect('/auth/reset-password?token='.urlencode($token).'&uid='.(int)$uid);
            return;
        }

        // 5) Mise à jour du mot de passe + invalidation du token
        try {
            $this->userModel->updatePassword((int)$uid, $hash);
            $this->passwordResetModel->markUsedById((int)$resetRow['id']); // set used_at = NOW()
            Flash::set('success', 'Votre mot de passe a été réinitialisé. Vous pouvez vous connecter.');
            Http::redirect('/auth/login');
            return;
        } catch (Throwable $e) {
            // log éventuel
            Flash::set('errors', ['global' => 'Erreur interne lors de la mise à jour du mot de passe.']);
            Http::redirect('/auth/reset-password?token='.urlencode($token).'&uid='.(int)$uid);
            return;
        }
    }
}
