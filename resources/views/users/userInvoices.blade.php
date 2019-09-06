@extends('layouts.main')

@section('title-section')
{{$user->first_name}} Notification | @parent
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['active'=>14])
		</div>
		<div class="col-md-10"
>			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<ul class="list-group">
				<li class="list-group-item">
					<div class="text-center">
						<h3>{{$user->first_name}} {{$user->last_name}}<br><small>{{$user->email}}</small></h3>
					</div>
				</li>
			</ul>
			<h3 class="text-center">Notifications</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="notificationTable">
					<thead>
						<tr>
							<th>Project Name</th>
							<th>Date of Progress</th>
							<th>Description</th>
							<th>Details</th>
						</tr>
					</thead>
					<tbody>
						@if($projects->count())
						@foreach($projects as $project)
						<tr>
							<td>{!!$project->title!!}</td>
							<td>{{date("d/m/Y",strtotime($project->updated_date))}}
							</td>
							<td>{!!$project->description!!} </td>
							<td>
								@if($project->confirmation)
								<i>Confirmed</i>
								@else
								<button data-toggle="modal" data-target=".invoiceConfirmationModal" class="btn btn-primary" data="{{$project->id}}" id="project{{$project->id}}">Confirm</button>
								@endif
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br><br>
</div>
@include('partials.invoiceTermsConfirmationModal')
@stop

@section('js-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var usersTable = $('#notificationTable').DataTable();
		$('.invoiceConfirmationModal').on('show.bs.modal',function (e) {
			console.log(e);
		});
	});
</script>
@stop
