<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id',
        'category_id'
    ];

    public function getImageUrlAttribute(){
        if($this->image){
            $path = "/storage";
            $imageName = $this->image;
            return url("$path/$imageName");
        }
        return null;
    }

    public function isOwner($user){
        return $this->user_id == $user->id;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
