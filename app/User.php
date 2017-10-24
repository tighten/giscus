<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'github_id', 'avatar', 'token'];

    protected $hidden = ['password', 'remember_token'];

    public function getVerifyHash()
    {
        return md5($this->github_id . $this->token);
    }

    public function getUnsubscribeUrl()
    {
        return 'https://giscus.co/unsubscribe?' . http_build_query([
            'id' => $this->github_id,
            'hash' => $this->getVerifyHash(),
        ]);
    }
}
