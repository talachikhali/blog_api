<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'image'
    ];

    public function getImageUrlAttribute(){
        if($this->image){
            $path = "/storage";
            $imageName = $this->image;
            return url("$path/$imageName");
        }
        return null;
    }
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
