@extends('layouts.base')

@section('styles')

@endsection

@section('content')
<div class="card bg-white rounded shadow-sm">
  <h5 class="card-header bg-white">Edit Organization</h5>
    <div class="card-body">
        <form method="POST" class="row g-3 needs-validation" action="{{ route('organization.update', [$data->id]) }}" enctype="multipart/form-data">
            @method('PUT')
        	@csrf
            @include('organization.form')
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')

@endsection