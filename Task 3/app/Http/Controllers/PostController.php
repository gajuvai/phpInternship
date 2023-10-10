<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostHasImage;
use Illuminate\support\Facades\File;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('postHasImages')->get();

        return view('posts.index', ['posts' => $posts]);
    }


    public function create(){
        return view('posts.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'published_at' => 'required|date',
            'caption.*' => 'required',
            'image.*' => 'max:2048', // This is the maximum file size in kilobytes (2MB).
        ]);

        try {
            $post = Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'published_at' => $request->published_at,
                'author' => auth()->user()->name,
            ]);

            if ($post) {
                $captions = $request->caption;
                $images = $request->file('image');

                foreach ($images as $key => $image) {
                    $extension = $image->getClientOriginalExtension();
                    $filename = time() . '_' . $key . '.' . $extension;
                    $image->move('uploads/posts/', $filename);

                    PostHasImage::create([
                        'caption' => $captions[$key],
                        'image' => $filename,
                        'post_id' => $post->id,
                    ]);
                }
            }

            $request->session()->flash('msg', 'Post is created successfully!');
            return redirect()->route('post.index');
        } catch (Exception $e) {
            Log::error('Post creation: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while saving!');
            return redirect()->route('post.index');
        }
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
    public function delete(Request $request, $id)
    {
        $post = Post::find($id);

        if ($post) {
            // Find and delete all associated images
            $postImages = PostHasImage::where('post_id', $post->id)->get();

            foreach ($postImages as $image) {
                $destination = 'uploads/posts/' . $image->image;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $image->delete();
            }

            // Delete the post itself
            $post->delete();

            $request->session()->flash('msg', 'Post and associated images are deleted successfully!');
        }
        return redirect()->route('post.index');
    }
}
