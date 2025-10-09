<?php
declare(strict_types=1);

final class RememberTokenModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getPdo();
    }

    /**
     * Crée un nouveau token de "remember me".
     * 
     * @param array $data [
     *   'user_id'         => int,
     *   'selector'        => string,
     *   'validator_hash'  => string,
     *   'expires_at'      => string (Y-m-d H:i:s),
     *   'user_agent_hash' => string,
     *   'created_at'      => string (Y-m-d H:i:s)
     * ]
     * @return int ID du token créé
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO remember_tokens (
                    user_id,
                    selector,
                    validator_hash,
                    expires_at,
                    user_agent_hash,
                    created_at
                ) VALUES (
                    :user_id,
                    :selector,
                    :validator_hash,
                    :expires_at,
                    :user_agent_hash,
                    :created_at
                )
                RETURNING remember_token_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id'         => $data['user_id'],
            ':selector'        => $data['selector'],
            ':validator_hash'  => $data['validator_hash'],
            ':expires_at'      => $data['expires_at'],
            ':user_agent_hash' => $data['user_agent_hash'],
            ':created_at'      => $data['created_at'],
        ]);

        return (int)$stmt->fetchColumn();
    }

    /**
     * Supprime tous les tokens associés à un utilisateur.
     */
    public function deleteForUser(int $userId): void
    {
        $sql = "DELETE FROM remember_tokens WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
    }

    /**
     * Supprime un token spécifique par son selector.
     */
    public function deleteBySelector(string $selector): void
    {
        $sql = "DELETE FROM remember_tokens WHERE selector = :selector";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':selector' => $selector]);
    }

    /**
     * Recherche un token valide à partir du selector (non expiré).
     * 
     * @return array|null
     */
    public function findValidBySelector(string $selector): ?array
    {
        $sql = "SELECT remember_token_id,
                       user_id,
                       selector,
                       validator_hash,
                       expires_at,
                       user_agent_hash,
                       created_at
                  FROM remember_tokens
                 WHERE selector = :selector
                   AND expires_at > NOW()
                 LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':selector' => $selector]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    /**
     * Nettoie les anciens tokens expirés (entretien périodique).
     */
    public function deleteExpired(): void
    {
        $sql = "DELETE FROM remember_tokens WHERE expires_at <= NOW()";
        $this->pdo->exec($sql);
    }
}
