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
			@include('partials.sidebar', ['active'=>15])
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
			<br>
			<ul class="nav nav-tabs nav-justified">
				<li class="active"><a data-toggle="tab" href="#buy_using_cash">Buy AUDC using Cash</a></li>
				<li><a data-toggle="tab" href="#buy_using_dai">Buy AUDC using DAI</a></li>
			</ul>

			<div class="tab-content">
				<div id="buy_using_cash" class="tab-pane fade in active">
					<h3 class="text-center">Buy AUDC Token</h3>
					<div class="">
						<form class="" action="{{route('project.user.audc.buy')}}" method="POST" name="audcForm" id="audcForm">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-md-6 form-group">
									<label>Amount</label>
									<input type="number" name="amount_to_invest" class="form-control" placeholder="Enter a amount to buy an AUDC" max="10000" required="required" value="{{request()->amount}}">
								</div>
								<div class="col-md-6 form-group">
									<label>&nbsp;</label>
									<input type="submit" class="btn btn-primary form-control" name="submit" value="Buy" id="buyAudcBtn">
								</div>
							</div>
							<p><small><small>Your AUDC purchase is operated as an exempt Non Cash internal payment facility. Each AUDC represents 1 Australian Dollar. No more than 10 Million AUDC (or $10 Million AUD) are under circulation and no user is allowed to hold more than $1000 worth of AUDC.
										We use AUDC to enable cash equivalent movements within the platform. You may redeem any AUDC held by you from us in favor of Australian Dollars at any time. We will process any payments promptly after any AML/CTF/KYC obligations are met. We hold an equivalent amount of Australian Dollars in trust with us to the value of AUDC under circulation ensuring it is always maintained at a one to one peg. We also publish bank statements confirming the balance every 7 days.</small></small></p>
						</form>
					</div>
					<br><br>
					<div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="transactionTable">
								<thead>
								<tr>
									<th>Date of purchase</th>
									<th>Amount</th>
									<th>accepted</th>
									<th>Transaction</th>
								</tr>
								</thead>
								<tbody>
								@if(count($project->investors->where('id',$user->id)) > 0)
									@foreach($project->investors->where('id',$user->id) as $investor)
										<tr>
											<td>{{date("d/m/Y",strtotime($investor->pivot->created_at))}}</td>
											<td>{{$investor->pivot->amount}}
											</td>
											<td>@if($investor->pivot->accepted == 1) <i>Accepted</i> @else Yet to accept @endif</td>
											<td>
												@if($investor->pivot->transaction_hash){{$investor->pivot->transaction_hash}} @else Waiting for approval &nbsp;&nbsp;<a href="#" data-toggle="tooltip" data-placement="right" title="For approval please transfer {{$investor->pivot->amount}} AUD to listed bank details"><i class="fa fa-question-circle"></i> </a> &nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#audcBankDetailsModal"><i class="fa fa-bank"></i></a> @endif
											</td>
										</tr>
									@endforeach
								@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div id="buy_using_dai" class="tab-pane fade">
					<br>
					<div class="gas-check-progress text-center hide">
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<div><img src="{{ asset('/assets/images/loader.GIF') }}" height="50px" width="50px"></div><br>
								<p>Please wait while we check for available GAS to perform DAI exchange.</p><br>
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-sm active" role="progressbar"
										 aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width:5%"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="dai-audc-section">
						<div class="alert alert-warning text-center">
							<p>Please send DAI to your exchange wallet address "<span class="dai-user-account">{{ $user->wallet_address }}</span>" so that you can buy AUDC using it.</p>
						</div>
						<h3 class="text-center">Buy AUDC Token using DAI<br>( Balance: <span class="dai-user-balance">{{ $user->dai_balance }}</span> DAI )</h3>
						<div>
							<form action="#" method="POST" id="dai_audc_exchange_form">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-6 form-group">
										<label>Amount</label>
										<input type="number" name="amount_to_invest" class="form-control" placeholder="Enter the number of DAI to buy AUDC" max="10000">
									</div>
									<div class="col-md-6 form-group">
										<label>&nbsp;</label>
										<input type="submit" class="btn btn-primary form-control" name="submit" value="Buy">
									</div>
								</div>
								<p><small><small>** Make sure you have enough DAI in your wallet.</small></small></p>
							</form>
						</div>
						<br>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="exchangeTable">
								<thead>
								<tr>
									<th>Transaction ID</th>
									<th>From token</th>
									<th>To token</th>
									<th>Status</th>
									<th>Created at</th>
								</tr>
								</thead>
								<tbody>
								@foreach($exchanges as $exchange)
									<tr>
										<td>TRX{{ $exchange->id }}</td>
										<td>{{ $exchange->source_token_amount . ' ' . $exchange->source_token }}</td>
										<td>{{ $exchange->dest_token_amount . ' ' . $exchange->dest_token }}</td>
										<td>
											@if($exchange->transaction_response2)
												Success
											@else
												Failed
											@endif
										</td>
										<td>{{ date("d/m/Y", strtotime($exchange->created_at)) }}</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>
	<br><br>
