<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }

    public function index()
    {
        $posts = Post::latest()->with(['user', 'likes'])->paginate(20);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        // Post Model Method
        // Post::create([
        //     'userId' => auth()->id(), // or auth()->user()-id;
        //     'body' => $request->body
        // ]);

        // Elequent Method
        // auth()->user()->posts()->create(); OR

        // $request->user()->posts()->create([
        //     'body' => $request->body
        // ]); OR

        $request->user()->posts()->create($request->only('body'));

        return back();

    }

    public function destroy(Post $post)
    {
        // Commit due to create PostPolicy
        // if(!$post->ownedBy(auth()->user()))
        // {
        //     dd('no');
        // }

        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }


}
