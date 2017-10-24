<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UnsubscribeController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $hash = $request->input('hash');

        // Check for necessary parameters
        if (empty($id) || empty($hash)) {
            return redirect('/');
        }

        // Get the user with this github_id
        $user = User::where('github_id', $id)->first();
        if (!$user) {
            Log::info('User not found with github_id ' . $id);
            return redirect('/');
        }

        // Verify the hash given against the computed hash
        if ($hash !== $user->getVerifyHash()) {
            return redirect('/');
        }

        // Login the user
        Auth::login($user);

        // Send to the confirmation page
        return redirect('user/confirm-cancel');
    }
}
