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
		{{-- <h3 class="text-center">Notifications</h3> --}}
		<div class="table-responsive">
			<table class="table table-bordered table-striped" id="notificationTable">
				<thead>
					<tr>
						<th>Invoice Name</th>
						<th>Invoice Submitted Date</th>
						<th>Invoice Due Date</th>
						<th>Invoice Amount</th>
						<th>Invoice Asking Amount</th>
						<th>Invoice submitted from</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					@if($projects->count())
					@foreach($projects as $project)
					<tr>
						<td>{!!$project->title!!}</td>
						<td>{{$project->investment->fund_raising_start_date->toFormattedDateString()}} </td>
						<td>{{$project->investment->fund_raising_close_date->toFormattedDateString()}} </td>
						<td>{!!$project->investment->invoice_amount!!} </td>
						<td>{!!$project->investment->asking_amount!!}</td>
						<td>{!!$project->invoice_issued_from!!} </td>
						<td id="statusOfConfirmation">
							@if($project->confirmation)
							<i>Confirmed</i>
							@else
							<button data-toggle="modal" data-target=".invoiceConfirmationModal" class="btn btn-primary invoiceConfirmationModal1" data="{{$project}}" >Confirm</button>
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
@if(isset($project))
@include('partials.invoiceTermsConfirmationModal')
@endif
@stop

@section('js-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var usersTable = $('#notificationTable').DataTable({
			"order": [[1, 'desc']],
			"iDisplayLength": 50
		});
		$('.invoiceConfirmationModal1').on('click',function (temp) {
			var project = JSON.parse($(this).attr('data'));
			$('#projectTitle').html(project.title);
			$('#projectGoalAmount').html(project.investment.goal_amount);
			$('#totalProjectedCosts').html(project.investment.total_projected_costs);
			$('#fundRaisingCloseDate').html(project.investment.fund_raising_close_date);
			$('#projectDescription').html(project.description);
			$('#invoiceIssuedFrom').html(project.invoice_issued_from);
			$('#confirmInvoiceBtn').on('click',function (e) {
				$('.loader-overlay').show();
				$('.overlay-loader-image').after('<div class="text-center alert alert-info"><h3>It may take a while!</h3><p>Please wait... your request is processed. Please do not refresh or reload the page.</p><br></div>');
				$.ajax({
					url : '/user/invoice/'+project.id+'/confirm',
					type : 'POST',
					data : {
						'numberOfWords' : 10
					},
					dataType:'json',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
					// success : function(data) {
					// 	location.reload();
					// },
					// error : function(request,error)
					// {
					// 	alert("Request: "+JSON.stringify(request));
					// }
				}).done(function () {
					$('#statusOfConfirmation').html('<i>Pending</i>');
					location.reload();
				});
			})
		});
	});
</script>
@stop
