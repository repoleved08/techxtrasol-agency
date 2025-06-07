<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Team;

class CompanyController extends Controller
{
    // Simple page methods
    public function aboutUs(): Response
    {
        return inertia('Company/AboutUs');
    }
    public function contactUs(): Response
    {
        return inertia('Company/ContactUs');
    }
    public function termsOfService(): Response
    {
        return inertia('Company/TermsOfService');
    }
    public function privacyPolicy(): Response
    {
        return inertia('Company/PrivacyPolicy');
    }
    public function cookiePolicy(): Response
    {
        return inertia('Company/CookiePolicy');
    }

    // app/Http/Controllers/CompanyController.php

    public function ourTeam()
    {
        $teamMembers = Team::all();

        $formattedTeam = $teamMembers->map(function ($member) {
            return [
                'id' => $member->id,
                'name' => $member->name,
                'position' => $member->position,
                'department' => $member->department,
                'image_url' => $member->image_url,
                'bio' => $member->bio,
                'skills' => $this->formatSkills($member->skills),
                'socials' => $this->formatSocials($member->socials),
            ];
        });

        return inertia('Company/OurTeam', [
            'team' => $formattedTeam,
        ]);
    }

    protected function formatSkills($skills)
    {
        // If already properly formatted (from model accessor)
        if (is_array($skills) && !empty($skills) && is_string($skills[0])) {
            return $skills;
        }

        // Handle empty case
        if (empty($skills)) {
            return ['General']; // Fallback skill
        }

        // Handle JSON string
        if (is_string($skills)) {
            $skills = json_decode($skills, true);
        }

        // Handle array of objects
        if (is_array($skills) && isset($skills[0]['name'])) {
            return array_column($skills, 'name');
        }
        if (is_array($skills) && isset($skills[0]['skill'])) {
            return array_column($skills, 'skill');
        }

        // Handle malformed data
        return is_array($skills) ? $skills : ['General'];
    }

    protected function formatSocials($socials)
    {
        // If already properly formatted (from model accessor)
        if (is_array($socials) && !empty($socials) && is_string($socials[0]['platform'])) {
            return $socials;
        }

        // Handle empty case
        if (empty($socials)) {
            return []; // No socials
        }

        // Handle JSON string
        if (is_string($socials)) {
            $socials = json_decode($socials, true);
        }

        // Handle array of objects
        if (is_array($socials) && isset($socials[0]['platform'])) {
            return $socials;
        }

        // Handle malformed data
        return is_array($socials) ? $socials : [];
    }

    public function consultation(): Response
    {
        return inertia('Company/Consultation');
    }
    // terms of service
    public function termsOfServicePage(): Response
    {
        return inertia('Company/TermsOfService');
    }
    // privacy policy
    public function privacyPolicyPage(): Response
    {
        return inertia('Company/PrivacyPolicy');
    }

    // Blog index page
      public function blog(Request $request): Response
    {
        // Validate and sanitize inputs
        $validated = $request->validate([
            'category' => 'nullable|string|max:255',
            'search' => 'nullable|string|max:255',
            'page' => 'nullable|integer|min:1'
        ]);

        // Get featured post (only show if no filters are active)
        $featuredPost = null;
        if (empty($validated['category']) && empty($validated['search'])) {
            $featuredPostQuery = Post::with([
                'category:id,name,slug',
                'user:id,name'
            ])
                ->where('is_published', true)
                ->orderByDesc('published_at')
                ->first();

            $featuredPost = $featuredPostQuery ? $this->formatPost($featuredPostQuery) : null;
        }

        // Build posts query with filters
        $postsQuery = Post::with([
            'category:id,name,slug',
            'user:id,name'
        ])
            ->where('is_published', true)
            ->when($validated['category'] ?? null, function ($query, $category) {
                if ($category !== 'all') {
                    $query->whereHas('category', fn($q) => $q->where('slug', $category));
                }
            })
            ->when($validated['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%")
                      ->orWhere('body', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('published_at');

        // Exclude featured post if it exists and no filters are active
        if ($featuredPost) {
            $postsQuery->where('id', '!=', $featuredPostQuery->id);
        }

        // Paginate results
        $posts = $postsQuery->paginate(6)->withQueryString();

        // Format posts
        $formattedPosts = $posts->getCollection()->map(fn($post) => $this->formatPost($post));
        $posts->setCollection($formattedPosts);

        // Get categories for filtering
        $formattedCategories = Category::select('id', 'name', 'slug')
            ->get()
            ->map(fn($category) => [
                'id' => $category->slug,
                'name' => $category->name,
                'icon' => $this->getCategoryIcon($category->slug)
            ]);

        // Prepend "All Posts" category
        $formattedCategories->prepend([
            'id' => 'all',
            'name' => 'All Posts',
            'icon' => 'BookOpenIcon'
        ]);

        // Build dynamic meta data
        $meta = $this->buildBlogMetaData($validated);

        return inertia('Company/Blog', [
            'featuredPost' => $featuredPost,
            'blogPosts' => $posts,
            'categories' => $formattedCategories,
            'filters' => $request->only(['category', 'search']),
            'meta' => $meta,
        ]);
    }

    private function buildBlogMetaData(array $filters): array
    {
        $title = 'Blog | TechXtraSol';
        $description = 'Discover the latest trends, technologies, and insights from our experts.';

        // Customize meta based on active filters
        if (!empty($filters['category']) && $filters['category'] !== 'all') {
            $category = Category::where('slug', $filters['category'])->first();
            if ($category) {
                $title = "{$category->name} Articles | Blog | TechXtraSol";
                $description = "Explore our latest {$category->name} articles and insights.";
            }
        }

        if (!empty($filters['search'])) {
            $searchTerm = Str::limit($filters['search'], 50);
            $title = "Search: {$searchTerm} | Blog | TechXtraSol";
            $description = "Search results for '{$searchTerm}' in our blog articles.";
        }

        if (!empty($filters['category']) && !empty($filters['search']) && $filters['category'] !== 'all') {
            $category = Category::where('slug', $filters['category'])->first();
            $searchTerm = Str::limit($filters['search'], 50);
            if ($category) {
                $title = "Search: {$searchTerm} in {$category->name} | Blog | TechXtraSol";
                $description = "Search results for '{$searchTerm}' in {$category->name} articles.";
            }
        }

        return [
            'title' => $title,
            'description' => $description,
            'image' => asset('images/blog-default-og.jpg'),
            'url' => url()->current(),
            'type' => 'website',
            'canonical' => url()->current(),
        ];
    }

    // Single post view
    public function showPost(Post $post)
    {
        if (!$post->is_published) {
            abort(404);
        }

        // Load relationships without assuming profile exists
        $post->load([
            'category:id,name,slug',
            'user:id,name,email',
            'comments.user:id,name'
        ]);

        // Prepare meta data
        $cleanExcerpt = Str::limit(strip_tags($post->excerpt), 160);
        $metaDescription = $post->meta_description
            ? strip_tags($post->meta_description)
            : $cleanExcerpt;
        $metaTitle = $post->meta_title
            ? html_entity_decode(strip_tags($post->meta_title))
            : html_entity_decode(strip_tags($post->title));
        $imageUrl = $post->featured_image
            ? url('storage/' . ltrim($post->featured_image, '/'))
            : url('images/default-og-image.jpg');

        // Format related posts
        $relatedPosts = Post::with([
            'category:id,name,slug',
            'user:id,name'
        ])
            ->where('is_published', true)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn($related) => $this->formatRelatedPost($related));

        return Inertia::render('Blog/SinglePost', [
            'post' => $this->formatSinglePost($post, $cleanExcerpt, $metaTitle, $metaDescription, $imageUrl),
            'comments' => $post->comments->map(fn($comment) => $this->formatComment($comment)),
            'meta' => $this->generateMetaData($post, $metaTitle, $metaDescription, $imageUrl),
            'relatedPosts' => $relatedPosts,
        ]);
    }

    /**
     * Helper methods for formatting data
     */
    private function formatPost(Post $post): array
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'excerpt' => $post->excerpt,
            'slug' => $post->slug,
            'body' => $post->body ?? null,
            'image' => $post->featured_image ? asset('storage/' . $post->featured_image) : null,
            'category' => $post->category->name,
            'date' => $post->published_at,
            'author' => [
                'name' => $post->user->name,
                'avatar' => null, // Removed profile reference
                'role' => 'Author', // Default role
            ]
        ];
    }

