@extends('layouts.main')

@section('title-section')
Projects | Dashboard | @parent
@stop

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>6])
		</div>
		<div class="col-md-10">
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="requestsTable">
					<thead>
						<tr>
							<th></th>
							<th>Applicant Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Project Name</th>
							<th>Requested On</th>
							<th>Investment Form Link</th>
						</tr>
					</thead>
					<tbody>
						@foreach($investmentRequests as $investmentRequest)
						<tr id="application_request_{{$investmentRequest->id}}">
							<td>
								<a href="javascript:void(0);" class="hide-application-request" data="{{$investmentRequest->id}}" title="Delete application form fillup request">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</a>
							</td>
							<td><a href="{{route('dashboard.users.show', [$investmentRequest->user_id])}}">{{$investmentRequest->user->first_name}} {{$investmentRequest->user->last_name}}</a></td>
							<td><a href="{{route('dashboard.users.show', [$investmentRequest->user_id])}}">{{$investmentRequest->user->email}}</a></td>
							<td><a href="tel:{{$investmentRequest->user->phone_number}}">{{$investmentRequest->user->phone_number}}</a></td>
							<td>{{$investmentRequest->project->title}}</td>
							<td>{{$investmentRequest->created_at}}</td>
							<td class="text-center"><a target="_blank" href="{{route('project.interest.fill', [$investmentRequest->id])}}">Investment Form</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop

@section('js-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var projectsTable = $('#requestsTable').DataTable({
			"iDisplayLength": 10
		});

		//Hide application form fillup request from requests page in admin dashboard

		$('.hide-application-request').on("click", function(e){
			e.preventDefault();
			var application_request_id = $(this).attr('data');
			if (confirm('Are you sure you want to delete this?')) {
				$('.loader-overlay').show();
				$.ajax({
		          	url: '/dashboard/projects/hideApplicationFillupRequest',
		          	type: 'POST',
		          	dataType: 'JSON',
		          	data: {application_request_id},
		          	headers: {
		            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		          	},
		        }).done(function(data){
		        	if(data){
		        		$('.loader-overlay').hide();
	 						$("#requestsTable").DataTable().row( $('#application_request_' + application_request_id) ).remove().draw( false );
		        	}
		        });
		    }
		});
	});
</script>
@stop
