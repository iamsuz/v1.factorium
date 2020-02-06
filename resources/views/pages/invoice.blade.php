@extends('layouts.mainproject')

@section('title-section')
Create New Project | @parent
@stop

@section('css-section')
<style>
	body{

	}
	.buy-now-btn {
		background-color: transparent;
		color: #23527c;
		border-radius: 30px;
		transition: transform .2s;
	}
	.buy-now-btn:hover{
		transform: scale(1.04);
	}
	.list-group-item{
		/*border-bottom: 1px solid #ddd;*/
<<<<<<< HEAD
		/*border-radius: 0px;*/
		margin-left: -1px;
		margin-right: -1px;
=======
		/*border-top: 1px solid;*/
		margin-left: 0px;
		margin-right: 0px;
>>>>>>> efbf74dfc29986c54c448d4ff2acb0d7ade93577
	}
	.list-group{
		margin-bottom: 0px;
	}
	.panel-body{
		padding: 0px;
	}
	.panel-heading{
		margin-left: 0px;
		margin-right: 0px;
	}
	#buy-invoice-panel{
		margin-top: -70px;
	}
	#sold-invoice-panel{
		margin-top: -70px;
	}
	.circle-btn{
		height: 130px;
		width: 130px;
		border-radius: 50%;
		border: 2px solid ;
		color: #fff;
	}
</style>
{!! Html::style('plugins/animate.css') !!}
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop

@section('content-section')
@if (Session::has('message'))
<section class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<br><br>
			@if (Session::has('message'))
			<br>
			{!! Session::get('message') !!}
			<br>
			@endif
			@if ($errors->has())
			<br>
			<div class="alert alert-danger" >
				@foreach ($errors->all() as $error)
				{{ $error }}<br>
				@endforeach
			</div>
			@endif
			<div class="alert alert-danger hide text-center" id="alertCreateInvoice">
			</div>
		</div>
	</div>
</section>
@endif
<section id="mainFold" style="background-color: #070a0e; height: 60vh;">
	<div class="container">
		<div class="row" style="padding-top:30px; margin-right: 0px !important;">
			<div class="col-md-2 col-md-offset-8">
			</div>
			<div class="col-md-2">
				<button class="btn" data-toggle="modal" data-target="#connectToWallet" style="background-color: #141e27; color: #fff;" data-backdrop="static" data-keyboard="false" id="connectToWalletBtn">Connect to wallet</button>
			</div>
		</div>
	</div>
	<br><br><br><br>
	<div class="row text-center">
		<button class="btn btn-lg btn-primary buy-now-btn circle-btn">
			Approve Dai<br>
			<span id="balanceBtn"></span>
		</button>
	</div>
</section>
<section>
	<div class="container">
		<div class="row" style="">
			<div class="col-md-6" id="buy-invoice-panel">
				<div class="panel panel-default" style="box-shadow: 0px 0px 10px grey;">
					<div class="panel-heading row">
						<div class="col-md-3 col-xs-3">
							Project Name
						</div>
						<div class="col-md-3 col-xs-3">
							Asking Amount
						</div>
						<div class="col-md-3 col-xs-3">
							Project Name
						</div>
						<div class="col-md-3 col-xs-3">
							Status
						</div>
					</div>
					<div class="panel-body">
						<div class="">
							@foreach($projects as $project)
							<div class="" style="border-top: 1px solid; width:100%;">
								<a href="#" class="list-group-item row" style="padding: 1em 0;">
									<div class="col-md-3 col-xs-3">
										{{$project->title}}
									</div>
									<div class="col-md-3 col-xs-3">
										{{$project->investment->asking_amount}}
									</div>
									<div class="col-md-3 col-xs-3">
										Project Name
									</div>
									<div class="col-md-3 col-xs-3">
										Project Name
									</div>
								</a>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6" id="sold-invoice-panel">
				<div class="panel panel-default" style="box-shadow: 0px 0px 10px grey;">
					<div class="panel-heading row">					
						<div class="col-md-3 col-xs-3">
							Project Name
						</div>
						<div class="col-md-3 col-xs-3">
							Asking Amount
						</div>
						<div class="col-md-3 col-xs-3">
							Project Name
						</div>
						<div class="col-md-3 col-xs-3">
							Status
						</div>
					</div>
					<div class="panel-body">
						<div class="">
							@foreach($projects as $project)
							<div class="" style="border-top: 1px solid; width:100%;">
								<a href="#" class="list-group-item row" style="padding: 1em 0;">
									<div class="col-md-3 col-xs-3">
										{{$project->title}}
									</div>
									<div class="col-md-3 col-xs-3">
										{{$project->investment->asking_amount}}
									</div>
									<div class="col-md-3 col-xs-3">
										Project Name
									</div>
									<div class="col-md-3 col-xs-3">
										Project Name
									</div>
								</a>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('partials.connectToWallet')
@stop
@section('js-section')
{{-- {!! Html::script('js/konkrete.js') !!} --}}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/assets/abi/smartInvoiceABI.js"></script>
<script src="/assets/abi/byteCode.js"></script>
<script type="text/javascript">
	window.addEventListener('load', async () => {
		if (window.ethereum) {
			window.web3 = new Web3(ethereum);
			try{
				if(ethereum._metamask.isEnabled()){
					var uAddress = ethereum.selectedAddress;
					var shortText = jQuery.trim(uAddress.toString()).substring(0, 8)+ "...";
					console.log(ethereum);
					$('#connectToWalletBtn').text(shortText);
					var balance = await getDaiBalance(ethereum.selectedAddress);
					var balance = web3.utils.fromWei(balance.toString(), 'ether');
					var b = Number(balance).toFixed(2);
					$('#balanceBtn').text(b);
					console.log('Enabled');
				}else{
					$('#connectToWallet').modal('show');
					console.log('not enabled');
				}
				$('#metamaskConnect').on('click',function (e) {
					ethereum.enable();
				});
				//ethereum.autoRefreshOnNetworkChange = false;
				//await ethereum.enable();
			}catch{
				console.log('User has denied the access');
			}
		}else{
			console.log('Browser does not have metamask');
		}
		// console.log(abi);
		$("form#createInvoiceForm").submit(async(e) => {
			e.preventDefault();
			$('.loader-overlay').show();
			var amount = $('input[name=invoice_amount]').val();
			var askingAmount = $('input[name=asking_amount]').val();
			var dueDate = $('input[name=due_date]').val();
			var someDate = new Date(dueDate);
			someDate = someDate.getTime();
			var walletAddressBuyer = $('input[name=wallet_address_buyer').val();
			if(amount == null){
				window.reload;
			}
			var result = compileCode(amount,askingAmount,someDate,walletAddressBuyer,e);
			console.log(result);
		});
	});
</script>
@stop
