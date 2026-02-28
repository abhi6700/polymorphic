<?php

namespace App\Http\Controllers;

use App\Http\Requests\comment\StoreRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\HttpCache\Store;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        try {
            return response()->json([
                'post_id' => $post->id,
                'comments' => $post->comments
            ]);
        } catch (\Throwable $th) {
            return json_encode([
                'status' => false,
                'message' => 'Something went wrong!',
                'erorr' => $th->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $validated = $request->validated();
            $post = Post::findOrFail($validated['post_id']);
            $post->comments()->create([
                'post_id' => $post->id,
                'comment' => ucfirst($validated['comment']),
            ]);
            return json_encode([
                'status' => true,
                'message' => 'Comment created successfully'
            ]);
        } catch (\Throwable $th) {
            return json_encode([
                'status' => false,
                'message' => 'Something went wrong!',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
