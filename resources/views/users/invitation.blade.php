@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | @parent
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>$user, 'active'=>6])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			{!! Form::open(array('route'=>['users.invitation.store', $user], 'class'=>'form-horizontal', 'role'=>'form')) !!}
			<fieldset>
				<div class="text-center">
					<font style="font-family: SourceSansPro-Bold; font-size:22px;color:#282a73;">Invite your friends</font><br>
						<font style="font-family: SourceSansPro-Regular; font-size:16px;color:#282a73;">To send multiple invitations separate emails with semicolon. <i>e.g. you@somewhere.com;you2@somewhere.com</i></font>
				</div>
					<br>
				<div class="row">
					<div class="form-group <?php if($errors->first('email')){echo 'has-error';}?>">
						<div class="col-sm-offset-3 col-sm-6">
							{!! Form::text('email', null, array('placeholder'=>'Email (you@somwehere.com)', 'class'=>'form-control', 'tabindex'=>'3', 'data-toggle'=>'popover', 'data-trigger'=>'hover', 'data-placement'=>'bottom', 'data-content'=>'Enter your friends email id here', 'required'=>'true')) !!}
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