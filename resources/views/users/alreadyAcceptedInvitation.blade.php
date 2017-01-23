@extends('layouts.main')
@section('title-section')
Already Accepted | @parent
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
					<div style="padding:10em 0;">
						<h1 class="wow fadeIn animated text-center" data-wow-duration="1.5s" data-wow-delay="0.2s">Already Accepted! <br>
							<small class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-size:.5em">You have already accepted the invitation, if you cant sign in please contact us at 1 300 033 221</small>
						</h1>
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop