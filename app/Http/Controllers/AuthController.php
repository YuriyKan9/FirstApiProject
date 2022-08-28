<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
       $formFields = request()->validate(
        [
            'email'=>'required',
            'password'=>'required'
        ]
        );
        $user = User::where('email', request()->email)->first();
        if ($user) {
            if (Hash::check(request()->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->plainTextToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
        
    }
    public function logout(User $user){
        $user->tokens()->delete();
        request()->user()->currentAccessToken()->delete();
        return response('Logout succeed!');
    }
    public function register(){
        $fields = request()->validate(
            [
                'name'=>'required',
                'email'=>'required|unique:users,email',
                'password'=>'required|confirmed|min:6'
            ]
            );
        $user = User::create(
            [
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
            ]
        );
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token
        ];
        Auth::login($user);
        return response($response,201);
    }
}