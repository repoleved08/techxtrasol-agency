<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Resource;
use App\Models\ResourceCategory;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Resources API endpoint
Route::get('/resources', function (Request $request) {
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
        ->paginate(6)
        ->withQueryString();

    return [
        'resources' => $resources->items(),
        'pagination' => [
            'current_page' => $resources->currentPage(),
            'last_page' => $resources->lastPage(),
            'per_page' => $resources->perPage(),
            'total' => $resources->total()
        ],
        'categories' => ResourceCategory::orderBy('order')->get()
    ];
});
