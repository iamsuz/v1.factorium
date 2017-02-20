@extends('layouts.main')
@section('title-section')
{{$project->title}} crowdfunding with just $2000
@stop

@section('meta-section')
<meta property="og:title" content="{{$project->title}} crowdfunding with just $2000" />
<meta property="og:description" content="Invest with small amounts in the construction of 2 townhouses in the prestigious mount waverley school zone. 20% returns in 18 months, Refer to PDS for details" />

<meta name="description" content="Invest with small amounts in the construction of 2 townhouses in the prestigious mount waverley school zone. 20% returns in 18 months, Refer to PDS for details">
<meta name="csrf-token" content="{{csrf_token()}}" />
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@parent
<style>
	#map {
		height: 350px;
	}
	.blur {
		color: transparent;
		text-shadow: 0 0 5px rgba(0,0,0,0.9);
		-webkit-filter: blur(5px);
		-moz-filter: blur(5px);
		-o-filter: blur(5px);
		-ms-filter: blur(5px);
		filter: blur(5px);
	}
	.btn-hover-default-color:hover{
		color: #fff !important;
	}
</style>
@stop
@section('content-section')
<script>
	function initMap() {
		var lat = {{$project->location->latitude}}
		var lng = {{$project->location->longitude}}
		var mycenter = new google.maps.LatLng(lat,lng);
		var map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: lat, lng: lng},
			zoom: 10,
			scrollwheel: false,
			navigationControl: false,
			mapTypeControl: false,
			scaleControl: false,
			draggable: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(lat, lng)
		});
		marker.setMap(map);
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfXbxHUxjmBw-pW7cRIW6AsUv0wLk1Za0&callback=initMap" async defer></script>
@if(Auth::guest())
@else
@if(App\Helpers\SiteConfigurationHelper::isSiteAdmin())
<form method="POST" action="{{route('configuration.updateProjectDetails')}}">
	{{csrf_field()}}
	<div class="col-md-6 col-md-offset-3" style="position: absolute;margin-top: 15px;text-align: center;">
		<button type="button" class="btn btn-primary btn-lg edit-project-page-details-btn">Edit Project Details</button>
		<button type="submit" class="btn btn-default btn-lg store-project-page-details-btn" style="display: none;">Update Project</button><br>
		<a href="" status="{{$project->active}}" style="color: #fff;"><u>
			@if($project->active == '1') 
			<a href="{{route('dashboard.projects.deactivate', [$project->id])}}">Deactivate</a> 
			@elseif($project->active == '2')
			Private
			@elseif($project->active == '0')
			<a href="{{route('dashboard.projects.activate', [$project->id])}}"> Activate </a>
			@endif
		</u></a>
	</div>
	@endif
	@endif
	<input type="hidden" name="current_project_id" id="current_project_id" value="{{$project->id}}">
	<section style="background: @if($project->media->where('type', 'projectpg_back_img')->last()) url({{asset($project->media->where('type', 'projectpg_back_img')->last()->path)}}) @else url({{asset('assets/images/bgimage_sample.png')}}) @endif;background-repeat: no-repeat; background-size:100% 100%;" class="project-back img-responsive" id="project-title-section">
		<div class="color-overlay">
			<div class="container">
				<div class="row" id="main-context" style="margin-top:10px; padding-top: 2em;">
					<div class="col-md-4 col-sm-6">
						<h2 class="text-left second_color project-title-name" style="font-size:2.625em; color:#fed405;">{{$project->title}}</h2>
						<p class="text-left project-description-field" style="color:#fff; font-size:0.875em;">{{$project->description}}</p>
						<br>
					</div>
					<div class="col-md-4 col-md-offset-4 col-sm-6 days-left-circle">
						<div id="circle">
							<div class="text-center" style="color:#fff;">
								<div class="circle" data-size="140" data-thickness="15" data-reverse="true">
									<div class="text-center"  style="color:#fff; position:relative; bottom:100px;">
										<p style="color: #fff; font-size: 1.6em; margin: 0 0 -5px;">
											<span id="daysremained"></span>
											<br>
											<p style="font-size: 1.1em; margin: 0 0 -3px;" class="h1-faq">Days Left</p>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><br>
				<div class="row">
					<div class="col-md-4">
						<div class="" style="color:#fff;">
							@if($project->investment)
							<div class="row text-left">
								<div class="col-md-3 col-sm-3 col-xs-3" style="border-right: thin solid #ffffff; height:70px;">
									<h4 class="font-bold project-min-investment-field" style="font-size:1.375em;color:#fff;">${{(int)$project->investment->minimum_accepted_amount}}</h4><h6 class="font-regular" style="font-size: 0.875em;color: #fff">Min Invest</h6>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-3" style="border-right: thin solid #ffffff; height:70px;">
									<h4 class="font-bold project-hold-period-field" style="font-size:1.375em;color:#fff;">{{$project->investment->hold_period}}</h4><h6 class="font-regular" style="font-size: 0.875em; color: #fff;">Months</h6>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-3" style="border-right: thin solid #ffffff; height:70px;">
									<h4 class="font-bold project-returns-field" style="font-size:1.375em;color:#fff;">{{$project->investment->projected_returns}}%</h4><h6 class="font-regular" style="font-size: 0.875em;color: #fff">Return</h6>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-3">
									<h4 class="text-left font-bold" style="font-size:1.375em;color:#fff; ">
										@if($project->investment) {{$number_of_investors}} @else ### @endif
									</h4>
									<h6 class="font-regular" style="font-size: 0.875em;color: #fff">Investors</h6>
								</div>
							</div>
							@endif
						</div>
						<div class="progress" style="height:10px; border-radius:0px;background-color:#cccccc; margin: 10px 0 20px;">
							<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{$completed_percent}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$completed_percent}}%">
							</div>
						</div>
						<p class="font-regular" style="font-size:1em;color:#fff; margin-top:-10px;">
							@if($project->investment)
							${{number_format($pledged_amount)}} raised of $<span class="project-goal-amount-field">{{number_format($project->investment->goal_amount)}}</span>
							@endif
						</p>
					</div>
					<div class="col-md-4 col-md-offset-4" style="margin-top:0%;" id="express_interest">
						<br>
						@if($project->investment)
						<a href="{{route('projects.interest', $project)}}" style="font-size:1.375em;letter-spacing:2px;" class="btn btn-block btn-n1 btn-lg pulse-button text-center second_color_btn @if(!$project->show_invest_now_button) disabled @endif btn-hover-default-color" @if(Auth::user() && Auth::user()->investments->contains($project))  @endif><b>
							@if($project->button_label)
							<?php echo $project->button_label; ?>
							@else
							Invest Now
							@endif
						</b></a>
						<h6><small style="font-size:0.85em; color:#fff;">* Note that this is a No Obligation Expression of interest, you get to review the document before making any decisions</small></h6>
						@else
						<a href="{{route('projects.interest', [$project])}}" class="btn btn-block btn-primary" disabled>NO Investment Policy Yet</a>
						@endif
					</div>
				</div>
			</div>
			@if(Auth::guest())
			@else
			@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
			<div class="col-md-12">
				<div class="edit-img-button-style edit-projectpg-back-img"><a><i class="fa fa fa-edit fa-lg" style="vertical-align: -webkit-baseline-middle;color: #fff;"></i></a></div>
				<span style="margin: 5px 5px 5px 22px; float: left; background: rgba(0, 0, 0, 0.3); padding: 2px 10px 2px 20px; border-radius: 20px; color: #fff;"><small>Edit Background</small></span>
				<input class="hide" type="file" name="projectpg_back_img" id="projectpg_back_img">
				<input type="hidden" name="projectpg_back_img_name" id="projectpg_back_img_name">
			</div>
			@endif
			@endif
		</div>
	</section>
	<h6 style="color: #707070;">** The information provided on this webpage is only a summary of the offer and may not contain all the information needed to determine if this offer is right for you. You should read the Prospectus in its entirety which can be downloaded in the Downloads section below as well as on the Project application page once you press the Invest Now or Express Interest button.</h6>
