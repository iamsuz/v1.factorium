@extends('layouts.app')
@section('title-section')
Sign Up | @parent
@stop

@section('css-section')
@parent
@stop

@section('content-section')
<div class="title" style="min-height:300px; background:@if($color=App\Helpers\SiteConfigurationHelper::getSiteThemeColors())@if($color->nav_footer_color)#{{$color->nav_footer_color}} @else #2d2d4b @endif @else #2d2d4b @endif; margin-top:-70px;">
	<div class="container">
		<div class="text-center wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.2s" style="padding-top:6rem;">
		<br>
			<center>
				@if($siteConfigMedia=App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->siteconfigmedia)
                @if($mainLogo = $siteConfigMedia->where('type', 'brand_logo')->first())
                <img class="img-responsive" src="{{asset($mainLogo->path)}}" alt="estate baron" width="350"></center>
                @else
                <img class="img-responsive" src="{{asset('assets/images/main_logo.png')}}" alt="estate baron" width="350"></center>
                @endif
                @else
                <img class="img-responsive" src="{{asset('assets/images/main_logo.png')}}" alt="estate baron" width="350"></center>
                @endif
			</div>
			<br>
			<h1 class="text-center font-semibold" style="color: #fff;">Registered Members Only</h1>
			<h3 class="text-center h1-faq" style="color: #fff;">Sign up for free, to see the current opportunities and receive updates.</h3>
			<br>
		</div>
	</div>
	@if(Auth::guest())
	<section id="register" class="chunk-box">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="row">
						<div class="col-md-12">
							<br>
							@if (Session::has('message'))
							{!! Session::get('message') !!}
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<section id="registerForm" style="padding:0 10px;">
								<h4 class="font-bold first_color" style="font-weight:500 !important; font-size:1.125em; color:#2d2d4b;">Register with an email</h4>
								{!! Form::open(array('route'=>'registrations.store', 'class'=>'form-horizontal', 'role'=>'form','id'=>'form'))!!}
								<div class="row form-group">
									<!-- <div> -->
									<div class="col-md-12 <?php if($errors->first('email')){echo 'has-error';}?> wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.7s" style="z-index:3;" id="err_msg">
										{!! Form::email('email', null, array('placeholder'=>'Email', 'class'=>'form-control', 'tabindex'=>'2', 'id'=>'email', 'data-toggle'=>'popover', 'data-trigger'=>'hover', 'data-placement'=>'bottom', 'data-content'=>'', 'required'=>'true')) !!}
										{!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
									</div>
									<!-- </div> -->
								</div>
								<div class="row hide">
									<div class="col-md-12 <?php if($errors->first('password')){echo 'has-error';}?>" data-wow-delay="0.2s">
										{!! Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control input-box','name'=>'password', 'Value'=>'', 'id'=>'password', 'tabindex'=>'3')) !!}
										{!! $errors->first('password', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
								<p class="font-bold hide" style="font-size:1.125em;color:#2d2d4b;">What best describes you?</p>
								<div class="row text-left hide">
									<div class="col-md-12 wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.4s">
										<div class="btn-group" data-toggle="buttons">
											<input type="radio" name="role" id="investor_role" autocomplete="off" value="investor" checked tabindex="1"><span class="font-regular first_color" style="font-size:0.875em; color:#2d2a6e;">&nbsp;&nbsp;&nbsp; I am an Investor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
											<input type="radio" name="role" id="developer_role" autocomplete="off" value="developer" tabindex="2"><span class="font-regular first_color" style="font-size:0.875em;color:#2d2a6e;">&nbsp;&nbsp;&nbsp; I have a venture </span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
										{!! $errors->first('g-recaptcha-response', '<small class="text-danger">:message</small>') !!} 
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="1s">
										<input type="submit" value="Register" id="submit" name="submit"  class="btn btn-block font-bold second_color_btn hide" style="height:40px; width:50%; font-size: 1.125em; background-color:#fed405; border-radius:0px;color:#2d2d4b;" tabindex="8">
										<a class='btn btn-lg btn-danger font-semibold text-right second_color_btn no-hower-style' id="submitform" href='#' style="width:243px; background-color: #fed405; font-size:1.125em; color:#000;border-radius:50px !important; border: 0px;"><img class="pull-left" src="{{asset('assets/images/estatebaronLogo.png')}}" style="width: 20px;"> Register</a>

									</div>
								</div>
								{!! Form::close() !!}
								<br>
								<h4 class="text-left font-regular first_color" style="font-size:1.375em;color:#2d2a6e;">If you have an existing Estate Baron account. <b><!-- {!! Html::linkRoute('users.login', 'Sign In Here') !!} --><a href="/users/login" id="redirection">Sign In Here</a></b>
								</h4>
							</section>
						</div>
						{{--<div class="col-md-3" style="position:relative;">
							<div style="position: absolute; margin: auto;top:50%;left:50%;margin-top:-25px;">
								<div class="second_color_btn" style="border-radius: 100%"><img class="img-responsive" src="{{asset('assets/images/Ellipse1.png')}}" style="opacity: 0;"/></div><p class="text-center" style="margin-top: -70%;font-size: 1.2em;font-weight: 600;color:#F7C228;">OR</p>
							</div>
							<br><br>
							<br><br>
							<br>
						</div>--}}
						{{--<div class="col-md-3">
							<div class="row" style="text-align:center;">
								<div class="btn-group" style="box-shadow:3px 3px 3px #888888;">
									<!-- <a class='btn btn-lg btn-danger'><i class="fa fa-google-plus" style="width:16px;"></i></a> -->
									<a class='btn btn-lg btn-danger font-semibold text-right' href='/auth/google' style="width:243px; background-color: #F1F1F1; border-color: #F1F1F1; font-size:1em; color:#000;border-radius:0;"><img class="pull-left" src="{{asset('assets/images/google_login.png')}}"> Sign in with Google</a>
								</div>
								<br><br>
								<div class="btn-group" style="box-shadow:3px 3px 3px #888888;">
									<!-- <a class='btn btn-lg btn-info disabled' style="background: #4875b4;border-color: #4875b4;"><i class="fa fa-linkedin" style="width:16px;"></i></a> -->
									<a class='btn btn-lg btn-info  font-semibold' href='/auth/linkedin' style="width:243px; background-color: #127AB6; border-color: #127AB6; font-size:1em; color:#fff; border-radius:0;"><img class="pull-left" src="{{asset('assets/images/linkedin_login.png')}}" style="width:25px; background-color:#fff;"> Sign in with Linkedin</a>
								</div>
								<br><br>
								<div class="btn-group" style="box-shadow:3px 3px 3px #888888;">
									<a class='btn btn-lg btn-primary font-semibold' href='/auth/facebook' style="width:243px; background-color: #375599; border-color: #375599; font-size:1em; color:#fff; border-radius:0;"><img class="pull-left" src="{{asset('assets/images/fb_login.png')}}" style=" margin:-10px -12px; background-color: #fff; width:45px;"> Sign in with Facebook</a>
								</div>
								<br><br>
							</div>
						</div>--}}
					</div>
				</div>
			</div>
		</div>
	</section>
	@endif
	<footer id="footer" style="background-color: @if($color=App\Helpers\SiteConfigurationHelper::getSiteThemeColors())@if($color->nav_footer_color)#{{$color->nav_footer_color}} @else #2d2d4b @endif @else #2d2d4b @endif";>
		<div class="container" style="height: 300px;">
			<div class="row">
				<div class="col-md-12">

				</div>
			</div>
		</div>
	</footer>
	@stop

	@section('js-section')
	<!-- Script for reCaptcha -->
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<script type="text/javascript">
		function getParameterByName(name, url) {
			if (!url) url = window.location.href;
			name = name.replace(/[\[\]]/g, "\\$&");
			var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)", "i"),
			results = regex.exec(url);
			if (!results) return null;
			if (!results[2]) return '';
			return decodeURIComponent(results[2].replace(/\+/g, " "));
		}
		if(getParameterByName('project')){
			var project = getParameterByName('project');
			document.getElementById("redirection").href = '/users/login?next=projects/'+project;
		} else {
			document.getElementById("redirection").href = '/users/login?next={{app('request')->input('next')}}';
		}
		$(document).ready(function(){
			$('#submitform').click(function(){
				$('#submit').trigger('click');
			});
			$(".no-hower-style").mouseover(function() {
	        	$(this).css('color', '#000');
	      	}).mouseout(function() {
	        	$(this).css('color', '#000');
	      	});
		});
	</script>
	@stop
