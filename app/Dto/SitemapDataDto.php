<?php

namespace App\Dto;

use Illuminate\Support\Collection;

class SitemapDataDto
{
    public Collection $routes;

    public function __construct()
    {
        $this->routes = collect(config('sitemap.data'));
    }

    public static function getFromStorage(): SitemapDataDto
    {
        return new self();
    }
}
