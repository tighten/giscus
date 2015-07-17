<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index()
    {
        return '<div style="text-align: center; font-size: 2em; margin-top: 2em">Welcome!<br><br><a href="/logout">Log out</a></div>';
    }
}
