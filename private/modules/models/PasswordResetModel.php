<?php
final class PasswordResetModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getPdo();
    }

    public function create(array $data): ?int
    {
        $sql = 'INSERT INTO password_resets (user_id, token_hash, expires_at, created_at)
                VALUES (:user_id, :token_hash, :expires_at, :created_at)
                RETURNING user_id';
        $stmt = $this->pdo->prepare($sql);
        if (!$stmt->execute([
            ':user_id'    => $data['user_id'],
            ':token_hash' => $data['token_hash'],
            ':expires_at' => $data['expires_at'],
            ':created_at' => $data['created_at'],
        ])) {
            return null;
        }
        return (int)$stmt->fetchColumn();
    }

    public function invalidateForUser(int $userId): void
    {
        // Marque comme utilisés/expirés tous les anciens tokens encore actifs
        $sql = 'UPDATE password_resets
                   SET used_at = now()
                 WHERE user_id = :uid AND used_at IS NULL';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':uid' => $userId]);
    }

    public function findValidByUidAndToken(int $userId, string $plainToken): ?array
    {
        // Pour la méthode reset ultérieure : on re-hash et on cherche le hash
        $hash = hash('sha256', $plainToken);
        $sql = 'SELECT * FROM password_resets
                 WHERE user_id = :uid
                   AND token_hash = :hash
                   AND used_at IS NULL
                   AND expires_at > now()
                 ORDER BY id DESC
                 LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':uid' => $userId, ':hash' => $hash]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function markUsedById(int $id): void
    {
        $stmt = $this->pdo->prepare('UPDATE password_resets SET used_at = now() WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
