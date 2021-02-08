@extends('layouts.base')

@section('styles')

@endsection

@section('content')
<div class="card bg-white rounded shadow-sm">
  <h5 class="card-header bg-white">Add New Person</h5>
    <div class="card-body">
        <form class="row g-3 needs-validation" method="post" action="{{ route('organization.person.store', [$organization->id]) }}" enctype="multipart/form-data">
            @csrf
            @include('person.form')
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