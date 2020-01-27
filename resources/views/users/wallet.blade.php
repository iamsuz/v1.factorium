@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | @parent
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>$user, 'active'=>12])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<ul class="list-group">
				<li class="list-group-item">
					<dl class="dl-horizontal">
						<div class="text-center">
							<h2>Wallet Address</h2>
							<a href="https://ropsten.etherscan.io/address/{{$user->wallet_address}}" target="_blank"><h4 class="alert alert-success">{{$user->wallet_address}}</h4></a>
						</div>
						<hr>
						<dt></dt>
						<dd style="margin-left: 0px;">
							<div class="col-md-10 col-md-offset-1 wow fadeIn text-center" data-wow-duration="1.5s" data-wow-delay="0.2s">
								<h2 class="text-center wow fadeIn hide" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-size:3em;"> Balance for Investments
								</h2>
								<table class="table table-striped">
									<thead>
										<tr>
											<th class="text-center hide">Project Name</th>
											<th class="text-center hide">Tokens</th>
										</tr>
									</thead>
									<tbody>
										@foreach($project_balance as $key => $balance)
										<tr>
											<td>{{$key}}</td>
											<td>@if(isset($balance))<a href="https://ropsten.etherscan.io/token/{{$balance}}?a={{$user->wallet_address}}" target="_blank">Balance</a> @else Na @endif</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</dd>
					</dl>
				</li>
			</ul>
		</div>
	</div>
</div>
@endsection
@section('js-section')
<script>
	$(document).ready(function () {
		new Clipboard('.btn');
		if(ethereum != 'undefined'){
			ethereum.enable();
			if({{$user->wallet_address == NULL}}){
				$.ajax({
					type: 'POST',
					url: "{{route('users.updateWalletAddress')}}",
					data: {address: ethereum.selectedAddress},
					headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					success: function (result) {
						console.log(result);
					},
					error: function (err) {
						console.log(err);
					}
				},function (e) {
					console.log(e);
				});
			}
		}
	});
</script>
@endsection
