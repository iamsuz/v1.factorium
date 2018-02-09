@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | @parent
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>$user, 'active'=>8])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			{!! Form::open(array('route'=>['projects.invitation.store'], 'class'=>'form-horizontal', 'role'=>'form')) !!}
			<fieldset>
				<div class="text-center">
					<h2 class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.2s">Select Project and Invite Investors!<br>
						<small class="wow fadeIn animated text-justify" data-wow-duration="1.5s" data-wow-delay="0.3s">You can invite only 20 Investors. <br><br><small>to send multiple invitations separate emails with semicolon. <i>e.g. you@somewhere.com;you2@somewhere.com</i> </small></small>
					</h2>
					<br>
				</div>
				<div class="row">
					<div class="form-group @if($errors->first('country')){{'has-error'}} @endif">
						<div class="col-sm-offset-3 col-sm-6">
							<select name="project" class="form-control">
								@foreach($user->invite_only_projects as $project)
								<option value="{{$project->id}}">{{$project->title}}</option>
								@endforeach
							</select>
							{!! $errors->first('country', '<small class="text-danger">:message</small>') !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group <?php if($errors->first('email')){echo 'has-error';}?>">
						<div class="col-sm-offset-3 col-sm-6">
							{!! Form::text('email', null, array('placeholder'=>'Email (you@somwehere.com)', 'class'=>'form-control', 'tabindex'=>'3', 'data-toggle'=>'popover', 'data-trigger'=>'hover', 'data-placement'=>'bottom', 'data-content'=>'Enter email ids here', 'required'=>'true')) !!}
							{!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">
							{!! Form::submit('Invite User', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'6')) !!}
						</div>
					</div>
				</div>
			</fieldset>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@stop