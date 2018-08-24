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
			@include('dashboard.includes.sidebar', ['active'=>9])
		</div>
		<div class="col-md-10">
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="requestsTable">
					<thead>
						<tr>
							<th>Applicant Name</th>
							<th>Investing as</th>
							<th>Requested On</th>
							<th>Document Link</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($kycRequests as $kyc)
						<tr>
							<td><a href="{{route('dashboard.users.show', [$kyc->user_id])}}">{{$kyc->user->first_name}} {{$kyc->user->last_name}}</a></td>
							<td>{{$kyc->investing_as}}</td>
							<td>{{$kyc->created_at}}</td>
							<td class="text-center"><a target="_blank" href="{{route('dashboard.users.idVerify', [$kyc->user_id])}}">Documents</a></td>
							<td>@if($kyc->verified == 0)Not Verified @elseif($kyc->verified == 1) Verified @else Asks for Re-Upload @endif</td>
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
