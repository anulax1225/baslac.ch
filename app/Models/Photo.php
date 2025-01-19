<?php

namespace App\Models;

use App\Utils\S3;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'name',
        'path',
        'uuid',
        'user_id'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function jsonSerialize():array 
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name, 
            'path' => S3::signUrl($this->path),
            'user' => $this->user,
        ];
    }

}
