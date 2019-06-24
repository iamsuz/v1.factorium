@extends('layouts.main')

@section('title-section')
@parent
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>11])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<ul class="list-group">
				<li class="list-group">
					<dl class="dl-horizontal">
						<dd style="margin-left: 0px;">
							<div class="col-md-10 col-md-offset-1 wow fadeIn text-center" data-wow-duration="1.5s" data-wow-delay="0.2s">
								<h2 class="text-center wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-size:3em;"> Orders
								</h2>
								<ul class="nav nav-tabs" style="margin-top: 2em; width: 100%;">
									<li class="active" style="width: 50%"><a data-toggle="tab" href="#my_orders">ASK</a></li>
									<li style="width: 50%"><a data-toggle="tab" href="#all_orders">BID</a></li>
								</ul>

								<div class="tab-content">
									<div id="my_orders" class="tab-pane fade in active">
										<h3>My Orders</h3>
										<br>
										<table class="table table-striped">
											<thead>
												<tr>
													<th class="text-center">Project</th>
													<th class="text-center">User</th>
													<th class="text-center">Price/Share</th>
													<th class="text-center">No Of Shares</th>
													<th class="text-center">Status</th>
												</tr>
											</thead>
											<tbody>
												@foreach($askOrders as $askOrder)
												@if($askOrder->type === 'ASK')
												<tr>
													<td>{{$askOrder->project->title}}</td>
													<td>{{$askOrder->user->first_name}} {{$askOrder->user->last_name}}</td>
													<td>{{$askOrder->price}}</td>
													<td>{{$askOrder->amount_of_shares}}</td>
													<td>@if($askOrder->accepted) @if($askOrder->is_money_received) <i>Money Received </i> @else <button class="btn btn-warning" onclick="moneyReceived({{$askOrder}})">Money Received</button> @endif @else <button class="btn btn-primary" onclick="orderAccept({{$askOrder}})">Confirm</button> @endif</td>
												</tr>
												@endif
												@endforeach
											</tbody>
										</table>
									</div>
									<div id="all_orders" class="tab-pane fade">
										<h3>All Orders</h3>
										<table class="table table-striped">
											<thead>
												<tr>
													<th class="text-center">Project</th>
													<th class="text-center">User</th>
													<th class="text-center">Price/Share</th>
													<th class="text-center">No Of Shares</th>
													<th class="text-center">Status</th>
												</tr>
											</thead>
											<tbody>
												@foreach($bidOrders as $bidOrder)
												@if($bidOrder->type === 'BID')
												<tr>
													<td>{{$bidOrder->project->title}}</td>
													<td>{{$bidOrder->user->first_name}} {{$bidOrder->user->last_name}}</td>
													<td>{{$bidOrder->price}}</td>
													<td>{{$bidOrder->amount_of_shares}}</td>
													<td>@if($bidOrder->accepted) @if($bidOrder->is_money_received) <i>Money Received </i> @else <button class="btn btn-warning" onclick="moneyReceived({{$bidOrder}})">Money Received</button> @endif @else <button class="btn btn-primary confirm" data-order="{{$bidOrder->id}}" onclick="orderAccept({{$bidOrder}})">Confirm</button> @endif</td>
												</tr>
												@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</dd>
					</dl>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="container">
	<div class="modal fade" id="order_modal" role="dialog">
		<div class="modal-dialog " style="margin-top: 5em;">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body" id="body_text">
					<form method="POST" action="{{route('dashboard.market.accept')}}" name="orderForm">
						<div class="row">
							<div class="col-md-6 col-md-offset-3 text-center">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<p style="font-size: 26px;">Project- <b><span id="project_name">Project Name</span></b></p>
							</div>
						</div>
						<br><br>
						<input type="hidden" name="market_id" id="market_id">
						<div class="row">
							<div class="col-md-5 col-md-offset-1">
								<h3 id="type">BID/ASk</h3>
								<h4 id="price">Price</h4>
							</div>
							<div class="col-md-5">
								<h4>Amount of Shares</h4>
								<input type="number" class="form-control" placeholder="Number of Shares" required="required" id="no_of_shares" name="amount_of_shares" min="1">
							</div>
						</div>
						<br>
						<input type="submit" name="place_order" value="Place Order" class="btn btn-primary hidden">
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" id="confirm">Confirm</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
</div>

@endsection
@section('js-section')
<script>
	$(document).ready(function () {
		new Clipboard('.btn');
		$('#bid_ask').on('change',function (bidAsk) {
			if($(this).val() === 'BID'){
				console.log('Inside BID');
			}
		});
		$('#confirm').on('click',function () {
			$('form[name="orderForm"]').submit();
		});
		$('form[name="my_orders_form"]').on('submit',function (event) {
			event.preventDefault();
			$this = $(this);
			var order_project_name = $('#order_project_name option:selected').text();
			var bid_ask = $('#bid_ask').val();
			var no_of_shares = $('#no_of_shares').val();
			var price = $('#price').val();
			var total_amount = no_of_shares*price;
			var state_of_wallet = ((bid_ask === 'BID') ? 'up' : 'down');
			var pay_receive = ((bid_ask === 'BID') ? 'pay' : 'receive');
			$('#body_text').html('You are about to place an order to '+bid_ask+' '+no_of_shares+' shares of '+order_project_name+' at $'+price+' per share. If the order succeeds you will '+pay_receive+' $'+total_amount+' for '+no_of_shares+' shares. Your share balance will go '+ state_of_wallet +' by '+no_of_shares+' shares.');
			$('#order_modal').modal('show');
			$('#confirm').on('click',function (e) {
				console.log('inside');
				$this.unbind(event.preventDefault());
				$('form[name="my_orders_form"]').submit();
			});
		});
	});
	function orderAccept(order) {
		$('#project_name').html(order.project.title);
		$('#type').html(order.type);
		$('#price').html('$'+order.price+' Price/share');
		$('#no_of_shares').attr('value',order.amount_of_shares);
		$('#market_id').attr('value',order.id);
		$('form[name="orderForm"]').attr('action','/dashboard/market/order');
		$('#order_modal').modal('show');
	}
	function moneyReceived(order) {
		$('#project_name').html(order.project.title);
		$('#type').html(order.type);
		$('#price').html('$'+order.price+' Price/share');
		$('#no_of_shares').attr('value',order.amount_of_shares);
		$('#market_id').attr('value',order.id);
		$('form[name="orderForm"]').attr('action','/dashboard/market/moneyReceived');
		$('form[name="orderForm"]').submit();
	}
</script>
@endsection
