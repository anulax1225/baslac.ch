<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "created_at",
        "updated_at"
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function images()
    {
        $images = [];
        foreach($this->articles as $article) $images = array_merge($images, $article->images);
        return $images;
    }
}
