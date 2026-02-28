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
            if ($auth) {
                $user = User::where('email', $validated['email'])->first();
                $token = $user->createToken('api-token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'Login successfully',
                    'token' => $token
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid email or password'
                ]);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'erorr' => $th->getMessage()
            ]);
        }
    }
}
