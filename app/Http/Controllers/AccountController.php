<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Account;
use App\AccountType;

class AccountController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permissions')->only('list', 'opened', 'closed');
    }

    public function list(Request $request){
        $users = User::all();
        $userId = $request->route('user');
        User::findOrFail($userId);
        $accounts = Account::where('owner_id', $userId)->get();
        $account_types = AccountType::all();
        return view('accounts.list', compact('users', 'accounts', 'account_types'));
    }

    public function opened(Request $request){
		$users = User::all();
        $userId = $request->route('user');
        User::findOrFail($userId);
        $accounts = Account::where('owner_id', $userId)->get();
        $account_types = AccountType::all();
        return view('accounts.openedList', compact('users', 'accounts', 'account_types'));
    }

    public function closed(Request $request){
		$users = User::all();
        $userId = $request->route('user');
        User::findOrFail($userId);
        $accounts = Account::where('owner_id', $userId)->get();
        $account_types = AccountType::all();
        return view('accounts.closedList', compact('users', 'accounts', 'account_types'));
    }
    
    /*public function destroy(Request $request){
        $accountId = $request->route('account');
        $account = Account::findOrFail($accountId);
        if ($account->last_movement_date() == null){
            $account->delete();
        }
        return redirect()->back();
    }*/
}
