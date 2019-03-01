<?php

namespace App\Http\Controllers;

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
        Log::info('User ' . auth()->user()->id . ' (' . auth()->user()->email . ') canceled.');

        auth()->user()->delete();

        return redirect('/');
    }
}
