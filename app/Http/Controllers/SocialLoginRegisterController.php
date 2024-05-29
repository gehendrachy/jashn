<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use App\Models\User;

class SocialLoginRegisterController extends Controller
{
    public function redirect($provider)
    {
    	return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();

        // dd($userSocial);
        $user = User::where(['email' => $userSocial->getEmail()])->first();

        if($user){

            Auth::login($user);

            return redirect()->to('/');
            dd($user);

        }else{

        	$user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
            ]);         
            Auth::login($user);

            return redirect()->to('/customer/account/profile');
        }

    }


}
