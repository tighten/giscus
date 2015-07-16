<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index()
    {
        return 'Account page <a href="/logout">Log out</a>';
    }
}
