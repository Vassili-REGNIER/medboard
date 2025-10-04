<?php
final class Http {
    public static function redirect(string $url): never {
        header('Location: ' . $url, true, 302);
        exit;
    }
}
