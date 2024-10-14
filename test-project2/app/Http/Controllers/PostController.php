<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
    return view('posts.index', ['posts'=>Post::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users=User::get();
        return view('posts.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validdata= $request->validate([
            'title'=>'required|string|min=5|max=10',
            'description'=>'required|string|max=20',
            'user_id'=>'required|exists:user,id'
        ]);
        Post::create($validdata);
        return redirect()->route('posts.index')->with('message','post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post) // Use Post model for route model binding
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post) // Use Post model for route model binding
    {
        $users = User::all(); // In case you need to show users in the edit form
        return view('posts.edit', compact('post', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post) // Use Post model for route model binding
    {
        $validatedData = $request->validate([
            'title' => 'required|string|min=5|max=10',
            'description' => 'required|string|max=20',
            'user_id' => 'required|exists:users,id',
        ]);

        $post->update($validatedData); // Update the post with new data
        return redirect()->route('posts.index')->with('message', 'Post updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post) 
    {
        if (!$post) {
            abort(404, 'Post not found');
        }
        $post->delete(); // Delete the post
        return redirect()->route('posts.index')->with('message', 'Post deleted successfully');
    }
}
