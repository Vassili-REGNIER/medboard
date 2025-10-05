<?php
declare(strict_types=1);

final class Database
{
    private $pdo = null;

    public function __construct(
        ?string $host = null,
        ?int    $port = null,
        ?string $dbName = null,
        ?string $user = null,
        ?string $pass = null,
        ?string $charset = null,
        array $options = []
    ) {
        $host    = $host    ?? DB_HOST;
        $port    = $port    ?? DB_PORT;
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

        // DSN PostgreSQL
        $dsn = sprintf(
            'pgsql:host=%s;port=%d;dbname=%s',
            $host,
            $port,
            $dbName
        );

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            error_log('DB connection error: ' . $e->getMessage());
            throw new RuntimeException('Erreur de connexion à la base de données.');
        }
    }

    public function getPdo(): PDO
    {
        if (!$this->pdo instanceof PDO) {
            throw new RuntimeException('PDO non initialisé.');
        }
        return $this->pdo;
    }
}
