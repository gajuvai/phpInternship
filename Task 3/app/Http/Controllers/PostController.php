<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\support\Facades\File;

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

        // Post::create([
        //     'title' => $request->title,
        //     'content' => $request->content,
        //     'published_at' => $request->published_at,
        //     'author' => auth()->user()->name
        //     ]
        // );
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'published_at'=>'required|date',
            'image'=>'required|max:2048',
        ]);

        $post = new Post;
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->published_at = $request->input('published_at');
        $post->author = auth()->user()->name;

        if($request->hasfile('image')){

            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/posts/', $filename);

            $post->image = $filename;
        }
        $post->save();

        $request->session()->flash('msg', 'Post is created successfully!');
        return redirect()->route('post.index');
    }
    public function edit(Post $post){

        return view('posts.edit', compact('post'));
    }
    public function update(Request $request, $id){

        // $post->update([
        //     'title' => $request->title,
        //     'content' => $request->content,
        //     'published_at' => $request->published_at,
        //     'author' => $request->author
        //     ]
        // );
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'published_at'=>'required|date',
            'image'=>'required|max:2048',
        ]);
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->published_at = $request->input('published_at');
        $post->author = auth()->user()->name;

        if($request->hasfile('image')){

            $destination = 'uploads/posts/'.$post->image;
            if(File::exists($destination))
            {
                File::delete($destination);
            }

            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/posts/', $filename);

            $post->image = $filename;
        }
        $post->update();

        $request->session()->flash('msg', 'Post is updated successfully!');
        return redirect()->route('post.index');
    }
    public function delete(Request $request, $id){

        $post = Post::find($id);

        $destination = 'uploads/posts/'.$post->image;
        if(File::exists($destination))
        {
            File::delete($destination);
        }

        $post->delete();
        $request->session()->flash('msg', 'Post is deleted successfully!');
        return redirect()->route('post.index');
    }
}
