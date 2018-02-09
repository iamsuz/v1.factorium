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
			@include('partials.sidebar', ['user'=>$user, 'active'=>5])
		</div>
		<div class="col-md-10">
			<section id="developer" class="chunk-box grey">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10">
                            <h2 class="text-center wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-weight:100; line-height:1.3em;">Are you a project developer looking to raise finance or<br> a site owner looking for a buyer?</h2>
                            <br>
                            <div class="text-center wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.4s">
                                <a href="{{route('projects.create')}}" class="btn btn-default text-center" style="padding: 0.7em 2em;font-size:17px;">Submit Project</a>
                            </div>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </section>
		</div>
	</div>
</div>
@stop
@section('js-section')
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
        $('.partnerLogo').tooltip();
        $('[data-toggle="popover"]').popover();
        $('#scheduler_toggle').click(function() {
            $('#scheduler').toggle("slow");
        });
    });

    function LoadingScreen(isDisplay) {
        if (isDisplay) // show loading
        {
            $(".status").fadeIn();
            // will fade out the whole DIV that covers the website.
            $(".preloader").fadeIn("slow");
        } else // hide loading
        {
            $(".status").fadeOut();
            // will fade out the whole DIV that covers the website.
            $(".preloader").fadeOut("slow");
        }
    }
</script>
@stop