<?php

namespace App\Http\Controllers;

use App\Http\Requests\comment\StoreRequest;
use App\Http\Requests\comment\UpdateRequest;
use App\Models\Comment;
use App\Models\Post;

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
            return response()->json([
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
            return response()->json([
                'status' => true,
                'message' => 'Comment created successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
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
        try {
            $comment = Comment::select('id', 'comment')->find($id);
            if ($comment) {
                return response()->json([
                    'status' => true,
                    'comment' => $comment
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Comment not found'
                ]);
            }
           
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'erorr' => $th->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $validated = $request->validated();
            $comment->update([
                'comment' => ucfirst($validated['comment']),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Comment update successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Comment::find($id)->delete();
            return response()->json([
                'status' => true,
                'message' => 'Comment deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!'
            ]);
        }
    }
}
