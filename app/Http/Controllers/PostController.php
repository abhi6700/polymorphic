<?php

namespace App\Http\Controllers;

use App\Http\Requests\post\StoreRequest;
use App\Http\Requests\post\UpdateRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $post = Post::with('comments')->get(['id', 'title', 'content']);
            if ($post->isNotEmpty()) {
                return response()->json([
                    'status' => true,
                    'post' => $post
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Post not found'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!'
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
            Post::create([
                'title' => ucfirst($validated['title']),
                'content' => ucfirst($validated['content']),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Post created successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $post = Post::select('id', 'title', 'content')->find($id);
            if ($post) {
                return response()->json([
                    'status' => true,
                    'post' => $post
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Post not found'
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
            $post = Post::findOrFail($id);
            $validated = $request->validated();
            $post->update([
                'title' => ucfirst($validated['title']),
                'content' => ucfirst($validated['content']),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Post update successfully'
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
            Post::find($id)->delete();
            return response()->json([
                'status' => true,
                'message' => 'Post deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!'
            ]);
        }
    }
}
