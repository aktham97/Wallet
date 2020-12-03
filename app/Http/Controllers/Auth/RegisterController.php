<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'country_code'=>['required'],
            'phone_code'=>['required','unique:users'],
            'birthdate'=>['nullable'],
            'password' => ['required', 'string','regex:/[a-z]/','regex:/[0-9]/', 'min:8', 'confirmed'],
            'user_image'=>['required','mimes:jpeg,bmp,png','max:5120']
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $file=$data['user_image'];
        $name=$file->getClientOriginalName();
        $file->move('images',$name);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'country_code'=>$data['country_code'],
            'phone_code'=>$data['phone_code'],
            'birthdate'=>$data['birthdate'],
            'password' => Hash::make($data['password']),
            'user_image'=>$name,

        ]);
    }
}
