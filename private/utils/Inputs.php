<?php

final class Inputs
{
    /* ===============================
     *  REGEX centrales (aligne-les avec tes CHECK SQL)
     * =============================== */
    public const RE_NAME   = '/^[a-zà-öø-ÿ\' -]+$/u';
    public const RE_USER   = '/^[a-z][a-z0-9_.-]*$/';
    public const RE_EMAIL  = '/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/';
    public const RE_ARGON2 = '/^\$argon2id\$v=\d+\$m=\d+,t=\d+,p=\d+\$[A-Za-z0-9+\/=]+\$[A-Za-z0-9+\/=]+$/';

    /* ===============================
     *  Helpers génériques
     * =============================== */
    public static function collapseSpaces(string $s): string
    {
        // Remplace runs d'espaces (y compris tabs) par un simple espace
        // et supprime espaces en début/fin
        $s = preg_replace('/\s+/u', ' ', $s ?? '');
        return trim($s);
    }

    public static function sanitizeString(string $s, bool $lower = false, bool $collapseSpaces = true): string 
    {
        $s = trim($s ?? '');
        if ($collapseSpaces) {
            $s = self::collapseSpaces($s);
        }
        if ($lower) {
            $s = mb_strtolower($s, 'UTF-8');
        }
        return $s;
    }

    public static function validateLength(string $s, ?int $min = null, ?int $max = null, string $label = 'La valeur'): ?string 
    {
        $len = mb_strlen($s, 'UTF-8');
        if ($min !== null && $len < $min) {
            return "$label doit faire au moins $min caractères.";
        }
        if ($max !== null && $len > $max) {
            return "$label ne doit pas dépasser $max caractères.";
        }
        return null;
    }

    /* ===============================
     *  Name (firstname / lastname)
     * =============================== */
    public static function sanitizeName(string $s): string
    {
        // trim + lower + collapse espaces
        return self::sanitizeString($s, lower: true, collapseSpaces: true);
    }

    public static function validateName(string $s, int $max = 32, string $label = 'Le nom'): ?string
    {
        if ($s === '') return "$label est requis.";
        if ($msg = self::validateLength($s, min: null, max: $max, label: $label)) return $msg;
        if (!preg_match(self::RE_NAME, $s)) return "$label contient des caractères non autorisés.";
        return null;
    }

    /* ===============================
     *  Username
     * =============================== */
    public static function sanitizeUsername(string $s): string
    {
        return self::sanitizeString($s, lower: true, collapseSpaces: true);
    }

    public static function validateUsername(string $s, int $min = 3, int $max = 32): ?string
    {
        if ($s === '') return "Le nom d’utilisateur est requis.";
        if ($msg = self::validateLength($s, $min, $max, "Le nom d’utilisateur")) return $msg;
        if (!preg_match(self::RE_USER, $s)) {
            return "Le nom d’utilisateur doit commencer par une lettre et ne contenir que lettres, chiffres, points, tirets et underscores.";
        }
        return null;
    }

    /* ===============================
     *  Email
     * =============================== */
    public static function sanitizeEmail(string $s): string
    {
        return self::sanitizeString($s, lower: true, collapseSpaces: true);
    }

    public static function validateEmail(string $s, int $max = 254): ?string
    {
        if ($s === '') return "L’email est requis.";
        if ($msg = self::validateLength($s, min: null, max: $max, label: "L’email")) return $msg;
        if (!preg_match(self::RE_EMAIL, $s)) return "Format d’email invalide.";
        return null;
    }

    /* ===============================
     *  Spécialisation (ID entier > 0) — nullable
     * =============================== */
    public static function sanitizeIntId(?string $s): ?int
    {
        $s = trim((string)$s);
        if ($s === '') return null;
        if (!ctype_digit($s)) return null;
        $i = (int)$s;
        return $i > 0 ? $i : null;
    }

    public static function validateIntId(?int $id, string $label = 'Identifiant'): ?string
    {
        if ($id === null) return null; // nullable OK
        if ($id <= 0) return "$label invalide.";
        return null;
    }

    /* ===============================
     *  Password (plain + hash PHC)
     * =============================== */
    public static function validatePasswordMinBytes(string $plain, int $minBytes = 8): ?string
    {
        if (strlen($plain) < $minBytes) {
            return "Le mot de passe doit contenir au moins $minBytes caractères.";
        }
        return null;
    }

    /**
     * Valide qu'un mot de passe respecte les critères de sécurité :
     * - Au moins 8 caractères
     * - Une lettre majuscule
     * - Une lettre minuscule
     * - Un chiffre
     * - Un caractère spécial
     *
     * @param string $plain Le mot de passe en clair
     * @return array|null Tableau de messages d'erreur ou null si valide
     */
    public static function validatePasswordStrength(string $plain): ?array
    {
        $errors = [];

        // Au moins 8 caractères
        if (strlen($plain) < 8) {
            $errors[] = "Au moins 8 caractères";
        }

        // Au moins une lettre majuscule
        if (!preg_match('/[A-Z]/', $plain)) {
            $errors[] = "Une lettre majuscule";
        }

        // Au moins une lettre minuscule
        if (!preg_match('/[a-z]/', $plain)) {
            $errors[] = "Une lettre minuscule";
        }

        // Au moins un chiffre
        if (!preg_match('/[0-9]/', $plain)) {
            $errors[] = "Un chiffre";
        }

        // Au moins un caractère spécial
        if (!preg_match('/[^A-Za-z0-9]/', $plain)) {
            $errors[] = "Un caractère spécial";
        }

        return empty($errors) ? null : $errors;
    }

    public static function validatePasswordConfirmation(string $plain, string $confirm): ?string
    {
        if (!hash_equals($plain, $confirm)) return "Les mots de passe ne correspondent pas.";
        return null;
    }

    public static function validateArgon2idPHC(string $hash): ?string
    {
        if (!preg_match(self::RE_ARGON2, $hash)) {
            return "Le format du hash Argon2id est invalide.";
        }
        return null;
    }

    public static function sanitizeBase64UrlToken(string $s): string
    {
        // trim + suppression d'espaces invisibles
        $s = trim($s ?? '');
        // on retire les éventuels '=' de padding s'ils arrivent
        return rtrim($s, '=');
    }

    /**
     * Valide un token "base64url" (A–Z a–z 0–9 - _), longueur bornée.
     * Par défaut: 32 octets → ~43 chars en base64url (sans padding).
     */
    public static function validateBase64UrlToken(string $s, int $min = 24, int $max = 128, string $label = 'Le token'): ?string
    {
        if ($s === '') return "$label est requis.";
        if (!preg_match('/^[A-Za-z0-9\-_]+$/', $s)) return "$label a un format invalide.";
        $len = strlen($s);
        if ($len < $min || $len > $max) return "$label a une longueur invalide.";
        return null;
    }


    /* ===============================
     *  Outils ponctuels
     * =============================== */
    public static function validateRegex(string $s, string $regex, string $label = 'La valeur'): ?string
    {
        if (!preg_match($regex, $s)) return "$label a un format invalide.";
        return null;
    }
}
