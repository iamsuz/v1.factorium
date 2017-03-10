@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | @parent
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/1.1.1/introjs.min.css">
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>$user, 'active'=>3])
		</div>
		@if($user->registration_site == "https://estatebaron.com")
		<br><br>
			<h2 class="text-center">Please Verify your Account from Estatebaron Account</h2>
			<br><br>
			<p class="text-center"><a href="{{$user->registration_site}}/users/{{$user->id}}/verification" class="text-center" target="_blank">Verify here please</a></p>
			@else
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			@if ($errors->has())
			<br>
			<div class="alert alert-danger">
				@foreach ($errors->all() as $error)
				{{ $error }}<br>
				@endforeach
			</div>
			<br>
			@endif
			@if($user->verify_id == 0 || $user->verify_id == -1)
			<div id="top-message" class="text-center">
				<font style="font-family: SourceSansPro-Bold; font-size:22px;color:#282a73;">Please take a picture of yourself using your webcam.</font><br>
				<font style="font-family: SourceSansPro-Regular; font-size:16px;color:#282a73;">This photo will be used as your profile image and for verification purposes.</font>
			</div> 
			<br>
			<div class="row" id="web-camera-row">
				<div class="col-md-offset-3 col-md-6">
					<div id="web_camera" style="width:457px; height:341px;"></div>
				</div>
				<div  class="col-md-3 hide">
					<font style="font-family: SourceSansPro-Regular; font-size:18px;color:#282a73;" id="snap-button-with-id1">
						Please take a picture of your drivers license or passport with image and name details clearly visible in the camera screen above <br> <img src='/assets/images/drivers_license.jpg' style='height:15em;'>
					</font>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-offset-3 col-md-6 text-right">
					<a href="javascript:void(take_snapshot())" id="snap-button" class="btn btn-primary" style="width:100%; white-space: normal;font-size:100%"role="button" data-toggle="popover" data-placement="bottom" data-container="body" data-trigger="hover" data-content="Please click this button when you are ready to take your picture">Take a snap 
					<div style="float:left;">
							<i class="fa fa-camera pull-left" style="line-height:1.5"></i>
							<span style="border-right: 1px solid #ffffff; padding: 20px 4px 24px;"></span>
						</div>
					</a>
				</div>
				{{-- <div class="hide"> --}}
				<div class="col-md-offset-3 col-md-6 hide">
					<a href="javascript:void(take_snapshot_with_id())" id="snap-button-with-id" data-html="true" class="btn btn-danger btn-block" style="width:100%; white-space: normal;font-size:100%" role="button" data-toggle="popover" data-placement="right" data-container="body" data-trigger="hover" data-content="">Take a snapshot with your ID <div style="float:left;">
							<i class="fa fa-camera pull-left" style="line-height:1.5"></i>
							<span style="border-right: 1px solid #ffffff; padding: 20px 4px 24px;"></span>
						</div></a>
				</div>
				{{-- </div> --}}
			</div>
			<br>
			<div class="row">
				<div id="my_result" class="col-md-6"></div>
				<div id="my_result_with_id" class="col-md-6"></div>
			</div>
			{!! Form::open(array('route'=>['users.verification.upload', $user], 'class'=>'form-horizontal', 'role'=>'form', 'files'=>true, 'id'=>'verification-form'))!!}
			<input id="photo" name="photo" type="hidden" value="">
			<input id="photo_with_id" name="photo_with_id" type="hidden" value="">
			<div class="row hide" id="submit-button-row">
				<div class="col-md-offset-4 col-md-3">
					<input type="submit" class="btn btn-success btn-block" value="submit">
				</div>
			</div>
			{!! Form::close()!!}</div>
			@elseif($user->verify_id == 1)
			<div class="row" id="section-1">
				<div class="col-md-12">
					<div style="padding:1em 0;">
						<h2 class="text-center wow fadeIn animated">Already Submitted.<br>
							<small>Thanks for this, you are all set. We will do our verifications and notify you shortly.</small>
						</h2>
						<br><br>
						<h4 class="text-center wow fadeIn animated">If you are ready to see the projects <a href="/#projects">click here</a><br>
							<small>Clicking here will take you to the main page, project listings.</small>
						</h4>
						<br><br>
						<h4 class="text-center wow fadeIn animated">Or if you want to invite some of your friends, <a href="{{route('users.invitation', $user)}}">click here</a><br>
							<small>For each of your friends who join on your recommendation we will give you an additional $50 bonus to you as well as your friend.</small>
						</h4>
						<br><br>
					</div>
				</div>
			</div>
			@endif
			@endif
		</div>
	</div>
	<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					We are submitting your data, please wait.<label class="pull-right"><img id="loader" src="http://dev.cloudcell.co.uk/bin/loading.gif"/></label>
				</div>
			</div>
		</div>
	</div>
	@stop

	@section('js-section')
	@if($user->registration_site == "https://estatebaron.com")
	@else
	@if($user->verify_id == 0 || $user->verify_id == -1)
	<script type="text/javascript" src="{{asset('js/webcam.min.js')}}"></script>
	<script type="text/javascript">
		function happy () {
			$(document).ready(function(){
				$('#snap-button').addClass('hide');
				$('#happy-button').addClass('hide');
				$('#another-snap').addClass('hide');
				$('#message-note').addClass('hide');
				$('#snap-button-with-id').parent().removeClass('hide');
				$('#snap-button-with-id1').parent().removeClass('hide');
				$('#top-message').html( "<font style='font-family: SourceSansPro-Bold; font-size:22px;color:#282a73;'>Please take a picture of your ID. </font><br> <font style='font-family: SourceSansPro-Regular; font-size:16px;color:#282a73;'>Please hold your drivers license in front of the webcam so that the details in it are clearly visible.</font>" );
			});
		}

		$(document).ready(function() {
			$('#snap-button').click(function() {
				$(this).parent().hide();
			});
			$('#snap-button-with-id').click(function() {
				$(this).parent().hide();
			});
		});
		function happy_id () {
			$(document).ready(function(){
				$('#snap-button-with-id').addClass('hide');
				$('#another-snap-id').addClass('hide');
				$('#happy-button-with-id').addClass('hide');
				$('#message-note-id').addClass('hide');
				$('#web-camera-row').addClass('hide');
				// $('#submit-button-row').removeClass('hide');
				$('#top-message').remove();
				
				$('#loadingModal').modal('show');
				$( "#verification-form" ).submit();
				Webcam.reset();
			});
		}

		Webcam.attach('#web_camera');

		function take_snapshot() {
			Webcam.snap( function(data_uri) {
				document.getElementById('my_result').innerHTML = '<a href="javascript:void(take_snapshot())" style="white-space: normal;" class="btn btn-primary" id="another-snap" role="button">&nbsp&nbspTake another snap<div style="float:left;"><i class="fa fa-camera pull-left" style="line-height:1.5"></i><span style="border-right: 1px solid #ffffff; padding: 20px 4px 24px;"></span></div></a> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(happy())" id="happy-button" class="btn btn-success">I am happy with it</a><h3 id="message-note"><small>NOTE: If you are NOT happy with this image, take another shot.<small></h3><img src="'+data_uri+'" class="thumbnail"><div class="caption text-center"><h3>Photo</h3></div>';
				var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
				document.getElementById('photo').value = raw_image_data;
			} );
		}
		function take_snapshot_with_id() {
			Webcam.snap( function(data_uri) {
				document.getElementById('my_result_with_id').innerHTML = '<a href="javascript:void(take_snapshot_with_id())" class="btn btn-primary" id="another-snap-id" style="white-space: normal;" role="button">&nbsp&nbspTake another snap with ID <div style="float:left;"><i class="fa fa-camera pull-left" style="line-height:1.5"></i><span style="border-right: 1px solid #ffffff; padding: 20px 4px 24px;"></span></div></a> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(happy_id())" id="happy-button-with-id"  class="btn btn-success">I am happy with it</a><h3 id="message-note-id"></h3><img src="'+data_uri+'" class="thumbnail"><div class="caption text-center"><h3>Photo With ID</h3></div>';
				var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
				document.getElementById('photo_with_id').value = raw_image_data;
			} );
		}
	</script>
	@endif
	@endif
	@stop