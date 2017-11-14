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
			@include('partials.sidebar', ['active'=>9])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
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
						@if($project_prog->count())
						@foreach($project_prog as $project_progs)
						<tr>
							<td>{{$project_progs->project->title}}</td>
							<td>{{date("d/m/Y",strtotime($project_progs->updated_date))}}
							</td>
							<td>{{$project_progs->progress_description}} </td>
							<td>{{$project_progs->progress_details}}
								<br>
								<a href="{{$project_progs->video_url}}" target="_blank">{{$project_progs->video_url}}</a>
								@if($project_progs->image_path != '')
								<div class="row">
									<div class="col-md-10 change_column">
										<div class="thumbnail">
											<img src="{{asset($project_progs->image_path)}}" class="img-responsive">
										</div>
									</div>
								</div>
								@endif
								@if($project_progs->video_url != '')
								<iframe class="embed-responsive-item" width="100%" height="100%" src="{{$project_progs->video_url}}" frameborder="0" allowfullscreen></iframe>
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
@stop

@section('js-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var usersTable = $('#notificationTable').DataTable();
	});
</script>
@stop