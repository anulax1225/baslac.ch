<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "created_at",
        "updated_at"
    ];

    public function infos()
    {
        return $this->hasMany(Info::class);
    }
}
