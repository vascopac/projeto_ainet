@extends('master')
@section('content')
<?php
if (count($errors) > 0) {
    include 'resources/views/partials/errors.php';
}
?>
<form action="{{ action('UserController@store') }}" method="post" class="form-group">
    <input type="hidden" name="user_id" value="<?= $user->user_id ?>" />
    <?php require 'resources/views/users/partials/add-edit.php'?>
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Save</button>
        <button type="submit" class="btn btn-default" name="cancel">Cancel</button>
    </div>
</form>
@endsection('content')