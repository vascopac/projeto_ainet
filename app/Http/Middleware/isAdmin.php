<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;

class isAdmin
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
        if ($request->user() && $request->user()->admin == 1) {
            return $next($request);
        }
        
        $error = "You must be administrator to enter in this page!";

        return Response::make(view('home', compact('error')), 403);
    }
}
