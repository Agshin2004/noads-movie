<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use RandomLib\Factory;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'secretkey' => 'required|string',
        ]);

        $credentials = $request->only('username', 'secretkey');
        // LOGGIN USER MANUALLY SINCE JWTAuth::attempt() EXCEPTS EMAIL AND PASSWORD BUT WE LOGIN IN WITH username AND secretkey
        $user = User::where('username', $credentials['username'])->first();

        if (!$user || !Hash::check($credentials['secretkey'], $user->secretkey)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Wrong username or password'
            ], 400);
        }

        // NOTE: Could use guard (auth('api')) but decided to use JWTAuth facade to handle features pertaining jwt

        // Generate a JWT token for the user
        $token = JWTAuth::fromUser($user);

        return response()->json(data: [
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $factory = new Factory();
        // Get a generator for the requested strength; HERE convenience method is used
        $generator = $factory->getMediumStrengthGenerator();
        // Create new random secret key
        $secretKeyPassword = $generator->generateString(16, 'abczxc!@#$%^&*');

        $user = User::create([
            'username' => $request->username,
            'secretkey' => Hash::make($secretKeyPassword),
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'secretkey' => $secretKeyPassword,
            'authorisation' => [
                'token' => $token,
            ]
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());  // gets the token from the current HTTP request
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        $token = JWTAuth::parseToken();
        $newToken = JWTAuth::refresh($token);
        return response()->json([
            'status' => 'success',
            'user' => JWTAuth::user(),
            'authorisation' => [
                'token' => $newToken,
            ]
        ]);
    }

    /**
     * Url to check if user authenticated
     * @throws \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException
     * @return User
     */
    public function auth()
    {
        $token = auth('api')->user();
        if (!$token) {
            throw new TokenInvalidException('Invalid or missing jwt token', 400);
        }
        return $token;
    }
}
