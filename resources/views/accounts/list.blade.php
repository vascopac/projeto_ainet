@extends('layouts.app')
@section('content')

@if (DB::table('accounts')->count() != 0)
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Status
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu">
            <a class="dropdown-item" href="{{ route('accounts_list', Auth::user()->id) }}">All accounts</a>
            <a class="dropdown-item" href="{{ route('openedAccounts_list', Auth::user()->id) }}">Open accounts</a>
            <a class="dropdown-item" href="{{ route('closedAccounts_list', Auth::user()->id) }}">Closed accounts</a>
        </div>
        <a class="btn btn-primary" style="float: right" href="{{ route('account_create') }}">Create account</a>
    </div>
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Code</th>
            <th>Type</th>
            <th>Current Balance</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        @foreach ($accounts as $account)
            @if ($user->id == $account->owner_id)
                <tr>
                    <td>{{ $account->code }}</td>
                    <td>{{ $account->type->name }}</td>
                    <td>{{ $account->current_balance }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('account_edit_index', $account) }}">Edit</a>
                    </td>
                </tr>
            @endif
        @endforeach
    @endforeach
    </table>

@else
    <h2>No accounts found</h2>
@endif

@endsection