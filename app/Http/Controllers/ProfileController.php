<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User; 

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users.changeProfile');
    }

    public function changeProfile(Request $request){
		$validatedData = $request->validate([
            'name' => 'required|string|regex:/^[\pL\s]+$/u|max:255',
            'email' => ['required','string','email','max:255', Rule::unique('users')->ignore(Auth::user()->id)],
            'phone' => 'nullable|regex:/^[0-9 +\s]+$/',
            'profile_photo' => 'nullable|mimes:jpeg,bmp,png,jpg',
        ]);

        $path = Auth::user()->profile_photo;
        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            do{
                $path = str_random(32) . '.' . $photo->getClientOriginalExtension();
        	}while (count(User::where('profile_photo', $path)->get())>0);
            Storage::disk('public')->putFileAs('profiles', $photo, $path);

        }

        $user = Auth::user();
       	$user->email = $request->input('email');
		$user->name = $request->input('name');
		$user->phone = $request->input('phone') ?? null;
        $user->profile_photo = $path;
        $user->update();

        return redirect()->back()->with("success","Profile updated successfully !");
    }
}
