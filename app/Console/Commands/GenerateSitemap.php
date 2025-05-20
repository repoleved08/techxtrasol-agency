<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use App\Models\CaseStudy;
use App\Models\Resource;
use Carbon\Carbon;
use Spatie\Sitemap\Tags\Image;
use Illuminate\Support\Facades\Schema;

class GenerateSitemap extends Command
{
    protected $signature = 'generate:sitemap';
    protected $description = 'Generate the sitemap for the website';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Static URLs
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency('weekly')
            ->setLastModificationDate(Carbon::now()));

        $sitemap->add(Url::create('/about-us')->setPriority(0.8)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/agency/our-team')->setPriority(0.7)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/agency/blog')->setPriority(0.9)->setChangeFrequency('weekly'));
        $sitemap->add(Url::create('/agency/consultation')->setPriority(0.6)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/our-resources')->setPriority(0.7)->setChangeFrequency('weekly'));
        $sitemap->add(Url::create('/our-consultation')->setPriority(0.6)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/terms-of-service')->setPriority(0.5)->setChangeFrequency('yearly'));
        $sitemap->add(Url::create('/privacy-policy')->setPriority(0.5)->setChangeFrequency('yearly'));

        // Blog posts with images
        if (Schema::hasColumn('posts', 'is_published')) {
            Post::where('is_published', true)->get()->each(function ($post) use ($sitemap) {
                $url = Url::create("/agency/blog/{$post->slug}")
                    ->setLastModificationDate($post->updated_at ?? Carbon::now())
                    ->setPriority(0.9);

                if (!empty($post->featured_image_url)) {
                    $url->addImage($post->featured_image_url);
                }

                $sitemap->add($url);
            });
        }

        // Resources
        if (Schema::hasColumn('resources', 'is_published')) {
            Resource::where('is_published', true)->get()->each(function ($resource) use ($sitemap) {
                $sitemap->add(
                    Url::create("/resources/{$resource->slug}")
                        ->setLastModificationDate($resource->updated_at ?? Carbon::now())
                        ->setPriority(0.7)
                );
            });
        }

        // Case studies
        CaseStudy::all()->each(function ($caseStudy) use ($sitemap) {
            $url = Url::create("/case-studies/{$caseStudy->slug}")
                ->setLastModificationDate($caseStudy->updated_at ?? Carbon::now())
                ->setPriority(0.8);

            if ($caseStudy->featured_image) {
                $url->addImage($caseStudy->image_url);
            }

            $sitemap->add($url);
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('✅ Sitemap generated successfully!');
    }
}
