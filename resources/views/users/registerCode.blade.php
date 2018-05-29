@extends('layouts.main')

@section('title-section')
Thank You | @parent
@stop

@section('css-section')
{!! Html::style('plugins/animate.css') !!}
@stop

@section('content-section')
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="row" id="section-1">
				<div class="col-md-12">
					<div style="padding:10em 0;">
						<h1 class="text-center wow fadeIn animated h1-faq">To Continue your Expression of Interest <br><small>Please confirm your email address by entering a code which is sent by an entered Email address.</small><br><br><br>
							<small>
								<form action="{{route('users.registration.code')}}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<input type="text" name="eoiCode" required="required" class="form-control" id="eoiCode">
									</div>
									<button type="submit" class="btn btn-primary">Confirm</button>
								</form>
							</small>
						</h1>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('js-section')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
{!! Html::script('plugins/wow.min.js') !!}
<script type="text/javascript">
	new WOW().init({
		boxClass:     'wow',
		animateClass: 'animated',
		mobile:       true,
		live:         true
	});
	$(function() {
    $('#eoiCode').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
})
</script>
@stop
