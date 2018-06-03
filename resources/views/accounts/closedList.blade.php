@extends('layouts.app')
@section('content')

@if (DB::table('accounts')->count() != 0)

<table class="table table-striped">
<thead>
    <tr>
        <th>Code</th>
        <th>Type</th>
        <th>Current Balance</th>
    </tr>
</thead>
<tbody>
@foreach ($users as $user)
    @foreach ($accounts as $account)
        @if ($user->id == $account->owner_id)
            @if ($account->isDeleted() == true)
                <tr>
                    <td>{{ $account->code }}</td>
                    <td>{{ $account->typeToStr->name }}</td>
                    <td>{{ $account->current_balance }}</td>
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