<div class="col-md-12">
    <span class="text-danger">Required (*) </span>
</div>

<div class="col-md-6">
    <label class="form-label">Account Manager <span class="text-danger">*</span></label>
    @if (\Auth::user()->is_admin == true)
        <select class="form-control @error('user_id') is-invalid @enderror" name="user_id">
            <option>Select account manager</option>
            @foreach ($user as $element)
    			<option value="{{$element->id}}" {{old('user_id') == $element->id ? 'selected' : (isset($data) && $data->user_id == $element->id ? 'selected' : '')}}>{{$element->name}}</option>
    		@endforeach
        </select>
    @else
        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ \Auth::user()->name }}" readonly>
        <input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
    @endif
    @error('user_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-6">
    <label class="form-label">Name <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $data->name ?? old('name') }}">
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
    <label class="form-label">Email <span class="text-danger">*</span></label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$data->email ?? old('email')}}">
    @error('name')
	    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-md-6">
    <label class="form-label">Website <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ $data->website ?? old('website')}}">
    @error('website')
	    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-md-6">
    <label class="form-label">Logo <span class="text-danger">*</span></label>
    <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo">
    @error('logo')
	    <div class="invalid-feedback">{{ $message }}</div>
	@enderror
	@if (isset($data))
		<a href="{{$data->logo_link}}" target="_blank">
			<small>{{$data->logo}}</small>
		</a>
    @endif
</div>
