<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->only(['firstname', 'lastname', 'email', 'password']), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }else{
            $user = new User();
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if($user->save()){
                return response()->json([
                    'user' => $user,
                    'token' => $user->createToken('user_token')->plainTextToken
                ], 201);
            }
        }
    }

    public function login(Request $request){
        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }else{
            $user = User::where('email', $request->email)->first();
            if(!$user || !Hash::check($request->password, $user->password)){
                return response([
                    'message' => 'Invalid credentials'
                ], 401);
            }else{
                return response([
                    'user' => $user,
                    'token' => $user->createToken('user_token')->plainTextToken
                ], 201);
            }
        }
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response(['status' => '200'], 201);
    }
}
