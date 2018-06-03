<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('admin')->only('index', 'promote', 'demote', 'block', 'unblock');

        $this->middleware('canChange')->only('promote', 'demote', 'block', 'unblock');
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

    public function getProfiles(Request $request){
        $users = $this->profilesFilterByName($request);
        $associates = DB::table('associate_members')->where('main_user_id', Auth::user()->id)->get();
        $associate_of = DB::table('associate_members')->where('associated_user_id', Auth::user()->id)->get();
        return view('users.profileList', compact('users', 'associates', 'associate_of'));
    }

    public function profilesFilterByName(Request $request){
        //Somente o campo nome preenchido
        if ($request->filled('name'))
            return User::where('name', 'like', "%{$request->query('name')}%")->get();
        return User::all();
    }
    
    public function getAssociates(){
        $users = User::all();
        $associates = DB::table('associate_members')->where('main_user_id', Auth::user()->id)->get();
        return view('users.associates', compact('users', 'associates'));
    }

    public function getAssociateOf(){
        $users = User::all();
        $associate_of = DB::table('associate_members')->where('associated_user_id', Auth::user()->id)->get();
        return view('users.associateOf', compact('users', 'associate_of'));
    }
}
