<?php

namespace App\Http\Controllers;

use App\Rules\AccountEditRule;
use App\Rules\AccountRule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Account;
use App\AccountType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AccountController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permissions')->only('list', 'opened', 'closed');

        $this->middleware('owner')->only('update', 'delete', 'close', 'reopen');

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

    public function create()
    {
        $account_types = AccountType::all();
        return view('accounts.create', compact('account_types'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_type_id' => 'required|exists:account_types,id',
            'code' => ['required',new AccountRule()],
            'date' => 'nullable|date',
            'start_balance' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $account = new Account();
        $account->fill($validatedData);
        if (!array_key_exists('date', $validatedData) || $validatedData['date'] == null)
        {
            $account->date = Carbon::now()->format('Y-m-d');
        }
        $account->owner_id = Auth::user()->id;
        $account->current_balance = $account->start_balance;
        $account->save();

        return redirect()->route('accounts_list', Auth::user()->id)->with('success', 'Account created successfully!');
    }

    public function edit(Request $request)
    {
        $account_types = AccountType::all();
        $account = Account::findOrFail($request->route('account'));
        return view('accounts.edit', compact('account', 'account_types'));
    }

    public function update(Request $request)
    {
        if(!$account = Account::findOrFail($request->route('account'))){
            $error = "Invalid account!";
            return Response::make(view('home', compact('error')), 404);
        }

        $validatedData = $request->validate([
            'account_type_id' => 'required|exists:account_types,id',
            'code' => ['required',new AccountRule()],
            'date' => 'nullable|date',
            'start_balance' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $account->account_type_id = $validatedData['account_type_id'];
        $account->code = $validatedData['code'];
        $old_start_balance = $account->start_balance;
        $account->start_balance = $validatedData['start_balance'];
        $account->date = $validatedData['date'];
        if (array_key_exists('description', $validatedData) || $validatedData['description'] != null){
            $account->description = $validatedData['description'];
        }

        if (!array_key_exists('date', $validatedData) || $validatedData['date'] == null)
        {
            $account->date = Carbon::now()->format('Y-m-d');
        }
        
        $account->save();


        return redirect()->route('accounts_list', Auth::user()->id)->with('success', 'Account edited successfully!');
    }

}
