<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';

    // যেসব ফিল্ড mass assignment এর মাধ্যমে fill করা যাবে
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // password auto hash করার জন্য (optional কিন্তু ভালো practice)
    //protected function setPasswordAttribute($value)
    //{
    //    $this->attributes['password'] = bcrypt($value);
    //}

    // hide sensitive data
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
