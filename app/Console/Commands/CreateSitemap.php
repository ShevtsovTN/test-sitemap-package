<?php

namespace App\Console\Commands;

use App\Dto\SitemapDataDto;
use Exception;
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
    protected $signature = 'create:sitemap {file_type} {file_path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a sitemap file in one of three extensions';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        $dirname = dirname($this->argument('file_path'));
        if (!is_dir($dirname) && !is_file($this->argument('file_path'))) {
            try {
                mkdir($dirname);
            } catch (Exception $e) {
                throw new Exception('Directory creating failure.', 400);
            }
        }
        $routes = SitemapDataDto::getFromStorage();
        SitemapFacade::create(
            file_type: $this->argument('file_type'),
            file_path: $dirname,
            sitemap_data: $routes->routes
        );
    }
}
