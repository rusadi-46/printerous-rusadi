@extends('layouts.base')

@section('styles')

@endsection

@section('content')
<div class="card bg-white rounded shadow-sm">
  <h5 class="card-header bg-white py-3">Add New User</h5>
	<div class="row py-4 px-2">
		<div class="col-md-4 col-6">
			<div class="form-group ">
				<div class="kt-input-icon kt-input-icon--right">
					<input type="text" class="form-control" placeholder="{{__('Search')}}..." id="generalSearch" value="{{ request()->query('generalSearch') }}" onblur="goto('{{ route('user.index', request()->except(['page', 'generalSearch'])) }}{{request()->except(['page', 'generalSearch']) ? '&' : '?'}}generalSearch=' + this.value)">
				</div>
			</div>
		</div>
		<div class="col-md-8 col-6" align="right">
			<a href="{{ route('user.create') }}" class="btn btn-primary">Add New</a>
		</div>
	</div>
	<div class="row py-2 px-2">
		<div class="col-md-12 col-12">
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th width="11%" class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($table as $key => $element)
							<tr>
								<th scope="row" class="text-center">{{$key + 1}}</th>
								<td class="text-pre-line">{{$element['name']}}</td>
								<td class="text-pre-line">{{$element['email']}}</td>
								<td class="text-center">
									<div class="row">
										<div class="col-md-4">
											<a href="{{ route('user.edit', [$element['id']]) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
										</div>
										<div class="col-md-4">
											<form method="POST" action="{{ route('user.destroy', [$element['id']]) }}" id="kt_form_{{$key}}" id="kt_form_{{$key}}">
												@csrf
												@method('DELETE')
												<button type="button" id="delete_btn_{{$key}}" class="btn btn-danger" onclick="deleteForm('kt_form_{{$key}}', 'delete_btn_{{$key}}', '{{__('Are you sure?')}}', '{{__("You will not be able to revert this!")}}', '{{__('Delete')}}', '{{__('Cancel')}}')"><i class="fas fa-trash"></i></button>
											</form>
										</div>									
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="14" class="text-center">No data found to display </td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-12">
			{{ $table->onEachSide(5)->links() }}
		</div>
	</div>
</div>
@endsection

@section('scripts')

@endsection