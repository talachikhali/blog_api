<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        $validateData =  $request->validate([
            'name' => 'string|required',
            'email' => 'email|required|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken($user->name . "-AuthToken")->plainTextToken;
        $data = [
            'name' => $user->name,
            'id' => $user-> id,
            'email' => $user->email
        ];
        return response()->json(['message'=> 'user created successfully', 'user' => $data , 'token' => $token] , 200);
    }

    public function login(Request $request){
        $validateData =  $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $user = User::where('email' , $request->email)->first();

        if(!$user || Hash::check(Hash::make($request->password), $user->password)){
            return response()->json(['message' => 'invalid information'], 401);
        }

        $token = $user->createToken($user->name . "-AuthToken")->plainTextToken;
        $data = [
            'name' => $user->name,
            'id' => $user-> id,
            'email' => $user->email
        ];
        return response()->json(
            [
                'user' => $data , 'token' => $token
            ] , 200);

    }

    public function logout(Request $request){
        auth()->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'logged out']);
    }
}
