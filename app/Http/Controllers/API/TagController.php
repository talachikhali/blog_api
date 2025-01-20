<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return response() -> json(['message' => 'this is the tags' ,$tags], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string'
        ]);
        $tag = Tag::create($validateData);
        return response()->json(['message' => 'tag created successflly' , $tag], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tag = Tag::where('id', $id)->first();
        if(!$tag){
            return response()->json(['message' => 'tag not found'] , 404);
        }
        return response()->json(['message' => 'this is the tag info' , $tag], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $tag = Tag::where('id', $id)->first();
        if(!$tag){
            return response()->json(['message' => 'tag was not found'], 404);
        }
        $validateData = $request->validate([
            'name' => 'required|string'
        ]);
        $tag->update($validateData);
        return response()->json(['message' => 'tag updated successflly' , $tag], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tag = Tag::where('id' , $id)->first();
        if(!$tag){
            return response()->json(['message' => 'tag not found'], 404);
        }
        $tag->delete();
        return response()->json(['message' => 'tag deleted successfully' , $tag], 200);
    }
}
