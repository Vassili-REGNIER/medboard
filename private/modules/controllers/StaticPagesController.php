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

    public function about(): void
    {
        require __DIR__ . '/../views/about.php';
    }

}
