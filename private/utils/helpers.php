<?php

require __DIR__ . '/../config/config.php';

/** ==================== Helpers nav ==================== */

function redirect(string $url): never {
    header('Location: ' . $url, true, 302);
    exit;
}

/** ==================== Helpers auth ==================== */

function isLoggedIn(): bool {
    return !empty($_SESSION['user_id']);
}
function guardAuth(): void {
    if (!isLoggedIn()) {
        redirect('/auth/login');
    }
}