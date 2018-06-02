@extends('master')
@section('content')

{{ dump($errors) }}

<form action="{{ action('UserController@store') }}" method="post" class="form-group">
    {{csrf_field()}}
    @include('users.partials.add-edit')
    <div class="form-group">
        <label for="inputPassword">Password</label>
        <input
            type="password" class="form-control"
            name="password" id="inputPassword"
            value="{{ old('password') }}"/>
    </div>
    <div class="form-group">
        <label for="inputPasswordConfirmation">Password confirmation</label>
        <input
            type="password" class="form-control"
            name="password_confirmation" id="inputPasswordConfirmation"/>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Add</button>
        <button type="submit" class="btn btn-default" name="cancel">Cancel</button>
    </div>
</form>
@endsection('content')