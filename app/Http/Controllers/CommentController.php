<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'post_id' => $validated['post_id'],
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        // Find the comment by ID
        $comment = Comment::findOrFail($id);

        // Check if the comment belongs to the authenticated user
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete the comment
        $comment->delete();

        // Return a response indicating the comment has been deleted
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
