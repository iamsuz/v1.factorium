@extends('layouts.main')
@section('title-section')
Edit {!! $user->first_name !!} | @parent
@stop

@section('css-section')
@parent
@stop
@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-12">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<section id="signUpForm">
				<div class="row">
					<div class="col-md-12 center-block">
						{!! Form::model($user, array('route'=>['users.update', $user], 'method'=>'PATCH', 'class'=>'form-horizontal', 'role'=>'form')) !!}
						<fieldset>
							<h2 class="text-center">Edit your profile details</h2>
							<br>
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
										{!! Form::email('email', null, array('placeholder'=>'you@somwehere.com', 'class'=>'form-control', 'tabindex'=>'4','readonly'=>'readonly')) !!}
										{!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>

							<div class="row">
								<div class="form-group <?php if($errors->first('gender')){echo 'has-error';}?>">
									{!!Form::label('gender', 'Gender', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::select('gender', ['male'=>'Male','female'=>'Female'], null, array('class'=>'form-control', 'tabindex'=>'7')) !!}
										{!! $errors->first('gender', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group <?php if($errors->first('date_of_birth')){echo 'has-error';}?>">
									{!!Form::label('date_of_birth', 'Your Birth Date', array('class'=>'col-sm-2 control-label'))!!}
									@if($user->date_of_birth)
									<?php $dob_string = $user->date_of_birth->toDateString(); ?>
									@else
									<?php $dob_string = Null; ?>
									@endif
									<div class="col-sm-9">
										{!! Form::input('date', 'date_of_birth', $dob_string , array('class'=>'form-control', 'tabindex'=>'8')) !!}
										{!! $errors->first('date_of_birth', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group <?php if($errors->first('phone_number')){echo 'has-error';}?>">
									{!!Form::label('phone_number', 'Mobile', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::input('tel', 'phone_number', null, array('placeholder'=>'7276160000', 'class'=>'form-control', 'tabindex'=>'9')) !!}
										{!! $errors->first('phone_number', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-9">
										{!! Form::submit('Update Details', array('class'=>'btn btn-warning btn-block', 'tabindex'=>'10')) !!}
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