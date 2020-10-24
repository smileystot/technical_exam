<?php

namespace App\Http\Controllers;
use App\User;
use Response;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function Login(Request $req){

        $user = User::where('Email',$req->Email)->first();
        if(!!$user){
            if(Hash::check($req->Password, $user->Password)){
                $user->token = $user->createToken('token-name')->plainTextToken;
                return $user;
            }else{
                return Response::json('Password does not match!' ,500);
            }
                
            
        }else{
            return Response::json('Invalid Email or Password!',500);
        }
    }

}
