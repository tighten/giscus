<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    protected $fillable = ['name', 'email', 'github_id', 'avatar', 'token'];

    protected $hidden = ['password', 'remember_token'];
}
