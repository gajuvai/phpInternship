<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * login user
     */
    public function loginUser(Request $request): Response
    {
        $input = $request->all();

        Auth::attempt($input);

        $user = Auth::user();

        $token = $user->createToken('User Token')->accessToken;
        return Response(['status' => 200, 'token' => $token], 200);
    }

    /**
     * display user details
     */
    public function getUserDetail(): Response
    {
        if(Auth::guard('api')->check()){

            $user = Auth::guard('api')->user();
            return Response(['data' => $user], 200);
        }

        return Response(['data' => 'Unauthorized'], 404);
    }

    /**
     *  logout login user
     */
    public function userLogout(): Response
    {
        if(Auth::guard('api')->check()){

            $accessToken =Auth::guard('api')->user()->token();

            \DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update(['revoked' => true]);
            $accessToken->revoke();

            return Response(['data' => 'Unauthorized', 'message' => 'User logout successfully.'],200);
        }
        return Response(['data' => 'Unauthorized'], 404);
       }

}
