@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | @parent
@stop

@section('css-section')
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/1.1.1/introjs.min.css"> -->
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>$user, 'active'=>4])
		</div>
        <br><br>
		<div class="col-md-10">
			<div class="text-center">
				<font style="font-family: SourceSansPro-Regular; font-size:22px;color:#282a73;">Contact us via <a href="tel:+61 3 9811 7015"> +61 3 9811 7015 </a> or <a href="mailto:info@vestabyte.com"> info@vestabyte.com </a> to schedule a meeting.</font>
			</div>
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