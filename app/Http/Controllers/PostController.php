<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getAll(){
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();
        return $posts;
    }

    public function store(Request $request){
        $user = Auth::user();

        $post = new Post;
        $post->text = $request['text'];

        $user->posts()->save($post);

        $last_post = Post::with('user')->where('id', $post->id)->first();

        return $last_post;
    }
}
