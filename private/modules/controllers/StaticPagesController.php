<?php
final class StaticPagesController
{
    public function home(): void
    {
        require __DIR__ . '/../views/home.php';
    }

    public function sitemap(): void
    {
        require __DIR__ . '/../views/sitemap.php';
    }

    public function legal(): void
    {
        require __DIR__ . '/../views/legal.php';
    }

    public function privacy(): void
    {
        require __DIR__ . '/../views/privacy.php';
    }

    public function notFound(): void
    {
        require __DIR__ . '/../views/not-found.php';
    }
}
