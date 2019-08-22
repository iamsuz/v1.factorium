@extends('layouts.main')

@section('title-section')
Receivables | Dashboard | @parent
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>7])
		</div>
		<div class="col-md-10">
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="prospectusDownloadsTable">
					<thead>
						<tr>
							<th>Applicant Name</th>
							<th>Receivable Name</th>
							<th>Downloaded On</th>
						</tr>
					</thead>
					<tbody>
						@foreach($prospectusDownloads as $prospectusDownload)
						<tr>
							<td><a href="{{route('dashboard.users.show', [$prospectusDownload->user_id])}}">{{$prospectusDownload->user->first_name}} {{$prospectusDownload->user->last_name}}</a></td>
							<td>{{$prospectusDownload->project->title}}</td>
							<td>{{$prospectusDownload->created_at}}</td>
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
		var projectsTable = $('#prospectusDownloadsTable').DataTable({
			"iDisplayLength": 10
		});
	});
</script>
@stop