@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | @parent
@stop
@section('css-section')
<style>
	.nav >li >a{
	padding: 0.8em 0.6em;
}
</style>
@stop
@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>$user, 'active'=>13])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<ul class="list-group">
				<li class="list-group-item">
					<dl class="dl-horizontal">
						<dd style="margin-left: 0px;">
							<div class="col-md-10 col-md-offset-1 wow fadeIn text-center" >
								<ul class="nav nav-tabs" style="margin-top: 2em; width: 100%;">
									<li class="active" style="width: 50%"><a data-toggle="tab" href="#my_orders">My Orders</a></li>
									<li style="width: 50%"><a data-toggle="tab" href="#all_orders">All Orders</a></li>
								</ul>

								<div class="tab-content">
									<div id="my_orders" class="tab-pane fade in active">
										{{-- <h3>My Orders</h3> --}}
										<form method="POST" action="{{route('users.market.store')}}" name="my_orders_form">
											<div class="row">
												<div class="col-md-6 col-md-offset-3">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<br>
													<select class="" id="order_project_name" name="project_id">
														@foreach($projects as $project)
														<option value="{{$project->id}}" data-max="{{$project->investment->goal_amount}}">{{$project->title}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<br><br>
											<div class="row">
												<div class="col-md-5">
													{{-- <h4> Bidding prices from those seeking to buy</h4> --}}
													{{-- <div class="form-group"> --}}
														<div class="input-group">
															<div class="input-group-btn" style="width: 17%;">
																<select class="form-control" id="bid_ask" name="type">
																	<option selected="selected" value="BID">BID</option>
																	<option value="ASK">ASK</option>
																</select>
															</div>
															<input type="number" class="form-control" placeholder="Price" required="required" id="price" name="price" min="1">
														</div>
													{{-- </div> --}}
												</div>
												<div class="col-md-4">
													{{-- <h4>Amount of Shares</h4> --}}
													<input type="number" class="form-control" placeholder="Number of Shares" required="required" id="no_of_shares" name="amount_of_shares" min="1">
												</div>
												<div class="col-md-3">
													<input type="submit" name="place_order" value="Place Order" class="btn btn-primary btn-block form-control">
												</div>
											</div>
											<br>
										</form>
										<ul class="nav nav-tabs" style="margin-top: 2em; width: 100%;">
											<li class="active" style="width: 50%"><a data-toggle="tab" href="#bid_orders">BID</a></li>
											<li style="width: 50%"><a data-toggle="tab" href="#ask_orders">ASK</a></li>
										</ul>

										<div class="tab-content">
											<div id="bid_orders" class="tab-pane fade in active">
												<h3>Bid Orders</h3>
												<br>
												<table class="table table-striped">
													<thead>
														<tr>
															<th class="text-center">Project</th>
															<th class="text-center">Price/Share</th>
															<th class="text-center">No Of Shares</th>
															<th class="text-center">Status</th>
														</tr>
													</thead>
													<tbody>
														@foreach($askingOrders as $askOrder)
														@if($askOrder->type === 'BID')
														<tr>
															<td>{{$askOrder->project->title}}</td>
															<td>{{$askOrder->price}}</td>
															<td>{{$askOrder->amount_of_shares}}</td>
															<td>@if($askOrder->accepted) Order Accepted @else Order is in Line @endif</td>
														</tr>
														@endif
														@endforeach
													</tbody>
												</table>
											</div>
											<div id="ask_orders" class="tab-pane fade">
												<h3>Ask Orders</h3>
												<table class="table table-striped">
											<thead>
												<tr>
													<th class="text-center">Project</th>
													<th class="text-center">Price/Share</th>
													<th class="text-center">No Of Shares</th>
													<th class="text-center">Status</th>
												</tr>
											</thead>
											<tbody>
												@foreach($askingOrders as $askOrder)
												@if($askOrder->type === 'ASK')
												<tr>
													<td>{{$askOrder->project->title}}</td>
													<td>{{$askOrder->price}}</td>
													<td>{{$askOrder->amount_of_shares}}</td>
													<td>@if($askOrder->accepted) Order Accepted @else Order is in Line @endif</td>
												</tr>
												@endif
												@endforeach
											</tbody>
										</table>
											</div>
										</div>
									</div>
									<div id="all_orders" class="tab-pane fade">
										<h3>All Orders</h3>
										{{-- <form>
											<select>
												@foreach($projects as $project)
												<option value="{{$project->id}}">{{$project->title}}</option>
												@endforeach
											</select>
											<div class="row">
												<div class="col-md-6">
													<h4> Asking prices from those seeking to sell</h4>
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon">ASK</span>
															<input type="integer" class="form-control" placeholder="Asking prices from those seeking to sell">
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<h4> Bidding prices from those seeking to buy</h4>
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon">BID</span>
															<input type="integer" class="form-control"  placeholder="Bidding prices from those seeking to buy">
														</div>
													</div>
												</div>
											</div>
											<input type="submit" name="Place Order" class="btn btn-primary">
										</form> --}}
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
		$("ul.nav-tabs a").click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
		new Clipboard('.btn');
		$('#bid_ask').on('change',function (bidAsk) {
			if($(this).val() === 'ASK'){
				var maxValue = $('#order_project_name option:selected').attr('data-max');
				$('#no_of_shares').attr('max',maxValue);
			}else{
				$('#no_of_shares').removeAttr('max');
			}
		});
		$('#order_project_name').on('change',function (e) {
			if($('#bid_ask').val() === 'ASK'){
				var maxValue = $('#order_project_name option:selected').attr('data-max');
				$('#no_of_shares').attr('max',maxValue);
			}
		});
		$('form[name="my_orders_form"]').on('submit',function (event) {
			event.preventDefault();
			$this = $(this);
			var order_project_name = $('#order_project_name option:selected').text();
			var bid_ask = $('#bid_ask').val();
			var buy_sell = ((bid_ask === 'BID') ? 'Buy' : 'Sell');
			var no_of_shares = $('#no_of_shares').val();
			var price = $('#price').val();
			var total_amount = no_of_shares*price;
			var state_of_wallet = ((bid_ask === 'BID') ? 'up' : 'down');
			var pay_receive = ((bid_ask === 'BID') ? 'pay' : 'receive');
			$('#body_text').html('You are about to place an order to '+buy_sell+' '+no_of_shares+' shares of '+order_project_name+' at $'+price+' per share. If the order succeeds you will '+pay_receive+' $'+total_amount+' for '+no_of_shares+' shares. Your share balance will go '+ state_of_wallet +' by '+no_of_shares+' shares.');
			$('#order_modal').modal('show');
			$('#confirm').on('click',function (e) {
				console.log('inside');
				$this.unbind(event.preventDefault());
				$('form[name="my_orders_form"]').submit();
			});
		});
	});
</script>
@endsection
