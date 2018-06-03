<?php

namespace App\Http\Middleware;

use App\Account;
use Closure;
use Illuminate\Support\Facades\Response;

class CanDelete
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
        if ($account->canDelete() == true){
            return $next($request);
        }

        $error = "You can\'t delete this account!";

        return Response::make(view('home', compact('error')), 403);
    }
}
