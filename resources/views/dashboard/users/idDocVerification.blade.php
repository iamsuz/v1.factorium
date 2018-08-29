@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | Dashboard | @parent
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>2])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			@if($user->idDoc)
			<div class="row">
				<div class="col-md-6">
					<a href="{{asset($user->idDoc->path)}}" alt="Document" class="thumbnail" target="_blank">User Doc</a>
				</div>
				@if($user->idDoc->investing_as == 'Joint Investor')
				<div class="col-md-6">
					<a href="{{asset($user->idDoc->joint_id_path)}}" alt="Document" class="thumbnail" target="_blank">Other Doc</a>
				</div>
				@endif
			</div>
			<br>
			@if($user->idDoc->verify == '1')
			<div class="row">
				<div class="col-md-12">
					<br>
					<div class="row">
						<div class="col-md-offset-4 col-md-4">
							<p class="alert alert-success text-center">Already Verified</p>
						</div>
					</div>
				</div>
			</div>
			@else
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(array('route'=>['dashboard.users.idVerifying', $user], 'class'=>'form-horizontal', 'role'=>'form')) !!}
					<div class="row">
						<div class="col-md-6">
							<textarea class="form-control" name="fixing_message" placeholder="Write comment which user needs to fix"></textarea>
						</div>
						@if($user->idDoc->investing_as == 'Joint Investor')
						<div class="col-md-6">
							<textarea class="form-control" name="fixing_message_for_id" placeholder="Write comment which user needs to fix"></textarea>
						</div>
						@endif
					</div>
					<br>
					<div class="row text-center">
						<div class="col-md-12">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-primary">
									<input type="radio" name="status" id="good" autocomplete="off" value="1" tabindex="1"> Good
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="status" id="try_again" autocomplete="off" value="-1" tabindex="2"> Try Again
								</label>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-offset-5 col-md-2">
							<input type="submit" class="btn btn-info btn-block" value="Verify">
						</div>
					</div>
				</div>
				{!! Form::close() !!}
			</div>
			@endif
			@else
			no image
			@endif
		</div>
	</div>
</div>
</div>
@stop
