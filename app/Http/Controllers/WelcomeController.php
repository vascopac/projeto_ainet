<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function statistics()
    {
    	$statistics = [
	        'users' => DB::table('users')->count(),
	        'accounts' => DB::table('accounts')->count(),
	        'movements' => DB::table('movements')->count(),
    	];
    	return view('welcome', compact('statistics')); 
    }
}