<!-- <section class="chunk-box" style="overflow:hidden;">
	<div class="container-fluid">
		<div class="row">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<div class="col-md-offset-1 col-md-5">
				<h2>@if($project->investment) ${{ number_format($project->investment->goal_amount) }} <small>Total Required</small>@else ######@endif </h2>
			</div>
			<div class="col-md-5 text-center" style="padding-top:1.5em">
				@if($project->investment)
				<a href="{{route('projects.interest', $project)}}" class="btn btn-block btn-primary pulse-button" @if($completed_percent == 100) disabled data-disabled @endif @if(Auth::user() && Auth::user()->investments->contains($project))  @endif">
					@if(Auth::user() && Auth::user()->investments->contains($project))
					Already expressed interest, View Offer Docs again
					@else
					<span style="font-size: 15px;">I &nbspAM &nbspINTERESTED</span>
					@endif
				</a>
				<h4><small>* Note that this is a No Obligation Expression of interest, you get to review the document before making any decisions</small></h4>
				@else
				<a href="{{route('projects.interest', [$project])}}" class="btn btn-block btn-primary" disabled>NO Investment Policy Yet</a>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-5">
				<h2>@if($project->investment)${{ number_format($pledged_amount) }} <small>Pledged</small>@else #####@endif</h2>
			</div>
			<div class="col-md-5" style="padding-top:1.6em">
				<div class="progress" style="height:2em;background-color:#ccc;">
					<div class="progress-bar progress-bar-info  progress-bar-striped" role="progressbar" aria-valuenow="{{$completed_percent}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$completed_percent}}%;font-size: 1.1em;line-height: 1.8em;">
						{{round(($completed_percent), 2)}}%
					</div>
				</div>
				<h4 class="text-center">
					<small>@if($project->investment) @if($project->id == 2) 54 @elseif($project->id == 3) 27 @else {{$number_of_investors}} @endif @else ### @endif Investors Interested</small>
				</h4>
			</div>
		</div>
	</div>
