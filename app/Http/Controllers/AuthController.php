<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

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
}
