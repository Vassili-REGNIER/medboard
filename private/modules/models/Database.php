<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';

final class Database
{
    /** @var PDO|null */
    private $pdo = null;

    /**
     * Tu peux surcharger les paramètres si besoin (tests, CLI, etc.)
     */
    public function __construct(
        ?string $host = null,
        ?string $dbName = null,
        ?string $user = null,
        ?string $pass = null,
        ?string $charset = null,
        array $options = []
    ) {
        // Valeurs par défaut depuis config.php (DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET)
        $host    = $host    ?? DB_HOST;
        $dbName  = $dbName  ?? DB_NAME;
        $user    = $user    ?? DB_USER;
        $pass    = $pass    ?? DB_PASS;
        $charset = $charset ?? DB_CHARSET;

        // Options PDO par défaut (sécurisées)
        $defaultOptions = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $options = $options + $defaultOptions;

        // Connexion paresseuse: on ne tente la connexion que maintenant
        $dsn = sprintf('pgsql:host=%s;dbname=%s;charset=%s', $host, $dbName, $charset);

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            // En production, ne jamais afficher l'erreur brute
            error_log('DB connection error: ' . $e->getMessage());
            // On relance une exception générique si tu préfères la gérer plus haut
            throw new RuntimeException('Erreur de connexion à la base de données.');
        }
    }

    /**
     * Retourne l’instance PDO prête à l’emploi.
     */
    public function getPdo(): PDO
    {
        if (!$this->pdo instanceof PDO) {
            throw new RuntimeException('PDO non initialisé.');
        }
        return $this->pdo;
    }
}
