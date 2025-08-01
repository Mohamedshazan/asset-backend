<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['avatar_url'];

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }




    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function supportRequests()
    {
        return $this->hasMany(SupportRequest::class);
    }

    // AFTER
    public function assignedAssets()
    {
        return $this->hasMany(\App\Models\Asset::class, 'user_id');
    }
}
