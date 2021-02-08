@extends('layouts.base')

@section('styles')

@endsection

@section('content')
<div class="card bg-white rounded shadow-sm">
  <h5 class="card-header bg-white">Add New User</h5>
    <div class="card-body">
        <form class="row g-3 needs-validation" method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
            @csrf
            @include('user.form')
            <div class="col-12">
                <button class="btn btn-primary" type="submit">
                  Submit
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')

@endsection