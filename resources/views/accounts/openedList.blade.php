@extends('layouts.app')
@section('content')

@if (DB::table('accounts')->count() != 0)
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <th>Delete/Close</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        @foreach ($accounts as $account)
            @if ($user->id == $account->owner_id)
                @if ($account->isDeleted() == false)
                    <tr>
                        <td>{{ $account->code }}</td>
                        <td>{{ $account->type->name }}</td>
                        <td>{{ $account->current_balance }}</td>
                        <td>
                            @if($account->canDelete() == true)
                                <form action="{{ route('account_delete', $account) }}" method="POST" role="form" class="inline">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="account" value="{{ $account }}">
                                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                                </form>
                            @else
                                <form action="{{ route('account_close', $account) }}" method="POST" role="form" class="inline">
                                    @method('PATCH')
                                    @csrf
                                    <input type="hidden" name="account_id" value="{{ $account }}">
                                    <button type="submit" class="btn btn-xs btn-primary">Close</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endif
            @endif
        @endforeach
    @endforeach
    </table>
@else
    <h2>No accounts found</h2>
@endif

@endsection