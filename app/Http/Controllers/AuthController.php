<?php

namespace App\Http\Controllers;

use App\Models\User;
use RandomLib\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        // Setting up RandomLib for generating random sercret keys (AKA passwords)
        $factory = new Factory;
        // Get a generator for the requested strength; HERE convenience method is used
        $generator = $factory->getMediumStrengthGenerator();
        // Create new random secret key
        $secretKeyPassword = $generator->generateString(16, 'abczxc!@#$%^&*');

        $validatedCredentials = $request->validate([
            'username' => ['required', 'min:1', 'max:32']
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

    public function login(Request $request) {}

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/');
    }
}
