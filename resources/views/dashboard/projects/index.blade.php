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
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="projectsTable">
					<thead>
						<tr>
							<th></th>
							<th>Title</th>
							{{-- <th>Description</th> --}}
							<th>Status</th>
							<th>Asking Amount</th>
							<th>Invoice Amount</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($projects as $project)
						<tr class="@if(!$project->active) inactive @endif">
							<td>{{$project->id}}</td>
							<td>
							<a href="{{route('dashboard.projects.edit', [$project])}}">{{$project->title}}</a><br>
							@if(!$project->projectspvdetail && $project->is_coming_soon == '0')
							Submitted <br> <a href="#" id="alert">Activate</a>
							@else
							@if($project->activated_on && $project->active == '1')<a href="{{route('dashboard.projects.deactivate', [$project])}}" style="font-size: 14px;font-family: SourceSansPro-Regular;">Deactivate</a><br> @endif
								@if($project->activated_on && $project->active == '1')
									<time datetime="{{$project->activated_on}}">
									{{$project->activated_on->diffForHumans()}}
									</time><br>
								@elseif($project->activated_on && $project->active == '2') Private<br>
								@elseif($project->activated_on && $project->active == '0') Deactivate <br> <a href="{{route('dashboard.projects.activate', [$project])}}"> Activate </a><br>
								@else($project->active == '0') Submitted <br> <a href="{{route('dashboard.projects.activate', [$project])}}">Activate</a><br>
								@endif
							<a href="{{route('dashboard.projects.investors', [$project])}}">Investors <i class="fa fa-angle-double-right"></i></a>
							@endif
							</td>
							{{-- <td>{!!substr($project->description, 0, 50)!!}...</td> --}}
							<td>
								@if($project->is_funding_closed == '1') Funding Closed <br>
									@if($project->investors->first())
									@if($project->investors->first()->pivot->is_repurchased == '1') Repurchased @elseif($project->investors->first()->pivot->money_received != '1') Application received @elseif($project->investors->first()->pivot->money_received == '1') Money Received @endif @endif
								@elseif($project->eoi_button == '1') EOI @elseif($project->is_coming_soon == '1') Upcoming @elseif($project->active == '1') Active <br>
								@if($project->investors->first())
								@if($project->investors->first()->pivot->is_repurchased == '1') Repurchased @elseif($project->investors->first()->pivot->money_received != '1') Application received @elseif($project->investors->first()->pivot->money_received == '1') Money Received @endif @endif
								@else Inactive @endif
								</td>
							<td>@if($project->investment)${{number_format($project->investment->goal_amount)}} @else Not Specified @endif</td>
							<?php $pledged_amount = $pledged_investments->where('project_id', $project->id)->sum('amount');?>
							<td>@if($project->investment)${{-- {{ number_format($pledged_amount)}} --}}{{number_format($project->investment->total_projected_costs)}} @else Not Specified @endif</td>
							<td><button class="btn btn-default btn-sm" onclick="duplicateProject({{$project->id}})">Duplicate</button></td>
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
			"iDisplayLength": 10,
			"order": [[ 0, "desc" ]]
		});
	});
	$(document).on("click","#alert",function(){
	 swal ( "Oops !" ,  "Please add the Project SPV Details first." ,  "error" );
	});

	function duplicateProject(projectId) {
		if(confirm('Are you sure you want to duplicate the project?')) {
			location.href = '{{ route("home") }}/dashboard/project/' + projectId + '/copy';
		}
	}
</script>
@stop
