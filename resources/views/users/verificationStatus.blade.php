@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | @parent
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>$user, 'active'=>3])
		</div>
		<div class="col-md-10">
			<div class="row" id="section-1">
				<div class="col-md-12">
					<div style="padding:1em 0;">
						<br><br>
						<br><br>
						<h2 class="text-center wow fadeIn animated">Thank you <br>
							<small>We will perform a verification and notify you shortly.</small>
						</h2>
						<br><br>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop