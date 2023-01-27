<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if($request->isMethod('POST')){
            $creds = $request->validate([
                'email'=>'required',
                "password"=>"required"
            ]);

            if(Auth::attempt($creds)){
                return redirect()->route('home');
            }else{
                back()->with("error", "Email ou mot de passe incorrect !");
            }
        }

        return view("login");
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("/login");
    }
}
