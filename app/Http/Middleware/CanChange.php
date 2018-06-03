<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\User;

class CanChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::user()->id != $request->route('user')->id) {
            return $next($request);
        }

        $request->session()->flash('errors', 'You can\'t change your own type or status!');
        $users = User::all();

        return Response::make(view('users.list', compact('users')), 403);

    }
}
