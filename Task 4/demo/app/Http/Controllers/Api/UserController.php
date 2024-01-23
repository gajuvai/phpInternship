<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($flag)
    {
        //flag is 1 active users
        //flag is 0 for all users
        // $users = User::select('name', 'email')->where('status', 1)->get();
        $query = User::select('name', 'email');
        if($flag == 1){
            $query->where('status', 1);
        }else if($flag == 0){
            //empty
        }else{
            return response()->json([
                'Message' => 'Invalid variable passed',
                'status' => 0
            ], 400);
        }

        $users = $query->get();
        if(count($users) > 0){
            $response = [
                'message' => count($users).' user found..',
                'status' => 1,
                'data' => $users
            ];
            return response()->json($response, 200);
        }else{
            return response()->json([
                'Message' => 'User not found'
            ], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required'],
            'address' => ['required'],
            'postcode' => ['required', 'min:6']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }else{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'postcode' => $request->postcode,
                'contact' => $request->contact
            ];
            // p($data);
            DB::beginTransaction();
            try{
                $user = User::create($data);
                DB::commit();
            }catch (\Exception $e) {
                DB::rollback();
                $user = null;
            }
            if($user != null){
                //if ok
                return response()->json([
                    'message' => 'User registered successfully'
                ], 200);
            }else{
                return response()->json([
                    'message' => 'Internal server error'
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(is_null($user)){
            $response = [
                'message' => 'user not found'
            ];
        }else{
            $response = [
                'message' => 'user found',
                'satus' => 1,
                'data' => $user
            ];
        }
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'status' => 0,
                'message' => "User id not exist"
            ], 400);
        }else{
            try {
                DB::beginTransaction();
    
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->contact = $request->input('contact');
                $user->address = $request->input('address');
                $user->postcode = $request->input('postcode');
                $user->save();
    
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                
                return response()->json([
                    'status' => 0,
                    'message' => "Internal server error",
                    'error' => $e->getMessage()
                ], 500);
            }
            return response()->json([
                'status' => 1,
                'message' => "User updated successfully"
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(is_null($user)){
            $response = [
                'message' => 'user doesnot exits',
                'status' => 0
            ];
            $resCode = 400;
        }else{
            DB::beginTransaction();
            try{
                $user->delete();
                DB::commit();
                $response = [
                    'message' => 'user deteleted successfully',
                    'status' => 1
                ];
                $resCode = 400;
            }catch(\Exception $e){
                DB::rollBack();
                $response = [
                    'message' => 'Internal server error',
                    'status' => 0
                ];
                $resCode = 500;
            }
        }
        return response()->json($response, $resCode);
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'status' => 0,
                'message' => "User id not exist"
            ], 400);
        }else{
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

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required'],
            'address' => ['required'],
            'postcode' => ['required', 'min:6']
        ]);

        $user = User::create($validatedData);
        $token = $user->createToken("authToken")->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'User created successfully',
            'status' => 1
        ]);

    }
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where(['email' => $validatedData['email'], 'password' => $validatedData['password']])->first();
        $token = $user->createToken("authToken")->accessToken;
        
        if(is_null($user)){
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 0
            ], 400);
        }else{
            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'Login successfully',
                'status' => 1
            ],200);
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
