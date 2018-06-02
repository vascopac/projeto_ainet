<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Resources\Views\Users;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.list', compact('users'));
    }

    public function promote(Request $request)
    {
        $userId = intval($request->input('user_id'));
        $user = User::findOrFail($userId);
        if (is_null($user)) {
            return $this->index();
        }

        if ($userId === Auth::id()) {
            return $this->index();
        }

        if ($user->admin === 0) {
            $user->admin = 1;
        }

        $user->save();

        return $this->index();
    }

    public function demote(Request $request)
    {
        $userId = intval($request->input('user_id'));
        $user = User::findOrFail($userId);
        if (is_null($user)) {
            return $this->index();
        }

        if ($userId === Auth::id()) {
            return $this->index();
        }

        if ($user->admin === 1) {
            $user->admin = 0;
        }

        $user->save();

        return $this->index();
    }

    public function block(Request $request)
    {
        $userId = intval($request->input('user_id'));
        $user = User::findOrFail($userId);
        if (is_null($user)) {
            return $this->index();
        }

        if ($userId === Auth::id()) {
            return $this->index();
        }

        if ($user->blocked === 0) {
            $user->blocked = 1;
        }

        $user->save();
        
        return $this->index();
    }

    public function unblock(Request $request)
    {
        $userId = intval($request->input('user_id'));
        $user = User::findOrFail($userId);
        if (is_null($user)) {
            return $this->index();
        }

        if ($userId === Auth::id()) {
            return $this->index();
        }

        if ($user->blocked === 1) {
            $user->blocked = 0;
        }


        $user->save();
        
        return $this->index();
    }
}
