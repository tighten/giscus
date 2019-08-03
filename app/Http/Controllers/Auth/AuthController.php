<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Exception;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        $scopes = request('allow-private') ? ['gist', 'user:email'] : ['user:email'];

        return Socialite::driver('github')
            ->scopes($scopes)
            ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return redirect('auth/github');
        }

        if (! $user->email) {
            return redirect('no-email');
        }

        $authUser = $this->findOrCreateUser($user);

        auth()->login($authUser, true);

        return redirect('home');
    }

    public function noEmail()
    {
        return view('y-u-no-email');
    }

    private function findOrCreateUser($user)
    {
        if ($authUser = User::where('github_id', $user->id)->first()) {
            return $authUser;
        }

        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'github_id' => $user->id,
            'avatar' => $user->avatar,
            'token' => $user->token,
        ]);
    }

    public function getLogout()
    {
        auth()->logout();

        return redirect('/');
    }
}
