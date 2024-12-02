<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('username', 'password');
        if(!$token = Auth::guard('api')->attempt($credentials)){
            return response()->json(['error'=>'Credenciales invalidas'], 401);
        }
        $user = Auth::guard('api')->user();
        return response()->json([
            'token' => $token,
            'user'=> $user
        ]);
    }

    public function register(Request $request){

        try {
            $user = User::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'username' => $request->username,
                'role' => $request->role,
                'password' => bcrypt($request->password),
            ]);
     
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ], 201);
     
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