    private function formatSinglePost(
        Post $post,
        string $excerpt,
        string $metaTitle,
        string $metaDescription,
        string $imageUrl
    ): array {
        return [
            'id' => $post->id,
            'title' => html_entity_decode(strip_tags($post->title)),
            'excerpt' => $excerpt,
            'body' => $post->body,
            'slug' => $post->slug,
            'image' => $imageUrl,
            'category' => [
                'name' => $post->category->name,
                'slug' => $post->category->slug,
            ],
            'user' => [
                'name' => $post->user->name,
                'email' => $post->user->email,
                'avatar' => null, // Removed profile reference
                'role' => 'Author', // Default role
                'bio' => null, // Removed profile reference
            ],
            'published_at' => $post->published_at,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $post->meta_keywords,
        ];
    }

    private function formatComment($comment): array
    {
        return [
            'id' => $comment->id,
            'body' => $comment->body,
            'created_at' => $comment->created_at->diffForHumans(),
            'user' => [
                'name' => $comment->user->name,
                'avatar' => null, // Removed profile reference
            ],
        ];
    }

    private function formatRelatedPost($related): array
    {
        return [
            'id' => $related->id,
            'title' => html_entity_decode(strip_tags($related->title)),
            'excerpt' => Str::limit(strip_tags($related->excerpt), 150),
            'slug' => $related->slug,
            'image' => $related->featured_image
                ? url('storage/' . ltrim($related->featured_image, '/'))
                : null,
            'category' => [
                'name' => $related->category->name,
                'slug' => $related->category->slug,
            ],
            'user' => ['name' => $related->user->name],
            'published_at' => $related->published_at,
            'date' => $related->published_at,
        ];
    }

    private function generateMetaData(
        Post $post,
        string $title,
        string $description,
        string $imageUrl
    ): array {
        return [
            'title' => $title,
            'description' => $description,
            'image' => $imageUrl,
            'url' => url()->current(),
            'type' => 'article',
            'published_time' => $post->published_at,
            'modified_time' => $post->updated_at,
            'author' => $post->user->name,
            'site_name' => 'TechXtraSol',
            'twitter_card' => 'summary_large_image',
            'twitter_site' => '@techxtrasol',
            'twitter_creator' => '@techxtrasol',
        ];
    }

    private function getCategoryIcon(string $slug): string
    {
        $iconMap = [
            'development' => 'CodeIcon',
            'design' => 'PaletteIcon',
            'marketing' => 'TrendingUpIcon',
            'technology' => 'ServerIcon',
            'business' => 'BriefcaseIcon',
            'finance' => 'DollarSignIcon',
            'health' => 'HeartIcon',
            'travel' => 'GlobeIcon',
            'lifestyle' => 'SunIcon',
            'education' => 'BookOpenIcon',
        ];

        return $iconMap[$slug] ?? 'BookOpenIcon';
    }
}
