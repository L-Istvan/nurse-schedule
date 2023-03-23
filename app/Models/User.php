<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Dotenv\Util\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_id',
        'name',
        'mobile_number',
        'email',
        'password',
        'role',
        'rank',
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole(string $role):bool{
        return $this->getAttribute('role') === $role;
    }

    public function post(){
        return $this->hasMany(Post::class);
    }

    public function holiday(){
        return $this->hasMany(Holiday::class);
    }

    public function sickLeave(){
        return $this->hasMany(SickLeave::class);
    }

    public function petition(){
        return $this->hasMany(Petition::class);
    }

    public function setting(){
        return $this->hasMany(Setting::class);
    }
}
