<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request){

        $validator = Validator::make($request->all(), [
              'name' => 'required|string|max:255',
              'email' => 'required|string|email|max:255|unique:users',
              'password'=>'required|string|min:6|confirmed',
          ]);
  
          if($validator->fails()){
              return response(['errors'=>$validator->errors()->all()],422);
          }
  
          $user = new User([
              'name' => $request->name,
              'email' => $request->email,
              'password'=> Hash::make($request->password),
          ]);
  
          $user->save();
  
          return response()->json(['message'=>'User Created']);
  
      }
  
      public function login(Request $request){
          $user = User::where('email',$request->email)->first();
          if($user){
              if(Hash::check($request->password,$user->password)){
                  $token =  $user->createToken('Token Name')->accessToken;
                  return response()->json(['toke'=>$token],200);
              }
              else{
                  return response() -> json(['error'=> 'Password or Email missMatch'],422);
              }
          }
          return response() -> json(['error'=> 'Email Not Found'],422);
      }
}
