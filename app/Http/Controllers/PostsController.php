<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * React to the specified post as (like,dislike).
     */
    public function react(Request $request, Post $post)
    {
         if(array_search($request->user(),$post->reactions)){
            array_splice($post->reactions,$post->reactions[$request->user()],1);
            $post->save();
         }
         else{
            array_push($post->reactions,[$request->user()=>$request->react_type]);
            $post->save();

         }
         return response(['message' => 'Reaction updated'],201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response(['message'=>'Post deleted']);
    }
}
