<!-- @extends('layouts.main') -->
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
						{!! Form::model($user, array('route'=>['users.fbupdate', $user], 'method'=>'PATCH', 'class'=>'form-horizontal', 'role'=>'form')) !!}
						<fieldset>
							<h2 class="text-center">Update your profile details</h2>
							<br>
							<div class="row">
								<div class="form-group <?php if($errors->first('first_name') && $errors->first('last_name')){echo 'has-error';}?>">
									{!!Form::label('first_name', 'Name', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-6 <?php if($errors->first('first_name')){echo 'has-error';}?>">
												{!! Form::text('first_name', null, array('placeholder'=>'First Name', 'class'=>'form-control ', 'tabindex'=>'1','required'=>'required')) !!}
												{!! $errors->first('first_name', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 <?php if($errors->first('last_name')){echo 'has-error';}?>">
												{!! Form::text('last_name', null, array('placeholder'=>'Last Name', 'class'=>'form-control', 'tabindex'=>'2','required'=>'required')) !!}
												{!! $errors->first('last_name', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group <?php if($errors->first('phone_number')){echo 'has-error';}?>">
									{!!Form::label('phone_number', 'Mobile', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::input('tel', 'phone_number', null, array('placeholder'=>'7276160000', 'class'=>'form-control', 'tabindex'=>'9','required'=>'required')) !!}
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