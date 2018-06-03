<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

        $this->middleware('owner')->only('delete', 'close', 'reopen');

        $this->middleware('canDelete')->only('delete');
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
    
    public function delete(Request $request){
        $account = Account::findOrFail($request->route('account'));
        $account->delete();
        return redirect()->back();
    }

    public function close(Request $request){
        $account = Account::findOrFail($request->route('account'));
        $account->deleted_at = Carbon::now();
        $account->save();
        return redirect()->back();
    }

    public function reopen(Request $request){
        $account = Account::findOrFail($request->route('account'));
        $account->deleted_at = null;
        $account->save();
        return redirect()->back();
    }


}