</div>
@if(count($project->investors->where('id',$user->id)) > 0)
@include('partials.audcBankDetailsModal')
@endif
@stop

@section('js-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#transactionTable').DataTable();
		$('#exchangeTable').DataTable({
			"bSort" : false
		});

		$('#dai_audc_exchange_form').on('submit', function (e) {
			e.preventDefault();
			let daiAmount = $('#dai_audc_exchange_form input[name=amount_to_invest]').val();
			if(daiAmount == NaN || daiAmount == '') {
				alert('Please enter valid amount');
				return;
			}
			$('.loader-overlay').show();

			// Check DAI balance
			$.ajax({
				url: '{{ route('user.dai.local.balance') }}',
				type: 'POST',
				dataType: 'JSON',
				data: { 'dai_amount': daiAmount },
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			}).done(function (data) {
				if (!data.status) {
					alert(data.message);
					$('.loader-overlay').hide();
					return;
				}
				let transactionId = data.data.transaction_id;
				transferDaiToAudc(daiAmount, transactionId);
				transferAudcToDai(daiAmount, transactionId);
			});
		});

		$('#audcForm').submit(function (e) {
			$('.loader-overlay').show();
		});

		// Methods
		getDAIAccountBalance();
	});

	/**
	 *
	 * @param daiAmount
	 * @param transactionId
	 */
	function transferDaiToAudc(daiAmount, transactionId) {
		$.ajax({
			url: '{{ route('project.user.dai.audc') }}',
			type: 'POST',
			dataType: 'JSON',
			async: true,
			data: {
				'dai_amount': daiAmount,
				'transaction_id': transactionId,
				'action': 'dai_to_audc'
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		}).done(function (data) {
			console.log(data);
		});
	}

	/**
	 *
	 * @param daiAmount
	 * @param transactionId
	 */
	function transferAudcToDai(daiAmount, transactionId) {
		$.ajax({
			url: '{{ route('project.user.dai.audc') }}',
			type: 'POST',
			dataType: 'JSON',
			data: {
				'dai_amount': daiAmount,
				'transaction_id': transactionId,
				'action': 'audc_to_dai'
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		}).done(function (data) {
			console.log(data);
			$('.loader-overlay').hide();
			if (!data.status) {
				alert(data.message);
				return;
			}
			alert('Transfer successful. It may take some time to reflect balance in wallet.');
			location.reload();
		});
	}

	function  getDAIAccountBalance() {
		updateProgressBar(10);
		$.ajax({
			url: '{{ route('user.dai.balance') }}',
			type: 'GET',
			dataType: 'JSON',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		}).done(function (data) {
			if (!data.status) {
				alert(data.message);
				return;
			}
			$('.dai-user-account').html(data.data.daiAccount);
			$('.dai-user-balance').html(data.data.daiBalance);

			// if (data.data.daiBalance >= 1) {
				// updateProgressBar(20);
				// transferGasToUserWallet();
			// }
		});
	}

	function  transferGasToUserWallet() {
		updateProgressBar(30);
		$.ajax({
			url: '{{ route('user.dai.transfer.gas') }}',
			type: 'GET',
			dataType: 'JSON',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		}).done(function (data) {
			console.log(data);
			updateProgressBar(50);
			if (!data.status) {
				alert('Something went wrong!');
				return;
			}
			updateProgressBar(100);
			setTimeout(function () {
				$('.gas-check-progress').hide('slow');
				$('.dai-audc-section').removeClass('hide');
			}, 1000);
		})
	}

	function updateProgressBar(width, message = '') {
		$('.progress-bar').css('width', width+'%').attr('aria-valuenow', width).html(width + "%");
	}
</script>
@stop
