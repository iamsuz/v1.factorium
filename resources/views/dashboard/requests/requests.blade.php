@extends('layouts.main')

@section('title-section')
Projects | Dashboard | @parent
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
							<th>Applicant Name</th>
							<th>Project Name</th>
							<th>Requested On</th>
							<th>Investment Form Link</th>
						</tr>
					</thead>
					<tbody>
						@foreach($investmentRequests as $investmentRequest)
						<tr>
							<td>{{$investmentRequest->project->title}}</td>
							<td>{{$investmentRequest->user->first_name}} {{$investmentRequest->user->last_name}}</td>
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
	});
</script>
@stop