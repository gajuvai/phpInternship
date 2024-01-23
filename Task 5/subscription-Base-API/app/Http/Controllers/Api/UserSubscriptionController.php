<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserPackage;

class UserSubscription extends Controller
{
    public function AddUserPackage(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required'],
            'password_confirmation' => ['required', 'confirmed:password']
        ]);
    }
}
