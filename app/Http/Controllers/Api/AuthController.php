<?php

namespace App\Http\Controllers\Api;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{


    public function login(Request $request)
    {
        $validation = Validator::make($request->all() , [
            'email' => 'required' ,
            'password' => 'required' ,
        ]);

        if ($validation->fails()){
            return apiResponse(400 , 'validation error' , $validation->errors() );
        }

        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return apiResponse(401 , 'Invalid credentials' );
        }

        return apiResponse(200 , 'user logged in successfully' , [$this->respondWithToken($token)  , Auth::user()] );
    }



    public function register(Request $request)
    {
        $validation = Validator::make($request->all() , [
            'name' => 'required' ,
            'email' => 'required|email|unique:users,email,except,id' ,
            'password' => 'required' ,
        ]);

        if ($validation->fails()){
            return apiResponse(400 , 'validation error' , $validation->errors() );
        }

        User::create([
            'name'=>$request->name ,
            'email'=>$request->email ,
            'password'=> Hash::make($request->password ),
        ]);

        return apiResponse(200 , 'user registered successfully' , $this->respondWithToken(auth()->attempt($request->only('email', 'password'))) );

    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
