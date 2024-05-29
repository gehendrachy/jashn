<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $data['role'] = 'customer';
        // dd($data);

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

        return $user;
    }
}
