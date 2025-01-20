<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user')->get();
        return response()->json(['message' => "these are all comments" , $comments], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $validateData = $request->validate([
            'description' => 'required|string'
        ]);
        $comment = Comment::create([
            'description' => $request->description,
            'user_id' => auth()->id(),
            'post_id' => $post->id
        ]);
        $post->comments()->save($comment);

        return response()->json(['message' => 'comment added successfully' , $comment], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post , $id)
    {
        $comment = Comment::where('id' , $id)->first();
        if(!$comment){
            return response()->json(['message' => 'this comment doesnt exist'], 404);
        }
        return response()->json(['message' => 'this is the comment', $comment], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post ,$id)
    {
        $comment = $post->comments()->where('id' , $id)->first();
        if(!$comment){
            return response()->json(['message' => 'this comment doesnt exist'], 404);
        }
        if($comment->user_id != auth()->id()){
            return response()->json(['message'=> 'can not update a comment that is not yours'], 403);
        }
        $validateData = $request->validate([
            'description' => 'required|string'
        ]);
        $comment->update([
            'description' => $request->description
        ]);

        return response()->json(['message' => 'comment updated successfully', $comment], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, $id)
    {
        $comment = Comment::where('id' , $id)->first();
        if(!$comment){
            return response()->json(['message'=> 'comment not found'], 404);
        }
        if(($comment->user_id != auth()->id()) || ($post->user_id != auth()->id())){
            return response()->json(['message'=> 'can not delete a comment that is not yours'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'comment deleted successfully'], 200);
    }
}
