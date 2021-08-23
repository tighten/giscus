<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnsubscribeController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $hash = $request->input('hash');

        if (empty($id) || empty($hash)) {
            return redirect('/');
        }

        try {
            $user = User::where('github_id', $id)->firstOrFail();
        } catch (Exception $e) {
            Log::info('User not found with github_id '.$id);

            return redirect('/');
        }

        if ($hash !== $user->getVerifyHash()) {
            return redirect('/');
        }

        auth()->login($user);

        return redirect('user/confirm-cancel');
    }
}
