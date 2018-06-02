<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
    protected $redirectTo = '/home';

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
            'name' => 'required|string|regex:/^[\pL\s]+$/u|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed',
            'phone' => 'nullable|regex:/^[0-9 +\s]+$/',
            'profile_photo' => 'nullable|mimes:jpeg,bmp,png,jpg',
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
        $path = null;
        if (array_key_exists('profile_photo', $data)) {
            $photo = $data['profile_photo'];
            do{
                $path = str_random(32) . '.' . $photo->getClientOriginalExtension();
            }while (count(User::where('profile_photo', $path)->get())>0);
            Storage::disk('public')->putFileAs('profiles', $photo, $path);
        }
        /*if (!empty(request()->file('profile_photo'))) {
            if (request()->file('profile_photo')->isValid()) {
                $path= Storage::putFile('public/profiles', request()->file('profile_photo'));
            }
        }*/
        

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'profile_photo' => $path,
        ]);
    }
}
