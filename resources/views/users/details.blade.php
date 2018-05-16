@extends('layouts.main')
@section('title-section')
Fill the user details | @parent
@stop

@section('css-section')
@parent
@stop

@section('content-section')
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<br>
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<br>
			<section id="signUpForm">
				<div class="row">
					<div class="col-md-12">
						{!! Form::open(array('route'=>'registration.storeDetails', 'class'=>'form-horizontal', 'role'=>'form')) !!}
						<fieldset>
							<h3 class="text-center h1-faq">Please fill the following details to complete your registration</h3>
							<br>
							<div class="row">
								<div class="form-group <?php if($errors->first('first_name') && $errors->first('last_name')){echo 'has-error';}?>">
									<div class="col-sm-offset-1 col-sm-10">
										<div class="row">
											<div class="col-sm-6 <?php if($errors->first('first_name')){echo 'has-error';}?>">
												{!! Form::text('first_name', null, array('placeholder'=>'First Name', 'class'=>'form-control ', 'tabindex'=>'1', 'required'=>'true')) !!}
												{!! $errors->first('first_name', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 <?php if($errors->first('last_name')){echo 'has-error';}?>">
												{!! Form::text('last_name', null, array('placeholder'=>'Last Name', 'class'=>'form-control', 'tabindex'=>'2', 'required'=>'true')) !!}
												{!! $errors->first('last_name', '<small class="text-danger">:message</small>') !!}
												{!! Form::hidden('token', $user->token) !!}

											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="form-group <?php if($errors->first('phone_number')){echo 'has-error';}?>">
									<div class="col-sm-offset-1 col-sm-10">
										{!! Form::input('tel', 'phone_number', null, array('placeholder'=>'Phone Number', 'class'=>'form-control', 'tabindex'=>'3', 'required'=>'true')) !!}
										{!! $errors->first('phone_number', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-sm-offset-1 col-sm-10">
										{!! Form::submit('Take me to projects', array('class'=>'btn btn-warning btn-block', 'tabindex'=>'10')) !!}
									</div>
								</div>
							</div>
						</fieldset>
						{!! Form::close() !!}
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
@stop