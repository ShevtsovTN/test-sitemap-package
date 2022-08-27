<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Router;
use Sitemap\SitemapFacade;

class CreateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:sitemap {file_type} {file_path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a sitemap file in one of three extensions';

    /**
     * Execute the console command.
     *
     * @param Router $router
     * @return void
     */
    public function handle(Router $router): void
    {
        $routes = collect($router->getRoutes())->map(function ($route) {
            if ($route->methods[0] == 'GET') {
                return [
                    'loc' => $route->uri(),
                    'lastmod' => date('Y-m-d'),
                    'priority' => 1,
                    'changefreq' => 'hourly'
                ];
            }
        })->filter()->all();
        SitemapFacade::create(file_type: $this->argument('file_type'), file_path: $this->argument('file_path')?? public_path(), sitemap_data: $routes);
    }
}
