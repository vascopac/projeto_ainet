<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;
use Auth;
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
        if ($request->route('user')->id != $request->user()->id) {
            return $next($request);
        }

        $request->session()->flash('errors', 'You can\'t change your own type or status!');
        $users = User::all();

        return Response::make(view('users.list', compact('users')), 403);

    }
}
