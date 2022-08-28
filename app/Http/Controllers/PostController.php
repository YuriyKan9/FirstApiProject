<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        dd(auth()->user());
        return Post::all();
    }
    public function show($id){
        return Post::find($id);
    }
    public function store(){
        $fields = request()->validate(
            [
                'title'=>'required',
                'price'=>'required'
            ]
            );
        $fields['user_id'] = auth()->user()->id;
        $post = Post::create($fields);
        return $post;
    }
    public function update($id){
        $post = Post::find($id);
        $post->update(request()->all());
        return response([
            'post'=>$post
        ]);
    }
    public function destroy($id){
        $post = Post::find($id);
        $post->delete();
        return response('Post was deleted successfully!');
    }
    /**
     * Search for a name
     *
     * @param  str  $title
     * @return \Illuminate\Http\Response
     */
    public function search($title){
        return Post::where('title','like', '%'.$title.'%')->get();
    }
}