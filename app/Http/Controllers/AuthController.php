<?php

namespace App\Http\Controllers;

use App\Http\Helper\JWTToken;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
      public function register(Request $request){

        $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => $request->password,
        ]);

        return response()->json([
              'status' =>true,
              'message' =>"User Creeated successfullu",
              'data' =>$user,
        ]);
      }

      public function login(Request $request){
        // take input 
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email',$email)->where('password',$password)->select('id')->first();

        if($user != null){
            // createtoken 
            $token = JWTToken::CreateToken($email,$user->id);
        }

        return response()->json([
             'status' =>true,
              'message' =>"login Successfull",
              'token' =>$token,
        ])->cookie('token',$token,60*24);
      }
}
