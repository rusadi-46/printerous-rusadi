@extends('layouts.base')

@section('styles')

@endsection

@section('content')
<div class="card bg-white rounded shadow-sm">
  <h5 class="card-header bg-white">Add New Organization</h5>
    <div class="card-body">
        <form class="row g-3 needs-validation" method="post" action="{{ route('organization.store') }}" enctype="multipart/form-data">
            @csrf
            @include('organization.form')
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