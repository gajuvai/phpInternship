<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function getLogin(){
        return view('auth.login');
    }

    public function postLogin(Request $request){

        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $validated=auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if($validated){
            return redirect()->route('dashboard')->with('success', 'Login Successful');
        }else{
           return redirect()->back()->with('error', 'Invalid credentials');
        }
    }
}
