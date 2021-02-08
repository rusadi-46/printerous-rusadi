<div class="col-md-12">
    <span class="text-danger">Required (*) </span>
</div>
<div class="col-md-12">
    <label class="form-label">Name <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $data->name ?? old('name') }}">
	@error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-md-6">
    <label class="form-label">Role User <span class="text-danger">*</span></label>
    <select class="form-control @error('is_admin') is-invalid @enderror" name="is_admin">
        <option>Select role user</option>
        <option value="1" {{old('is_admin') == "1" ? 'selected' : (isset($data) && $data->is_admin == "1" ? 'selected' : '')}}>Admin</option>
        <option value="0" {{old('is_admin') == "0" ? 'selected' : (isset($data) && $data->is_admin == "0" ? 'selected' : '')}}>Account Manager</option>
    </select>
    @error('is_admin')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-md-6">
    <label class="form-label">Email <span class="text-danger">*</span></label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$data->email ?? old('email')}}">
    @error('name')
	    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@if (!isset($data))
    <div class="col-md-6">
        <label class="form-label">Password <span class="text-danger">*</span></label>
        <div class="input-group" id="show_hide_password">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $data->password ?? old('password') }}">
            <div class="input-group-text">
                <a href="#" class="password-style"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
            </div>
        </div>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
        <div class="input-group" id="show_hide_password_confirm">
            <input class="form-control" type="password" name="password_confirmation">
            <div class="input-group-text">
                <a href="#"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
@endif