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
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<div class="alert alert-danger hide text-center" id="alertBuyerInv"></div>
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
								@if(!$project->repurchased->isEmpty())
								<i style="color: #737373;">Settled</i>
								@elseif(!$project->soldInvoice->isEmpty())
								<button data-toggle="modal" data-target="#aprTokenSettleModal" class="btn btn-block btn-default settleInvoiceBtn" data-address="{{$project->contract_address}}" data-id="{{$project->id}}" data-amount="{{$project->investment->total_projected_costs}}">Settle</button>
								@elseif($project->confirmation)
								<button data-toggle="modal" data-target="#aprTokenSettleModal" class="btn btn-block btn-default settleInvoiceBtn" data-address="{{$project->contract_address}}" data-id="{{$project->id}}" data-amount="{{$project->investment->total_projected_costs}}">Settle without Financed</button>
								@else
								<button data-toggle="modal" data-target=".invoiceConfirmationModal" class="btn btn-info btn-block invoiceConfirmationModal1" data="{{$project}}" >Confirm</button>
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
@include('partials.aprTokenSettleModal')
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
				loaderOverlay();
				var hash = project.transaction_hash.toString();
				if(project.contract_address){
					commit(project);
				}else if(project.transaction_hash){
					getContractAdderss(project,hash);
				}else{
					userInvoiceError();
					$('#alertBuyerInv').html('Sorry! We coudnt find transaction hash, this seems not a valid Invoice');
				}
			});
		});
		$('.settleInvoiceBtn').on('click',function (e) {
			//loaderOverlay();
			var cAddress = $(this).data('address');
			var pid = $(this).data('id');
			var amount = $(this).data('amount');
			$('#apprDai').on('click',function (e) {
				approvalSettle(cAddress,amount);
			});
			$('#settleApprInvoiceBtn').on('click',function (e) {
				settleInvoice(cAddress,pid);
			});
			//$('#approveTokenModal').modal('show');
			// settleInvoice(cAddress,pid);
		});
	});
</script>
@stop
