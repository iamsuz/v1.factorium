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
			@include('partials.sidebar', ['active'=>16])
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
						<th>Invoice name</th>
						<th>Invoice submitted date</th>
						<th>Invoice due date</th>
						<th>Invoice amount</th>
						<th>Invoice asking amount</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					@if($projects->count())
					@foreach($projects as $project)
					<tr>
						<td>{!!$project->title!!}<br>@if($project->active) @if(!count($project->investors)) <a href="{{route('user.projects.deactivate', [$project])}}" style="font-size: 14px;font-family: SourceSansPro-Regular;">Deactivate</a> @endif @endif </td>
						<td>{{date("d/m/Y",strtotime($project->investment->fund_raising_start_date))}} </td>
						<td>{{date("d/m/Y",strtotime($project->investment->fund_raising_close_date))}} </td>
						<td>{!!$project->investment->invoice_amount!!} </td>
						<td>{!!$project->investment->asking_amount!!}</td>
						<td>
							@if($project->confirmation)
							<i>Confirmed</i>
							@else
							<i>Submitted</i>
							@endif
							@if($project->is_funding_closed == '1')<br> Funding Closed <br>
							@if($project->investors->first())
							@if($project->repurchased) @if($project->repurchased->first()) Invoice repaid
							@elseif($project->soldInvoice) @if($project->soldInvoice->first()) Invoice sold
							@elseif($project->moneyReceived) @if($project->moneyReceived->first()) Money received
							@elseif($project->investors->first()->pivot->money_received != '1') Application received
							@endif @endif @endif @endif
							@endif
							@elseif($project->eoi_button == '1') EOI @elseif($project->is_coming_soon == '1') Upcoming @elseif($project->active == '1')<br> Active <br>
							@if($project->investors->first())
							@if($project->repurchased) @if($project->repurchased->first() || $project->repurchased_by_partial_pay->first()) Invoice repaid
							@elseif($project->soldInvoice) @if($project->soldInvoice->first()) Invoice sold
							@elseif($project->moneyReceived) @if($project->moneyReceived->first()) Money received
							@elseif($project->investors->first()->pivot->money_received != '1') Application received
							@endif @endif @endif @endif
							@endif
							@else <br>Inactive @endif
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
		var usersTable = $('#notificationTable').DataTable();
		$('.invoiceConfirmationModal').on('click',function (temp) {
			var id = $(this).attr('data');
			$('#confirmInvoiceBtn').on('click',function (e) {
				$.ajax({
					url : '/user/invoice/'+id+'/confirm',
					type : 'POST',
					data : {
						'numberOfWords' : 10
					},
					dataType:'json',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success : function(data) {
						location.reload();
					},
					error : function(request,error)
					{
						alert("Request: "+JSON.stringify(request));
					}
				})
			})
		});
	});
</script>
@stop
