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
    protected $signature = 'create:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(Router $router)
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
        SitemapFacade::create(file_type: 'json', file_path: public_path(), sitemap_data: $routes);
    }
}
