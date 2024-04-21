<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AuthController extends Controller
{
    
    public function user()
    {
        return Auth::user();
    }
    public function register(Request $request)
    {
        //  return User::create([
        //     'name' => $request->input('name'),
        //     'email' => $request->input('email'),
        //     'password' => Hash::make($request->input('password'))
        // ]);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], Response::HTTP_OK);
        
    }

    // public function login(Request $request){
    // if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response([
    //             'message' => 'Invalid credentials!'
    //         ], Response::HTTP_UNAUTHORIZED);
    //     }

    //     $user = Auth::user();

    //     $token = $user->createToken('token')->plainTextToken;

    //     $cookie = cookie('jwt', $token, 60 * 24); // 1 day

    //     return response([
    //         'message' => $token
    //     ])->withCookie($cookie);
    // }

    public function login(Request $request)
    {
    //     if (!Auth::attempt([
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //     ])){
    //         return response()->json([
    //             'message' => 'Invalid login details'
    //         ], 401);
    //     }
    // return response([
    //             'message' => 'Invalid credentials!'
    //         ], Response::HTTP_UNAUTHORIZED);//401
    //     }
    //is true but not cleaner than the next line
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials!'
            ],401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 24); // 1 day
        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ])->withCookie($cookie);
    }
    
    public function logout()
    {
        Session::flush(); 
        // Auth::logout();
        $cookie = Cookie::forget('jwt');
        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }
}
