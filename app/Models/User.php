<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Utils\S3;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'totem',
        'path',
        'tel',
        'contactable',
        'role',
    ];

    public function jsonSerialize():array 
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email, 
            'pic' => S3::signUrl($this->path),
            'path' => $this->path,
            'totem' => $this->totem,
            'tel' => $this->tel,
            'contactable' => $this->contactable,
            'role' => $this->role,
            'created_at' => date("d.m.Y", strtotime($this->created_at)),
        ];
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function photos() 
    {
        return $this->hasMany(Photo::class);
    }

    public function albums() 
    {
        return $this->hasMany(Album::class);
    }
}
