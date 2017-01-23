@extends('layouts.main')

@section('title-section')
Subdivide | @parent
@stop

@section('css-section')
{!! Html::style('plugins/animate.css') !!}
@stop

@section('content-section')
<div class="container">
<div class="row">
	<div class="col-md-12">
		<div style="padding:10em 0;">
			<h1 class="text-center">Thank you <br>
			<small>We would be happy to meet you in person and answer any queries at our offices at 350 Collins st, Melbourne <br> click <em>here</em> to schedule a meeting with us or request a phone call.</small>
			</h1>
		</div>
	</div>
</div>
</div>
@stop

@section('js-section')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
{!! Html::script('plugins/wow.min.js') !!}
<script type="text/javascript">
	$(function () {
		$('.scrollto').click(function(e) {
			e.preventDefault();
			$(window).stop(true).scrollTo(this.hash, {duration:1000, interrupt:true});
		});
	});
	new WOW().init({
		boxClass:     'wow',
		animateClass: 'animated',
		mobile:       true,
		live:         true
	});
</script>
@stop
