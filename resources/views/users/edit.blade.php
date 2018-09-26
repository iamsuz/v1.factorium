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
							<h3 class="text-center" style="font-size: 1.7em;">Edit your profile details</h3>
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
										{!! Form::input('date', 'date_of_birth', $dob_string , array('class'=>'form-control', 'tabindex'=>'8', 'max'=>'2099-01-01')) !!}
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
								<div class="form-group @if($errors->first('line_1') && $errors->first('line_2')){{'has-error'}} @endif ">
									{!!Form::label('line_1', 'Address:', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-6 @if($errors->first('line_1')){{'has-error'}} @endif">
												{!! Form::text('line_1', null, array('placeholder'=>'line 1', 'class'=>'form-control', 'tabindex'=>'3')) !!}
												{!! $errors->first('line_1', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 @if($errors->first('line_2')){{'has-error'}} @endif">
												{!! Form::text('line_2', null, array('placeholder'=>'line 2', 'class'=>'form-control', 'tabindex'=>'4')) !!}
												{!! $errors->first('line_2', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('city') && $errors->first('state')){{'has-error'}} @endif">
									<div class="col-sm-offset-2 col-sm-9">
										<div class="row">
											<div class="col-sm-6 @if($errors->first('city')){{'has-error'}} @endif">
												{!! Form::text('city', null, array('placeholder'=>'City', 'class'=>'form-control', 'tabindex'=>'5')) !!}
												{!! $errors->first('city', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 @if($errors->first('state')){{'has-error'}} @endif">
												{!! Form::text('state', null, array('placeholder'=>'state', 'class'=>'form-control', 'tabindex'=>'6')) !!}
												{!! $errors->first('state', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('postal_code') && $errors->first('country')){{'has-error'}} @endif">
									<div class="col-sm-offset-2 col-sm-9">
										<div class="row">
											<div class="col-sm-6 @if($errors->first('postal_code')){{'has-error'}} @endif">
												{!! Form::text('postal_code', null, array('placeholder'=>'postal code', 'class'=>'form-control', 'tabindex'=>'7')) !!}
												{!! $errors->first('postal_code', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 @if($errors->first('country')){{'has-error'}} @endif">
												<select name="country" class="form-control">
													@foreach(\App\Http\Utilities\Country::all() as $country => $code)
													<option @if($user->country == $country) value="{{$country}}" selected="selected" @else value="{{$country}}" @endif>{{$country}}</option>
													@endforeach
												</select>
												{!! $errors->first('country', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<h3 class="text-center" style="font-size: 1.6em;">Edit Nominated Bank Account Details</h3>
							<br>
							<div class="row">
								<div class="form-group <?php if($errors->first('account_name')){echo 'has-error';}?>">
									{!!Form::label('account_name', 'Account Name', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::text('account_name', null, array('placeholder'=>'Account name', 'class'=>'form-control', 'tabindex'=>'10')) !!}
										{!! $errors->first('account_name', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group <?php if($errors->first('account_name')){echo 'has-error';}?>">
									{!!Form::label('bsb', 'BSB', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::text('bsb', null, array('placeholder'=>'BSB', 'class'=>'form-control', 'tabindex'=>'11')) !!}
										{!! $errors->first('bsb', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group <?php if($errors->first('account_number')){echo 'has-error';}?>">
									{!!Form::label('account_number', 'Account Number', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::text('account_number', null, array('placeholder'=>'Account number', 'class'=>'form-control', 'tabindex'=>'12')) !!}
										{!! $errors->first('account_number', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group <?php if($errors->first('tfn')){echo 'has-error';}?>">
									{!!Form::label('tfn', 'TFN', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::text('tfn', null, array('placeholder'=>'tfn', 'class'=>'form-control', 'tabindex'=>'12')) !!}
										{!! $errors->first('tfn', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<br><br>
							<div class="row">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-9">
										{!! Form::submit('Update Details', array('class'=>'btn btn-warning btn-block', 'tabindex'=>'13')) !!}
									</div>
								</div>
							</div>
							<br>
						</fieldset>
						{!! Form::close() !!}
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
@stop