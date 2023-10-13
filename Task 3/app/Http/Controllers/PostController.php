<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostHasImage;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
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

                foreach ($captions as $key => $value) {

                    $extension = $images[$key]->getClientOriginalExtension();
                    $image_path = time() . '_' . $key . '.' . $extension;
                    $images[$key]->move('uploads/posts/', $image_path);

                    PostHasImage::create([
                        'caption' => $value,
                        'image' => $image_path,
                        'post_id' => $post->id,
                    ]);
                }
            }
            DB::commit();
            $request->session()->flash('msg', 'Post is created successfully!');
            return redirect()->route('post.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Post creation: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while saving!');
            return redirect()->route('post.index');
        }
    }


    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'published_at' => 'required|date',
            'caption.*' => 'required',
            'image.*' => 'max:2048', // This is the maximum file size in kilobytes (2MB).
        ]);
        DB::beginTransaction();
        try {
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
                'published_at' => $request->published_at,
                'author' => auth()->user()->name,
            ]);

            // Handle image updates
            if ($post) {
                $captions = $request->caption;
                $images = $request->file('image');
                $old_images = $request->oldImage;

                //delete old image
                $post->postHasImages()->delete();

                foreach ($captions as $key => $value) {

                    if(isset($images[$key])){
                        if(isset($old_images[$key]) && !empty(trim($old_images[$key]))){

                            dd($images[$key]);
                            $destination = public_path("\uploads\posts\\") .$old_images[$key];

                            if(File::exists($destination)) {
                                File::delete($destination);
                            }
                            //$images->delete();
                        }
                        $extension = $images[$key]->getClientOriginalExtension();
                        $image_path = time() . '_' . $key . '.' . $extension;
                        $images[$key]->move('uploads/posts/', $image_path);
                    }else{
                        $destination = public_path("\uploads\posts\\") .$old_images[$key];

                        if(File::exists($destination)) {
                            File::delete($destination);
                        }

                        $image_path = $old_images[$key] ?? '';
                        //$images[$key]->move('uploads/posts/', $image_path);
                    }

                    PostHasImage::create([
                        'caption' => $value,
                        'image' => $image_path,
                        'post_id' => $post->id,
                    ]);
                }
            }
            DB::commit();

            $request->session()->flash('msg', 'Post is updated successfully!');
            return redirect()->route('post.index');
        } catch (Exception $e) {

            DB::rollBack();
            Log::error('Post update: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while updating the post!');
            return redirect()->route('post.index');
        }
    }

    public function delete(Request $request, $id)
    {
        $post = Post::find($id);

        if ($post) {
            // Find and delete all associated images
            $postImages = PostHasImage::where('post_id', $post->id)->get();

            foreach ($postImages as $image) {

               $destination = public_path("\uploads\posts\\") .$image->image;

               if(File::exists($destination)) {
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
