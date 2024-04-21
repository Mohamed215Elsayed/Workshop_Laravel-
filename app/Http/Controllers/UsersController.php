<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
/***************************/
class UsersController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        if($user){
        return response()->json([$user,'message' => 'user registered successfully','status'=>true]);
        }
        else{
        return response()->json(['message' => 'user not registered','status'=>false]);
        }
    }

    public function login(REQUEST $request){
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized,Invalid credentials'], 401);
        }
        $token = Auth::user()->createToken('MyApp')->plainTextToken;
        $success['name'] =  Auth::user()->name;
        $success['email'] =  Auth::user()->email;
        $success['token'] =  $token;
        $cookie = cookie('jwt', $token, 60*24);
        return response()->json(['message' => 'user logged in successfully','success' => $success], 200)->withCookie($cookie);
    }

    public function logout()
    {
        // $request->user()->currentAccessToken()->delete();
        Session::flush(); //if u open in more than one page
        Auth::logout();
        $cookie = Cookie::forget('jwt');
        return response()->json(['message' => 'user logged out successfully'], 200)->withCookie($cookie);
    }
}
