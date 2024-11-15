<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Access\AuthorizationException;


class PostController extends Controller
{

    // constructor
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['getAllPosts' , 'getPost']]);
    }

    public function getAllPosts(Request $request )
    {
        $validation = Validator::make($request->all() , [
            'search' => 'string' ,
            'start_date' => 'date' ,
            'end_date' => 'date' ,
            'category' => 'string' ,
        ]);

        if ($validation->fails()){
            return apiResponse(400 , 'validation error' , $validation->errors() );
        }

        $query = Post::query();

        // Search by title, author, or category
        if ($request->has('search')) {
            $query->search($request->input('search'));
        }

        // Filter by date range and category
        if (($request->has('start_date') && $request->has('end_date') || $request->has('category'))) {
            $query->filter($request->input('start_date'), $request->input('end_date'), $request->input('category'));
        }

        $posts = $query->paginate(10);
        return apiResponse(200, 'success', $posts);
    }

    public function createPost(CreatePostRequest $request)
    {
        $post = auth()->user()->posts()->create($request->all());
        return apiResponse(200, 'Post created successfully', $post);
    }

    public function getPost($id)
    {
        $post = Post::with('user:id,name,email')->find($id);
        if (!$post) {
            return apiResponse(404, 'Post not found');
        }

        return apiResponse(200, 'success', $post);
    }

    public function updatePost(UpdatePostRequest $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return apiResponse(404, 'Post not found');
        }

        try {
            $this->authorize('update', $post);
        } catch (AuthorizationException $e) {
            return apiResponse(403, 'You are not authorized to update this post');
        }

        $post->update($request->all());
        return apiResponse(200, 'Post updated successfully', $post);
    }

    public function deletePost($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return apiResponse(404, 'Post not found');
        }

        try {
            $this->authorize('delete', $post);
        } catch (AuthorizationException $e) {
            return apiResponse(403, 'You are not authorized to delete this post');
        }

        $post->delete();
        return apiResponse(200, 'Post deleted successfully');
    }


}
