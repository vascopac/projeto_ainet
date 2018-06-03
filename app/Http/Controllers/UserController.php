<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Resources\Views\Users;
use App\User;



class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('admin');

        $this->middleware('canChange')->except('index');
    }

    public function index()
    {
        $users = User::all();

        return view('users.list', compact('users'));
    }

    public function promote(User $user)
    {
        $user->admin = 1;
        $user->save();

        return redirect()->back();
    }

    public function demote(User $user)
    {
        $user->admin = 0;
        $user->save();

        return redirect()->back();
    }

    public function block(User $user)
    {
        $user->blocked = 1;
        $user->save();
        
        return redirect()->back();
    }

    public function unblock(User $user)
    {
        $user->blocked = 0;
        $user->save();
        
        return redirect()->back();
    }
}
