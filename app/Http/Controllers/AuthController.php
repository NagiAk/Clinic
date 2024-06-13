<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function toLogin(LoginRequest $req)
    {
        $etatLog=$req->validated();  
        if(Auth::attempt($etatLog)){     
        session()->regenerate();
        if(Auth::user()->role=="medecin"){
            return redirect()->intended(route('medecin.profile.show'));  
        }
        if(Auth::user()->role=="admin")
        return redirect()->intended(route('dashboard'));  
        }

        
        return to_route('login')
		->withErrors(
		[
            "email"=>'Email ou mot de passe invalide'
        ])
		->withInput();
    }
    function logout() {
        Auth::logout();
        return to_route('home');
    }


}
