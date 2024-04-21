<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class GoogleController extends Controller
{
    public function formg()
    {
        return Socialite::driver('google')->redirect();
    }
    public function loging()
    {
        $user = Socialite::driver('google')->user();
        // dd($user);
        $check_user = User::where('google_id', $user->id)->first();
        if(!$check_user){
            $new_user = User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'google_id' => $user->getId(),
            ]);
            Auth()->login($new_user);
            return redirect()->intended('dashboard');
        }else{
            Auth()->login($check_user);
            return redirect()->intended('dashboard');
            
        }
        }
    }

