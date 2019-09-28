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
			<h3 class="text-center">Buy AUDC Token using DAI</h3>
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
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="exchangeTable">
					<thead>
					<tr>
						<th>Transaction ID</th>
						<th>From token</th>
						<th>To token</th>
						<th>Status</th>
						<th>Transaction Hash</th>
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
								@if($exchange->transaction_response1 && $exchange->transaction_response2)
									Success
								@else
									Failed
								@endif
							</td>
							<td class="text-center">@if($exchange->transaction_hash) {{ $exchange->transaction_hash }} @else - @endif</td>
							<td>{{ date("d/m/Y", strtotime($exchange->created_at)) }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			<hr>
			<h3 class="text-center">Buy AUDC Token</h3>
			<div class="">
				<form class="" action="{{route('project.user.audc.buy')}}" method="POST">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6 form-group">
							<label>Amount</label>
							<input type="number" name="amount_to_invest" class="form-control" placeholder="Enter a amount to buy an AUDC" max="10000">
						</div>
						<div class="col-md-6 form-group">
							<label>&nbsp;</label>
							<input type="submit" class="btn btn-primary form-control" name="submit" value="Buy">
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
			"order": [[0, 'DESC'], [5, 'DESC']],
		});

		$('#dai_audc_exchange_form').on('submit', function (e) {
			e.preventDefault();
			let daiAmount = $('#dai_audc_exchange_form input[name=amount_to_invest]').val();
			if(daiAmount == NaN || daiAmount == '') {
				alert('Please enter valid amount');
				return;
			}
			$('.loader-overlay').show();
			$.ajax({
				url: '{{ route('project.user.dai.audc') }}',
				type: 'POST',
				dataType: 'JSON',
				data: { 'dai_amount': daiAmount },
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
				alert(data.message);
				location.reload();
			});
		})
	});
</script>
@stop
