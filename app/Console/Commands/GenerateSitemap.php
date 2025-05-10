<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use App\Models\CaseStudy;
use App\Models\Resource;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    protected $signature = 'generate:sitemap';
    protected $description = 'Generate the sitemap for the website';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Static URLs
        $sitemap->add(Url::create('/'));
        $sitemap->add(Url::create('/dashboard'));
        $sitemap->add(Url::create('/about-us'));
        $sitemap->add(Url::create('/agency/our-team'));
        $sitemap->add(Url::create('/agency/blog'));
        $sitemap->add(Url::create('/agency/consultation'));
        $sitemap->add(Url::create('/resources'));

        // Blog posts
        Post::where('is_published', true)->get()->each(function ($post) use ($sitemap) {
            $sitemap->add(
                Url::create("/agency/blog/{$post->slug}")
                    ->setLastModificationDate($post->updated_at ?? Carbon::now())
            );
        });

        // Resources
        Resource::where('is_published', true)->get()->each(function ($resource) use ($sitemap) {
            $sitemap->add(
                Url::create("/resources/{$resource->slug}")
                    ->setLastModificationDate($resource->updated_at ?? Carbon::now())
            );
        });

        // Case studies
        CaseStudy::all()->each(function ($caseStudy) use ($sitemap) {
            $sitemap->add(
                Url::create("/case-studies/{$caseStudy->slug}")
                    ->setLastModificationDate($caseStudy->updated_at ?? Carbon::now())
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('✅ Sitemap generated and saved to public/sitemap.xml');
    }
}
