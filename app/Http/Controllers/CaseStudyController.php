<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CaseStudy;
use Illuminate\Support\Str;

class CaseStudyController extends Controller
{
    public function index()
{
    $caseStudies = CaseStudy::query()
        ->whereNotNull('featured_image')
        ->orderBy('project_date', 'desc')
        ->get()
        ->map(function ($caseStudy) {
            return [
                'id' => $caseStudy->id,
                'title' => $caseStudy->title ?? 'No title',
                'category' => $caseStudy->project_type ?? 'general',
                'description' => $caseStudy->short_description ?? '',
                'image' => $caseStudy->image_url ?? asset('images/default-case-study.jpg'),
                'gallery' => $caseStudy->gallery_urls ?? [],
                'client_name' => $caseStudy->client_name ?? 'No client name',
                'project_date' => $caseStudy->project_date?->format('F Y') ?? 'No date',
                'highlights' => $caseStudy->highlights ?? [],
                'testimonial_name' => $caseStudy->testimonial_name ?? 'No name',
                'testimonial_title' => $caseStudy->testimonial_title ?? 'No title',
                'testimonial_quote' => $caseStudy->testimonial_quote ?? 'No quote',
                'approach' => $caseStudy->approach ?? [],
                'technologies' => $caseStudy->technologies ?? [],
                'key_metrics' => $caseStudy->key_metrics ?? [],
                'slug' => $caseStudy->slug ?? Str::slug($caseStudy->title ?? 'no-title')
            ];
        });

    return Inertia::render('Welcome', [ // ← Match to Welcome.vue
        'projects' => $caseStudies,
        'categories' => [
            'All', 'Web', 'Mobile', 'AI', 'E-commerce', 'Finance'
        ]
    ]);
}


    public function show(CaseStudy $caseStudy)
    {
        return Inertia::render('CaseStudy/Show', [
            'caseStudy' => [
                ...$caseStudy->toArray(),
                'image_url' => $caseStudy->image_url,
                'gallery_urls' => $caseStudy->gallery_urls,
                'formatted_date' => $caseStudy->project_date?->format('F Y')
            ]
        ]);
    }
}
