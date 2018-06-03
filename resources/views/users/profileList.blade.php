@extends('layouts.app')
@section('content')

@if (DB::table('users')->count() != 0)
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" style="float: right"  id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Associate
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu">
            <a class="dropdown-item" href="{{ route('profile_list') }}">All Profiles List</a>
            <a class="dropdown-item" href="{{ route('associates') }}">Associates List</a>
            <a class="dropdown-item" href="{{ route('associateOf') }}">Associate Of List</a>
        </div>
    </div>
    <form action="{{action('UserController@getProfiles')}}" method="GET">
                    <input name="name" placeholder="Name">
                    <input type="submit" value="Search" >
    </form>
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Associate</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>
                @if ($user->profile_photo == null)
                    <img src="{{ asset('storage/profiles/default.jpeg')}}" style="width:100px;height:100px;">
                @else
                    <img src="{{ asset('storage/profiles/' . $user->profile_photo)}}" style="width:100px;height:100px;">
                @endif
            </td>
            <td>{{ $user->name }}</td>
            <td>
                @foreach ($associates as $associate)
                    @if ($user->id == $associate->associated_user_id)
                        <span>Associate</span>
                    @endif
                @endforeach
                @foreach ($associate_of as $associated)
                    @if ($user->id == $associated->main_user_id)
                        <span>Associate-of</span>
                    @endif
                @endforeach
            </td>
        </tr>
    @endforeach
    </table>
@else
    <h2>No users found</h2>
@endif

@endsection