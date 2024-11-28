<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(){
        $users=User::all();
        return response()->json($users);
    }

    public function getUser($id){
        $user=User::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'],404);
        }
        return response()->json($user);
    }

    public function registerUser(Request $request){
        $user=User::create($request->all());
        return response()->json($user,201);
    }

    public function deleteUser($id){
        $user=User::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'],404);
        }
        $user->delete();
    }

    public function updateUser(Request $request, $id){
        $user=User::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'],404);
        }
        $user->fill($request->all());
        $user->save();
        return response()->json($user);

    }


}