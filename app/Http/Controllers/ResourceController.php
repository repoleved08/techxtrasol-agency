<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $query = Resource::query()
            ->with(['category', 'user'])
            ->when($request->input('category'), function ($query, $category) {
                $query->whereHas('category', fn($q) => $q->where('slug', $category));
            })
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%")
                      ->orWhere('body', 'like', "%{$search}%");
                });
            });

        // Check if the published scope exists
        if (method_exists(Resource::class, 'scopePublished')) {
            $query->published();
        } else {
            $query->where('is_published', true)
                  ->where('published_at', '<=', now());
        }

        $resources = $query->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        // Prepare meta data for the resources index page
        $meta = [
            'title' => 'Resources | TechXtraSol',
            'description' => 'Browse our collection of valuable resources, guides, and tools to help you succeed.',
            'image' => asset('images/resources-default-og.jpg'),
            'url' => url()->current(),
            'type' => 'website',
        ];

        return Inertia::render('Resources/Index', [
            'resources' => $resources,
            'categories' => ResourceCategory::orderBy('order')->get(),
            'filters' => $request->only(['category', 'search']),
            'meta' => $meta,
        ]);
    }

    public function show(Request $request, $slug)
    {
        $resource = Resource::where('slug', $slug)
            ->with(['category', 'user'])
            ->firstOrFail();

        // Check if the resource is published or if the user has permission to view unpublished resources
        if (!$resource->is_published && !$request->user()?->can('view', $resource)) {
            abort(404);
        }

        // Clean and prepare meta data
        $rawExcerpt = strip_tags($resource->excerpt);
        $cleanExcerpt = Str::limit($rawExcerpt, 160);
        $metaDescription = $resource->meta_description ? strip_tags($resource->meta_description) : $cleanExcerpt;

        // Ensure title is clean and decoded
        $metaTitle = $resource->meta_title ? html_entity_decode(strip_tags($resource->meta_title))
            : html_entity_decode(strip_tags($resource->title));

        // Prepare image URL with proper encoding and default fallback
        $imagePath = $resource->featured_image ? ltrim($resource->featured_image, '/') : 'images/resources-default-og.jpg';
        $imageUrl = url('storage/' . $imagePath);

        // Format dates for meta tags
        $publishedTime = $resource->published_at;
        $modifiedTime = $resource->updated_at;

        // Prepare tags if they exist
        // $tags = $resource->tags->pluck('name')->toArray();

        $meta = [
            'title' => $metaTitle,
            'description' => $metaDescription,
            'image' => $imageUrl,
            'url' => url()->current(),
            'type' => 'article',
            'published_time' => $publishedTime,
            'modified_time' => $modifiedTime,
            'author' => $resource->user->name,
            'site_name' => 'TechXtraSol Resources',
            'twitter_card' => 'summary_large_image',
            'twitter_site' => '@techxtrasol',
            'twitter_creator' => $resource->user->twitter_handle ?? '@techxtrasol',
            'category' => $resource->category->name ?? null,

        ];

        return Inertia::render('Resources/Show', [
            'resource' => $resource,
            'related' => Resource::where('category_id', $resource->category_id)
                ->where('id', '!=', $resource->id)
                ->where('is_published', true)
                ->where('published_at', '<=', now())
                ->limit(3)
                ->get(),
            'meta' => $meta,
        ]);
    }
}
