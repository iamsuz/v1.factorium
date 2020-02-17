@extends('layouts.mainproject')

@section('title-section')
Asset Tokenization
@stop

@section('css-section')
<style>
	body{
		color: #000;
	}
	.content{
		position: relative;
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
		border: none;
		/*border-bottom: 1px solid #ddd;*/
		/*border-radius: 0px;*/
		margin-left: -1px;
		margin-right: -1px;
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
		margin-top: -64px;
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
<section style="background-color: #070a0e;">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="alert alert-danger hide text-center" id="alertAllInvoice">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<p class="hide text-center" id="networkInfo" style="color: #fff;">
				</p>
			</div>
		</div>
	</div>
</section>
<section class="main-fold" id="mainFold" style="background-color: #070a0e;color: #fff;">
	<div class="container">
		<div class="row" style="padding-top:30px; margin-right: 0px !important;">
			<div class="col-md-2">
				<a href="/"><img src="/assets/images/white.png" width="200px;"></a>
			</div>
			<div class="col-md-1 col-md-offset-7">
				<button class="btn" style="background-color: #141e27; color: #fff;" data-backdrop="static" data-keyboard="false" ><span id="balanceBtn"></span> Dai</button>
			</div>
			<div class="col-md-2">
				<button class="btn pull-right" data-toggle="modal" data-target="#connectToWallet" style="background-color: #141e27; color: #fff;" data-backdrop="static" data-keyboard="false" id="connectToWalletBtn">Connect to wallet</button>
			</div>
		</div>
		<div class="row text-center" style="margin-top: 10vh;">
			<div class="col-md-4">
				<br>
				<h3 class="project-name">Asset Name</h3>
				<p class="askingAmt">Asking Amount</p>
			</div>
			<div class="col-md-4 text-center">
				<button class="btn btn-lg btn-info buy-now-btn circle-btn approval-btn">
					Unlock Dai<br>
					<span class="askingAmt"></span>
				</button>
				<p id="confirmationMessage" class="hide">Waiting for confirmation</p>
			</div>
			<div class="col-md-4">
				<br>
				<h3 class="invested-amount">Invested Amount</h3>
				<p class="investedAmount">0 DAI</p>
			</div>
		</div>
	</div>
</section>
<section class="second-fold" style="background-color: #070a0e;">
	<div class="container" style="padding: 85px 15px 85px 15px;">
		<div class="row">
			<div class="col-md-2">
				<button class="btn btn-block btn-default filterbtn @if(!request('filter') || (request('filter') == 'all')) active @endif" onclick="filterSelection('all')" > Show all</button>
			</div>
			<div class="col-md-2">
				<button class="btn btn-block btn-default filterbtn  @if(request('filter') && (request('filter') == 'buy')) active @endif" onclick="filterSelection('buy')"> Buy Now</button>
			</div>
			<div class="col-md-2">
				<button class="btn btn-block btn-default filterbtn  @if(request('filter') && (request('filter') == 'sold')) active @endif" onclick="filterSelection('sold')"> Asset Bought</button>
			</div>
			<div class="col-md-2">
				<button class="btn btn-block btn-default filterbtn @if(request('filter') && (request('filter') == 'repaid')) active @endif" onclick="filterSelection('repaid')">Redeem</button>
			</div>
		</div>
	</div>
</section>
<section class="third-fold">
	<div class="container">
		<div class="row text-center" id="buy-invoice-panel">
			<div class="col-md-12">
				<div class="panel panel-default" style="box-shadow: 0px 0px 10px grey;">
					<div class="panel-heading row" style="padding: 2rem 0;color: #aab8c1;">
						<div class="col-md-2 col-xs-2">
							Asset Name
						</div>
						<div class="col-md-2 col-xs-2">
							Due Amount
						</div>
						<div class="col-md-2 col-xs-2">
							Asking Amount
						</div>
						<div class="col-md-2 col-xs-2">
							Due Date
						</div>
						<div class="col-md-2 col-xs-2">
							APR
						</div>
						<div class="col-md-2 col-xs-2">
							Status
						</div>
					</div>
					<div class="panel-body">
						<div class="">
							@foreach($projects as $project)
							<div class=""  style="border-top: 1px solid #e3e9eb; width:100%;">
								<li class="list-group-item row" style="padding: 1em 0;" data-id="{{$project->id}}" data-asking="{{$project->investment->getCalculatedAskingPriceAttribute()}}" data-address="{{$project->contract_address}}" data-dueD="{{$project->investment->fund_raising_close_date}}" data-amount="{{$project->investment->invoice_amount}}">
									<div class="col-md-2 col-xs-2">
										{{$project->title}} <a href="https://kovan.etherscan.io/token/{{$project->contract_address}}" style="color: #424242;" target="_blank"> <i class="fa fa-external-link" aria-hidden="true" style="font-size: 10px;"></i></a>
									</div>
									<div class="col-md-2 col-xs-2">
										{{$project->investment->invoice_amount}}
									</div>
									<div class="col-md-2 col-xs-2">
										{{number_format($project->investment->getCalculatedAskingPriceAttribute(),3)}}
									</div>
									<div class="col-md-2 col-xs-2">
										{{date('d-m-Y', strtotime($project->investment->fund_raising_close_date))}}
									</div>
									<div class="col-md-2 col-xs-2">
										5%
									</div>
									<div class="col-md-2 col-xs-2">
										@if(!$project->repurchased->isEmpty())
										<i>Settled</i>
										@elseif(!$project->soldInvoice->isEmpty())
										<i>Sold</i>
										@else
										Buy Now
										@endif
									</div>
								</li>
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
@include('partials.redeemInvTokenModal')
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
					(!ethereum.selectedAddress) ? $('#connectToWallet').modal('show') : console.log('Enabled');
					var uAddress = ethereum.selectedAddress;
					window.ethereum.on('accountsChanged', async (accounts) => {
						var uAddress = accounts[0];
						var shortText = jQuery.trim(uAddress.toString()).substring(0, 10)+ "...";
						$('#connectToWalletBtn').text(shortText);
						var balance = await getDaiBalance(ethereum.selectedAddress);
						var balance = web3.utils.fromWei(balance.toString(), 'ether');
						var b = Number(balance).toFixed(3);
						$('#balanceBtn').text(b);
					});
					var shortText = jQuery.trim(uAddress.toString()).substring(0, 10)+ "...";
					$('#connectToWalletBtn').text(shortText);
					var balance = await getDaiBalance(ethereum.selectedAddress);
					var balance = web3.utils.fromWei(balance.toString(), 'ether');
					var b = Number(balance).toFixed(3);
					$('#balanceBtn').text(b);
					var askAmount, pid, cAddress, dueD, amount,df,tAmount;
					@if(request('filter') && (request('filter') == 'sold'))
					$('li.list-group-item').each(function () {
						var ca = $(this).data('address');
						getInvTokenBalance(ca).then(async (res) => {
							if(res === 0){
								$('li.list-group-item').addClass('hide');
							}
						});
					});
					@endif
					$('li.list-group-item').on('click',function (e) {
						$('li.list-group-item').each(function () {
							$(this).removeClass('list-group-item-info');
						});
						$(this).addClass('list-group-item-info');
						tAmount = $(this).data('amount');
						console.log(tAmount);
						askAmount = Number($(this).data('asking'));
						dueD = new Date($(this).data('dued'));
						cAddress = $(this).data('address');
						pid = $(this).data('id');
						$('.project-name').text('Invoice '+pid);
						$('.askingAmt').text('$'+(askAmount).toFixed(3));
						approvalStatus(cAddress,tAmount,askAmount);
					});
					$('.circle-btn').on('click',function (e) {
						e.preventDefault();
						if($(this).hasClass('approval-btn') && cAddress && tAmount){
							approval(cAddress,tAmount);
						}else if($(this).hasClass('buy-now') && cAddress && askAmount){
							var hPid = btoa(pid);
							byInvoice(cAddress,askAmount,hPid,pid);
							$('.loader-overlay').show();
						} else if($(this).hasClass('redeem-btn') && cAddress){
							$('.loader-overlay').hide();
							getInvTokenBalance(cAddress);
							$('#redeemInvTokenModal').modal('show');
							$('form#redeemTokenForm').submit(function (t) {
								t.preventDefault();
								var invToken = $('input[name="invToken"]').val();
								redeemInvToken(cAddress, invToken);
        							//getDaiBalance(ethereum.selectedAddress);
        						});
						}else{
							showAlertMessage('Please select any project',4000);
						}
					});
				}else{
					$('#connectToWallet').modal('show');
					console.log('not enabled');
				}
				//ethereum.autoRefreshOnNetworkChange = false;
				//await ethereum.enable();
			}catch(err){
				if(!ethereum._metamask.isEnabled()){
					$('#connectToWallet').modal('show');
				}
				console.log(err);
				showAlertMessage('User has denied the access',5000);
			}
			$('#metamaskConnect').on('click',function (e) {
				ethereum.enable().then(function (accounts) {
					location.reload();
				});
			});
		}else{
			showAlertMessage('Browser does not have metamask',3000000);
			console.log('Browser does not have metamask');
		}
		// console.log(abi);
	});
</script>
<script type="text/javascript">
	function filterSelection(c) {
		let filterUrl = '{{ route('home') }}?filter=' + c + '#projects';
		window.location.href = filterUrl;
		return;
	}
</script>
@stop
