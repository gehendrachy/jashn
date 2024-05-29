<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserDetail;
use Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    protected $redirectTo = RouteServiceProvider::USERHOME;

    public function __construct(){
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms_and_conditions' => ['accepted']
        ]);
    }

    public function verify(){
        return view('user.verification.notice');
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if(auth()->user() === null){
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                if(Auth::user()->roles()->first()->name !== "customer"){
                    Auth::logout();
                    return redirect()->back()->with('error', 'Please check if you are in right page');
                }
                // if(Auth::user()->email_verified_at == null){
                //     return redirect(route('verify'))->with('error', "Please verify your account!");
                // }
                if($request->redirect == "checkout"){
                    return redirect(route('shop'))->with('status', 'Logged in successfully');
                }
                
                return redirect(route('customer.my-account'))->with('status', 'Logged in succesfully');
            }
            return redirect()->back()->with('error', 'Email or Password might be mistaken!');
        }
        return redirect()->back()->with('error', 'Something is wrong!');
    }

    public function register(Request $request){

        if($request->terms_and_conditions !== "1"){
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        $data = $request->all();       
        
        $data['role'] = 'customer';

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'country_id' => isset($data['country_id']) ? $data['country_id'] : '',
            'country_name' => isset($data['country_name']) ? $data['country_name'] : '',
            'state_id' => isset($data['state_id']) ? $data['state_id'] : '',
            'state_name' => isset($data['state_name']) ? $data['state_name'] : '',
            'district_id' => isset($data['district_id']) ? $data['district_id'] : '',
            'district_name' => isset($data['district_name']) ? $data['district_name'] : '',
            'city_id' => isset($data['city_id']) ? $data['city_id'] : '',
            'city_name' => isset($data['city_name']) ? $data['city_name'] : '',
            'address' => $data['address'],
            'get_updates_via_sms' => $data['get_updates_via_sms'],
            'get_updates_via_email' => $data['get_updates_via_email'],
            'get_updates_on_chrome' => $data['get_updates_on_chrome']
        ]);

        $user->assignRole('customer');
        event(new Registered($user));

        auth()->login($user);

        return redirect(route('verification.notice'))->with('Please verify your account');
    }
}
