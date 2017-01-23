@extends('layouts.main')

@section('title-section')
StartUp Smart Review | @parent
@stop

@section('content-section')
<div class="containerouter">
	<div class="title" style="min-height:300px; background:#50B0DC; margin-top:-50px;">
		<div class="container">
			<h1 style="padding-top:120px; color:#FFFFFF;" class="text-center">Founding Stone a good support for real estate crowdfunder</h1>
			<p style="color:#FFFFFF; text-align:center; padding-bottom:100px">
			</p>
		</div>
	</div>
	<div class="container">
		<div class="left_container" style="padding-top:20px;">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<p class="text-justify">Australian real estate equity crowdfunding platform Estate Baron has closed a $400,000 seed funding round led by AngelCube founder Adrian Stone.</p>
					<p>The Melbourne-based startup aims to lower the barrier to entry for investment in real estate projects, allowing people to contributing funding as little as $2000 in exchange for an equity stake.</p>
					<p>The platform connects project developers with potential retail investors, who decide what to invest in based on the anticipated return, time-frame, location and developer.</p>
					<p>
						Estate Baron founder Moresh Kokane says this area of crowdfunding is set to take off in Australia.
						“Crowdfunding will change the way Australians buy and fund property,” Kokane says.
						“I’ve followed the rise of crowdfunding sites in the US and Australia is ripe for this sort of disruption in property finance.”
					</p>
					<p>The Series A funding round, which valued the startup at $2 million, will be used on technology development and marketing, Kokane says.
						AngelCube founder Adrian Stone led the investment round, and says the Estate Baron team pitched to him during his regular open sessions.
					</p>
					<p>
						“I invested because Australians punch far above their weight when it comes to real estate investing, and the US experience with startups such as Fundrise.com have shown that this is a necessary alternate form of investment,” Stone says.
						“Unlike crowdsourced equity funding for startups, I invested in Estate Baron because I believe that there is a tangible underlying asset that underwrites the value of each investment made on the platform.”
					</p>
					<p>
						Kokane says Estate Baron is the first startup of this model to have a full Public Disclosure Statement and a Retail Australian Financial Services Licence, meaning there are no restrictions on the number of investors involved in each project, or the minimum amount which can be invested.
						It’s a way for people who aren’t wealthy wholesalers to be involved in the property market, he says.
						“The people who are that wealthy already have these sort of projects presented to them daily, so they don’t really need us,” Kokane says.
						“With a lot of money coming from overseas, people are being pushed out of the market.”
						“Beginners can’t get into the game. This is a way for them to get into the investment property market.”
					</p>
					<p>Estate Baron launched in February and has closed $1.2 million in investments through the platform, with 450 local investors signed up.</p>
					<p>The real estate equity crowdfunding market is heating up in Australia, with the recent launch of CrowdFundUp, which offers both debt and equity investment opportunities.</p>
					<p>
						It’s Estate Baron’s focus on retail investors that sets it apart though, Kokane says.
						“We’re the only site with access to the retail licence at the moment,” he says.
						“Others are limited to wholesale investors. That’s how we started as well but we realised there we nothing really to be achieved in that area.”
					</p>
					<p>
						Prominent real estate developer Benni Aroni also invested in the startup, and will be personally vetting the projects before they are listed.
						Real estate investment is a notoriously risky endeavour, but Kokane says they’re doing everything they can to minimise these and explain them to users.
						“We’re trying to get as much transparency as possible,” he says.
						“It’s very important that the projects listed meet our very strict quality criteria. We meet with every investor involved and make sure they know what they’re getting in to.”
					</p>
					<p>Raising your first round of capital? Starting a crowdfunding campaign? Want to grow your business with Instagram? StartupSmart School can help.
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
						Posted on <time datetime="2015-08-06 13:00">August 6, 2015</time> by Denham Sadler.
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