<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Register(Request $req)
    {
        //valdiate
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6'
        ];

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        //create new user in users table
        $user = User::create([
            'name' => $req['name'],
            'email' => $req['email'],
            'password' => Hash::make($req->password)
        ]);
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $response = ['user' => $user, 'token' => $token];
        return response()->json($response, 200);
    }


    public function login(Request $req)//login
    {
    // validate inputs
    $rules = [
        'email' => 'required',
        'password' => 'required|string'
    ];
    $req->validate($rules);
    // find user email in users table
    
    $user = User::where('email', $req->email)->first();
    // if user email found and password is correct
    if ($user && Hash::check($req->password, $user->password)) {
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $response = ['user' => $user, 'token' => $token];
        return response()->json($response, 200);
    }
    $response = ['message' => 'Incorrect email or password'];
    return response()->json($response, 400);
}

public function logout(Request $request){
    $request->user()->currentAccessToken()->delete();
    return response()->json([
        'message'=> 'User successfully Logged out',
        'data' =>$request->user()
    ],200);
}
}
