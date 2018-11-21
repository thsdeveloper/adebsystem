<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getAll(){
        $posts = Post::with('user', 'media')->orderBy('created_at', 'desc')->get();

        foreach ($posts as $post){
            $mediaItems = $post->getMedia();
            $mediaItems[0]->getFullUrl();
            //dd($mediaItems[0]->getFullUrl());
        }

        return $posts;
    }

    public function store(Request $request){
        $user = Auth::user();

        $url = "https://catequistasbrasil.com.br/wp-content/uploads/2018/09/os-jovens-catequistas-e-a-vontade-de-aprender-catequistasbrasil.jpg";

        $post = new Post;
        $post->text = $request['text'];
        $post->addMediaFromUrl($url)->toMediaCollection();

        $user->posts()->save($post);

        $last_post = Post::with('user', 'media')->where('id', $post->id)->first();

        return $last_post;
    }
}
