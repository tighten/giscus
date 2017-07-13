<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name', 'email', 'github_id', 'avatar', 'token'];

    protected $hidden = ['password', 'remember_token'];
}
