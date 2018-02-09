@extends('layouts.main')

@section('title-section')
Financial Service Guide | @parent
@stop

@section('content-section')
<div class="containerouter">
	<div class="title" style="min-height:300px; background:#50B0DC; margin-top:-50px;">
		<div class="container">
			<h1 style="padding-top:120px; color:#FFFFFF;" class="text-center">ESTATE BARON – REAL ESTATE DEVELOPMENT CROWDFUNDING</h1>
			<p style="color:#FFFFFF; text-align:center; padding-bottom:100px">
			</p>
		</div>
	</div>
	<div class="container">
		<div class="left_container" style="padding-top:20px;">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<p class="text-justify"><p>Ed: I believe this an underserved market, development finance is really tough to get, but there is a reason for that.</p>

					<p>Property development is a highly risky game with massive rewards once you get it right but so many things can go wrong during the process.</p>

					<p>Development Application delays from the council, legal action from neighbours, building delays due to weather and every day you lose comes off the bottom line.</p>

					<p>Its a tough market and it has a high failure rate but this problem is real, the banks do a crappy job, my biggest concern is that developers are probably a lot sharper and have a highly honed sense of survival, far more than startups.</p>

					<p>The toughest thing is for the investor to ensure they get their share of the profits and the investment vehicle has some methods to enforce this, its not a game for young players.</p>

					<p>I note that each project is ASIC regulated which is a step in the right direction.</p>
					<br>
					<table class="table table-bordered text-left">
						<tbody>
							<tr>
								<td>Startup Name</td>
								<td>Estate Baron</td>
							</tr>
							<tr>
								<td>What problem are you solving?</td>
								<td>We are giving everyone the chance to be able to invest in expensive Melbourne real estate, while providing project developers with the financing they need.</td>
							</tr>
							<tr>
								<td>What is your solution?</td>
								<td>We provide users with a list of development projects and allow them to invest as little as $2000 for a share of the property, using the model of crowdfunding.</td>
							</tr>
							<tr>
								<td>Target Market</td>
								<td>Our target market are primarily Men between 25-54 years of age.</td>
							</tr>
							<tr>
								<td>How will you make money?</td>
								<td>We take a percentage of the returns on each investment.</td>
							</tr>
							<tr>
								<td>Tell us about the market & founders, why is this a great opportunity?</td>
								<td>Real Estate Crowdfunding has grown to become very popular and successful in the American, European and British market and Australia has just started to catch on. We are one of 3 companies in Australia who provide this service. Crowdfunding is a new and popular way to bring people together to fund a communal project instead of depending on Banks for financial backing all the time.</td>
							</tr>
							<tr>
								<td>Founders Names</td>
								<td>Moresh Kokane, Mark Winslade and Luke Hindson</td>
							</tr>
							<tr>
								<td>What type of funding has the company received?</td>
								<td>Private Equity</td>
							</tr>
							<tr>
								<td>Website</td>
								<td><a href="http://www.estatebaron.com">www.estatebaron.com</a></td>
							</tr><tr>
								<td>Twitter Handle</td>
								<td><a href="http://www.twitter.com/estatebaron">@EstateBaron</a></td>
							</tr>

						</tbody>
					</table>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<p class="text-right">
						Posted on <time datetime="2015-07-30 13:00">July 30, 2015</time> by MIKE88.
					</p>
				</div>
			</div>
		</div>
	</footer>
	@if(Auth::guest())
	<section id="register" class="chunk-box">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h2 class="wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.2s" style="font-weight:100;">You are almost there! <br>
						<small class="wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-size:.5em">Sign up for free, to see the current opportunities.</small>
					</h2>
				</div>
			</div>
			@if ($errors->has())
			<br>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="alert alert-danger text-center">
						@foreach ($errors->all() as $error)
						{{ $error }}<br>
						@endforeach
					</div>
				</div>
			</div>
			<br>
			@endif
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(array('route'=>'registrations.store', 'class'=>'form-horizontal', 'role'=>'form','onsubmit'=>'return checkvalidi();','id'=>'form'))!!}
					<div class="row text-center">
						<div class="col-md-12 wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.4s">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-primary active eb-checkbox">
									<input type="radio" name="role" id="investor_role" autocomplete="off" value="investor" checked tabindex="1"> I am an Investor
								</label>
								<label class="btn btn-primary eb-checkbox">
									<input type="radio" name="role" id="developer_role" autocomplete="off" value="developer" tabindex="2"> I am a Developer
								</label>
							</div>
						</div>
					</div>
					<br>
					<div class="row text-center">
						<div class="col-md-8 col-md-offset-2">
							<div class="row">
								<div class="form-group">
									<div class="col-md-6 col-md-offset-3 <?php if($errors->first('email')){echo 'has-error';}?> wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.7s" style="z-index:3;" id="err_msg">
										{!! Form::email('email', null, array('placeholder'=>'you@somwehere.com', 'class'=>'form-control', 'tabindex'=>'2', 'id'=>'email', 'data-toggle'=>'popover', 'data-trigger'=>'hover', 'data-placement'=>'bottom', 'data-content'=>'We will never share your contact details with unaffiliated parties, we use your email to notify you of the new and exciting projects on our site', 'required'=>'true')) !!}
										{!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group" id="password_form" style="display:none">
									<div class="col-md-6 col-md-offset-3 <?php if($errors->first('password')){echo 'has-error';}?>" data-wow-delay="0.2s">
										{!! Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control input-box','name'=>'password', 'Value'=>'', 'id'=>'password', 'tabindex'=>'3')) !!}
										{!! $errors->first('password', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="1s">
									<input type="submit" value="See the Opportunities" id="submit" name="submit"  class="btn btn-primary btn-danger" style="height:40px; width:244px;font-size: 1.2em; margin:10px 10px; " tabindex="8">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="1s" style="padding-top:10px;">
							You have an account!
							{!! Html::linkRoute('users.login', 'Sign In Here') !!}
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</section>
	@endif
	@stop