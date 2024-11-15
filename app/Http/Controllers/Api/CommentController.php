<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function CreateComment(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Find the post
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->comments()->create([
            'content' => $request->content,
            'author_id' => auth()->id(),
        ]);

        // Return the updated post with the comments for testing
        return apiResponse(200, 'Comment created successfully' , $post->load('comments'));
    }
}
