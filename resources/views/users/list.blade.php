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
    </tr>
</thead>
<tbody>
@foreach ($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->typeToStr() }}</td>
        <td>{{ $user->statusToStr() }}</td>
            <td>
                @if ($user->admin === 0)
                    <form action="{{ route('user_promote', $user->id) }}" method="POST" role="form" class="inline">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="user_id" value="{{ intval($user->id) }}">
                        <button type="submit" class="btn btn-xs btn-primary">Promote</button>
                    </form>
                @else
                    <form action="{{ route('user_demote', $user->id) }}" method="POST" role="form" class="inline">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="user_id" value="{{ intval($user->id) }}">
                        <button type="submit" class="btn btn-xs btn-danger">Demote</button>
                    </form>
                @endif
            </td>
            <td>
                @if ($user->blocked === 0)
                    <form action="{{ route('user_block', $user->id) }}" method="POST" role="form" class="inline">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="user_id" value="{{ intval($user->id) }}">
                        <button type="submit" class="btn btn-xs btn-primary">Block</button>
                    </form>
                @else
                    <form action="{{ route('user_unblock', $user->id) }}" method="POST" role="form" class="inline">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="user_id" value="{{ intval($user->id) }}">
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