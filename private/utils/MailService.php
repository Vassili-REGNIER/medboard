<?php
declare(strict_types=1);

require_once BASE_PATH . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once BASE_PATH . '/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once BASE_PATH . '/vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

final class MailService
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        // Configuration SMTP — à adapter selon ton compte AlwaysData
        $this->mail->isSMTP();
        $this->mail->Host       = SMTP_HOST;
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = SMTP_USERNAME;
        $this->mail->Password   = SMTP_PASSWORD;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;

        // Réglages de base
        $this->mail->CharSet = 'UTF-8';
        $this->mail->isHTML(true);
        $this->mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
    }

    /**
     * Envoie un e-mail simple (HTML + texte alternatif)
     */
    public function send(
        string $to,
        string $subject,
        string $htmlBody,
        string $textBody = ''
    ): bool {
        try {
            $this->mail->clearAllRecipients();
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $htmlBody;
            $this->mail->AltBody = $textBody ?: strip_tags($htmlBody);
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            // Log interne si besoin
            error_log('MailService error: ' . $e->getMessage());
            return false;
        }
    }
}
