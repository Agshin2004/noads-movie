<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RandomLib\Factory;

class AuthController extends Controller
{
    public function showRegisterForm(Request $request)
    {
        return view('register');
    }

    public function showLoginForm(Request $request)
    {
        return view('login');
    }

    public function register(Request $request)
    {
        // dd($request->input('g-recaptcha-response'));
        // Setting up RandomLib for generating random sercret keys (AKA passwords)
        $factory = new Factory;
        // Get a generator for the requested strength; HERE convenience method is used
        $generator = $factory->getMediumStrengthGenerator();
        // Create new random secret key
        $secretKeyPassword = $generator->generateString(16, 'abczxc!@#$%^&*');

        // 'g-recaptcha-response' is the name of the hidden
        $validatedCredentials = $request->validate([
            'username' => ['required', 'min:1', 'max:32'],
            'g-recaptcha-response' => 'required|recaptcha'
        ], [
            'g-recaptcha-response.required' => 'Please Submit The Captcha',
            'g-recaptcha-response.recaptcha' => 'Failed ReCaptcha. Try again laterr'
        ]);

        $user = User::create([
            'username' => $validatedCredentials['username'],
            'secretkey' => Hash::make($secretKeyPassword, ['rounds' => 8])
        ]);

        // TODO: Send password via email to the user

        auth()->login($user, true);

        return view('welcome', [
            'password' => $secretKeyPassword
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'secretkey' => ['required', 'min:16']
        ]);
        // admin
        // ca$c!acc*z%&c$*%
        $user = User::where('username', $credentials['username'])->first();

        if ($user && Hash::check($credentials['secretkey'], $user->secretkey)) {
            auth()->login($user);

            return redirect(route('index'));
        }

        return redirect(route('login'))->with('fail', 'Wrong username or secret key');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/');
    }
}
