<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{

    protected $validRules = [
        'name' => 'required|string|min:3|max:24|regex:/^[а-яА-ЯёЁ\w]+$/u|unique:users',
        'email' => 'required|string|email|max:64|unique:users',
        'password' => 'required|string|min:6|max:255', //confirmed - id="password_confirmation"
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function login(Request $request)
    {
        //check if guest
        //if email is too long
        $user = User::where('email', $request->email)->first();
        if ($user && $user->active && Hash::check($request->password, $user->password)) {
            return $this->generateToken($user);
        }
        return response('login failed');
    }

    public function register(Request $request)
    {
        // $request->ip
        $this->validate($request, $this->validRules);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response('registration successful', 200);
    }

    // public function logout(Request $request)
    // {
    //     if ($request->user()) {
    //         //
    //     }
    // }

    protected function generateToken($user)
    {
        $jwtHeader = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $jwtPayload = base64_encode(json_encode(['name' => $user->name]));
        $jwtSignature = base64_encode(hash_hmac('sha256', $jwtHeader . '.' . $jwtPayload, env('JWT_KEY'), true));
        $jwt = $jwtHeader . '.' . $jwtPayload . '.' . $jwtSignature;
        return $jwt;
    }

}
