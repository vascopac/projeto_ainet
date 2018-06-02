<div class="form-group">
    <label for="inputFullname">Fullname</label>
    <input
        type="text" class="form-control"
        name="name" id="inputName"
        placeholder="Name" value="{{ old('name') }}" />
        @if ($errors->has('name'))
            <em>{{ $errors->first('name') }}</em>
        @endif
</div>
<div class="form-group">
    <label for="inputType">Type</label>
    <select name="type" id="inputType" class="form-control">
        <option disabled selected> -- select an option -- </option>
        <option {{ old('type', strval($user->type))==='0' ? 'Selected' : '' }} value="0">Administrator</option>
        <option {{ old('type', strval($user->type))==='1' ? 'Selected' : '' }} value="1">Publisher</option>
        <option {{ old('type', strval($user->type))==='2' ? 'Selected' : '' }} value="0">Client</option>
    </select>
</div>
<div class="form-group">
    <label for="inputEmail">Email</label>
    <input
        type="email" class="form-control"
        name="email" id="inputEmail"
        placeholder="Email address" value="{{ old('email', $user->email) }}"/>
</div>
