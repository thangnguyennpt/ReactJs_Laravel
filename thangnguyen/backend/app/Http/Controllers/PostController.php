<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $post->image = $path;
        }

        $post->save();

        return redirect()->route('posts.index');

    }

}