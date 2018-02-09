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
					<div style="padding:5em 0;">
						<h1 class="text-center wow fadeIn animated h1-faq">Welcome {{$user->first_name}}<br>
							<small>Thank you for providing your details.</small>
						</h1>
						<br>
						<h3 class="text-center wow fadeIn animated h1-faq">You have Signed Up as {{$user->roles->first()->role}} <br> 
						<small>Would you like to change your Role at Estate Baron</small></h3>
						{!! Form::open(array('route'=>'registration.changeRole', 'class'=>'form-horizontal', 'role'=>'form')) !!}
							<div class="row text-center">
								<div class="radio">
									<label><input type="radio" name="role" value="investor" autocomplete="off" @if($user->roles->first()->role == 'investor') checked @endif>I am an Investor</label>
								</div>
								<div class="radio">
									<label><input type="radio" name="role" value="developer" autocomplete="off" @if($user->roles->first()->role == 'developer') checked @endif>I have a venture </label>
								</div>
							</div>
							{{-- <div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-1">Next</button>
								</div>
							</div> --}}
							<br>
							<div class="row">
								<div class="text-center col-md-offset-3 col-md-6 wow fadeIn animated">
									{!! Form::submit('Take me to Projects', array('class'=>'btn btn-warning btn-block', 'tabindex'=>'10')) !!}
								</div>
							</div>
						{!! Form::close() !!}
					</div>

				</div>
			</div>
			{{-- <div class="row hide" id="section-2">
				<div class="col-md-12">
					<div style="padding:1.5em 0;">
						<h1 class="text-center wow fadeIn animated h1-faq">
							Investment Structure and Security
							<br>
						</h1>
						<p class="text-center">
							We are a Corporate Authorised Representative of Guardian Securities Limited AFSL 7405661. The Vestabyte Investment Platform operates as a sub-trust within the Guardian Investment Fund (ARSN 168 048 057), a registered managed investment scheme.
						</p>
						<br><br>
						<h1 class="text-center wow fadeIn animated h1-faq">
							Disclosure
							<br>
						</h1>
						<p class="text-center">
							You will be provided with a Product Disclosure Statement (PDS) for each investment, that contains information about a financial product, including any significant benefits and risks, the cost of the financial product and the fees and charges that the financial product issuer may receive.
							<br>
							These measures ensure potential investors have the information necessary to conduct their own research and due diligence, therefore empowering the investors to make their own investment decisions. 
							<br>
							Read our FAQ for more information.
						</p>
						<br><br>
						<div class="row">
							<div class="text-center col-md-offset-3 col-md-6 wow fadeIn animated">
								<a href="{{route('home')}}#projects" class="btn btn-primary btn-block" role="button">Go to the projects.</a>
							</div>
						</div>
					</div>

				</div>
			</div> --}}
			<!-- <div class="row hide" id="section-3">
				<div class="col-md-12">
					<div style="padding:10em 0;">
						<h1 class="text-center wow fadeIn animated">
							<small>As part of our commitment to meeting Australian Securities Law we are required to do some additional user verification to meet Anti Money Laundering and Counter Terror Financing requirements.<br> This wont take long, promise!</small>
						</h1>
						<br><br>
						<div class="row">
							<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
								<button class="btn btn-primary btn-block" id="step-3">Continue</button>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="text-center col-md-offset-3 col-md-6 wow fadeIn animated">
								<a href="{{route('home')}}#projects" class="btn btn-default btn-block" role="button">Skip and go to the projects.</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row hide" id="section-4">
				<div class="col-md-12">
					<div style="padding:10em 0;">
						<h1 class="text-center wow fadeIn animated">Thank you <br>
							<small>We will take a quick picture of yours using your webcam and of your drivers license or passport to verify your identity.</small></h1> <h3>
							<small> Your data is not shared with any 3rd parties and will be used only for verification as per legal requirements.</small>
						</h3>
					</h1>
					<br><br>
					<div class="text-center col-md-offset-4 col-md-4 wow fadeIn animated">
						<a href="{{route('users.verification',$user)}}" class="btn btn-primary" style="font-size:100%;"><span class="glyphicon glyphicon-camera" style="line-height:initial;"></span><span style="border-right: 1px solid #ffffff; padding: 20px 6px 24px;"></span><cite>&nbsp&nbsp Ready? Smile!</cite></a>
					</div>
				</div>
			</div> -->
		</div>
	</div>
</div>
</div>
@stop

@section('js-section')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
{!! Html::script('plugins/wow.min.js') !!}
<script type="text/javascript">
	$(function () {
		$('.scrollto').click(function(e) {
			e.preventDefault();
			$(window).stop(true).scrollTo(this.hash, {duration:1000, interrupt:true});
		});
		$('#step-1').click(function(e) {
			$('#section-1').hide();
			$('#section-2').removeClass('hide');
		});
		// $('#step-2').click(function(e) {
		// 	$('#section-2').hide();
		// 	$('#section-3').removeClass('hide');
		// });
		// $('#step-3').click(function(e) {
		// 	$('#section-3').hide();
		// 	$('#section-4').removeClass('hide');
		// });
	});
	new WOW().init({
		boxClass:     'wow',
		animateClass: 'animated',
		mobile:       true,
		live:         true
	});
</script>
@stop
