<?php
declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class UserModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getPdo();
    }

    /**
     * Retourne l'ID de spécialisation (table `specializations`) correspondant
     * au nom exact (stocké en minuscules dans la DB). Renvoie null si introuvable.
     * On normalise par sécurité (trim + lower), même si le contrôleur le fait déjà.
     */
    public function getSpecializationIdByName(string $name): ?int
    {
        $normalized = mb_strtolower(trim($name), 'UTF-8');

        if ($normalized === '') {
            return null;
        }

        $sql = 'SELECT specialization_id
                FROM specializations
                WHERE name_en = :name
                LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':name' => $normalized]);
        $id = $stmt->fetchColumn();

        return $id !== false ? (int) $id : null;
    }

    /**
     * Récupère un utilisateur à partir d'un login (email OU username).
     * Retourne: ['user_id','firstname','lastname','username','password_hash','email','specialization_id'] ou null
     */
    public function findByLogin(string $login): ?array
    {
        $sql = "SELECT user_id, firstname, lastname, username, password_hash, email, specialization_id
                FROM users
                WHERE email = :login OR username = :login
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /**
     * Met à jour le hash si nécessaire (durcissement Argon2id).
     */
    public function maybeRehashPassword(int $userId, string $plainPassword, string $currentHash): void
    {
        $opts = [
            'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
            'time_cost'   => PASSWORD_ARGON2_DEFAULT_TIME_COST,
            'threads'     => PASSWORD_ARGON2_DEFAULT_THREADS,
        ];

        if (!password_needs_rehash($currentHash, PASSWORD_ARGON2ID, $opts)) {
            return;
        }

        $newHash = password_hash($plainPassword, PASSWORD_ARGON2ID, $opts);

        $upd = $this->pdo->prepare("UPDATE users SET password_hash = :h WHERE user_id = :id");
        $upd->execute([':h' => $newHash, ':id' => $userId]);
    }

    /**
     * Vérifie si un username existe déjà.
     */
    public function isUsernameTaken(string $username): bool
    {
        $sql = 'SELECT 1 FROM users WHERE username = :u LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':u' => $username]);
        return (bool) $stmt->fetchColumn();
    }

    /**
     * Vérifie si un email existe déjà.
     */
    public function isEmailTaken(string $email): bool
    {
        $sql = 'SELECT 1 FROM users WHERE email = :e LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':e' => $email]);
        return (bool) $stmt->fetchColumn();
    }

    /**
     * Crée l’utilisateur et renvoie son user_id.
     * Attend un tableau $data avec les clés :
     *  - firstname, lastname, username, password_hash, email
     *  - specialization_id (nullable)
     */
    public function createUser(array $data)
    {
        $sql = <<<SQL
            INSERT INTO users (firstname, lastname, username, password_hash, email, specialization_id)
            VALUES (:firstname, :lastname, :username, :password_hash, :email, :specialization_id)
            RETURNING user_id
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':firstname'         => $data['firstname'],
            ':lastname'          => $data['lastname'],
            ':username'          => $data['username'],
            ':password_hash'     => $data['password_hash'],
            ':email'             => $data['email'],
            ':specialization_id' => $data['specialization_id'] ?? null,
        ]);

        return $stmt->fetchColumn(); // user_id
    }
}
