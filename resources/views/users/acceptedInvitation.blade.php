@extends('layouts.main')
@section('title-section')
Thank You | @parent
@stop

@section('css-section')
<style type="text/css">
	.navbar-default {
		border-color: #fff ;
	}
</style>
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
			<div class="row">
				<div class="col-md-12 center-block">
					<div class="text-center">
						<h1 class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.2s">Welcome to Vestabyte <br>
							<small class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-size:.5em">Please fill the following details to complete your registration.</small>
						</h1>
						<br>
					</div>
					<div class="row">
						<div class="col-md-12">
							{!! Form::open(array('route'=>'users.invitation.storeDetails', 'class'=>'form-horizontal', 'role'=>'form')) !!}
							<fieldset>
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
													{!! Form::hidden('token', $token) !!}

												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group">
										<div class="col-sm-offset-1 col-sm-10">
											<div class="row">
												<div class="col-sm-6 <?php if($errors->first('phone_number')){echo 'has-error';}?>">
													{!! Form::input('tel', 'phone_number', null, array('placeholder'=>'Phone Number', 'class'=>'form-control', 'tabindex'=>'3', 'data-toggle'=>'popover', 'data-trigger'=>'hover', 'data-placement'=>'bottom', 'required'=>'true')) !!}
													{!! $errors->first('phone_number', '<small class="text-danger">:message</small>') !!}
												</div>
												<div class="col-sm-6 <?php if($errors->first('password')){echo 'has-error';}?>">
													{!! Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('password', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-sm-offset-1 col-sm-10">
											{!! Form::submit('Create Account', array('class'=>'btn btn-warning btn-block', 'tabindex'=>'10')) !!}
										</div>
									</div>
								</div>
							</fieldset>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop