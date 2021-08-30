<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $fields = $request->validated();

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token  
        ];
        
        return response($response, 201);

    }

    public function logout(Request $request)
    {

        auth()->user()->tokens()->delete();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return [
            'message' => 'logged out'
        ];
    }

    public function login(LoginRequest $request)
    {
        $fields = $request->validated();

        //check email 
        $user = User::where('email', $fields['email'])->first();

        //check password 
        if (!$user || !Hash::check($fields['password'], $user->password) ) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token, 
            'login' => 'loging succesfull'
        ];
        
        return response($response, 201);

    }

}
