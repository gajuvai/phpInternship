<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required'],
            'password_confirmation' => ['required', 'confirmed:password'],
            'address' => ['required'],
            'contact' => ['required', 'numeric', 'digits:10']
        ]);

        try{
            $validatedData['password'] = Hash::make($validatedData['password']);

            $user = User::create($validatedData);
            
            $token = $user->createToken('authToken')->accessToken;
        
            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'User created successfully',
                'status' => 1
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error creating user: ' . $e->getMessage(),
                'status' => 0
            ]);
        }    
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        $user = User::where('email', $validatedData['email'])->first();

        if ($user) {

            if (auth()->attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
                $token = $user->createToken("authToken")->accessToken;
                return response()->json([
                    'token' => $token,
                    'user' => $user,
                    'message' => 'Login successfully',
                    'status' => 1
                ],200);
            } else {
                return response()->json([
                    'message' => 'Invalid credentials',
                    'status' => 0
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'Something went worng',
                'status' => 0
            ], 400);
        }
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);

        if(is_null($user)){
            return response()->json([
                'status' => 0,
                'message' => "User id not exist"
            ], 400);
        }else{
            $validatedData = $request->validate([
                'old_password' => ['required'],
                'new_password' => ['required', 'different:old_password'],
                'confirm_password' => ['required'],
            ]);

             //change password
             if($user->password == $request['old_password']){
                
                if($request['new_password'] == $request['confirm_password']){
                    //change
                    DB::beginTransaction();
                    try{
                        $user->password = $request['new_password'];
                        $user->save();
                        DB::commit();
                    }catch(\Exception $e){
                        $user = null;
                        DB:rollBack();
                    }
                    if(is_null($user)){
                        return response()->json([
                            'status' => 0,
                            'message' => "Internal server error",
                            'error' => $e->getMessage()
                        ], 500);
                    }else{
                        return response()->json([
                            'status' => 1,
                            'message' => "Password update successfully"
                        ], 200);
                    }
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "New password and confirm password does not match"
                    ], 400);
                }

            }else{
                return response()->json([
                    'status' => 0,
                    'message' => "Old password does not match"
                ], 400);
            }
        }
    }

    public function forgetPassword(Request $request, $id)
    {
        $user = User::find($id);

        if(is_null($user)){
            return response()->json([
                'status' => 0,
                'message' => "User id not exist"
            ], 400);
        }else{
            $validatedData = $request->validate([
                'email' => ['required', 'email'],
                'new_password' => ['required'],
                'confirm_password' => ['required'],
            ]);
            if($validatedData['email'] == $request->email){
                //new old password and new password could not be same code is write here

                if($validatedData['new_password'] == $validatedData['confirm_password']){
                    //password save to database
                    DB::beginTransaction();
                    try{
                        $user->password = $request['new_password'];
                        $user->save();
                        DB::commit();
                    }catch(\Exception $e){
                        $user = null;
                        DB:rollBack();
                    }
                    if(is_null($user)){
                        return response()->json([
                            'status' => 0,
                            'message' => "Internal server error",
                            'error' => $e->getMessage()
                        ], 500);
                    }else{
                        return response()->json([
                            'status' => 1,
                            'message' => "Password update successfully"
                        ], 200);
                    }
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "New and Confirm password not match"
                    ], 400);
                }
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => "Invalid email"
                ], 400);
            }
        }
    }

    public function getUser($id)
    {
        $user = User::find($id);

        if(is_null($user)){
            return response()->json([
                'message' => 'User not found',
                'status' => 0
            ], 400);
        }else{
            return response()->json([
                'user' => $user,
                'message' => 'User found',
                'status' => 1
            ], 200);
        }
    }
}
