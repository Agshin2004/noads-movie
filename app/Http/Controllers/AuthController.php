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
        $backTo = $request->query('backTo');

        // Setting up RandomLib for generating random sercret keys (AKA passwords)
        $factory = new Factory;
        // Get a generator for the requested strength; HERE convenience method is used
        $generator = $factory->getMediumStrengthGenerator();
        // Create new random secret key
        $secretKeyPassword = $generator->generateString(16, 'abczxc!@#$%^&*');

        // 'g-recaptcha-response' is the name of the hidden
        $request->validate([
            'username' => ['required', 'min:1', 'max:32', 'alpha_dash'],
            'g-recaptcha-response' => 'required|recaptcha'
        ], [
            'username.alpha_dash' => 'Username cannot have characters other than A-Z and 0-9.',
            'g-recaptcha-response.required' => 'Please Submit The Captcha',
            'g-recaptcha-response.recaptcha' => 'Failed ReCaptcha. Try again laterr'
        ]);

        if (User::where('username', $request->input('username'))->exists()) {
            return back()->with('fail', 'Username already exists!');
        } 
        
        $user = User::create([
            'username' => $request->input('username'),
            'secretkey' => Hash::make($secretKeyPassword, ['rounds' => 8])
        ]);

        auth()->login($user, true);

        return view('welcome', [
            'password' => $secretKeyPassword,
            'backTo' => $backTo
        ]);
    }

    public function login(Request $request)
    {
        $backTo = $request->query('backTo');

        $credentials = $request->validate([
            'username' => ['required'],
            'secretkey' => ['required', 'min:16']
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if ($user && Hash::check($credentials['secretkey'], $user->secretkey)) {
            auth()->login($user);

            return redirect($backTo)->with('success', 'Logged in successfully!');
        }

        // Authentication failed
        return back()->withErrors([
            'username' => 'Wrong username or secret key.'
        ])->withInput(); // withInput() method is used to flash the old input data to the session, so it can be automatically repopulated in the form fields when the page is redirected back
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->back();
    }
}
