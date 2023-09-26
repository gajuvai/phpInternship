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
        return redirect()->route('post.index');
    }
    
}
