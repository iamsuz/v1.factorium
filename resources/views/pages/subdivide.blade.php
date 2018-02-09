@extends('layouts.main')

@section('title-section')
Subdivide | @parent
@stop

@section('css-section')
{!! Html::style('plugins/animate.css') !!}
@stop

@section('content-section')
<div class="container">
	<br>
	<h1 class="text-center wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.5s">Your Planning Permits for Free</h1>
	<br>
	@if (Session::has('message'))
	<br>
	{!! Session::get('message') !!}
	<br>
	@endif


	{!! Form::open(array('route'=>'pages.subdivide.store', 'class'=>'form-horizontal', 'role'=>'form', 'files'=>true)) !!}
	<section id="project-form">
		<div class="row">
			<div class="col-md-5">
				<p class="text-justify wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.3s">So you have a property you want to subdivide? Or put a granny flat on there? Whatever your development ideas are planning permits and councils can be tricky. One mistake can throw you back by months and incur huge expenses.</p>
				<br>
				<p class="text-justify wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.3s"> Our partners have done many development projects for years and can guide you through the permits process.</p>
				<br>
				<p class="text-justify wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.4s">We will assess your property and determine the best use for it, create the plans and lodge them with the council accordingly. And we are so confident of our work that we will pay for it ourselves.</p>
				<br>
				<p class="text-justify wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.5s">And it gets even better, once the permits are here we will buy your property outright at a price 20% higher than the current market rate. No agents, direct purchase.</p>
			</div>
			<div class="col-md-7">
				<fieldset>
					<div class="row wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.3s">
						<div class="form-group @if($errors->first('first_name') && $errors->first('last_name')){{'has-error'}} @endif ">
							<div class="col-sm-offset-1 col-sm-11">
								<div class="row">
									<div class="col-sm-6 @if($errors->first('first_name')){{'has-error'}} @endif">
										{!! Form::text('first_name', null, array('placeholder'=>'First Name', 'class'=>'form-control', 'tabindex'=>'1')) !!}
										{!! $errors->first('first_name', '<small class="text-danger">:message</small>') !!}
									</div>
									<div class="col-sm-6 @if($errors->first('last_name')){{'has-error'}} @endif">
										{!! Form::text('last_name', null, array('placeholder'=>'Last Name', 'class'=>'form-control', 'tabindex'=>'2')) !!}
										{!! $errors->first('last_name', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.3s">
						<div class="form-group @if($errors->first('phone_number') && $errors->first('email')){{'has-error'}} @endif">
							<div class="col-sm-offset-1 col-sm-11">
								<div class="row">
									<div class="col-sm-6 @if($errors->first('phone_number')){{'has-error'}} @endif">
										{!! Form::input('tel', 'phone_number', null, array('placeholder'=>'Phone Number (7276160000)', 'class'=>'form-control', 'tabindex'=>'3')) !!}
										{!! $errors->first('phone_number', '<small class="text-danger">:message</small>') !!}
									</div>
									<div class="col-sm-6 @if($errors->first('email')){{'has-error'}} @endif">
										{!! Form::email('email', null, array('placeholder'=>'Email', 'class'=>'form-control', 'tabindex'=>'4')) !!}
										{!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
						</div>
					</div>
					<br>
					<div class="row wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.4s">
						<div class="form-group @if($errors->first('line_1') && $errors->first('line_2')){{'has-error'}} @endif ">
							<div class="col-sm-offset-1 col-sm-11">
								<div class="row">
									<div class="col-sm-6 @if($errors->first('line_1')){{'has-error'}} @endif">
										{!! Form::text('line_1', null, array('placeholder'=>'Address line 1', 'class'=>'form-control', 'tabindex'=>'5')) !!}
										{!! $errors->first('line_1', '<small class="text-danger">:message</small>') !!}
									</div>
									<div class="col-sm-6 @if($errors->first('line_2')){{'has-error'}} @endif">
										{!! Form::text('line_2', null, array('placeholder'=>'Address line 2', 'class'=>'form-control', 'tabindex'=>'6')) !!}
										{!! $errors->first('line_2', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.4s">
						<div class="form-group @if($errors->first('city') && $errors->first('state')){{'has-error'}} @endif">
							<div class="col-sm-offset-1 col-sm-11">
								<div class="row">
									<div class="col-sm-6 @if($errors->first('city')){{'has-error'}} @endif">
										{!! Form::text('city', null, array('placeholder'=>'City', 'class'=>'form-control', 'tabindex'=>'7')) !!}
										{!! $errors->first('city', '<small class="text-danger">:message</small>') !!}
									</div>
									<div class="col-sm-6 @if($errors->first('state')){{'has-error'}} @endif">
										{!! Form::text('state', null, array('placeholder'=>'state', 'class'=>'form-control', 'tabindex'=>'8')) !!}
										{!! $errors->first('state', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.4s">
						<div class="form-group @if($errors->first('postal_code') && $errors->first('country')){{'has-error'}} @endif">
							<div class="col-sm-offset-1 col-sm-11">
								<div class="row">
									<div class="col-sm-6 @if($errors->first('postal_code')){{'has-error'}} @endif">
										{!! Form::text('postal_code', null, array('placeholder'=>'postal code', 'class'=>'form-control', 'tabindex'=>'9')) !!}
										{!! $errors->first('postal_code', '<small class="text-danger">:message</small>') !!}
									</div>
									<div class="col-sm-6 @if($errors->first('country')){{'has-error'}} @endif">
										<select name="country" class="form-control" tabindex="10">
											@foreach(\App\Http\Utilities\Country::aus() as $country => $code)
											<option value="{{$country}}">{{$country}}</option>
											@endforeach
										</select>
										{!! $errors->first('country', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
						</div>
					</div>
					<br>
					<div class="row wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.5s">
						<div class="form-group @if($errors->first('doc1')){{'has-error'}} @endif">
							{!!Form::label('doc1', 'Section-32 Form', array('class'=>'col-sm-4 control-label'))!!}
							<div class="col-sm-8">
								{!! Form::file('doc1', array('class'=>'form-control', 'tabindex'=>'11')) !!}
								{!! $errors->first('doc1', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
		<div class="row chunk-box">
			<fieldset>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6 wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.6s">
						{!! Form::submit('Submit', array('class'=>'btn btn-danger btn-lg btn-block', 'tabindex'=>'12')) !!}
					</div>
				</div>
			</fieldset>
			{!! Form::close() !!}
		</div>
		<br>
	</section>
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
	});
	new WOW().init({
		boxClass:     'wow',
		animateClass: 'animated',
		mobile:       true,
		live:         true
	});
</script>
@stop
