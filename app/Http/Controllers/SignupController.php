<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class SignupController extends Controller
{
    public function index()
    {
        return view('sign-up');
    }

    public function stripePostback()
    {
        $token = Input::get('stripeToken');

        Auth::user()->subscription('monthly')->create($token);

        return Redirect::to('home');
    }
}