</section> -->
<br>
<ul class="nav nav-tabs text-center">
	<li class="active" style="width: 50%; font-size: 1.5em;">
		<a data-toggle="tab" href="#home" style="padding: 15px 15px;">Project Details</a></li>
		<li style="width: 49%; font-size: 1.5em;"><a data-toggle="tab" href="#menu1" style="padding: 15px 15px;">Project Progress</a></li>
	</ul>
	<div class="tab-content">
		<div id="home" class="tab-pane fade in active">
			<section class="chunk-box ">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2 class="text-center first_color" style="font-size:2.625em;color:#282a73;">Project Summary</h2>
							<br>
							<div class="row">
								<div class="col-md-2 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="summary_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									<input class="hide" type="file" name="projectpg_thumbnail_image" id="projectpg_thumbnail_image">
									<input type="hidden" name="projectpg_thumbnail_image_name" id="projectpg_thumbnail_image_name">
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'summary_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/summary.png')}}@endif" alt="for whom" style="width:50px;" >
									<h4 class="second_color" style="margin-top:30px; color:#fed405; font-size:1.375em;">Summary</h4>
								</div>
								<div class="col-md-10 text-left"> 
									@if($project->investment) <p style="font-size:0.875em;" class="project-summary-field">{!!$project->investment->summary!!}</p> @endif
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-2 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="security_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'security_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/securityp.png')}}@endif" alt="security_long" style="width:50px;">
									<h4 class="second_color" style="margin-bottom:0px; color:#fed405;font-size:1.375em;">Security</h4>
								</div>
								<div class="col-md-10 text-left"> 
									@if($project->investment) <p style="margin-top:0px;font-size:0.875em;" class="project-security-long-field">{!!$project->investment->security_long!!}</p> @endif
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-2 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="investor_distribution_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'investor_distribution_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/investor_distribution.png')}}@endif" alt="exit" style="width: 50px; ">
									<h4 class="second_color" style="margin-top:30px; color:#fed405;font-size:1.375em;">Investor<br> Distribution</h4>
								</div>
								<div class="col-md-10 text-left"> 
									@if($project->investment) <p style="font-size:0.875em;" class="project-investor-distribution-field">{!!$project->investment->exit_d!!}</p> @endif
									<center>
										@if($project->media->where('type','exit_image')->last())
										<img src="{{asset($project->media->where('type', 'exit_image')->last()->path)}}" style="max-width:100%" alt="Exit">
										@endif
									</center>
								</div>
							</div>
							<br>
						</div>
					</div>
				</div>
			</section>
			@if($project->property_type == "1")
			<section class="chunk-box">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2 class="text-center first_color" style="font-size:2.625em;color:#282a73;">Suburb Profile</h2>
							<br><br><br>
							<div class="row">
								<div class="col-md-12">
									<div id="map" data-role="page" ></div>
									<address class="text-center"><p style="font-size:15px;">{{$project->location->line_1}}, <!-- {{$project->location->line_2}}, --> {{$project->location->city}}, {{$project->location->postal_code}}, {{$project->location->country}}</p></address>
								</div>
							</div>
							<br><br>
							<div class="row">
								<div class="col-md-2 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="marketability_image"><a data-toggle="tooltip" title="Edit Marketability Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'marketability_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/marketability.png')}}@endif" alt="for whom" style="width:50px; ">
									<br><br>
									<h4 class="second_color" style="margin-top:0px; color:#fed405;font-size:1.375em;">Marketability</h4>
								</div>
								<div class="col-md-10"> 
									@if($project->investment) <p class="text-left project-marketability-field" style="font-size:0.875em;">{!!$project->investment->marketability!!}</p> @endif
								</div>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-2">
									<center>
										@if($project->media->where('type','marketability')->last())
										<img src="{{asset($project->media->where('type', 'marketability')->last()->path)}}" style="width:100%" alt="Marketability">
										@endif
									</center>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-2 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="residents_image"><a data-toggle="tooltip" title="Edit Residents Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'residents_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/residents.png')}}@endif" alt="residents" style="width:50px; ">
									<br><br>
									<h4 class="second_color" style="margin-top:0px; color:#fed405;font-size:1.375em;">Residents</h4>
								</div>
								<div class="col-md-10"> 
									@if($project->investment) <p class="text-left project-residents-field" style="font-size:0.875em;">{!!$project->investment->residents!!}</p> @endif
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
								</div>
								<div class="col-md-10">
									<center>
										@if($project->media->where('type','residents')->last())
										<img src="{{asset($project->media->where('type', 'residents')->last()->path)}}" width="100%" alt="Image">
										@endif
									</center>
								</div> 
							</div>
						</div>
					</div>
				</div>
			</section>
			@endif
			<section class="chunk-box">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2 class="text-center first_color" style="font-size:2.625em;color:#282a73;">Investment Profile</h2>
							<br>
							<div class="row">
								<div class=" col-md-2 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="investment_type_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'investment_type_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/type.png')}}@endif" alt="type" style="width:50px;"> <br><br>
									<h4 class="second_color" style="margin-top:0px; color:#fed405;font-size:1.375em;">Type</h4><br>
								</div>
								<div class="col-md-10"> 
									@if($project->investment) <p class="project-investment-type-field" style="font-size:0.875em;">{{$project->investment->investment_type}}</p>@endif
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="security_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'security_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/securityp.png')}}@endif" alt="security" style="width:50px;"><br><br>
									<h4 class="second_color" style="margin-top:0px; color:#fed405;font-size:1.375em;">Security</h4><br>
								</div>
								<div class="col-md-10"> 
									@if($project->investment) <p class=" project-security-field" style="font-size:0.875em;">{{$project->investment->security}}</p> @endif
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 text-center" >
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="expected_returns_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'expected_returns_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/expected_returns.png')}}@endif" alt="expected returns" style="width:50px;"><br><br>
									<h4 class="second_color" style="margin-top:0px; color:#fed405;font-size:1.375em;">Expected<br> Returns</h4>
								</div>
								<div class="col-md-10"> 
									@if($project->investment) <p class=" project-expected-returns-field" style="font-size:0.875em;">{{$project->investment->expected_returns_long}}</p> @endif
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 text-center" >
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="returns_paid_as_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'returns_paid_as_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/returns_paid_as.png')}}@endif" alt="returns paid as" style="width:50px;"><br><br>
									<h4 class="second_color" style="margin-top:0px; color:#fed405;font-size:1.375em;">Returns<br> Paid As</h4>
								</div>
								<div class="col-md-10"> 
									@if($project->investment) <p class=" project-return-paid-as-field" style="font-size:0.875em;">{{$project->investment->returns_paid_as}}</p> @endif
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 text-center" >
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="taxation_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'taxation_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/taxation.png')}}@endif" alt="Taxation" style="width:50px;"><br><br>
									<h4 class="second_color" style="margin-top:0px; color:#fed405;font-size:1.375em;">Taxation</h4><br>
									</div>
									<div class="col-md-10"> 
									@if($project->investment) <p class=" project-taxation-field" style="font-size:0.875em;">{{$project->investment->taxation}}</p> @endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="chunk-box ">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2 class="text-center first_color" style="font-size:2.625em;color:#282a73;">Project Profile</h2>
							<br>
							<div class="row">
								<div class="col-md-4 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="developer_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'developer_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/developer.png')}}@endif" alt="proposer" style="width:50px;"> <br>
									@if($project->property_type == "1")
									<h4 class="second_color" style="margin-bottom:0px; color:#fed405;font-size:1.375em;">Developer</h4><br>
									@else
									<h4 class="second_color" style="margin-bottom:0px; color:#fed405;font-size:1.375em;">Venture</h4><br>
									@endif
									@if($project->investment) <p style="font-size:0.875em;" class="project-developer-field">{!!$project->investment->proposer!!}</p> @endif
									<div class="row">
										<div class="col-md-12 text-center">
											<center>
												@if($project->media->where('type','project_developer')->last())
												<img src="{{asset($project->media->where('type', 'project_developer')->last()->path)}}" width="30%" alt="Developer" style="padding:1em;" style="width:40px;">
												@endif
											</center>
										</div>	
									</div>
								</div>
								<div class="col-md-4 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="duration_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'duration_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/duration.png')}}@endif" alt="duration" style="width:50px;">
									<h4 class="second_color" style="margin-bottom:0px; color:#fed405;font-size:1.375em;">Duration</h4><br>
									@if($project->investment) <p style="font-size:0.875em;">{!!$project->investment->hold_period!!} Months</p> @endif
								</div>
								<div class="col-md-4 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="current_status_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'current_status_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/current_status.png')}}@endif" alt="current_status" style="width:50px;">
									<h4 class="second_color" style="margin-bottom:0px; color:#fed405;font-size:1.375em;">Current Status</h4><br>
									@if($project->investment) <p style="font-size:0.875em;" class="project-current-status-field">{!!$project->investment->current_status!!}</p> @endif
								</div>
							</div>
							<br><br><br>
							<div class="row">
								<div class="col-md-2 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="rationale_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'rationale_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/rationale.png')}}@endif" alt="rationale" style="width:50px;">
									<h4 class="second_color" style="margin-top:30px; color:#fed405;font-size:1.375em;">Rationale</h4><br>
								</div>
								<div class="col-md-10 text-left"> 
									@if($project->investment) <p style="font-size:0.875em;" class="project-rationale-field">{!!$project->investment->rationale!!}</p> @endif
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 text-center">
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
									<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="investment_risk_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
									@endif
									@endif
									<img src="@if($projMedia=$project->media->where('type', 'investment_risk_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/risk.png')}}@endif" alt="risk" style="width:50px;">
									<h4 class="second_color" style="margin-top:30px; color:#fed405;font-size:1.375em;">Risk</h4><br>
								</div>
								<div class="col-md-10 text-left"> 
									@if($project->investment) <p style="font-size:0.875em;" class="project-risk-field">{!!$project->investment->risk!!}</p> @endif
								</div>
							</div>
							<br><br>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section>
			<div class="container">
				<div class="row" style="background-color:#E6E6E6;">
					<div class="col-md-12">
						<h2 class="download-text first_color">Downloads</h2>
						<div class="row">
							<div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30" style="position: initial;">
								<span style="font-size:1em;" class="project-pds1-link-field">
								<a @if(Auth::check()) href="@if($project->investment){{$project->investment->PDS_part_1_link}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Part 1 PDS" style="text-decoration:underline;" class="download-links">Prospectus</a>
								</span>
							</div>
							<!-- <div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30" style="position: initial;">
								<span style="font-size:1em;" class="project-pds2-link-field">
								<a @if(Auth::check()) href="@if($project->investment){{$project->investment->PDS_part_2_link}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Part 2 PDS" style="text-decoration:underline;" class="download-links">Part 2 PDS</a></span>
							</div> -->
							<!-- <div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30">
								<p style="font-size:0.875em; margin-left:50px;"><a @if(Auth::check()) href="@if($project->investment){{$project->investment->PDS_part_1_link}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Part 1 PDS" style="text-decoration:underline;" class="download-links">Part 1 PDS</a></p>
							</div> -->
							<!-- <div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30">
								<p style="font-size:0.875em; margin-left:50px;"><a @if(Auth::check()) href="@if($project->investment){{$project->investment->PDS_part_2_link}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Part 1 PDS" style="text-decoration:underline;" class="download-links">Part 2 PDS</a></p>
							</div>
							<div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30">
								<p style="font-size:0.875em; margin-left:50px;"><a @if(Auth::check()) href="@if($project->investment){{$project->investment->construction_contract_url}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Master PDS" style="text-decoration:underline;" class="download-links">Construction Contract</a></p>
							</div>
							<div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30">
								<p style="font-size:0.875em; margin-left:50px;"><a @if(Auth::check()) href="@if($project->investment){{$project->investment->debt_details_url}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Master PDS" style="text-decoration:underline;" class="download-links">Debt Details</a></p>
							</div> -->
						</div>
						{{-- <div class="row">
							<div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30">
								<p style="font-size:0.875em; margin-left:50px;"><a @if(Auth::check()) href="@if($project->investment){{$project->investment->consultancy_agency_agreement_url}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Master PDS" style="text-decoration:underline;" class="download-links">Consultancy and Agency Agreement</a></p>
							</div>
							<div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30">
								<p style="font-size:0.875em; margin-left:50px;"><a @if(Auth::check()) href="@if($project->investment){{$project->investment->caveats_url}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Master PDS" style="text-decoration:underline;" class="download-links">Caveats</a></p>
							</div>
							<div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30">
								<p style="font-size:0.875em; margin-left:50px;"><a @if(Auth::check()) href="@if($project->investment){{$project->investment->land_ownership_url}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Master PDS" style="text-decoration:underline;" class="download-links">Land ownership documents</a></p>
							</div>
							<div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30">
								<p style="font-size:0.875em; margin-left:50px;"><a @if(Auth::check()) href="@if($project->investment){{$project->investment->valuation_report_url}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Master PDS" style="text-decoration:underline;" class="download-links">Valuation report</a></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30">
								<p style="font-size:0.875em; margin-left:50px;"><a @if(Auth::check()) href="@if($project->investment){{$project->investment->consent_url}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Master PDS" style="text-decoration:underline;" class="download-links">Consents</a></p>
							</div>
							<div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30">
								<p style="font-size:0.875em; margin-left:50px;"><a @if(Auth::check()) href="@if($project->investment){{$project->investment->spv_url}}@else#@endif" target="_blank" @else href="#" data-toggle="tooltip" title="Sign In to Access Document" @endif alt="Master PDS" style="text-decoration:underline;" class="download-links">SPV documents</a></p>
							</div>
						</div> --}}
						<br><br>
					</div>
				</div>
			</div>
		</section>
		<br><br>
		<section>
			<div class="container">
				<div class="row">
					<br>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12 text-center">
								@if(Auth::guest())
								@else
								@if(App\Helpers\SiteConfigurationHelper::isSiteSuperadmin())
								<div class="edit-img-button-style edit-projectpg-thumbnails" style="z-index: 10; position: absolute;" action="how_to_invest_image"><a data-toggle="tooltip" title="Edit Thumbnail"><i class="fa fa fa-edit fa-lg" style="color: #fff; vertical-align: -webkit-baseline-middle;"></i></a></div>
								@endif
								@endif
								<img src="@if($projMedia=$project->media->where('type', 'how_to_invest_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/how_to_invest.png')}}@endif" alt="exit" width="110px" /><br><br>
								<h4 class="second_color" style="margin-bottom:0px; color:#fed405;font-size:42px;">How To Invest</h4><br>
								@if($project->investment)<p class="project-how-to-invest-field">{!!$project->investment->how_to_invest!!}</p> @endif
							</div>
						</div>
							<!-- <ol>
							<li style="font-size:0.875em;"><a href="#" class="scrollto ">Read PDS/Offer document carefully</a></li>
							<li style="font-size:0.875em;">Press “Invest Now” at the top of the screen</li>
							<li style="font-size:0.875em;">Complete and Sign online application form</li>
							<li style="font-size:0.875em;">Complete any AML/CTF obligations (Verification)</li>
							<li style="font-size:0.875em;">Make a Bank transfer to</li>
						</ol> -->
						@if($project->investment)
						@if($project->investment->bank)
						<div class="row">
							<div class="col-md-10 col-md-offset-1 text-justify">
								<h5>
									<table class="table table-responsive font-bold" style="color:#2d2d4b;">
										<tr><td>Bank</td><td>{!!$project->investment->bank!!}</td></tr>
										<tr><td>Account Name</td><td>{!!$project->investment->bank_account_name!!}</td></tr>
										<tr><td>BSB </td><td>{!!$project->investment->bsb!!}</td></tr>
										<tr><td>Account No</td><td>{!!$project->investment->bank_account_number!!}</td></tr>
										<tr><td>Reference</td><td>{!!$project->investment->bank_reference!!}</td></tr>
									</table>
								</h5>
							</div>
						</div>
						@endif
						@endif
					</div>
					<div class="col-md-6">
						<h2 class="text-left second_color" style="font-size:42px;color:#282a73;padding-top:125px;">Project FAQs</h2>
						<br>
						<div class="panel-group" id="accordion">
							@foreach($project->projectFAQs as $key => $faq)
							<div class="panel panel-info">
								<div class="panel-heading collapse-header" data-toggle="collapse" data-target="#faq_{{$key}}">
									<i class="indicator glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
									<h4 class="panel-title font-bold first_color" style="padding-left:30px; font-size:16px;color:#282a73;">
										{{$faq->question}}
									</h4>
								</div>
								<div id="faq_{{$key}}" class="panel-collapse collapse">
									<div class="panel-body" style="padding-left:45px;">
										<p style="font-size:16px;color:#282a73;" class="font-regular">{{$faq->answer}}</p>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- <section class="chunk-box">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						@if($project->investment)
						<div class="row text-center">
							<div class="col-md-4">
								@if(Auth::check())
								<h4>${{number_format($project->investment->total_projected_costs)}} <small>Total Projected Costs</small></h4>
								@else
								<h4 style="background-color:0 0 10px rgba(0,0,0,0.5);"> Sign In to See <small>Total Projected Costs</small><small Class="blur" style="color: #bbb"><br> Total Projected Costs</small></h4>
								@endif
							</div>
							<div class="col-md-4">
								@if(Auth::check())
								<h4>${{number_format($project->investment->total_debt)}} <small>Total Debt</small></h4>
								@else
								<h4 style="background-color:0 0 10px rgba(0,0,0,0.5);"> Sign In to See <small>Total Debt</small><small Class="blur" style="color: #bbb"><br> Total Debt</small></h4>
								@endif
							</div>
							<div class="col-md-4">
								@if(Auth::check())
								<h4 style="margin-top:0px !important;">${{number_format($project->investment->total_equity)}} <small>Total Equity</small></h4>
								<div class="row">
									<div class="col-md-6">
										<h6 class="pull-right" style="margin-bottom:0px !important;">${{number_format($project->investment->developer_equity)}} <br><small>Developer Equity</small></h6>
									</div>
									<div class="col-md-6">
										<h6 class="pull-left" style="margin-bottom:0px !important;">${{number_format($project->investment->goal_amount)}} <br><small>Investor Equity</small></h6>
									</div>
								</div>
								@else
								<h4 style="background-color:0 0 10px rgba(0,0,0,0.5);"> Sign In to See <small>Total Equity</small><small Class="blur" style="color: #bbb"><br> Total Projected Costs</small></h4>
								<div class="row">
									<div class="col-md-6">
										<h6 style="background-color:0 0 10px rgba(0,0,0,0.5);"> Sign In to See <small>Developer Equity</small><small Class="blur" style="color: #bbb"><br> Developer Equity</small></h6>
									</div>
									<div class="col-md-6">
										<h6 style="background-color:0 0 10px rgba(0,0,0,0.5);"> Sign In to See <small>Investor Equity</small><small Class="blur" style="color: #bbb"><br> Investor Equity</small></h6>
									</div>
								</div>
								@endif
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</section> -->
		<section class="chunk-box @if($project->investment && $project->investment->insvestment_structure_video_url == null) hide @endif">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<h2 class="text-center" style="font-weight:100">EXPLAINER <span style="color:#1D92E8;">VIDEO</span></h2>
						<br>
						<div class="row">
							<div class="col-md-10 col-md-offset-1 text-center">
								<div class="embed-responsive embed-responsive-16by9" style="margin-bottom:4em;position: relative;padding-bottom: 53%;padding-top: 25px;height: 0;">
									<iframe class="embed-responsive-item" width="100%" height="100%" src="@if($project->investment){{$project->investment->investments_structure_video_url}}@endif" frameborder="0" allowfullscreen></iframe>
									{{-- <h4 style="margin-top:0px;"><small>Video</small></h4> --}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- <section class="chunk-box">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">
						<h2 class="text-center" style="font-weight:600 !important;color:#282a73;">Project FAQs</h2>
						<br>
						<div class="panel-group" id="accordion">
							@foreach($project->projectFAQs as $key => $faq)
							<div class="panel panel-info">
								<div class="panel-heading" data-toggle="collapse" data-target="#faq_{{$key}}">
									<i class="indicator glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
									<h4 class="panel-title" style="font-weight:500 !important; padding-left:30px;">
										{{$faq->question}}
									</h4>
								</div>
								<div id="faq_{{$key}}" class="panel-collapse collapse">
									<div class="panel-body" style="padding-left:45px;">
										<p>{{$faq->answer}}</p>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</section> -->
		<!-- <h4 class="text-center">More questions/comments/concerns? You can post them here or chat with us</h4> -->
		<!-- <section id="comments-form" class="chunk-box " style="padding-bottom:0px;">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-1 col-md-3"><b> {{$project->comments->count()}} @if($project->comments->count() == 1) Comment @else Comments @endif</b></div>
					<div class="col-md-8"></div>
				</div>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<hr style="margin-top:0px;">
					</div>
				</div>
				{!! Form::open(array('route'=>['projects.{projects}.comments.store', $project], 'class'=>'form-horizontal', 'role'=>'form')) !!}
				<div class="row">
					<div class="col-md-offset-1 col-md-10 wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.5s">
						<fieldset>
							<div class="row">
								<div class="col-md-1">
									<img src="{{asset('assets/images/default-male.png')}}" width="50" style="width:40px; height:50px;">
								</div>
								<div class="col-md-11">
									<div class="form-group @if($errors->first('text')){{'has-error'}} @endif">
										{!! Form::textarea('text', null, array('placeholder'=>'Write a comment', 'class'=>'form-control', 'rows'=>'2')) !!}
										{!! $errors->first('text', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-md-offset-10 col-md-2">
										{!! Form::submit('Post', array('class'=>'btn btn-danger btn-block comment-submit-button', 'tabindex'=>'15')) !!}
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</section> -->
		<style type="text/css">
			.vote-input {
				visibility:hidden;
			}
			.vote-input-label {
				cursor: pointer;
			}
			.vote-input:checked + label {
				color: red;
			}
			.vote-count {
				display:inline;
			}
		</style>
		<section id="comments-list" class="chunk-box " style="padding-top:0px;">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<?php
						function commentsFunc($project, $all_comments)
						{
							?>
							@foreach($all_comments as $comment)
							<div class="row" class="comment" style="padding:1em 0px;">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-1">
											<img src="{{asset('assets/images/default-male.png')}}" width="50" style="width:40px; height:50px;">
										</div>
										<div class="col-md-11">
											<b>{{$comment->user->first_name}} {{$comment->user->last_name}}</b> . <span style="font-size: 0.7em; padding-left:5px;">{{$comment->updated_at->diffForHumans()}}</span> @if(!Auth::guest() && App\Helpers\SiteConfigurationHelper::isSiteAdmin())<a href="{{route('projects.{projects}.comments.delete', [$project->id, $comment->id])}}"> <i class='fa fa-trash pull-right'></i> </a> @endif <br>
											<p class="text-justify">{{$comment->text}}</p>
										</div>
									</div>
									<div class="row">
										<div class="col-md-offset-1 col-md-11">
											<div style="font-size: 0.7em; color:#aeaeae">
												{!! Form::open(array('route'=>['projects.{projects}.comments.votes', $project->id, $comment->id], 'class'=>'form-horizontal', 'role'=>'form')) !!}
												<input type='radio' name='value' value='1' id='upvote_radio_{{$comment->id}}' class='vote-input'>
												<div id='upvote-count-{{$comment->id}}' class="upvote-count vote-count">@if($comment->votes->where('value', '1')->count()) {{$comment->votes->where('value', '1')->count()}} @endif </div>
												<label for='upvote_radio_{{$comment->id}}' class="vote-input-label"><i class='fa fa-chevron-up'></i></label>
												<input type='radio' name='value' value='-1' id='downvote_radio_{{$comment->id}}' class='vote-input'>
												<div id='downvote-count-{{$comment->id}}' class="downvote-count vote-count">@if($comment->votes->where('value', '-1')->count()) {{$comment->votes->where('value', '-1')->count()}} @endif </div>
												<label for='downvote_radio_{{$comment->id}}' class="vote-input-label"><i class='fa fa-chevron-down'></i></label>
												&nbsp; <i class="fa fa-circle" style="font-size:0.5em;"></i> &nbsp; <a href='#reply-form-{{$comment->id}}' class='reply-to-button'><b>Reply</b></a>
												{!! Form::close() !!}
											</div>
											<div class="reply-to-form" id="reply-form-{{$comment->id}}" style="display:none;">
												{!! Form::open(array('route'=>['projects.{projects}.comments.reply', $project, $comment], 'class'=>'form-horizontal', 'role'=>'form')) !!}
												<div class="row">
													<div class="col-md-12 wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.5s">
														<fieldset>
															<div class="row">
																<div class="col-md-1">
																	<img src="{{asset('assets/images/default-male.png')}}" width="50" style="width:40px; height:50px;">
																</div>
																<div class="col-md-11">
																	<div class="form-group">
																		{!! Form::textarea('text', null, array('placeholder'=>'Write a comment', 'class'=>'form-control', 'rows'=>'2')) !!}
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="form-group">
																	<div class="col-md-offset-10 col-md-2">
																		{!! Form::submit('Post', array('class'=>'btn btn-danger btn-block comment-reply-button', 'tabindex'=>'15')) !!}
																	</div>
																</div>
															</div>
														</fieldset>
													</div>
												</div>
												{!! Form::close() !!}
											</div>
											@if($comment->replies->count())
											<?php commentsFunc($project, $comment->replies);
											?>
											@endif
										</div>
									</div>
								</div>
							</div>
							@endforeach
							<?php
						}
						$comments = $project->comments->where('reply_id', '0')->reverse()->all();
						commentsFunc($project, $comments);?>
					</div>
				</div>
			</div>
		</section>
		<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document" style="width:46em; padding-top:3em;">
				<div class="modal-content">
					<div class="modal-body">
						<!-- <div style="display:block;margin:0;padding:0;border:0;outline:0;font-size:10px!important;color:#AAA!important;vertical-align:baseline;background:transparent;width:706px;"><iframe frameborder="0" height="500" scrolling="no" src="https://rightsignature.com/forms/MountWaverley-PDS-d4f76e/embedded/4c77894fd8d?height=500" width="706"></iframe><div style="font-family: 'Lucida Grande', Helvetica, Arial, Verdana, sans-serif;line-height:13px !important;text-align:center;margin-top: 6px !important;"><a href="https://rightsignature.com" target="_blank" style="color:#AAA;text-decoration:none;">Electronic Signature Software</a> by RightSignature &copy; &nbsp;&bull;&nbsp; <a href="https://rightsignature.com/terms" target="_blank" style="color:#888;">Terms of Service</a> &nbsp;&bull;&nbsp; <a href="https://rightsignature.com/privacy" target="_blank" style="color:#888;">Privacy Policy</a></div></div> -->
					</div>
				</div>
			</div>
		</div>
		{{-- <section id="section-progress-right" class="section-progress-right color-panel-right panel-close-right center" style="background-color: #{{$color->nav_footer_color}}">
			<div class="color-wrap-right">
				<button id="project_progress" class="btn project-progress progress-project-close"><i id="arrows" class="glyphicon glyphicon-chevron-left"></i></button>
				<button id="project_progress1" class="btn project-progress1 progress-project-close1 hide"><i id="" class="arrows1 glyphicon glyphicon-chevron-right"></i><i id="" class="arrows1 glyphicon glyphicon-chevron-right"></i></button>
			</div>
		</section> --}}
	</div>
	@if(Auth::guest())
	@else
	@if(App\Helpers\SiteConfigurationHelper::isSiteAdmin()) 
</form>
@endif
@endif
<div id="menu1" class="tab-pane fade">
	<div class="container">
		<h3>Progress</h3>
		<table class="table table-striped">
			<thead>
				<tr>
					<th style="width: 140px;">Date of Progress</th>
					<th>Description</th>
					<th>Details</th>
				</tr>
			</thead>
			<tbody>
				@foreach($project_prog as $project_progs)
				<tr>
					<td>{{$project_progs->updated_date}}
					</td>
					<td>{{$project_progs->progress_description}} </td>
					<td>{{$project_progs->progress_details}}
							{{--<div class="row">
								 @foreach($project->media->chunk(1) as $set)
								@foreach($set as $photo)
								@if($photo->type === 'progress_images')
								<div class="col-md-4 change_column">
									<div class="thumbnail">
										<img src="/{{$photo->path}}" alt="{{$photo->caption}}" class="img-responsive">
										<div class="caption">
											<!-- {{$photo->type}} -->
											<!-- <a href="#" class="pull-right">Delete</a> -->
										</div>
									</div>
								</div>
								@else
								@endif
								@endforeach
								@endforeach 
							</div> --}}
							<iframe class="embed-responsive-item" width="100%" height="100%" src="{{$project_progs->video_url}}" frameborder="0" allowfullscreen></iframe>
						</td>
					</tr>
					@endforeach
					<tr>
						@if(Auth::user())
						@if(App\Helpers\SiteConfigurationHelper::isSiteAdmin())
						<h3>Add new Updare</h3>
						{!! Form::open(array('route'=>['configuration.addprogress', $project->id], 'class'=>'form-horizontal', 'role'=>'form', 'method'=>'POST')) !!}
						<div class="row">
							<td>
								<div class="form-group <?php if($errors->first('updated_date')){echo 'has-error';}?>">
									<div class="col-sm-12 <?php if($errors->first('updated_date')){echo 'has-error';}?>">
										{!! Form::text('updated_date', null, array('placeholder'=>'Date', 'class'=>'form-control ', 'tabindex'=>'1','id'=>'datepicker')) !!}
										{!! $errors->first('updated_date', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</td>
							<td>
								<div class="form-group <?php if($errors->first('progress_description')){echo 'has-error';}?>">
									<div class="col-sm-12 <?php if($errors->first('progress_description')){echo 'has-error';}?>">
										{!! Form::textarea('progress_description', null, array('placeholder'=>'Description', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
										{!! $errors->first('progress_description', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</td>
							<td>
								<div class="row">
									<div class="form-group <?php if($errors->first('progress_details')){echo 'has-error';}?>">
										<div class="col-sm-12 <?php if($errors->first('progress_details')){echo 'has-error';}?>">
											{!! Form::textarea('progress_details', null, array('placeholder'=>'Description', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
											{!! $errors->first('progress_details', '<small class="text-danger">:message</small>') !!}
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="form-group <?php if($errors->first('video_url')){echo 'has-error';}?>">
										<div class="col-sm-12 <?php if($errors->first('video_url')){echo 'has-error';}?>">
											{!! Form::text('video_url', null, array('placeholder'=>'Video url', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
											{!! $errors->first('video_url', '<small class="text-danger">:message</small>') !!}
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-sm-6">
												{!! Form::submit('Add new Column', array('class'=>'btn btn-warning btn-block', 'tabindex'=>'10')) !!}
											</div>
										</div>
									</div>
								</div>
							</td>
							{!! Form::close() !!}
							@endif
							@endif
						</tr>
					</div>
				</tbody>
			</table>
			@if(Auth::user())
			@if(App\Helpers\SiteConfigurationHelper::isSiteAdmin())
			<h3>Upload a Images</h3>
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(array('route'=>['configuration.uploadprogress', $project->id], 'class'=>'form-horizontal dropzone', 'role'=>'form', 'files'=>true)) !!}
					{!! Form::close() !!}
				</div>
			</div>
			@endif
			@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="text-center">
		<!-- Edit Project Background Modal -->
		<div class="modal fade" id="edit_project_back_img_modal" role="dialog">
			<div class="modal-dialog" style="min-width: 800px;">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Crop Image</h4>
					</div>
					<div class="modal-body">
						<div class="text-center" id="image_cropbox_container" style="display: inline-block;">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" id="perform_crop_btn">Perform Crop</button>
						<!-- Hidden Fields to refer for JCrop -->
						<input type="hidden" name="image_crop" id="image_crop" value="" action="">
						<input type="hidden" name="image_action" id="image_action" value="">
						<input type="hidden" name="x_coord" id="x_coord" value="">
						<input type="hidden" name="y_coord" id="y_coord" value="">
						<input type="hidden" name="w_target" id="w_target" value="">
						<input type="hidden" name="h_target" id="h_target" value="">
						<input type="hidden" name="orig_width" id="orig_width" value="">
						<input type="hidden" name="orig_height" id="orig_height" value="">
					</div>
				</div>      
			</div>
		</div>
	</div>
</div>
@stop
@section('js-section')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$(function () {
		var minimized_elements = $('p.minimize');
		minimized_elements.each(function(){
			var t = $(this).text();
			if(t.length < 186) return;
			$(this).html(
				t.slice(0,186)+'<span>... </span><a href="#" class="more">More</a>'+
				'<span style="display:none;">'+ t.slice(186,t.length)+' <a href="#" class="less">Less</a></span>'
				);
		});
		var vm = this;
		vm.count = 0;
		$("#rightsignature-iframe").on("load", function () {
			vm.count++;
			if(vm.count ==2){
				window.location.href = "{{route('projects.interest', $project)}}";
			}
		});
		var daysPassedCheck=0;
		@if($project->investment && $project->investment->fund_raising_close_date) 
		fund_close_date = new Date({{date('Y,m-1,d', strtotime($project->investment->fund_raising_close_date))}});
		var now = new Date();
		totalDays = {{$project->investment->fund_raising_close_date->diffInDays()}} + {{$project->investment->fund_raising_start_date->diffInDays()}};
		if(fund_close_date < now){
			var closeYear = fund_close_date.getFullYear();
			var closeMonth = fund_close_date.getMonth()+1;
			var closeDate = fund_close_date.getDate();
			if((closeYear == now.getFullYear()) && (closeMonth == eval(now.getMonth()+1)) && (closeDate == now.getDate())){
				// Variable to check whether the fund_close_date is passed. 
				daysPassedCheck = 0;
			} else {
				daysPassedCheck = 1;
			}
			diffinDays = 0;
		}
		else{
			if(totalDays > 0){
				diffinDays = {{$project->investment->fund_raising_close_date->diffInDays()}}/totalDays;
			}
			else {
				diffinDays = 0;
			}
		}
		if(daysPassedCheck == 1){
			$(".days-left-circle").remove();
		}
		else{
			$('#daysremained').html(Math.ceil(diffinDays*totalDays));
			var c1 = $('.circle');
			c1.circleProgress({
				value : diffinDays,
				fill: { color: '@if($color)#{{$color->heading_color}}@endif' },
				size: '120',
				thickness: '1/12',
				emptyFill: 'rgba(0, 0, 0, 0.5)'
			});
			setTimeout(function() { c1.circleProgress('value', '1.0'); }, 2000);
			setTimeout(function() { c1.circleProgress('value', diffinDays); }, 3100);
		}
		@endif
		$('#show-interest-btn').click(function (e) {
			e.preventDefault();
			$('#loadingModal').modal('show');
		});
		$('a.more', minimized_elements).click(function(event){
			event.preventDefault();
			$(this).hide().prev().hide();
			$(this).next().show();
		});
		$('#project_progress').click(function(e){
			$('#section-progress-right').toggleClass('panel-close-right', 'panel-open-right');
			$('#section-progress-right').toggleClass('panel-open-right', 'panel-close-right');
			$('#project_progress').toggleClass('progress-project-close','progress-project-open');
			$('#project_progress').toggleClass('progress-project-open','progress-project-close');
			$('#project_progress1').toggleClass('progress-project-close','progress-project-open');
			$('#project_progress1').toggleClass('progress-project-open','progress-project-close');
			$('#arrows').toggleClass('glyphicon-chevron-left','glyphicon-chevron-right');
			$('#arrows').toggleClass('glyphicon-chevron-right','glyphicon-chevron-left');
			$('.arrows1').toggleClass('glyphicon-chevron-left','glyphicon-chevron-right');
			$('.arrows1').toggleClass('glyphicon-chevron-right','glyphicon-chevron-left');
			$('#project_progress1').toggleClass('hide','');
		});
		$('#project_progress1').click(function(e){
			$('#project_progress').toggleClass('','hide');
			$('#project_progress').toggleClass('hide','');
			$('#section-progress-right').toggleClass('panel-open-right', 'panel-open-right1');
			$('#section-progress-right').toggleClass('section-progress-right', 'section-progress-right1');
			$('#section-progress-right').toggleClass('section-progress-right1', 'section-progress-right');
			$('.arrows1').toggleClass('glyphicon-chevron-right','glyphicon-chevron-left');
			$('.arrows1').toggleClass('glyphicon-chevron-left','glyphicon-chevron-right');
			$('.change_column').toggleClass('col-md-12','col-md-6');
			$('.change_column').toggleClass('col-md-6','col-md-12');
		});
		$('a.less', minimized_elements).click(function(event){
			event.preventDefault();
			$(this).parent().hide().prev().show().prev().show();
		});
		$('.collapse-header').on('click', function () {
			$($(this).data('target')).collapse('toggle');
		});
		$('.vote-input').click(function(event) {
			$(this).parent().submit();
		});
		$('.reply-to-button').click(function(event) {
			event.preventDefault();
			var replyTo = $(this).attr('href');
			$(replyTo).toggle('slow');
		});
		var oneDay = 24*60*60*1000;
		var firstDate = new Date();
		var secondDate = new Date(2016,03,15);
		var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		var x = Math.floor((Math.random() * 20000) + 10000);
		window.setInterval(function(){
			var y = (Math.floor(Math.random() * 9) + 2) * 1000;
			var textArray = [
			'Abbotsford','Alphington','Burnley','Collingwood','Cremorne','Fairfield','Fitzroy','Balaclava','Elwood','Melbourne','Ripponlea','Southbank','Carlton','Jolimont','Flemington','Kensington','Parkville','Southbank'
			];
			var randomNumber = Math.floor(Math.random()*textArray.length);
			$(document).ready(function() {
				$('#section-colors-right').toggleClass('panel-close-right', 'panel-open-right');
				$('#section-colors-right').toggleClass('panel-open-right', 'panel-close-right');
				$('#addlocation').html(textArray[randomNumber]);
				$('#addamount').html(y);
			})
			return false;
		},1200);

		t=1;
		$(window).bind('scroll', function() {
			if ($(window).scrollTop() > 400 && t==1) {
				window.setInterval(function(){
					$('#section-colors').addClass('hide');
					t=0;
				},5000);
			}
		});
		$(window).bind('scroll', function() {
			if ($(window).scrollTop() > 400 && t==1) {
				$('#section-colors').removeClass('hide');
			}
		});
		var d = new Date();
		var n = d.getHours();
		if(n>=6){
			var y = (Math.floor(Math.random() * 15) + 5);
			$('#numberofpeople').html(y);
			window.setInterval(function() {
				$('#section-colors-left').removeClass('panel-close-left');
				$('#section-colors-left').addClass('panel-open-left');
				var y = (Math.floor(Math.random() * 15) + 5);
				$('#numberofpeople').html(y);
				// document.getElementById("numberofpeople").innerHTML = y;
			}, 60000);
		} else {
			$('#section-colors-left').toggleClass('panel-open-left panel-close-left');
		}
		var mq = window.matchMedia("(min-width: 1140px)");
		if(mq.matches){
		}else{
			$('#section-colors').addClass('hide');
			$('#section-colors-left').addClass('hide');
			$('#section-colors-right').addClass('hide');
			$('#containernav').removeClass('container');
			$('#containernav').addClass('container-fluid');
		}
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
		@if(Auth::check())
		@else
		window.setInterval(function(){
			// window.location = "/welcome?next=projects/{{$project->id}}"
		},5000); 
		@endif

		//Edit Project Page Details by Admin
		editProjectPageDetailsByAdmin();
		//Edit Project Page Background Image
		editProjectPageBackImg();
		//Edit Project Page Thumbnails
		editProjectPageThumbImages();
	});

	function editProjectPageDetailsByAdmin(){
		$('.edit-project-page-details-btn').click(function(e){
			$('.store-project-page-details-btn').show();
			$('.project-title-name').html('<input type="text" name="project_title_txt" class="form-control" value="{{$project->title}}" style="font-size: 25px;">');
			$('.project-description-field').html('<input type="text" name="project_description_txt" class="form-control" value="{{$project->description}}">');
			@if($project->investment)
			$('.project-min-investment-field').html('$<input type="text" name="project_min_investment_txt" class="form-control" value="{{(int)$project->investment->minimum_accepted_amount}}">');
			$('.project-hold-period-field').html('<input type="text" name="project_hold_period_txt" class="form-control" value="{{$project->investment->hold_period}}">');
			$('.project-returns-field').html('<input type="text" name="project_returns_txt" class="form-control" value="{{$project->investment->projected_returns}}">%');
			$('.project-goal-amount-field').html('<input type="text" name="project_goal_amount_txt" class="form-control" style="width:30%" value="{{$project->investment->goal_amount}}">');
			$('.project-summary-field').html('<textarea name="project_summary_txt" rows="3" class="form-control" placeholder="Enter Summary">{{$project->investment->summary}}</textarea>');
			$('.project-security-long-field').html('<textarea name="project_security_long_txt" rows="3" class="form-control" placeholder="Enter Security Details">{{$project->investment->security_long}}</textarea>');
			$('.project-investor-distribution-field').html('<textarea name="project_investor_distribution_txt" class="form-control" rows="4" placeholder="Enter Investor Distribution Details">{{$project->investment->exit_d}}</textarea>');
			$('.project-marketability-field').html('<textarea name="project_marketability_txt" class="form-control" rows="3" placeholder="Enter Marketability Details">{{$project->investment->marketability}}</textarea>');
			$('.project-residents-field').html('<textarea name="project_residents_txt" class="form-control" rows="3" placeholder="Enter Residents">{{$project->investment->residents}}</textarea>');
			$('.project-investment-type-field').html('<textarea name="project_investment_type_txt" class="form-control" rows="3" placeholder="Investment type">{{$project->investment->investment_type}}</textarea>');
			$('.project-security-field').html('<textarea name="project_security_txt" class="form-control" rows="3" placeholder="Investment Security">{{$project->investment->security}}</textarea>');
			$('.project-expected-returns-field').html('<textarea name="project_expected_returns_txt" class="form-control" rows="3" placeholder="Expected Returns">{{$project->investment->expected_returns_long}}</textarea>');
			$('.project-return-paid-as-field').html('<textarea name="project_return_paid_as_txt" class="form-control" rows="3" placeholder="Return paid as">{{$project->investment->returns_paid_as}}</textarea>');
			$('.project-taxation-field').html('<textarea name="project_taxation_txt" class="form-control" rows="3" placeholder="Taxation">{{$project->investment->taxation}}</textarea>');
			$('.project-developer-field').html('<textarea name="project_developer_txt" class="form-control" rows="3" placeholder="Developer">{{$project->investment->proposer}}</textarea>');
			$('.project-current-status-field').html('<textarea name="project_current_status_txt" class="form-control" rows="3" placeholder="Current Status">{{$project->investment->current_status}}</textarea>');
			$('.project-rationale-field').html('<textarea name="project_rationale_txt" class="form-control" rows="3" placeholder="Rationale">{{$project->investment->rationale}}</textarea>');
			$('.project-risk-field').html('<textarea name="project_risk_txt" class="form-control" rows="3" placeholder="Risk">{{$project->investment->risk}}</textarea>');
			$('.project-pds1-link-field').html('<input type="text" name="" class="form-control" placeholder="Title"><input type="text" name="project_pds1_link_txt" class="form-control" placeholder="PDS Document Link" @if(Auth::check()) value="@if($project->investment){{$project->investment->PDS_part_1_link}}@endif" @endif>');
			$('.project-pds2-link-field').html('<input type="text" name="" class="form-control" placeholder="Title"><input type="text" name="project_pds2_link_txt" class="form-control" placeholder="PDS Document Link" @if(Auth::check()) value="@if($project->investment){{$project->investment->PDS_part_2_link}}@endif" @endif>');
			$('.project-how-to-invest-field').html('<textarea name="project_how_to_invest_txt" class="form-control" rows="3" placeholder="How to invest">{{$project->investment->how_to_invest}}</textarea>');
			@endif
		});
	}

	function editProjectPageBackImg(){
		$('.edit-projectpg-back-img').click(function(){
			$('#projectpg_back_img').trigger('click');
		});
		$('#projectpg_back_img').change(function(e){
			if($('#projectpg_back_img').val() != ''){
				var formData = new FormData();
				formData.append('projectpg_back_img', $('#projectpg_back_img')[0].files[0]);
				$('.loader-overlay').show();
				$.ajax({
					url: '/configuration/uploadProjectPgBackImg',
					type: 'POST',
					dataType: 'JSON',
					data: formData,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					contentType: false,
					processData: false
				}).done(function(data){
					if(data.status == 1){
						var imgPath = data.destPath+data.fileName;
						var str1 = $('<div class="col-sm-9"><img src="../../'+imgPath+'" width="530" id="image_cropbox" style="max-width:none !important"><br><span style="font-style: italic; font-size: 13px"><small>Select The Required Area To Crop Logo.</small></span></div><div class="col-sm-2" id="preview_project_back_img" style="float: right;"><img width="530" src="../../'+imgPath+'" id="preview_image"></div>');

						$('#image_cropbox_container').html(str1);
						$('#edit_project_back_img_modal').modal({
							'show': true,
							'backdrop': false,
						});

						$('#image_crop').val(imgPath); //set hidden image value
						$('#image_crop').attr('action', 'projectPg back image');
						var target_width = 171;
						var target_height = 89;
						var origWidth = data.origWidth;
						var origHeight = data.origHeight;
						$('#image_cropbox').Jcrop({
							boxWidth: 530,
							aspectRatio: 171/89,
							keySupport: false,
							setSelect: [0, 0, target_width, target_height],
							bgColor: '',
							onSelect: function(c) {
								updateCoords(c, target_width, target_height, origWidth, origHeight);
							},
							onChange: function(c) {
								updateCoords(c, target_width, target_height, origWidth, origHeight);
							},
							onRelease: setSelect,
							minSize: [target_width, target_height],
						});
						$('.loader-overlay').hide();

						performCropOnImage();

						$('#modal_close_btn').click(function(e){
							$('#projectpg_back_img, #projectpg_back_img_name').val('');
						});
					}
					else{
						$('.loader-overlay').hide();
						$('#projectpg_back_img, #projectpg_back_img_name').val('');
						alert(data.message);
					}
				});
			}
		});
	}

	function updateCoords(coords, w, h, origWidth, origHeight){
		var target_width= w;
		var target_height=h;
		//Set New Coordinates
		$('#x_coord').val(coords.x);
		$('#y_coord').val(coords.y);
		$('#w_target').val(coords.w);
		$('#h_target').val(coords.h);
		$('#orig_width').val(origWidth);
		$('#orig_height').val(origHeight);

		// showPreview(coordinates)
		$("<img>").attr("src", $('#image_cropbox').attr("src")).load(function(){
			var rx = target_width / coords.w;
			var ry = target_height / coords.h;

			var realWidth = this.width;
			var realHeight = this.height;

			var newWidth = 530;
			var newHeight = (realHeight/realWidth)*newWidth;

			$('#preview_image').css({
				width: Math.round(rx*newWidth)+'px',
				height: Math.round(ry*newHeight)+'px',
				marginLeft: '-'+Math.round(rx*coords.x)+'px',
				marginTop: '-'+Math.round(ry*coords.y)+'px',
			});

		});
	}

	function setSelect(coords){
		jcrop_api.setSelect([coords.x,coords.y,coords.w,coords.h]);
	}

	function performCropOnImage(){
		$('#perform_crop_btn').click(function(e){
			$('.loader-overlay').show();
			var imageName = $('#image_crop').val();
			var imgAction = $('#image_crop').attr('action');
			var xValue = $('#x_coord').val();
			var yValue = $('#y_coord').val();
			var wValue = $('#w_target').val();
			var hValue = $('#h_target').val();
			var origWidth = $('#orig_width').val();
			var origHeight = $('#orig_height').val();
			var projectThumbAction = $('#image_action').val();
			var currentProjectId = $('#current_project_id').val();
			console.log(imageName+'|'+xValue+'|'+yValue+'|'+wValue+'|'+hValue);
			$.ajax({
				url: '/configuration/cropUploadedImage',
				type: 'POST',
				data: {
					imageName: imageName,
					imgAction: imgAction,
					xValue: xValue,
					yValue: yValue,
					wValue: wValue,
					hValue: hValue,
					origWidth: origWidth,
					origHeight: origHeight,
					projectThumbAction: projectThumbAction,
					currentProjectId: currentProjectId,
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			}).done(function(data){
				console.log(data);
				if(data.status){
					$('#image_crop').val(data.imageSource);
					location.reload('/');
				}
				else{
					$('.loader-overlay').hide();
					if(imgAction == 'projectPg back image'){
						$('#edit_project_back_img_modal').modal('toggle');
						$('#projectpg_back_img, #projectpg_back_img_name').val('');
					}
					else {}
						alert(data.message);
				}

			});
		});
	}

	function editProjectPageThumbImages(){
		var imgAction = '';
		$('.edit-projectpg-thumbnails').click(function(){
			$('#projectpg_thumbnail_image').trigger('click');
			imgAction = $(this).attr('action');
			$('#projectpg_thumbnail_image, #projectpg_thumbnail_image_name').val('');
		});
		$('#projectpg_thumbnail_image').change(function(e){
			console.log(imgAction);
			if($('#projectpg_thumbnail_image').val() != ''){
				var formData = new FormData();
				formData.append('projectpg_thumbnail_image', $('#projectpg_thumbnail_image')[0].files[0]);
				formData.append('imgAction', imgAction);
				$('.loader-overlay').show();
				$.ajax({
					url: '/configuration/uploadprojectPgThumbnailImages',
					type: 'POST',
					dataType: 'JSON',
					data: formData,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					contentType: false,
					processData: false
				}).done(function(data){
					if(data.status == 1){
						var imgPath = data.destPath+data.fileName;
						var str1 = $('<div class="col-sm-9"><img src="../../'+imgPath+'" width="530" id="image_cropbox" style="max-width:none !important"><br><span style="font-style: italic; font-size: 13px"><small>Select The Required Area To Crop Logo.</small></span></div><div class="col-sm-2" id="preview_project_thumb_img" style="float: right;"><img width="530" src="../../'+imgPath+'" id="preview_image"></div>');

						$('#image_cropbox_container').html(str1);
						$('#edit_project_back_img_modal').modal({
							'show': true,
							'backdrop': false,
						});

						$('#image_crop').val(imgPath); //set hidden image value
						$('#image_crop').attr('action', 'projectPg thumbnail image');
						$('#image_action').val(imgAction);
						var target_width = 150;
						var target_height = 150;
						var origWidth = data.origWidth;
						var origHeight = data.origHeight;
						$('#image_cropbox').Jcrop({
							boxWidth: 530,
							aspectRatio: 1,
							keySupport: false,
							setSelect: [0, 0, target_width, target_height],
							bgColor: '',
							onSelect: function(c) {
								updateCoords(c, target_width, target_height, origWidth, origHeight);
							},
							onChange: function(c) {
								updateCoords(c, target_width, target_height, origWidth, origHeight);
							},
							onRelease: setSelect,
							minSize: [target_width, target_height],
						});
						$('.loader-overlay').hide();
					}
					else{
						$('.loader-overlay').hide();
						$('#projectpg_thumbnail_image, #projectpg_thumbnail_image_name').val('');
						alert(data.message);
					}
				});
			}
		});
		performCropOnImage();

		$('#modal_close_btn').click(function(e){
			$('#projectpg_thumbnail_image, #projectpg_thumbnail_image_name').val('');
		});
	}

</script>
@stop
