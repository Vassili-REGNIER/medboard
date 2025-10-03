<?php
declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class SpecializationModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getPdo();
    }

    /**
     * Vérifie l'existence d'une spécialisation par son ID.
     */
    public function existsById(int $id): bool
    {
        $sql = 'SELECT 1 FROM specializations WHERE specialization_id = :id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return (bool)$stmt->fetchColumn();
    }

    /**
     * Retourne la liste des spécialisations (id + libellé), triée par nom.
     * Format: [['specialization_id' => 1, 'name_en' => 'cardiology'], ...]
     */
    public function getAll(): array
    {
        $sql  = "SELECT specialization_id, name_en
                 FROM specializations
                 ORDER BY name_en ASC";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows ?: [];
    }

    /**
     * (Optionnel) Retourne un tableau associatif id => label.
     * Utile pour un <select>.
     */
    public function getPairs(): array
    {
        $pairs = [];
        foreach ($this->getAll() as $row) {
            $pairs[(string)$row['specialization_id']] = (string)$row['name_en'];
        }
        return $pairs;
    }
}
