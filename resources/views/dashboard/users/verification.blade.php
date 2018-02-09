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
			@if($user->idImage)
			<div class="row">
				<div class="col-md-6">
					<img src="{{asset($user->idImage->get()->last()->path)}}" alt="photo" class="thumbnail">
				</div>
				<div class="col-md-6">
					<img src="{{asset($user->idImage->get()->last()->path_for_id)}}" alt="photo" class="thumbnail">
				</div>
			</div>
			<br>
			@if($user->verify_id == '2')
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
					{!! Form::open(array('route'=>['dashboard.users.verify', $user], 'class'=>'form-horizontal', 'role'=>'form')) !!}
					<div class="row">
						<div class="col-md-6">
							<textarea class="form-control" name="fixing_message" placeholder="Write comment which user needs to fix"></textarea>
						</div>
						<div class="col-md-6">
							<textarea class="form-control" name="fixing_message_for_id" placeholder="Write comment which user needs to fix"></textarea>
						</div>
					</div>
					<br>
					<div class="row text-center">
						<div class="col-md-12">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-primary">
									<input type="radio" name="status" id="good" autocomplete="off" value="2" tabindex="1"> Good
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
