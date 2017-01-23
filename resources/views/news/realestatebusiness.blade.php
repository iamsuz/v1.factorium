@extends('layouts.main')

@section('title-section')
Financial Service Guide | @parent
@stop

@section('content-section')
<div class="containerouter">
	<div class="title" style="min-height:300px; background:#50B0DC; margin-top:-50px;">
		<div class="container">
			<h1 style="padding-top:120px; color:#FFFFFF;" class="text-center">Real estate fintech deal turns property into shares</h1>
			<p style="color:#FFFFFF; text-align:center; padding-bottom:100px">
			</p>
		</div>
	</div>
	<div class="container">
		<div class="left_container" style="padding-top:20px;">
			<div class="container">
			<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<p class="text-justify"><p>A new fintech partnership will allow investors to ease their way into the market by acquiring a small stake in individual properties.Under the agreement, DomaCom will provide the back-end online book-build process and compliance for properties listed by Estate Baron.</p>

					<p>DomaCom is a ‘fractional property investment’ platform that combines online property listing with online trading. Estate Baron is a crowd-investing site created to raise capital for opportunities in real estate.The partnership enables Estate Baron to connect smaller investors with real estate opportunities, according to co-founder Moresh Kokane.</p>

					<p>DomaCom provides the expertise to ensure that those investors are properly serviced in a regulated environment, chief executive Arthur Naoumidis said.“Engaging with the new phenomena of property investment, crowdfunding is another first for DomaCom and further demonstrates the flexibility of our platform model,” he said.“Estate Baron are also breaking new ground as the first real estate equity crowdfunding site to provide investment property via a regulated product.”The fractional investment market allows home owners – principally retirees – to sell equity in their home.</p>

					<p>DomaCom runs a managed investment fund that allows investors to register an interest in specific properties via a book-build process.</p>

					<p>When a book build is complete, DomaCom purchases the property, places it in a sub-fund and issues the investors with units according to their investments.</p>
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
					Posted on <time datetime="2015-04-24 13:00">April 24, 2015</time> by Staff Reporter.
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