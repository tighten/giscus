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

    public function downloadInvoice($invoiceId) {
        return Auth::user()->downloadInvoice($invoiceId, [
            'vendor'  => 'Tighten Co.',
            'product' => 'Giscus',
        ]);
    }

    public function confirmCancel()
    {
        return view('confirm-cancel');
    }

    public function cancel()
    {
        Log::info('User ' . Auth::user()->id . ' canceled.');

        Auth::user()->subscription()->cancel();

        return redirect('/');
    }
}
