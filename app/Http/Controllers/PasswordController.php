<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class PasswordController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users.changePass');
    }

    public function changePassword(Request $request){
		$validatedData = $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:3|confirmed|different:old_password',
        ]);

		if (!(Hash::check($request->input('old_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->withErrors(['old_password' => ['Your current password does not matches with the password you provided. Please try again.']]);
        }
 
        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");
    }
}
