<?php
declare(strict_types=1);

final class Mailer
{
    public function __construct() {
    }

    /**
     * Envoie un email (texte + HTML). Retourne true/false.
     */
    public function send(string $to, string $subject, string $htmlBody, ?string $textBody = null): bool
    {
        return true;
    }

    /**
     * Email spécialisé : lien de réinitialisation du mot de passe.
     */
    public function sendPasswordResetLink(string $to, string $resetUrl): bool
    {
        return true;
    }
}
