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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($user->status === "0") {
                return redirect()->back()->with('error', 'User is blocked :(  Contact admin for more!');
            }

            if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('dashboard')->with('success', 'Welcome back '.$user->name);
            } else {
                return redirect()->back()->with('error', 'Invalid credentials :(');
            }
        } else {
            return redirect()->back()->with('error', 'User not found :(');
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
            'username' => $request['name'],
            'password' => Hash::make($request['password']),
            'status' => "1"
        ]);

        if($validated){
            return redirect()->back()->with('success', 'Register Successful');
        }else{
           return redirect()->back()->with('error', 'Invalid credentials');
        }
    }
}
