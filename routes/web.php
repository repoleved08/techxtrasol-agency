<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookController;
use App\Models\Post;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/', [CaseStudyController::class, 'index'])->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard', [
        'canViewAdmin' => Auth::user()?->can('viewAdmin', \App\Models\User::class),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Company routes
Route::get('/about-us', [CompanyController::class, 'aboutUs'])->name('about-us');
Route::get('/agency/our-team', [CompanyController::class, 'ourTeam'])->name('our-team');
// blog
Route::get('/agency/blog', [CompanyController::class, 'blog'])->name('blog');
Route::get('agency/consultation', [CompanyController::class, 'consultation'])->name('consultation');
Route::get('/agency/blog/{post:slug}', function (Post $post) {
    return Inertia::render('Blog/SinglePost', [
        'post' => $post->load(['category', 'user']),
        'relatedPosts' => Post::with(['category', 'user'])
            ->where('is_published', true)
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get(),
    ]);
})->name('blog.post');
// Resources routes
Route::get('/our-resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{slug}', [ResourceController::class, 'show'])->name('resources.show');

// bloginsightsection

// Add this route for the BlogInsightSection component
Route::get('/resources-data', function () {
    $resources = App\Models\Resource::with(['category', 'user'])
        ->where('is_published', true)
        ->where('published_at', '<=', now())
        ->latest('published_at')
        ->limit(7) // 1 featured + 6 regular
        ->get();

    // Mark the first resource as featured
    if ($resources->isNotEmpty()) {
        $resources[0]->featured = true;
    }

    return response()->json([
        'resources' => $resources,
        'categories' => App\Models\ResourceCategory::orderBy('order')->get()
    ]);
});
// single postt

Route::get('/agency/blog/{post:slug}', [CompanyController::class, 'showPost'])->name('blog.post');

// casestudy controller
// routes/web.php
Route::get('/case-studies/{caseStudy:slug}', [CaseStudyController::class, 'show']);

// mail route
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

// consultation route
Route::get('/our-consultation', [CompanyController::class, 'consultation'])->name('our-consultation');
Route::post('/consultation', [ConsultationController::class, 'store'])->name('consultation.submit');
// terms of service
Route::get('/terms-of-service', [CompanyController::class, 'termsOfService'])->name('terms-of-service');
// privacy policy
Route::get('/privacy-policy', [CompanyController::class, 'privacyPolicy'])->name('privacy-policy');

// coomments
Route::middleware('auth')->post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->middleware('auth');

// Books
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book:slug}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/{book:slug}/download', [BookController::class, 'download'])->name('books.download');



// emails newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/confirm/{token}', [NewsletterController::class, 'confirm'])->name('newsletter.confirm');
Route::get('/newsletter/unsubscribe/{email}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
