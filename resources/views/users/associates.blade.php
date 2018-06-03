@extends('layouts.app')
@section('content')

@if (DB::table('users')->count() != 0)

<table class="table table-striped">
<thead>
    <tr>
        <th>Photo</th>
        <th>Name</th>
        <th>Email</th>
    </tr>
</thead>
<tbody>
@foreach ($users as $user)
    @foreach ($associates as $associate)
        @if ($user->id == $associate->associated_user_id)
            <tr>
                <td>
                    @if ($user->profile_photo == null)
                        <img src="{{ asset('storage/profiles/default.jpeg')}}" style="width:100px;height:100px;"> 
                    @else
                        <img src="{{ asset('storage/profiles/' . $user->profile_photo)}}" style="width:100px;height:100px;">
                    @endif
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
            </tr>
        @endif
    @endforeach
@endforeach
</table>

@else
    <h2>No users found</h2>
@endif

@endsection