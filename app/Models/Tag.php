<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'uuid',
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }
}
