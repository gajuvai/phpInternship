<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
    public function getregister(){
        return view('auth.register');
    }

    public function postregister(Request $request){

        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'repassword' => 'required|same:password|'
        ]);

        $validated=User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        if($validated){
            return redirect()->route('getLogin')->with('success', 'Register Successful');
        }else{
           return redirect()->back()->with('error', 'Invalid credentials');
        }
    }
}
