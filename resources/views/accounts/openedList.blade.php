@extends('layouts.app')
@section('content')

@if (DB::table('accounts')->count() != 0)

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
                    <td>{{ $account->typeToStr->name }}</td>
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