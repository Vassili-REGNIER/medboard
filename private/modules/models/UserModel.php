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
     * Récupère un utilisateur à partir d'un login (email OU username).
     * Retourne: ['id','email','username','password_hash','role','is_active'] ou null
     */
    public function findByLogin(string $login): ?array
    {
        $sql = "SELECT user_id, firstname, lastname, username, password_hash, email, specialization
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
        $upd = $this->pdo->prepare("UPDATE users SET password_hash = :h WHERE id = :id");
        $upd->execute([':h' => $newHash, ':id' => $userId]);
    }
}
