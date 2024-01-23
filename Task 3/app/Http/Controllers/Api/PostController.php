<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $post;

    public function _construct(){
       $this->post = new Post();
    }

    public function index()
    {
        return $this->post->all();
    }

    public function store(Request $request)
    {
         return $this->post->create($request->all());
    }

    public function show(string $id)
    {
       $post = $this->post->find($id);
    }
    public function update(Request $request, string $id)
    {
         $post = $this->post->find($id);
         $post->update($request->all());
         return $post;
    }
    public function destroy(string $id)
    {
        $post = $this->post->find($id);
        return $post->delete();
    }
}
