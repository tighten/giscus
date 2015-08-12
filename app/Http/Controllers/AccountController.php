<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function index()
    {
        return view('account');
    }

    public function confirmCancel()
    {
        return view('confirm-cancel');
    }

    public function cancel()
    {
        Log::info('User ' . Auth::user()->id . ' canceled.');

        Auth::user()->delete();

        return redirect('/');
    }
}
