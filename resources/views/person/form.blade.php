<div class="col-md-12">
    <span class="text-danger">Required (*) </span>
</div>
<div class="col-md-6">
    <label class="form-label">Name <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $data->name ?? old('name') }}">
	@error('name')
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
<div class="col-md-6">
    <label class="form-label">Phone <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $data->phone ?? old('phone') }}">
    @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-md-6">
    <label class="form-label">Avatar <span class="text-danger">*</span></label>
    <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar">
    @error('avatar')
	    <div class="invalid-feedback">{{ $message }}</div>
	@enderror
    @if (isset($data))
    	<a href="{{$data->avatar_link}}" target="_blank">
    		<small>{{$data->avatar}}</small>
    	</a>
    @endif
</div>
