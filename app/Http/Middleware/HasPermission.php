<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class HasPermission
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
        User::findOrFail($request->route('user'));
        if (Auth::user()->id == $request->route('user') || count(DB::table('associate_members')->where('associated_user_id', Auth::user()->id)->where('main_user_id', $request->route('user'))->get()) > 0){
            return $next($request);
        }

        $error = "You don\'t have permission to do that!";

        return Response::make(view('home', compact('error')), 403);
    }
}
