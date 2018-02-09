@extends('layouts.main')

@section('title-section')
Thank You | @parent
@stop

@section('css-section')
{!! Html::style('plugins/animate.css') !!}
@stop

@section('content-section')
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="row" id="section-1">
				<div class="col-md-12">
					<div style="padding:2em 0;">
						<h2 class="text-center wow fadeIn animated">Please transfer your funds to the following account<br></h2>
						<div class="row">
						<div class="col-md-offset-2 col-md-8">
								<table class="table table-bordered table-hover">
									<tr><td>Bank</td><td>{!!$project->investment->bank!!}</td></tr>
									<tr><td>Account Name</td><td>{!!$project->investment->bank_account_name!!}</td></tr>
									<tr><td>BSB </td><td>{!!$project->investment->bsb!!}</td></tr>
									<tr><td>Account No</td><td>{!!$project->investment->bank_account_number!!}</td></tr>
									<tr><td>Reference</td><td>{!!$project->investment->bank_reference!!}</td></tr>
								</table>							
								<p>
								So if your name is John Smith, then reference would be Price St John Smith. We will get in touch with you to confirm receipt of funds and guide you through the process if needed.<p class="text-center"><small>Our contact details are info@estatebaron.com and 1 300 033 221 </small>.</p></p>
								<br><br>
								<span id="timer">
								</span>
							</div>
							</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<img src="{{asset('assets/images/estate_baron_hat1.png')}}" alt="Estate Baron Masoct" class="pull-right img-responsive" style="padding-top:20em;">
				</div>
			</div>
		</div>
		@stop

		@section('js-section')
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
		{!! Html::script('plugins/wow.min.js') !!}
		<script type="text/javascript">
			new WOW().init({
				boxClass:     'wow',
				animateClass: 'animated',
				mobile:       true,
				live:         true
			});
		</script>
		<script type="text/javascript">
	// var count = 6;
	// var redirect = "https://estatebaron.com/";

	// function countDown(){
	// 	var timer = document.getElementById("timer");
	// 	if(count > 0){
	// 		count--;
	// 		timer.innerHTML = "<h1><small>This page will redirect in "+count+" seconds.</small></h1>";
	// 		setTimeout("countDown()", 1000);
	// 	}else{
	// 		window.location.href = redirect;
	// 	}
	// }
	// countDown();
</script>
@stop
