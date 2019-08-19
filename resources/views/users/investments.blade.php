@extends('layouts.main')

@section('title-section')
{{$user->first_name}} Investments | @parent
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
<style type="text/css">
	#investmentsTable th {
		text-align: center;
	}
</style>
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['active'=>6])
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
			<h3 class="text-center">My Investments</h3>
			<div class="table-responsive text-center">
				<table class="table table-bordered table-striped" id="investmentsTable">
					<thead>
						<tr>
							<th>Project Name</th>
							<th>Invoice purchased for</th>
							<th>Investment Date</th>
							<th>Investment status</th>
							<th>Invoice amount</th>
							<th>Link to application form</th>
							<th>Returns received</th>
							<th>Tax and Accounting Docs</th>
						</tr>
					</thead>
					<tbody>
						@if($investments->count())
						@foreach($investments as $investment)
							<tr @if($investment->is_cancelled) style="color: #CCC;" @endif>
								<td>{{$investment->project->title}}</td>
								<td>${{number_format($investment->investment->goal_amount)}}</td>
								<td>{{$investment->created_at->toFormattedDateString()}}</td>
								<td>
									@if($investment->accepted)
									Receivable issued
									@elseif($investment->money_received)
									Funds committed
									@elseif($investment->investment_confirmation)
									Approved
									@else
									Applied
									@endif
								</td>
								<td>
									@if($investment->is_repurchased)
									<strong>Investment is repurchased</strong>
									@else
									@if($investment->is_cancelled)
									<strong>Investment record is cancelled</strong>
									@else
									@if($investment->accepted)
									${{number_format($investment->investment->total_projected_costs)}}
									{{-- <a href="{{route('user.view.share', [base64_encode($investment->id)])}}" target="_blank">Share Certificate</a> --}}
									@else
									NA
									@endif
									@endif
									@endif
								</td>
								<td><a href="{{route('user.view.application', [base64_encode($investment->id)])}}" target="_blank">Application form</a></td>
								<td></td>
								<td></td>
							</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>

			<!-- <ul class="list-group">
				@if($user->investments->count())
				@foreach($user->investments as $project)
				<a href="" class="list-group-item">{{$project->title}}</a>
				@endforeach
				@else
				<li class="list-group-item text-center alert alert-warning">Not Shown any Interest</li>
				@endif
			</ul> -->
		</div>
	</div>
</div>
@stop

@section('js-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var usersTable = $('#investmentsTable').DataTable({
			"order": [[5, 'desc'], [0, 'desc']],
			"iDisplayLength": 50
		});
	});
</script>
@stop
