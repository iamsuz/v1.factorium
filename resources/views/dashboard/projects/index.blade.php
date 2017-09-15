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
			@include('dashboard.includes.sidebar', ['active'=>3])
		</div>
		<div class="col-md-10">
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="projectsTable">
					<thead>
						<tr>
							<th></th>
							<th>Title</th>
							<th>Description</th>
							<th>Active</th>
							<th>Goal</th>
							<th>Collected</th>
						</tr>
					</thead>
					<tbody>
						@foreach($projects as $project)
						<tr class="@if(!$project->active) inactive @endif">
							<td>{{$project->id}}</td>
							<td>
							<a href="{{route('dashboard.projects.edit', [$project])}}">{{$project->title}}</a><br><br>
							<a href="{{route('dashboard.projects.investors', [$project])}}">Investors <i class="fa fa-angle-double-right"></i></a>
							</td>
							<td>{{substr($project->description, 0, 50)}}...</td>
							@if(!$project->projectspvdetail && $project->is_coming_soon == '0')
							<td>Submitted <br> <a href="#" id="alert">Activate</a></td>
							@else
							<td> @if($project->activated_on && $project->active == '1')
									<time datetime="{{$project->activated_on}}">
									{{$project->activated_on->diffForHumans()}}
									</time>
									<br><a href="{{route('dashboard.projects.deactivate', [$project])}}">Deactivate</a>
								@elseif($project->activated_on && $project->active == '2') Private
								@elseif($project->activated_on && $project->active == '0') Deactivate <br> <a href="{{route('dashboard.projects.activate', [$project])}}"> Activate </a>
								@else($project->active == '0') Submitted <br> <a href="{{route('dashboard.projects.activate', [$project])}}">Activate</a>
								@endif</td>
							@endif
							<td>@if($project->investment)${{number_format($project->investment->goal_amount)}} @else Not Specified @endif</td>
							<?php $pledged_amount = $pledged_investments->where('project_id', $project->id)->sum('amount');?>
							<td>@if($project->investment)${{ number_format($pledged_amount)}} @else Not Specified @endif</td>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var projectsTable = $('#projectsTable').DataTable({
			"iDisplayLength": 10
		});
	});
	$(document).on("click","#alert",function(){
	 swal ( "Oops !" ,  "Please add the Project SPV Details first." ,  "error" );
	});
</script>
@stop