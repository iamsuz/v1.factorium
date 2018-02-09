@extends('layouts.main')
@section('title-section')
Edit Role | @parent
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
						{!! Form::model($role, array('route'=>['roles.update',$role->id], 'class'=>'form-horizontal', 'role'=>'form', 'method'=>'PATCH')) !!}
						<fieldset>
							<legend class="text-center">Create New Role</legend>
							<div class="row">
								<div class="form-group <?php if($errors->first('role')){echo 'has-error';}?>">
									{!!Form::label('role', 'Role', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::text('role', null, array('placeholder'=>'First Name', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
										{!! $errors->first('role', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group <?php if($errors->first('description')){echo 'has-error';}?>">
									{!!Form::label('description', 'Description', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::textarea('description', null, array('placeholder'=>'Description', 'class'=>'form-control', 'tabindex'=>'2', 'rows'=>'3')) !!}
										{!! $errors->first('description', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-9">
										{!! Form::submit('Register New Role', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'3')) !!}
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