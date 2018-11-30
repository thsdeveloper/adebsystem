<?php

namespace App\Http\Controllers;

use App\Events\PostPublished;
use App\Notifications\PostNotification;
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

        $url = $request['url'];
        $post = new Post;
        $post->text = $request['text'];
        $post->addMediaFromBase64($url)->toMediaCollection();

        if($user->posts()->save($post)){
            // fire PostPublished event after post is successfully added to database
//            event(new PostPublished($post));
            Auth::user()->notify(new PostNotification($post));
        }

//        dd($evento);
        // or
//        Event::fire(new PostPublished($post));

        $last_post = Post::with('user', 'media')->where('id', $post->id)->first();

        return response($last_post, 201);
    }
}
