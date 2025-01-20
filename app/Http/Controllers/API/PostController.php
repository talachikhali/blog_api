<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user', 'category', 'tags')->get();
        return response()->json(['message'=> 'these are all the posts', $posts] , 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image',
            'category_id' => 'required|exists:categories,id'
        ]);

        $imageName = $request->file('image')->store('images/posts', 'public');

        $post = Post::create([
            'title' => $request->title,
            'description' =>$request->description,
            'image' => $imageName,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id
        ]);
        $tagIds = explode(',', $request->input('tags'));
        $post->tags()->attach($tagIds);
        $post->save();
        return response()->json(['message' => 'post has been created' , "post" => $post], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::where('id' , $id)->with('user', 'category', 'tags')->first();
        if(!$post){
            return response()->json([
                'message' => 'post not found'
            ], 404);
        }
        $comment = $post->comments()->with('user')->get();

        return response()->json(['message' => 'this is the requested post' , 'post' => $post, 'comments' => $comment ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::where('id' , $id)->with('user', 'category', 'tags')->first();

        if(!$post){
            return response()->json(["message" => "post not found"] , 404);
        }
        if(($post->user_id != auth()->id())){
            return response()->json(['message'=> 'can not edit a post that is not yours'], 403);
        }
        $validateData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($request->hasFile('image')) {        
            $imageName = $request->file('image')->store('images/posts', 'public');
            if (Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
        } else {
            $imageName = $post->image;
        }

        $post->update([
            'title' => $request->title,
            'description' =>$request->description,
            'image' => $imageName,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id
        ]);
        $tagIds = explode(',', $request->input('tags'));
        $post->tags()->sync($tagIds);
        return response()->json(['message' => 'post has been updated' , $post], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::where('id' , $id)->first();
        if(!$post){
            return response()->json(['message' => 'post does not exist '], 404);
        }
        if(($post->user_id != auth()->id())){
            return response()->json(['message'=> 'can not edit a post that is not yours'], 403);
        }
        if (Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->tags()->detach();
        $post->delete();

        return response()->json(['message' => 'post deleted'] , 200);
    }
}
