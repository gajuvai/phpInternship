<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; 


class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
        return view('posts.index', ['posts' => $posts]);
    }
    public function create(){
        return view('posts.create');
    }
    public function store(Request $request){
        
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'author' => $request->author
            ]
        );
        $request->session()->flash('msg', 'Post is created successfully!');
        return redirect()->route('post.index');
    }
    public function edit(Post $post){
        
        return view('posts.edit', compact('post'));
    }
    public function update(Request $request, Post $post){

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'author' => $request->author
            ]
        );
        $request->session()->flash('msg', 'Post is updated successfully!');
        return redirect()->route('post.index');
    }
    public function delete(Request $request, Post $post){

        $post->delete();
        $request->session()->flash('msg', 'Post is deleted successfully!');
        return redirect()->route('post.index');
    }
}
