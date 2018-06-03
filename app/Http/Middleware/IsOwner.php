<?php

namespace App\Http\Middleware;

use App\Account;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class IsOwner
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
        $account = Account::findOrFail($request->route('account'));
        if (Auth::user()->id == $account->owner_id ){
            return $next($request);
        }

        $error = "You are not the owner of the account!";

        return Response::make(view('home', compact('error')), 403);
    }
}
