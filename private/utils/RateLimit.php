<?php
declare(strict_types=1);

final class RateLimit
{
    /**
     * Vérifie si l'IP a dépassé la limite de tentatives
     *
     * @param string $action Identifiant de l'action (login, register, etc.)
     * @param int $maxAttempts Nombre maximum de tentatives
     * @param int $windowSeconds Fenêtre de temps en secondes
     * @return bool true si autorisé, false si bloqué
     */
    public static function check(string $action, int $maxAttempts = 5, int $windowSeconds = 900): bool
    {
        $ip = self::getClientIp();
        $key = "ratelimit_{$action}_{$ip}";

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['count' => 0, 'reset_at' => time() + $windowSeconds];
        }

        $data = $_SESSION[$key];

        // Reset si la fenêtre est expirée
        if (time() > $data['reset_at']) {
            $_SESSION[$key] = ['count' => 1, 'reset_at' => time() + $windowSeconds];
            return true;
        }

        // Incrémenter le compteur
        $_SESSION[$key]['count']++;

        // Vérifier la limite
        if ($_SESSION[$key]['count'] > $maxAttempts) {
            return false; // Bloqué
        }

        return true;
    }

    /**
     * Réinitialise le compteur pour une action (après succès)
     */
    public static function reset(string $action): void
    {
        $ip = self::getClientIp();
        $key = "ratelimit_{$action}_{$ip}";
        unset($_SESSION[$key]);
    }

    /**
     * Récupère l'IP du client (compatible proxy AlwaysData)
     */
    private static function getClientIp(): string
    {
        // AlwaysData utilise X-Forwarded-For
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ips[0]);
        }
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * Récupère le temps restant avant reset (en secondes)
     */
    public static function getRemainingTime(string $action): int
    {
        $ip = self::getClientIp();
        $key = "ratelimit_{$action}_{$ip}";

        if (!isset($_SESSION[$key])) {
            return 0;
        }

        return max(0, $_SESSION[$key]['reset_at'] - time());
    }
}