<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $validated = $request->validated();
            $auth = Auth::attempt([
                'email' => $validated['email'],
                'password' => $validated['password']
            ]);
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('api-token')->plainTextToken;
            if ($auth) {
                return json_encode([
                    'status' => true,
                    'message' => 'Login successfully',
                    'token' => $token
                ]);
            } else {
                return json_encode([
                    'status' => false,
                    'message' => 'Invalid email or password'
                ]);
            }
            
        } catch (\Throwable $th) {
            return json_encode([
                'status' => false,
                'message' => 'Something went wrong!',
                'erorr' => $th->getMessage()
            ]);
        }
    }
}
