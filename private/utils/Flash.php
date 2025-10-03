<?php
final class Flash {
    public static function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }
    public static function get(string $key, mixed $default = null): mixed {
        return $_SESSION[$key] ?? $default;
    }
    public static function consume(string $key, mixed $default = null): mixed {
        $val = $_SESSION[$key] ?? $default;
        unset($_SESSION[$key]);
        return $val;
    }
    public static function consumeMany(array $keys): array {
        $out = [];
        foreach ($keys as $k) { $out[$k] = self::consume($k); }
        return $out;
    }
}
