@extends('layouts.app')
@section('content')

@if (DB::table('users')->count())

<table class="table table-striped">
<thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Type</th>
        <th>Status</th>
        <th>Promote</th>
        <th>Block</th>

    </tr>
</thead>
<tbody>
@foreach ($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        @if ($user->admin)
            <td class="user-is-admin">{{ $user->typeToStr() }}</td>
        @else
            <td>{{ $user->typeToStr() }}</td>
        @endif
        @if ($user->blocked)
            <td class="user-is-blocked">{{ $user->statusToStr() }}</td>

        @else
            <td>{{ $user->statusToStr() }}</td>
        @endif
            <td>
                @if ($user->admin === 0)
                    <form action="{{ route('user_promote', $user) }}" method="POST" role="form" class="inline">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="user" value="{{ $user }}">
                        <button type="submit" class="btn btn-xs btn-primary">Promote</button>
                    </form>
                @else
                    <form action="{{ route('user_demote', $user) }}" method="POST" role="form" class="inline">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="user" value="{{ $user }}">
                        <button type="submit" class="btn btn-xs btn-danger">Demote</button>
                    </form>
                @endif
            </td>
            <td>
                @if ($user->blocked === 0)
                    <form action="{{ route('user_block', $user) }}" method="POST" role="form" class="inline">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="user" value="{{ $user }}">
                        <button type="submit" class="btn btn-xs btn-primary">Block</button>
                    </form>
                @else
                    <form action="{{ route('user_unblock', $user) }}" method="POST" role="form" class="inline">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user }}">
                        <button type="submit" class="btn btn-xs btn-danger">Unblock</button>
                    </form>
                @endif
            </td>
    </tr>
@endforeach
</table>

@else
    <h2>No users found</h2>
@endif

@endsection