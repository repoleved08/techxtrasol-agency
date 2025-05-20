<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookController extends Controller
{
  public function index()
  {
    $books = Book::latest()->paginate(12);
    return inertia('Books/Index', [
      'books' => $books,
    ]);
  }

  public function show(Book $book)
  {
    return inertia('Books/Show', [
      'book' => $book,
      'relatedBooks' => Book::where('id', '!=', $book->id)
        ->inRandomOrder()
        ->limit(4)
        ->get(),
    ]);
  }
  public function download(Book $book)
  {
    $book->incrementDownloadCount();

    if (!Storage::disk('public')->exists($book->file_path)) {
      abort(404, 'File not found');
    }

    $path = Storage::disk('public')->path($book->file_path);
    $name = $book->title . '.' . pathinfo($book->file_path, PATHINFO_EXTENSION);

    // Return a regular response with file contents
    return response(Storage::disk('public')->get($book->file_path), 200, [
      'Content-Type' => mime_content_type($path),
      'Content-Disposition' => 'attachment; filename="' . $name . '"',
      'Access-Control-Allow-Origin' => '*',
      'Access-Control-Allow-Methods' => 'GET',
    ]);
  }
}
