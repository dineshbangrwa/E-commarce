<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Product;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'generate:sitemap';

    protected $description = 'Generate sitemap.xml for the site';

    public function handle()
    {
        $languages = ['en', 'hi', 'es', 'fr']; // अपनी supported language codes डालें

        $sitemap = Sitemap::create();

        // Home page for all languages
        foreach ($languages as $lang) {
            $sitemap->add(Url::create(route('lang.index', ['lang' => $lang])));
            $sitemap->add(Url::create(route('contact', ['lang' => $lang])));
            // add other static pages similarly
        }

        // Products URLs for all languages
        $products = Product::all();
        foreach ($products as $product) {
            foreach ($languages as $lang) {
                $sitemap->add(Url::create(route('product.detail', ['lang' => $lang, 'url_key' => $product->url_key])));
            }
        }

        // Pages URLs for all languages
        $pages = Page::all();
        foreach ($pages as $page) {
            foreach ($languages as $lang) {
                $sitemap->add(Url::create(route('page', ['lang' => $lang, 'url_key' => $page->url_key])));
            }
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
