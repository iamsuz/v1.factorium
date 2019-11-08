@extends('layouts.main')

@section('title-section')
{{$user->first_name}} Notification | @parent
@stop

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['active'=>17])
		</div>
		<div class="col-md-10 msg">
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
			<br>
			<span class="msg text-justify"></span>
			<div class="tab-content">
				<div id="buy_using_cash" class="tab-pane fade in active">
					<h3 class="text-center">Redeem AUDC Token<br>
						@if($balanceAudk)
						@if(isset(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->audk_default_project_id)) {{-- {{App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->token_symbol}} --}}
						@else AUDC
						@endif Balance: {{$balanceAudk->balance}}
						@endif
					</h3>
					<br>
					<div>
						<form class="" action="#" method="POST" name="audcRedeemForm" id="audcRedeemForm">
							<div class="col-md-4">
								<label class="pull-left">Amount</label>
								<input type="number" name="amount_to_redeem_cash" class="form-control" placeholder="Enter a amount to redeem audc" required="required" min="1" max="@if($balanceAudk->balance){{  $balanceAudk->balance }}@endif">
							</div>
							<div class="col-md-4">
								<label for="paidType" class="control-label">CASH/DAI</label><br>
								<select id="paidType" class="form-control" name="paid_type">
									<option value="cash">Cash</option>
									<option value="dai">Dai</option>
								</select>
							</div>
							<div class="col-md-4">
								<label>&nbsp;</label>
								<input type="submit" name="redeemBtn" class="btn btn-primary form-control" id="redeem">
							</div>
							<p><small><small>** Make sure you have enough AUDC in your wallet.</small></small></p>
						</form>
					</div>		

					<br>
					<div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="transactionTable">
								<thead>
									<tr>
										<th>Date of purchase</th>
										<th>Amount</th>
										<th>confirmed</th>
										<th>Transaction</th>
									</tr>
								</thead>
								<tbody>
									@if(count($redeemAudc) > 0)
									@foreach($redeemAudc as $investor)
									<tr>
										<td>{{date("d/m/Y",strtotime($investor->created_at))}}</td>
										<td>{{$investor->amount}}
										</td>
										<td>@if($investor->confirmed == 1) <i>confirmed</i> @else Yet to accept @endif</td>
										<td>
											@if($investor->transaction_hash){{$investor->transaction_hash}} @else Waiting for approval &nbsp;&nbsp; @endif
										</td>
									</tr>
									@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<br>
				<br>
			</div>
		</div>
	</div>
</div>
@stop
@section('js-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#transactionTable').DataTable();
		$('#audcRedeemForm').on('submit', function (e) {
			e.preventDefault();
			let audcAmount = $('#audcRedeemForm input[name=amount_to_redeem_cash]').val();
			let paidType = $('#audcRedeemForm  #paidType option').attr('value');
			console.log(paidType,audcAmount);
			$('.loader-overlay').show();
			$.ajax({
				url: '{{ route('project.user.audc.redeemRequest') }}',
				type: 'POST',
				dataType: 'JSON',
				data: { 'audc_amount': audcAmount,
				'paid_type': paidType },
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			}).done(function (data) {
				if (data.status) {
					$('.msg').html(data.message);
					$('.loader-overlay').hide();
					return;
				}
			});	
		});
	});
</script>
@stop