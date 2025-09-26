<?php
// ~/private/db.php
require_once __DIR__ . '/../../config/config.php';

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,     // erreurs en exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // fetch par défaut
    ]);
} catch (PDOException $e) {
    // En production, éviter d’afficher le message exact
    error_log("DB connection error: " . $e->getMessage());
    die("Erreur de connexion à la base de données.");
}
