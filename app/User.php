<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'github_id', 'avatar', 'token'];

    protected $hidden = ['password', 'remember_token'];

    public function getVerifyHash()
    {
        return hash('sha256', $this->github_id.$this->token);
    }

    public function getUnsubscribeUrl()
    {
        return route('unsubscribe', [
            'id' => $this->github_id,
            'hash' => $this->getVerifyHash(),
        ]);
    }
}
