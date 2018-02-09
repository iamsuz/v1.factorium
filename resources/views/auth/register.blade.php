@extends('layouts.main')
@section('title-section')
Sign Up | @parent
@stop

@section('css-section')
@parent
@stop

@section('content-section')
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<section id="signUpForm">
				<div class="row well">
					<div class="col-md-12 center-block">
						{!! Form::open(array('url'=>'/auth/register', 'class'=>'form-horizontal', 'role'=>'form')) !!}
						<fieldset>
							<legend class="text-center">Register New User</legend>
							<div class="row">
								<div class="form-group <?php if($errors->first('first_name') && $errors->first('last_name')){echo 'has-error';}?>">
									{!!Form::label('first_name', 'Name', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-6 <?php if($errors->first('first_name')){echo 'has-error';}?>">
												{!! Form::text('first_name', null, array('placeholder'=>'First Name', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
												{!! $errors->first('first_name', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 <?php if($errors->first('last_name')){echo 'has-error';}?>">
												{!! Form::text('last_name', null, array('placeholder'=>'Last Name', 'class'=>'form-control', 'tabindex'=>'2')) !!}
												{!! $errors->first('last_name', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group <?php if($errors->first('email')){echo 'has-error';}?>">
									{!!Form::label('email', 'Email', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::email('email', null, array('placeholder'=>'you@somwehere.com', 'class'=>'form-control', 'tabindex'=>'3')) !!}
										{!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group <?php if($errors->first('password')){echo 'has-error';}?>">
									{!!Form::label('password', 'Password', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-6">
												{!! Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control', 'tabindex'=>'4')) !!}
												{!! $errors->first('password', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6">
												{!! Form::password('password_confirmation', array('placeholder'=>'Confirm Password', 'class'=>'form-control', 'tabindex'=>'5')) !!}
												{!! $errors->first('password_confirmation', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group <?php if($errors->first('phone_number')){echo 'has-error';}?>">
									{!!Form::label('phone_number', 'Telephone', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::input('tel', 'phone_number', null, array('placeholder'=>'7276160000', 'class'=>'form-control', 'tabindex'=>'6')) !!}
										{!! $errors->first('phone_number', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-9">
										{!! Form::submit('Register Account', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'7')) !!}
									</div>
								</div>
							</div>
						</fieldset>
						{!! Form::close() !!}
					</div>
				</div>
				<div class="row">
					<div class="text-center col-md-12">
						<br>
						<p>Already have an account! | <b> {!!Html::linkRoute('users.index','Sign In');!!} </b> </p>
					</div>
				</div>
				<center><a href="/auth/facebook" class="btn btn-primary" role="button"> Login With Facebook </a></center>
			</section>
		</div>
	</div>
</div>
@stop