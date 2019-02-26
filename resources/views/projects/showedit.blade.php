@extends('layouts.project')
@section('title-section')
{{$project->title}} crowdfunding with just ${{(int)$project->investment->minimum_accepted_amount}}
@stop
@if(App\Helpers\SiteConfigurationHelper::getConfigurationAttr())
@section('meta-section')
<meta property="og:image" content="@if($projectThumb=$project->media->where('type', 'project_thumbnail')->where('project_site', url())->last()){{asset($projectThumb->path)}} @else {{asset('assets/images/0001-139091381.png')}} @endif" />
<meta property="og:title" content="Invest in {{$project->title}} with just ${{(int)$project->investment->minimum_accepted_amount}}" />
<meta property="og:description" content="{{$project->description}}" />
<meta property="og:site_name" content="" />
<meta property="og:url" content="{{$project->project_site}}" />
<meta property="og:type" content="website" />

<meta name="description" content="{{$project->description}}">
<meta name="csrf-token" content="{{csrf_token()}}" />
@stop
@endif
@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-touchspin/3.1.2/jquery.bootstrap-touchspin.css">
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
		var map_zoom = {{$project->location->zoom_level}}
		var mycenter = new google.maps.LatLng(lat,lng);
		var map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: lat, lng: lng},
			zoom: map_zoom,
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
@if (Session::has('message'))
<div style="z-index: 100;position: fixed;top: 5em;left: 0.5em;background: #56f7c1;padding: 0.7em 2em;border-radius: 10px;opacity: 0.7;font-size: 16px;"><i class="fa fa-check-circle-o" aria-hidden="true">&nbsp;&nbsp;{!! Session::get('message') !!}</i></div>
@endif
@if ($errors->any())
<div class="alert alert-danger" style="z-index: 100;position: fixed;top: 5em;left: 0.5em;background: #56f7c1;padding: 0.7em 2em;border-radius: 10px;opacity: 0.7;font-size: 16px;">
	<ul>
		@foreach ($errors->all() as $error)
		<li ><?php echo $error; ?></li>
		@endforeach
	</ul>
</div>
@endif
{{-- @if ($errors->any())
<div class="alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li style="z-index: 100;position: absolute;top: 5em;left: 0.5em;background: #56f7c1;padding: 0.7em 2em;border-radius: 10px;opacity: 0.7;font-size: 16px;">{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif --}}
@if(Auth::guest())
@else
@if(App\Helpers\SiteConfigurationHelper::isSiteAdmin())
<form action="{{route('configuration.updateProjectDetails', [$project->id])}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}
	<button type="submit" class="btn btn-default btn-lg store-project-page-details-btn" style="display: none;">Update Project</button>
	<div style="position: fixed;z-index: 100;top: 75%;right: 5%;">
		<div class="save-project-details-floating-btn-style save-project-details-floating-btn" data-toggle="tooltip" title="Save the updated project details fields." data-placement="top">
			<i class="fa fa-floppy-o" aria-hidden="true" style="font-size: 1.6em;"></i><br>
			<span><b>Update Details</b></span>
		</div>
		<a href="{{route('projects.show', [$project->id])}}">
			<div class="exit-project-details-editable-btn-style exit-project-details-editable-btn" data-toggle="tooltip" title="Exit project details editable mode." data-placement="top">
				<i class="fa fa-times" aria-hidden="true" style="font-size: 1.6em;"></i><br>
				<span>Exit Edit Mode</span>
			</div>
		</a>
	</div>
	@endif
	@endif
	<input type="hidden" name="current_project_id" id="current_project_id" value="{{$project->id}}">
	<section style="background: @if($project->media->where('type', 'projectpg_back_img')->last()) url({{asset($project->media->where('type', 'projectpg_back_img')->last()->path)}}) @else url({{asset('assets/images/bgimage_sample.png')}}) @endif;background-repeat: no-repeat; background-size:100% 100%;" class="project-back img-responsive" id="project-title-section">
		<div class="color-overlay main-fold-overlay-color">
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<input type="url" id="custom_project_page_link" name="custom_project_page_link" class="form-control" value="{{$project->custom_project_page_link}}" style="margin-top: 25px;" placeholder="Custom project page url" data-toggle="tooltip" title="Custom project page url.">
					</div>
				</div>
				<div class="row" id="main-context" style=" padding-top: 1.1em;">
					<div class="col-md-4 col-sm-6">
						<h2 class="text-left second_color project-title-name" style="font-size:2.625em; color:#fed405;">
							<input type="text" name="project_title_txt" class="form-control" value="{{$project->title}}" style="font-size: 25px;">
						</h2>
						<span class="text-left project-description-field" style="color:#fff; font-size:0.875em;">
							<textarea type="text" name="project_description_txt" id="project_description_txt" class="form-control" required="required">{{$project->description}}</textarea>
						</span>
						<br>
					</div>
					<div class="col-md-4 col-md-offset-4 col-sm-6 text-center project-close-date-field">
						<p style="color: white !important;">Close Date</p><input name="fund_raising_close_date" type="date" style="color: #000;" value="{{$project->investment->fund_raising_close_date->toDateString()}}" placeholder="DD/MM/YYYY">
					</div>
					<div class="col-md-5 col-md-offset-3 col-sm-6">
						@if($project->projectconfiguration->show_project_progress_image)
						@if($project->media->where('type', 'project_progress_circle_image')->count())
						<div>
							<center><img src="{{asset($project->media->where('type', 'project_progress_circle_image')->last()->path)}}" style="position:relative;max-height: 200px; max-width: 100%;"></center>
						</div>
						@endif
						@elseif($project->projectconfiguration->show_project_progress_circle)
						<div id="circle" class="days-left-circle">
							<div class="text-center" style="color:#fff">
								<div class="circle" data-size="140" data-thickness="15" data-reverse="true" style="max-height: 140px;">
									<div class="text-center"  style="color:#fff; position:relative; bottom:100px;">
										<p style="color: #fff; font-size: 1.6em; margin: 0 0 -5px;">
											<span id="daysremained" style="color: #fff;"></span>
											<br>
											<p style="font-size: 1.1em; margin: 0 0 -3px;" class="h1-faq avoid-p-color">Days Left</p>
										</p>
									</div>
								</div>
							</div>
						</div>
						@else
						@endif
					</div>
				</div><br>
				<div class="row">
					<div class="col-md-4">
						<div class="" style="color:#fff;">
							@if($project->investment)
							<div class="row text-left">
								<div class="col-md-3 col-sm-3 col-xs-3" style="border-right: thin solid #ffffff;">
									<h4 class="font-bold project-min-investment-field" style="font-size:1.375em;color:#fff; display: -webkit-box;">
										$<input type="number" name="project_min_investment_txt" class="form-control" value="{{(int)$project->investment->minimum_accepted_amount}}" @if($project->eoi_button) step="5" @else step="100" @endif style="width: 60px; padding-left: 2px; padding-right: 2px;" @if($project->eoi_button) min="5" @else min="100" @endif>
									</h4><h6 class="font-regular" style="font-size: 0.875em;color: #fff">Min Invest</h6>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-3" style="border-right: thin solid #ffffff;">
									<h4 class="font-bold project-hold-period-field" style="font-size:1.375em;color:#fff;">
										<input type="text" name="project_hold_period_txt" class="form-control" value="{{$project->investment->hold_period}}" style="padding-left: 2px; padding-right: 2px;">
									</h4><h6 class="font-regular" style="font-size: 0.875em; color: #fff;">Months</h6>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-3" style="@if($project->projectconfiguration->show_project_investor_count)border-right: thin solid #ffffff; @endif">
									<h4 class="font-bold project-returns-field" style="width: 55px; font-size:1.375em;color:#fff; display: -webkit-box;">
										<input type="text" name="project_returns_txt" class="form-control" value="{{$project->investment->projected_returns}}" style="padding-left: 2px; padding-right: 2px;">%
									</h4>
									<h6 class="font-regular @if(Auth::guest()) @else @if(App\Helpers\SiteConfigurationHelper::isSiteAdmin()) edit-project-page-labels @endif @endif" style="font-size: 0.875em;color: #fff" effect="expected_return_label_text">{{$project->projectconfiguration->expected_return_label_text}}</h6>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-3 project_investor_count" @if(!$project->projectconfiguration->show_project_investor_count) style="display:none;" @endif>
									<h4 class="text-left font-bold" style="font-size:1.375em;color:#fff; ">
										@if($project->investment) {{$number_of_investors}} @else ### @endif
									</h4>
									<h6 class="font-regular" style="font-size: 0.875em;color: #fff">Investors</h6>
								</div>
							</div>
							@endif
						</div>

						<div class="project-progress-section" style="@if(!$project->projectconfiguration->show_project_progress) display: none; @endif">
							<div class="progress" style="height:10px; border-radius:0px;background-color:#cccccc; margin: 10px 0 20px;">
								<div class="progress-bar progress-bar-warning second_color_btn" role="progressbar" aria-valuenow="{{$completed_percent}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$completed_percent}}%">
								</div>
							</div>
							<span class="font-regular" style="font-size:1em;color:#fff; margin-top:-10px;">
								@if($project->investment)
								${{number_format($pledged_amount)}} raised of $<span class="project-goal-amount-field">
									<input type="text" name="project_goal_amount" class="form-control" style="width:30%" value="{{round($project->investment->goal_amount)}}" style="padding-left: 2px; padding-right: 2px;" required="required"></span>
									@endif
								</span>
							</div>
						</div>
						<div class="col-md-4 col-md-offset-4 project-invest-button-field" style="margin-top:0%;" id="express_interest">
							<span style="color: white;">Invest Now Button Label</span>
							<input type="text" name="project_button_invest_txt" class="form-control" value="{{$project->button_label}}" style="font-size: 25px;" placeholder="Button text">
						</div>
					</div>
				</div>
			</div>
		</section>
		<h6 style="color: #707070; font-size: 14px; margin-bottom: 1.2em;">@if($project->edit_disclaimer) {{$project->edit_disclaimer}} @else ** The information provided on this webpage is only a summary of the offer and may not contain all the information needed to determine if this offer is right for you. You should read the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ($siteConfiguration->prospectus_text!='') {{$siteConfiguration->prospectus_text}} @else Prospectus @endif in its entirety which can be downloaded in the Downloads section below as well as on the Project application page once you press the @if($project->button_label){{$project->button_label}}@else{{'Interest'}}@endif button. @if($project->add_additional_disclaimer){{$project->add_additional_disclaimer}} @endif @endif</h6>
		<div class="container-fluid">
			<div class="col-md-12">
				<textarea class="form-control text-textarea" name="add_disclaimer_txt" rows="3" placeholder="Edit Disclaimer" title="Edit Disclaimer" required="required">@if($project->edit_disclaimer) {{$project->edit_disclaimer}} @else ** The information provided on this webpage is only a summary of the offer and may not contain all the information needed to determine if this offer is right for you. You should read the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ($siteConfiguration->prospectus_text!='') {{$siteConfiguration->prospectus_text}} @else Prospectus @endif in its entirety which can be downloaded in the Downloads section below as well as on the Project application page once you press the @if($project->button_label){{$project->button_label}}@else{{'Interest'}}@endif button. @if($project->add_additional_disclaimer){{$project->add_additional_disclaimer}} @endif @endif</textarea>
				<br>
			</div>
		</div>
		<section @if($project->eoi_button) style="display: none;" @endif>
			<div class="container-fluid">
				<div class="row" style="background-color:#E6E6E6;">
					<div class="col-md-10 col-md-offset-1">
						<h2 class="download-text first_color">Downloads</h2><br>
						<div class="row">
							<div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="40" style="position: initial;">
								<span style="font-size:1.7em;" class="project-pds1-link-field">
									<input type="text" name="project_prospectus_txt" class="form-control" value="{{$project->project_prospectus_text}}" style="font-size: 25px;" placeholder="Title" data-toggle="tooltip" title="This will replace all instances of Prospectus with the word you type for that particular project"><textarea name="project_pds1_link_txt" class="form-control" placeholder="PDS Document Link" @if(Auth::check()) value="@if($project->investment){{$project->investment->PDS_part_1_link}}@endif" @endif>@if(Auth::check()) @if($project->investment){{$project->investment->PDS_part_1_link}}@endif @endif</textarea>
								</span>
								@if(Auth::user())
								@if(App\Helpers\SiteConfigurationHelper::isSiteAdmin())
								<h4 style="color: #000;">Upload Prospectus Document
								</h4>
								<div class="row">
									<div class="col-md-12">
										<input type="file" name="prospectusDocument" value="{{$project->document}}">
										@foreach($project->documents as $document)
										@if($document->type == 'ProspectusDocument')
										{{$document->filename}}
										@endif
										@endforeach
									</div>
								</div>
								@endif
								@endif
							</div>
						</div>
						<hr>
						<h3 class="download-text first_color">Reference Documents</h3><br>
						<div class="add-doc-ref-section">
							<a href="" class="add-doc-ref-fields">Add new Link</a>
							<input type="hidden" name="add_doc_ref_count" id="add_doc_ref_count" @if($project->documents) value="{{$project->documents->where('type','reference_document')->where('project_site', url())->count()}}" @else value="0" @endif>
						</div>
						<div class="doc-references">
							@if($project->documents)
							@foreach($project->documents->where('type','reference_document')->where('project_site', url())->all() as $document)
							<div class="col-md-3 text-left">
								<img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30" style="position: initial;">
								<input type="text" name="doc_ref_title[]" class="form-control" placeholder="Title" value="{{$document->filename}}">
								<input type="text" name="doc_ref_link[]" class="form-control" placeholder="Document Link" @if(Auth::check()) value="{{$document->path}}" @endif>
							</div>
							@endforeach
							@endif
						</div>
						<br><br>
					</div>
				</div>
			</div>
		</section>
		<br>
		<ul class="nav nav-tabs text-center">
			<li class="active " style="width: 50%; font-size: 1.5em;"><a class="show-project-details-tab-input" data-toggle="tab" href="#home" style="padding: 15px 15px;">@if($project->projectconfiguration){{$project->projectconfiguration->project_details_tab_label}} @else Project Details @endif</a></li>
			<li style="width: 49%; font-size: 1.5em;" ><a class="show-project-progress-tab-input" data-toggle="tab" href="#menu1" style="padding: 15px 15px;">@if($project->projectconfiguration){{$project->projectconfiguration->project_progress_tab_label}} @else Project Progress @endif</a></li>
		</ul>
		<div class="tab-content">
			<div id="home" class="tab-pane fade in active">
				<section>
					<div class="container">
						@if($project->media->where('type', 'gallary_images')->first())
						<div id="myCarousel" class="" data-ride="carousel" style="margin-top: 20px;">
							<!-- Indicators -->
							<ol class="carousel-indicators">
								{{-- <li data-target="#myCarousel" data-slide-to="0" class="active"></li> --}}
								@foreach($project->media->where('type','gallary_images') as $photos)
								<li data-target="#myCarousel" data-slide-to=""></li>
								@endforeach
							</ol>
							<!-- Wrapper for slides -->
							<div class="carousel-inner" role="listbox" style="height: 500px;">
								@foreach($project->media->chunk(1) as $set)
								@foreach($set as $photo)
								@if($photo->type === 'gallary_images')
								<div class="item">
									<img src="/{{$photo->path}}" alt="{{$photo->caption}}" alt="Chania" style="max-height: 500px;">
								</div>
								@endif
								@endforeach
								@endforeach
							</div>
							<!-- Left and right controls -->
							<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
								<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
						@endif
					</div>
				</section>
				<br><br>
				<div class="row" style="margin-left: 5em;">
					<div class="form-group @if($errors->first('investments_structure_video_url')){{'has-error'}} @endif">
						{!!Form::label('investments_structure_video_url', 'Investment Structure Video URL', array('class'=>'col-sm-2 control-label'))!!}
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-5 @if($errors->first('investments_structure_video_url')){{'has-error'}} @endif">
									<div class="">
										{!! Form::text('investments_structure_video_url', $project->investment?$project->investment->investments_structure_video_url:null, array('placeholder'=>'Investment Structure Video URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
										{!! $errors->first('investments_structure_video_url', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<section class="chunk-box @if($project->investment->investments_structure_video_url == "") hide @endif">
					<div class="container">
						<div class="row">
							<div class="col-md-offset-1 col-md-10">
								<h2 class="text-center first_color" style="font-weight:100">EXPLAINER <span>VIDEO</span></h2>
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
				<section>
					<div class="container">
						<div class="row show_project_summary_whole_section" @if(!$project->projectconfiguration->show_project_summary_whole_section) style="display: none;" @endif>
							<div class="col-md-12">
								<h2 class="text-center first_color show-project-summary-input" style="font-size:2.625em;color:#282a73;">@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->project_summary_label))}}@else Project Summary @endif</h2>
								<br>
								<div class="row show_summary_section" @if(!$project->projectconfiguration->show_summary_section) style="display: none;" @endif>
									<div class="col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'summary_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_summary.png')}}@endif" alt="for whom" style="width:50px;" >
										<h4 class="second_color show-summary-input" style="margin-top:30px; color:#fed405; font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->summary_label}}@else Summary @endif</h4>
									</div>
									<div class="col-md-10 text-left">
										@if($project->investment) <p style="font-size:0.875em;" class="project-summary-field"><textarea name="project_summary_txt" rows="3" class="form-control" placeholder="Enter Summary">{{$project->investment->summary}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','summary')->last())
											<img src="{{asset($project->media->where('type', 'summary')->last()->path)}}" style="max-width: 100%;" alt="Summary" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
								<br>
								<div class="row show_project_security_section" @if(!$project->projectconfiguration->show_project_security_section) style="display: none;" @endif>
									<div class="col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'security_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_security.png')}}@endif" alt="security_long" style="width:50px;">
										<h4 class="second_color show-security-input" style="margin-bottom:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->security_label}}@else Security @endif</h4>
									</div>
									<div class="col-md-10 text-left">
										@if($project->investment) <p style="margin-top:0px;font-size:0.875em;" class="project-security-long-field"><textarea name="project_security_long_txt" rows="3" class="form-control" placeholder="Enter Security Details">{{$project->investment->security_long}}</textarea></p>@endif
										<div>
											@if($projectMediaImage=$project->media->where('type','security')->last())
											<img src="{{asset($project->media->where('type', 'security')->last()->path)}}" style="max-width: 100%" alt="Security" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
								<br>
								<div class="row show_investor_distribution_section" @if(!$project->projectconfiguration->show_investor_distribution_section) style="display: none;" @endif>
									<div class="col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'investor_distribution_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_investor_distribution.png')}}@endif" alt="exit" style="width: 50px; ">
										<h4 class="second_color show-investor-distribution-input" style="margin-top:30px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->investor_distribution_label}}@else Investor<br> Distribution @endif</h4>
									</div>
									<div class="col-md-10 text-left">
										@if($project->investment) <p style="font-size:0.875em;" class="project-investor-distribution-field"><textarea name="project_investor_distribution_txt" class="form-control" rows="4" placeholder="Enter Investor Distribution Details">{{$project->investment->exit_d}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','exit_image')->last())
											<img src="{{asset($project->media->where('type', 'exit_image')->last()->path)}}" style="max-width: 100%" alt="Exit"  id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
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
						<div class="row show_suburb_whole_section" @if(!$project->projectconfiguration->show_suburb_whole_section) style="display: none;" @endif>
							<div class="col-md-12">
								<h2 class="text-center first_color show-suburb-profile-input" style="font-size:2.625em;color:#282a73;">@if($project->projectconfiguration){{$project->projectconfiguration->suburb_profile_label}}@else Suburb Profile @endif </h2>
								<br>
								<br><br>
								<div class="set_zoom"></div> <!-- Set Map Default Zoom Level -->
								@if($project->projectconfiguration)
								@if($project->projectconfiguration->show_suburb_profile_map)
								<div class="row">
									<div class="col-md-12">
										<div id="map" data-role="page" ></div>
										<address class="text-center"><p style="font-size:15px;">{{$project->location->line_1}}, <!-- {{$project->location->line_2}}, --> {{$project->location->city}}, {{$project->location->postal_code}}, {{$project->location->country}}</p></address>
									</div>
								</div>
								@endif
								@endif
								<br><br>
								<div class="address-update">
									<section> <div class="row well"> <div class="col-md-12"> <fieldset> <div class="row"> <div class="form-group @if($errors->first('line_1') && $errors->first('line_2')){{'has-error'}} @endif"> {!!Form::label('line_1', 'Lines', array('class'=>'col-sm-2 control-label'))!!} <div class="col-sm-9"> <div class="row"> <div class="col-sm-6 @if($errors->first('line_1')){{'has-error'}} @endif"> {!! Form::text('line_1', $project->location->line_1, array('placeholder'=>'line 1', 'class'=>'form-control', 'tabindex'=>'3')) !!} {!! $errors->first('line_1', '<small class="text-danger">:message</small>') !!} </div> <div class="col-sm-6 @if($errors->first('line_2')){{'has-error'}} @endif"> {!! Form::text('line_2', $project->location->line_2, array('placeholder'=>'line 2', 'class'=>'form-control', 'tabindex'=>'4')) !!} {!! $errors->first('line_2', '<small class="text-danger">:message</small>') !!} </div> </div> </div> </div> </div> <div class="row"> <div class="form-group @if($errors->first('city') && $errors->first('state')){{'has-error'}} @endif"> {!!Form::label('city', 'City', array('class'=>'col-sm-2 control-label'))!!} <div class="col-sm-9"> <div class="row"> <div class="col-sm-6 @if($errors->first('city')){{'has-error'}} @endif"> {!! Form::text('city', $project->location->city, array('placeholder'=>'City', 'class'=>'form-control', 'tabindex'=>'5')) !!} {!! $errors->first('city', '<small class="text-danger">:message</small>') !!} </div> <div class="col-sm-6 @if($errors->first('state')){{'has-error'}} @endif"> {!! Form::text('state', $project->location->state, array('placeholder'=>'state', 'class'=>'form-control', 'tabindex'=>'6')) !!} {!! $errors->first('state', '<small class="text-danger">:message</small>') !!} </div> </div> </div> </div> </div> <div class="row"> <div class="form-group @if($errors->first('postal_code') && $errors->first('country')){{'has-error'}} @endif"> {!!Form::label('postal_code', 'postal code', array('class'=>'col-sm-2 control-label'))!!} <div class="col-sm-9"> <div class="row"> <div class="col-sm-6 @if($errors->first('postal_code')){{'has-error'}} @endif"> {!! Form::text('postal_code', $project->location->postal_code, array('placeholder'=>'postal code', 'class'=>'form-control', 'tabindex'=>'7')) !!} {!! $errors->first('postal_code', '<small class="text-danger">:message</small>') !!} </div> <div class="col-sm-6 @if($errors->first('country')){{'has-error'}} @endif"> <select name="country" class="form-control" tabindex="8"> @foreach(\App\Http\Utilities\Country::aus() as $country => $code) <option value="{{$code}}" @if($project->location->country_code == $code) selected @endif>{{$country}}</option> @endforeach </select> {!! $errors->first('country', '<small class="text-danger">:message</small>') !!} </div> </div> </div> </div> </div> </fieldset> </div> </div> </section>
								</div>

								<div class="row show_marketability_section" @if(!$project->projectconfiguration->show_marketability_section) style="display: none;" @endif>
									<div class="col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'marketability_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_marketability.png')}}@endif" alt="for whom" style="width:50px; ">
										<br><br>
										<h4 class="second_color show-marketability-input" style="margin-top:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->marketability_label}}@else Marketability @endif</h4>
									</div>
									<div class="col-md-10">
										@if($project->investment) <p class="text-left project-marketability-field" style="font-size:0.875em;"><textarea name="project_marketability_txt" class="form-control" rows="3" placeholder="Enter Marketability Details">{{$project->investment->marketability}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','marketability')->last())
											<img src="{{asset($project->media->where('type', 'marketability')->last()->path)}}" style="max-width:100%" alt="Marketability" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
								<br>
								<div class="row show_residents_section" @if(!$project->projectconfiguration->show_residents_section) style="display: none;" @endif>
									<div class="col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'residents_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_residents.png')}}@endif" alt="residents" style="width:50px; ">
										<br><br>
										<h4 class="second_color show-residents-input" style="margin-top:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->residents_label}}@else Residents @endif</h4>
									</div>
									<div class="col-md-10">
										@if($project->investment) <p class="text-left project-residents-field" style="font-size:0.875em;"><textarea name="project_residents_txt" class="form-control" rows="3" placeholder="Enter Residents">{{$project->investment->residents}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','residents')->last())
											<img src="{{asset($project->media->where('type', 'residents')->last()->path)}}" style="max-width: 100%;" alt="Image" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				@endif
				<section class="chunk-box ">
					<div class="container">
						<div class="row show_investment_whole_section" @if(!$project->projectconfiguration->show_investment_whole_section) style="display: none;" @endif>
							<div class="col-md-12">
								<h2 class="text-center first_color show-investment-profile-input" style="font-size:2.625em;color:#282a73;">@if($project->projectconfiguration){{$project->projectconfiguration->investment_profile_label}}@else Investment Profile @endif</h2>
								<br>
								<div class="row show_investment_type_section" @if(!$project->projectconfiguration->show_investment_type_section) style="display: none;" @endif>
									<div class=" col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'investment_type_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_type.png')}}@endif" alt="type" style="width:50px;"> <br><br>
										<h4 class="second_color show-investment-type-input" style="margin-top:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->investment_type_label}}@else Type @endif</h4><br>
									</div>
									<div class="col-md-10">
										@if($project->investment) <p class="project-investment-type-field" style="font-size:0.875em;"><textarea name="project_investment_type_txt" class="form-control" rows="3" placeholder="Investment type">{{$project->investment->investment_type}}</textarea></p>@endif
										<div>
											@if($projectMediaImage=$project->media->where('type','investment_type')->last())
											<img src="{{asset($project->media->where('type', 'investment_type')->last()->path)}}" style="max-width: 100%;" alt="investment_type" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
									<br>
								</div>
								<div class="row show_investment_security_section" @if(!$project->projectconfiguration->show_investment_security_section) style="display: none;" @endif>
									<div class="col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'security_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_security.png')}}@endif" alt="security" style="width:50px;"><br><br>
										<h4 class="second_color show-investment-security-input" style="margin-top:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->investment_security_label}}@else Security @endif</h4><br>
									</div>
									<div class="col-md-10">
										@if($project->investment) <p class=" project-security-field" style="font-size:0.875em;"><textarea name="project_security_txt" class="form-control" rows="3" placeholder="Investment Security">{{$project->investment->security}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','investment_security')->last())
											<img src="{{asset($project->media->where('type', 'investment_security')->last()->path)}}" style="max-width: 100%;" alt="investment_security" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
									<br>
								</div>
								<div class="row show_expected_return_section" @if(!$project->projectconfiguration->show_expected_return_section) style="display: none;" @endif>
									<div class="col-md-2 text-center" >
										<img src="@if($projMedia=$project->media->where('type', 'expected_returns_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_ExpectedReturns.png')}}@endif" alt="expected returns" style="width:50px;"><br><br>
										<h4 class="second_color show-expected-returns-input" style="margin-top:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->expected_returns_label}}@else Expected<br> Returns @endif</h4>
									</div>
									<div class="col-md-10">
										@if($project->investment) <p class=" project-expected-returns-field" style="font-size:0.875em;"><textarea name="project_expected_returns_txt" class="form-control" rows="3" placeholder="Expected Returns">{{$project->investment->expected_returns_long}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','expected_returns')->last())
											<img src="{{asset($project->media->where('type', 'expected_returns')->last()->path)}}" style="max-width: 100%;" alt="expected returns" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
								<div class="row show_return_paid_as_section" @if(!$project->projectconfiguration->show_return_paid_as_section) style="display: none;" @endif>
									<div class="col-md-2 text-center" >
										<img src="@if($projMedia=$project->media->where('type', 'returns_paid_as_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_ReturnPaidAs.png')}}@endif" alt="returns paid as" style="width:50px;"><br><br>
										<h4 class="second_color show-return-paid-as-input" style="margin-top:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->return_paid_as_label}}@else Returns<br> Paid As @endif</h4>
									</div>
									<div class="col-md-10">
										@if($project->investment) <p class=" project-return-paid-as-field" style="font-size:0.875em;"><textarea name="project_return_paid_as_txt" class="form-control" rows="3" placeholder="Return paid as">{{$project->investment->returns_paid_as}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','return_paid_as')->last())
											<img src="{{asset($project->media->where('type', 'return_paid_as')->last()->path)}}" style="max-width: 100%;" alt="return pais as image" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
								<div class="row show_taxation_section" @if(!$project->projectconfiguration->show_taxation_section) style="display: none;" @endif>
									<div class="col-md-2 text-center" >
										<img src="@if($projMedia=$project->media->where('type', 'taxation_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_Taxation.png')}}@endif" alt="Taxation" style="width:50px;"><br><br>
										<h4 class="second_color show-taxation-input" style="margin-top:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->taxation_label}}@else Taxation @endif</h4><br>
									</div>
									<div class="col-md-10">
										@if($project->investment) <p class=" project-taxation-field" style="font-size:0.875em;"><textarea name="project_taxation_txt" class="form-control" rows="3" placeholder="Taxation">{{$project->investment->taxation}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','taxation')->last())
											<img src="{{asset($project->media->where('type', 'taxation')->last()->path)}}" style="max-width: 100%;" alt="taxation image" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<section class="chunk-box">
					<div class="container">
						<div class="row show_project_profile_whole_section" @if(!$project->projectconfiguration->show_project_profile_whole_section) style="display: none;" @endif>
							<div class="col-md-12">
								<h2 class="text-center first_color show-project-profile-input" style="font-size:2.625em;color:#282a73;">@if($project->projectconfiguration){{$project->projectconfiguration->project_profile_label}}@else Project Profile @endif </h2>
								<br>
								<div class="row show_developer_section" @if(!$project->projectconfiguration->show_developer_section) style="display: none;" @endif>
									<div class="col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'developer_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_developer.png')}}@endif" alt="proposer" style="width:50px;"> <br>
										@if($project->property_type == "1")
										<h4 class="second_color show-developer-input" style="margin-bottom:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->developer_label}}@else Developer @endif</h4><br>
										@else
										<h4 class="second_color show-venture-input" style="margin-bottom:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->venture_label}}@else Venture @endif</h4><br>
										@endif
									</div>
									<div class="col-md-10 text-left">
										@if($project->investment) <p style="font-size:0.875em;" class="project-developer-field"><textarea name="project_developer_txt" class="form-control" rows="3" placeholder="Developer">{{$project->investment->proposer}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','project_developer')->last())
											<img src="{{asset($project->media->where('type', 'project_developer')->last()->path)}}" alt="Developer" style="padding:1em;" style="width:40px;" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
								<br>
								<div class="row show_duration_section" @if(!$project->projectconfiguration->show_duration_section) style="display: none;" @endif>
									<div class="col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'duration_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_Duration.png')}}@endif" alt="duration" style="width:50px;">
										<h4 class="second_color show-duration-input" style="margin-bottom:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->duration_label}}@else Duration @endif</h4><br>
									</div>
									<div class="col-md-10 text-left">
										@if($project->investment) <p style="font-size:0.875em;">{!!$project->investment->hold_period!!} Months</p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','project_duration')->last())
											<img src="{{asset($project->media->where('type', 'project_duration')->last()->path)}}" style="max-width: 100%;" alt="Duration" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
								<br>
								<div class="row show_current_status_section" @if(!$project->projectconfiguration->show_current_status_section) style="display: none;" @endif>
									<div class="col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'current_status_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_Current_status.png')}}@endif" alt="current_status" style="width:50px;">
										<h4 class="second_color show-current-status-input" style="margin-bottom:0px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->current_status_label}}@else Current Status @endif</h4><br>
									</div>
									<div class="col-md-10 text-left">
										@if($project->investment) <p style="font-size:0.875em;" class="project-current-status-field"><textarea name="project_current_status_txt" class="form-control" rows="3" placeholder="Current Status">{{$project->investment->current_status}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','current_status')->last())
											<img src="{{asset($project->media->where('type', 'current_status')->last()->path)}}" style="max-width: 100%;" alt="current status" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
								<div class="row show_rationale_section" @if(!$project->projectconfiguration->show_rationale_section) style="display: none;" @endif>
									<div class="col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'rationale_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_Rationale.png')}}@endif" alt="rationale" style="width:50px;">
										<h4 class="second_color show-rationale-input" style="margin-top:30px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->rationale_label}}@else Rationale @endif</h4><br>
									</div>
									<div class="col-md-10 text-left">
										@if($project->investment) <p style="font-size:0.875em;" class="project-rationale-field"><textarea name="project_rationale_txt" class="form-control" rows="3" placeholder="Rationale">{{$project->investment->rationale}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','rationale')->last())
											<img src="{{asset($project->media->where('type', 'rationale')->last()->path)}}" alt="rationale" style="max-width: 100%;" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
								<div class="row show_risk_section" @if(!$project->projectconfiguration->show_risk_section) style="display: none;" @endif>
									<div class="col-md-2 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'investment_risk_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_risk.png')}}@endif" alt="risk" style="width:50px;">
										<h4 class="second_color show-risk-input" style="margin-top:30px; color:#fed405;font-size:1.375em;">@if($project->projectconfiguration){{$project->projectconfiguration->investment_risk_label}}@else Risk @endif</h4><br>
									</div>
									<div class="col-md-10 text-left">
										@if($project->investment) <p style="font-size:0.875em;" class="project-risk-field"><textarea name="project_risk_txt" class="form-control" rows="3" placeholder="Risk">{{$project->investment->risk}}</textarea></p> @endif
										<div>
											@if($projectMediaImage=$project->media->where('type','investment_risk')->last())
											<img src="{{asset($project->media->where('type', 'investment_risk')->last()->path)}}" alt="investment risk" style="max-width: 100%;" id="project_media_{{$projectMediaImage->id}}">
											@endif
										</div>
									</div>
								</div>
								<br><br>
							</div>
						</div>
					</div>
				</section>

				<section>
					<div class="container">
						<div class="row">
							<br>
							<div class="col-md-6 @if($project->eoi_button) hide @endif">
								<div class="row show_how_to_invest_whole_section" @if(!$project->projectconfiguration->show_how_to_invest_whole_section) style="display: none;" @endif>
									<div class="col-md-12 text-center">
										<img src="@if($projMedia=$project->media->where('type', 'how_to_invest_image')->first()){{asset($projMedia->path)}}@else{{asset('assets/images/new_how_to_invest.png')}}@endif" alt="exit" width="110px" /><br><br>
										<h4 class="second_color" style="margin-bottom:0px; color:#fed405;font-size:42px;">How To Invest</h4><br>
										@if($project->investment)<p class="project-how-to-invest-field"><textarea name="project_how_to_invest_txt" class="form-control" rows="3" placeholder="How to invest">{{$project->investment->how_to_invest}}</textarea></p> @endif

										@if($project->investment)
										<div class="row">
											<div class="col-md-10 col-md-offset-1 text-justify">
												<h5>
													@if($project->projectconfiguration->payment_switch)
													<h5 class="text-center">
														Please read the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ($siteConfiguration->prospectus_text!='') {{$siteConfiguration->prospectus_text}} @else Prospectus @endif and complete and submit the online Application Form by clicking the SUBMIT APPLICATION button. Please make payment via EFT within 48 hours of completing the Application Form. Alternatively please contact us should you wish to make payment using Cheque.
													</h5>
													@else
													<table class="table table-responsive font-bold" style="color:#2d2d4b;">
														<tr><td>Bank</td><td class="bank-name-field"><input type="text" value="{!!$project->investment->bank!!}" id="bank_name" name="bank_name"></td></tr>
														<tr><td>Account Name</td><td class="account-name-field"><input type="text" value="{!!$project->investment->bank_account_name!!}" id="account_name" name="account_name"></td></tr>
														<tr><td>BSB </td><td class="bsb-name-field"><input type="text" value="{!!$project->investment->bsb!!}" id="bsb_name" name="bsb_name"></td></tr>
														<tr><td>Account No</td><td class="account-number-field"><input type="text" value="{!!$project->investment->bank_account_number!!}" id="account_number" name="account_number"></td></tr>
														<tr><td>SWIFT code</td><td class="swift-code-field"><input type="text" value="{!!$project->investment->swift_code!!}" id="swift_code" name="swift_code"></td></tr>
														<tr><td>Reference</td><td class="bank-reference-field"><input type="text" value="{!!$project->investment->bank_reference!!}" id="bank_reference" name="bank_reference"></td></tr>
													</table>
													<h3 class="text-center second_color">Or pay using Bitcoin</h3><br>
													<table class="table table-responsive font-bold" style="color:#2d2d4b;">
														<tr><td>Bitcoin Wallet Address</td><td class="bitcoin-wallet-address-field"><input type="text" value="{!!$project->investment->bitcoin_wallet_address!!}" id="bitcoin_wallet_address" name="bitcoin_wallet_address"></td></tr>
													</table>
													<div class="btcwdgt-price" bw-theme="light" bw-cur="aud" style="margin: auto !important;"></div>
													@endif
												</h5>
											</div>
										</div>
										@endif
										<br>
										<div class="col-md-10 col-md-offset-1">
											@if($project->investment)
											<a href="{{route('projects.interest', $project)}}" style="font-size:1.375em;letter-spacing:2px; border-radius: 50px !important;" class="btn btn-block btn-n1 btn-lg pulse-button text-center second_color_btn @if(!$project->show_invest_now_button) disabled @endif btn-hover-default-color" @if(Auth::user() && Auth::user()->investments->contains($project))  @endif><b>
												@if($project->button_label)
												<?php echo $project->button_label; ?>
												@else
												Invest Now
												@endif
											</b></a>
											<h6><small style="font-size:0.85em; color:#999;">* Note that this is a No Obligation Expression of interest, you get to review the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ($siteConfiguration->prospectus_text!='') {{$siteConfiguration->prospectus_text}} @else Prospectus @endif  before making any decisions</small></h6>
											@else
											<a href="{{route('projects.interest', [$project])}}" class="btn btn-block btn-primary" disabled>NO Investment Policy Yet</a>
											@endif
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="show_project_faqs_whole_section" @if(!$project->projectconfiguration->show_project_faqs_whole_section) style="display: none;" @endif>
									<h2 class="text-center second_color" style="font-size:42px;color:#282a73;">Project FAQs</h2>
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
					</div>
				</section>
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
						</div>
					</div>
				</div>
			</div>
			@if(Auth::guest())
			@else
			@if(App\Helpers\SiteConfigurationHelper::isSiteAdmin())
		</form>
		@endif
		@endif
		@if(Auth::guest())
		@else
		@if(App\Helpers\SiteConfigurationHelper::isSiteAdmin())
		<div class="project-faq">
			<div class="container">
				<div class="row well">
					<div class="col-md-12">
						<div class="row">
							@foreach($project->projectFAQs as $faq)
							<div class="col-md-offset-2 col-md-7">
								<b>{{$faq->question}}</b>
								<!-- 								{{$faq->id}} -->
								<p class="text-justify">{{$faq->answer}}</p>
							</div>
							<div class="col-md-2">
								{!! Form::open(['route' => ['projects.destroy', $faq->id, $project->id],'id'=>'faq_form_'.$faq->id]) !!}
								<button class="btn btn-danger" id="delete_faq_{{$faq->id}}">Delete this FAQ?</button>
								{!! Form::close() !!}
							</div>
							<script>
								$(document).ready(function() {
									$('#delete_faq_{{$faq->id}}').click(function(){
										$('#faq_form_{{$faq->id}}').submit();
									});
								});
							</script>
							@endforeach
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								{!! Form::open(array('route'=>['projects.faq', $project->id], 'class'=>'form-horizontal', 'role'=>'form','id'=>'add_new_faq')) !!}
								<fieldset>
									<div class="row">
										<div class="form-group @if($errors->first('question')){{'has-error'}} @endif">
											{!!Form::label('question', 'Question', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-12 @if($errors->first('question')){{'has-error'}} @endif">
														{!! Form::text('question', null, array('placeholder'=>'Question', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
														{!! $errors->first('question', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group @if($errors->first('answer')){{'has-error'}} @endif">
											{!!Form::label('answer', 'Answer', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-12 @if($errors->first('answer')){{'has-error'}} @endif">
														{!! Form::textarea('answer', null, array('placeholder'=>'Answer', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
														{!! $errors->first('answer', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-9">
												{{-- {!! Form::submit('Add New FAQ', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'7')) !!} --}}
												<button class="btn btn-danger" id="add_faq">Add New FAQ</button>
											</div>
										</div>
									</div>
								</fieldset>
								{!! Form::close() !!}
								<script>
									$(document).ready(function() {
										$('#add_faq').click(function(){
											$('#add_new_faq').submit();
										});
									});
								</script>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
		@endif
	</div>
	<div id="menu1" class="tab-pane fade" style="color: #000;">
		<div class="container">
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
						<td>{{date("d/m/Y",strtotime($project_progs->updated_date))}}
						</td>
						<td>{{$project_progs->progress_description}} </td>
						<td>{{$project_progs->progress_details}}
							<br>
							<a href="{{$project_progs->video_url}}" target="_blank">{{$project_progs->video_url}}</a>
							@if($project_progs->image_path != '')
							<div class="row">
								<div class="col-md-10 change_column">
									<div class="thumbnail">
										<img src="{{asset($project_progs->image_path)}}" class="img-responsive">
									</div>
								</div>
							</div>
							@endif
							@if($project_progs->video_url != '')
							<iframe class="embed-responsive-item" width="100%" height="100%" src="{{$project_progs->video_url}}" frameborder="0" allowfullscreen></iframe>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
{{-- @if(Auth::user())
@if(App\Helpers\SiteConfigurationHelper::isSiteAdmin())
<h3 style="color: #000;">Upload a Images</h3>
<div class="row">
<div class="col-md-12">
{!! Form::open(array('route'=>['configuration.uploadprogress', $project->id], 'class'=>'form-horizontal dropzone', 'role'=>'form', 'files'=>true)) !!}
{!! Form::close() !!}
</div>
</div>
@endif
@endif--}}
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
						<input type="hidden" name="project_id" id="project_i" value="{{$project->id}}">
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-touchspin/3.1.2/jquery.bootstrap-touchspin.js"></script> <!-- Bootstrap Touchspin Plugin for Zoom feature for admin maps -->
<!-- Summernote editor -->
{!! Html::script('/assets/plugins/summernote/summernote.min.js') !!}
<!-- Tooltip effect-->
<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>
{{-- Code for Bitcoin Widget --}}
<script>
	(function(b,i,t,C,O,I,N) {
		window.addEventListener('load',function() {
			if(b.getElementById(C))return;
			I=b.createElement(i),N=b.getElementsByTagName(i)[0];
			I.src=t;I.id=C;N.parentNode.insertBefore(I, N);
		},false)
	})(document,'script','https://widgets.bitcoin.com/widget.js','btcwdgt');
</script>
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
		$('.item').first().addClass('active');
		$('.carousel-indicators > li').first().addClass('active');
		var daysPassedCheck=0;
		@if($project->investment && $project->investment->fund_raising_close_date)
		fund_close_date = new Date({{date('Y,m-1,d', strtotime($project->investment->fund_raising_close_date))}});
		var now = new Date();
		totalDays = {{$project->investment->fund_raising_close_date->diffInDays()}} + {{$project->investment->fund_raising_start_date->diffInDays()}};
		if(fund_close_date < now) {
			var closeYear = fund_close_date.getFullYear();
			var closeMonth = fund_close_date.getMonth()+1;
			var closeDate = fund_close_date.getDate();
			if((closeYear == now.getFullYear()) && (closeMonth == eval(now.getMonth()+1)) && (closeDate == now.getDate())){
				daysPassedCheck = 0;
			} else {
				daysPassedCheck = 1;
			}
			diffinDays = 0;
		}
		else {
			if(totalDays > 0){
				diffinDays = {{ $project->investment->fund_raising_close_date->diffInDays() }} / totalDays;
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
			}, 6000);
		} else {
			$('#section-colors-left').toggleClass('panel-open-left panel-close-left');
		}
		var mq = window.matchMedia("(min-width: 1140px)");
		if(mq.matches){
		}else{
			$('#section-colors').addClass('hide');
			$('#section-colors-left').addClass('hide');
			// $('#section-colors-right').addClass('hide');
			$('#containernav').removeClass('container');
			$('#containernav').addClass('container-fluid');
		}
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
		});

		@if(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->show_splash_page)
		@if(Auth::check())
		@else
		window.setInterval(function(){
			window.location = "/welcome?next=projects/{{$project->id}}"
		},5000);
		@endif
		@endif

		//Overlay Opacity
		@if($color)
		@if($color->nav_footer_color)
		var hexColor = '{{trim($color->nav_footer_color)}}';
		var rgb = hex2rgb(hexColor);
		var rgbaColor = 'rgba('+rgb[0]+', '+rgb[1]+', '+rgb[2]+', {{$project->projectconfiguration->overlay_opacity}})';
		$('.main-fold-overlay-color').css('background', rgbaColor);
		@else
		var rgbaColor = 'rgba(45, 45, 75, {{$project->projectconfiguration->overlay_opacity}})';
		$('.main-fold-overlay-color').css('background', rgbaColor);
		@endif
		@else
		var rgbaColor = 'rgba(45, 45, 75, {{$project->projectconfiguration->overlay_opacity}})';
		$('.main-fold-overlay-color').css('background', rgbaColor);
		@endif

		//Edit Project Page Details by Admin
		editProjectPageDetailsByAdmin();
		//Edit Project Page Background Image
		editProjectPageBackImg();
		//Edit Project Page Thumbnails
		editProjectPageThumbImages();
		//HideShowMap
		toggleMapVisibility();
		//Edit Project Page Sub Headings
		editProjectPageSubHeadings();
		//upload sub section Images
		uploadSubSectionImages();
		//update main fold overlay opacity
		updateOverlayOpacity();
		//show-hide project page sub sections
		toggleSubSectionsVisibility();
		//Delete Sub section Images
		deleteSubSectionImages();
		//Delete Carousel Image
		deleteCarouselImage();
		//toggleProspectusText();
		toggleProjectProgress();
		toggleProjectElementsVisibiity();
		editProjectPageLabelText();
		togglePaymentSwitch();
		projectProgress();
		addDocRefFields();
		//Map Zoom feature for admin
		mapZoomFeature();

		$('#myCarousel').addClass('carousel slide');
	});

function editProjectPageDetailsByAdmin(){
	$('.save-project-details-floating-btn').click(function(e){
		$('.store-project-page-details-btn').trigger('click');
	});
}

function mapZoomFeature(){
	$('.set_zoom').html('<div class="form-group" style="width: 450px; float: left;"> <label for="demo2" class="col-md-4 control-label">Set Map Zoom Level (upto 22x):</label> <input id="demo2" type="number" value="{{nl2br(e($project->location->zoom_level))}}" name="zoom_level" class="col-md-8 form-control "> </div> </form>');
	$("input[name='zoom_level']").TouchSpin({
		min: 1,
		max: 22,
		stepinterval: 50,
		maxboostedstep: 10000000,
		postfix: 'X',
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

		$('#modal_close_btn').click(function(e){
			$('#projectpg_thumbnail_image, #projectpg_thumbnail_image_name').val('');
		});
	}

	function toggleMapVisibility(){
		$('#show_suburb_profile_map').change(function(){
			var showMap = $(this).is(':checked');
			var projectId = $('#current_project_id').val();
			$.ajax({
				url: '/configuration/project/saveShowMapStatus',
				type: 'POST',
				dataType: 'JSON',
				data: {showMap, projectId},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			}).done(function(data){
				console.log(data);
				location.reload('/');
			});
		});
	}

	function editProjectPageSubHeadings(){
		$('.edit-sub-headings').click(function(){
			$(this).attr('disabled', true);
			$('.save-sub-headings').show();
			$('.show-project-details-tab-input').html('<input type="text" name="project_details_tab_label" id="project_details_tab_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->project_details_tab_label))}}@endif" style="font-size: 22px; text-align:center" placeholder="Project Details">');
			$('.show-project-progress-tab-input').html('<input type="text" name="project_progress_tab_label" id="project_progress_tab_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->project_progress_tab_label))}}@endif" style="font-size: 22px; text-align:center" placeholder="Project Progress">')
			$('.show-project-summary-input').html('<input type="text" name="project_summary_label" id="project_summary_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->project_summary_label))}}@endif" style="font-size: 22px; text-align:center" placeholder="Project Summary">');
			$('.show-summary-input').html('<input type="text" name="summary_label" id="summary_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->summary_label))}}@endif"  placeholder="Summary">');
			$('.show-security-input').html('<input type="text" name="security_label" id="security_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->security_label))}}@endif"  placeholder="Security">');
			$('.show-investor-distribution-input').html('<input type="text" name="investor_distribution_label" id="investor_distribution_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->investor_distribution_label))}}@endif" placeholder="Investor Distribution">');
			$('.show-suburb-profile-input').html('<input type="text" name="suburb_profile_label" id="suburb_profile_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->suburb_profile_label))}}@endif" style="font-size: 22px; text-align:center" placeholder="Suburb Profile">');
			$('.show-marketability-input').html('<input type="text" name="marketability_label" id="marketability_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->marketability_label))}}@endif"  placeholder="Marketability">');
			$('.show-residents-input').html('<input type="text" name="residents_label" id="residents_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->residents_label))}}@endif"  placeholder="Residents">');
			$('.show-investment-profile-input').html('<input type="text" name="investment_profile_label" id="investment_profile_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->investment_profile_label))}}@endif" style="font-size: 22px; text-align:center" placeholder="Investment Profile">');
			$('.show-investment-type-input').html('<input type="text" name="investment_type_label" id="investment_type_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->investment_type_label))}}@endif"  placeholder="Type">');
			$('.show-investment-security-input').html('<input type="text" name="investment_security_label" id="investment_security_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->investment_security_label))}}@endif"  placeholder="Security">');
			$('.show-expected-returns-input').html('<input type="text" name="expected_returns_label" id="expected_returns_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->expected_returns_label))}}@endif"  placeholder="Expected Returns">');
			$('.show-return-paid-as-input').html('<input type="text" name="return_paid_as_label" id="return_paid_as_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->return_paid_as_label))}}@endif"  placeholder="Returns Paid As">');
			$('.show-taxation-input').html('<input type="text" name="taxation_label" id="taxation_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->taxation_label))}}@endif"  placeholder="Taxation">');
			$('.show-project-profile-input').html('<input type="text" name="project_profile_label" id="project_profile_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->project_profile_label))}}@endif" style="font-size: 22px; text-align:center" placeholder="Project Profile">');
			$('.show-developer-input').html('<input type="text" name="developer_label" id="developer_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->developer_label))}}@endif"  placeholder="Developer">');
			$('.show-venture-input').html('<input type="text" name="venture_label" id="venture_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->venture_label))}}@endif"  placeholder="Venture">');
			$('.show-duration-input').html('<input type="text" name="duration_label" id="duration_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->duration_label))}}@endif"  placeholder="Duration">');
			$('.show-current-status-input').html('<input type="text" name="current_status_label" id="current_status_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->current_status_label))}}@endif"  placeholder="Current Status">');
			$('.show-rationale-input').html('<input type="text" name="rationale_label" id="rationale_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->rationale_label))}}@endif"  placeholder="Rationale">');
			$('.show-risk-input').html('<input type="text" name="investment_risk_label" id="investment_risk_label" class="form-control check-input-empty" value="@if($project->projectconfiguration){{nl2br(e($project->projectconfiguration->investment_risk_label))}}@endif"  placeholder="Risk">');
		});

$('.save-sub-headings').click(function(){
	var project_details_tab_label = $('#project_details_tab_label').val();
	var project_progress_tab_label = $('#project_progress_tab_label').val();
	var project_summary_label = $('#project_summary_label').val();
	var summary_label = $('#summary_label').val();
	var security_label = $('#security_label').val();
	var investor_distribution_label = $('#investor_distribution_label').val();
	var suburb_profile_label = $('#suburb_profile_label').val();
	var marketability_label = $('#marketability_label').val();
	var residents_label = $('#residents_label').val();
	var investment_profile_label = $('#investment_profile_label').val();
	var investment_type_label = $('#investment_type_label').val();
	var investment_security_label = $('#investment_security_label').val();
	var expected_returns_label = $('#expected_returns_label').val();
	var return_paid_as_label = $('#return_paid_as_label').val();
	var taxation_label = $('#taxation_label').val();
	var project_profile_label = $('#project_profile_label').val();
	var developer_label = $('#developer_label').val();
	var venture_label = $('#venture_label').val();
	var duration_label = $('#duration_label').val();
	var current_status_label = $('#current_status_label').val();
	var rationale_label = $('#rationale_label').val();
	var investment_risk_label = $('#investment_risk_label').val();
	var labelIsEmpty = false;
	$('.check-input-empty').each(function(){
		if($(this).val() == ''){
			labelIsEmpty = true;
		}
	});
	if(!labelIsEmpty){
		var projectId = $('#current_project_id').val();
		$.ajax({
			url: '/configuration/project/updateProjectPageSubHeading',
			type: 'POST',
			dataType: 'JSON',
			data: {project_details_tab_label, project_progress_tab_label, projectId, project_summary_label, summary_label, security_label, investor_distribution_label, suburb_profile_label, marketability_label, residents_label, investment_profile_label, investment_type_label, investment_security_label, expected_returns_label, return_paid_as_label, taxation_label, project_profile_label, developer_label, venture_label, duration_label, current_status_label, rationale_label, investment_risk_label},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		}).done(function(data){
			console.log(data);
			location.reload('/');
		});
	} else {
		alert("Label Inputs can't be empty");
	}

});
}

function uploadSubSectionImages(){
	$('.upload-sub-section-img').click(function(){
		var imgType = $(this).attr('imgType');
		$('#project_sub_heading_image_type').val(imgType);
		$('#project_sub_heading_image').trigger('click');
	});
	$('#project_sub_heading_image').change(function(){
		if($('#project_sub_heading_image').val() != ''){
			var formData = new FormData();
			formData.append('project_sub_heading_image', $('#project_sub_heading_image')[0].files[0]);
			formData.append('imgType', $('#project_sub_heading_image_type').val());
			formData.append('projectId', {{$project->id}});
			$('.loader-overlay').show();
			$.ajax({
				url: '/project/edit/uploadSubSectionImages',
				type: 'POST',
				dataType: 'JSON',
				data: formData,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				contentType: false,
				processData: false
			}).done(function(data){
				if(data.status){
					console.log(data);
					location.reload('/');
				}
				else{
					$('#project_sub_heading_image_type').val('');
					$('#project_sub_heading_image').val('');
					alert(data.message);
					$('.loader-overlay').hide();
				}
			});
		}
	});
}

function updateOverlayOpacity(){
	$('.update-overlay-opacity').click(function(e){
		var action = $(this).attr('action');
		var projectId = '{{$project->id}}';
		$.ajax({
			url: '/configuration/project/updateProjectPgOverlayOpacity',
			type: 'POST',
			dataType: 'JSON',
			data: {action, projectId},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		}).done(function(data){
			if(data.status){
				console.log(data.opacity);
				@if($color)
				@if($color->nav_footer_color)
				var hexColor = '{{trim($color->nav_footer_color)}}';
				var rgb = hex2rgb(hexColor);
				var rgbaColor = 'rgba('+rgb[0]+', '+rgb[1]+', '+rgb[2]+', '+data.opacity+')';
				$('.main-fold-overlay-color').css('background', rgbaColor);
				@else
				var rgbaColor = 'rgba(45, 45, 75, '+data.opacity+')';
				$('.main-fold-overlay-color').css('background', rgbaColor);
				@endif
				@else
				var rgbaColor = 'rgba(45, 45, 75, '+data.opacity+')';
				$('.main-fold-overlay-color').css('background', rgbaColor);
				@endif
			}
		});
	});
}

function hex2rgb(hexStr){
	var hex = parseInt(hexStr, 16);
	var r = (hex & 0xff0000) >> 16;
	var g = (hex & 0x00ff00) >> 8;
	var b = hex & 0x0000ff;
	return [r, g, b];
}

function toggleSubSectionsVisibility(){
	$(".checkbox-switch").bootstrapSwitch();
	$('.checkbox-switch').on('switchChange.bootstrapSwitch', function () {
		var setVal = $(this).val() == 1? 0 : 1;
		$(this).val(setVal);
		$('#'+$(this).attr('action')).val(setVal);
		var checkValue = $(this).val();
		var action = $(this).attr('action');
		var projectId = '{{$project->id}}';
		$('.loader-overlay').show();
		$.ajax({
			url: '/configuration/project/toggleSubSectionsVisibility',
			type: 'POST',
			dataType: 'JSON',
			data: {checkValue, action, projectId},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		}).done(function(data){
			console.log(data);
			if(data.status){
				$('.loader-overlay').hide();
				$('.'+action).slideToggle();
			}
		});
	});
}

function deleteSubSectionImages(){
	$('.delete-project-section-image').click(function(){
		var mediaId = $(this).attr('action');
		var projectId = '{{$project->id}}';
		if(mediaId!=''){
			if (confirm('Are you sure ?')) {
				$('.loader-overlay').show();
				$.ajax({
					url: '/project/edit/deleteSubSectionImages',
					type: 'POST',
					dataType: 'JSON',
					data: {mediaId,projectId},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				}).done(function(data){
					if(data.status){
						$('#project_media_'+data.mediaImageId).remove();
						$('.loader-overlay').hide();
					}
				});
			}
		}
	});
}

function deleteCarouselImage(){
	$(".carousel-thumb-image").mouseover(function() {
		$(this).children('.delete-carousel-section').show();
	}).mouseout(function() {
		$(this).children('.delete-carousel-section').hide();
	});
	$('.delete-project-carousel-image').click(function(){
		var mediaId = $(this).attr('action');
		var projectId = '{{$project->id}}';
		if(mediaId!=''){
			if (confirm('Are you sure, you want to delete selected Image?')) {
				$('.loader-overlay').show();
				$.ajax({
					url: '/project/edit/deleteProjectCarouselImages',
					type: 'POST',
					dataType: 'JSON',
					data: {mediaId,projectId},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				}).done(function(data){
					if(data.status){
						location.reload('/#carousel_image_delete_pane');
						$('.loader-overlay').hide();
					}
				});
			}
		}
	});
}

	/*function toggleProspectusText(){
		$('.prospectus-text-switch').bootstrapSwitch({
			onText: "Prospectus",
			onColor: 'primary',
			offColor: 'primary',
			offText: "IM",
			animate: true,
		});
		$('.prospectus-text-switch').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			var checkValue = $(this).val();
			var projectId = '{{$project->id}}';
			$('.loader-overlay').show();
			$.ajax({
				url: '/configuration/project/toggleProspectusText',
				type: 'POST',
				dataType: 'JSON',
				data: {checkValue, projectId},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			}).done(function(data){
				console.log(data);
				$('.loader-overlay').hide();
				if(!data.status){
					alert('something went wrong');
				}
			});
		});
	}*/

	function toggleProjectProgress(){
		$('.project-progress-switch').bootstrapSwitch({
			onText: "show",
			onColor: 'primary',
			offColor: 'primary',
			offText: "hide",
			animate: true,
		});
		$('.project-progress-switch').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			var checkValue = $(this).val();
			var projectId = '{{$project->id}}';
			$('.loader-overlay').show();
			$.ajax({
				url: '/configuration/project/toggleProjectProgress',
				type: 'POST',
				dataType: 'JSON',
				data: {checkValue, projectId},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			}).done(function(data){
				console.log(data);
				$('.loader-overlay').hide();
				if(data.status){
					$('.project-progress-section').slideToggle();
				}
			});
		});
	}
	function togglePaymentSwitch(){
		$('.project-payment-switch').bootstrapSwitch({
			onText: "Automate",
			onColor: 'primary',
			offColor: 'danger',
			offText: "Manual",
			animate: true,
		});
		$('.project-payment-switch').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			var checkValue = $(this).val();
			var projectId = '{{$project->id}}';
			$('.loader-overlay').show();
			$.ajax({
				url: '/configuration/project/toggleProjectpayment',
				type: 'POST',
				dataType: 'JSON',
				data: {checkValue, projectId},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			}).done(function(data){
				console.log(data);
				$('.loader-overlay').hide();
				if(data.status){
					$('.project-payment-section').slideToggle();
				}
			});
		});
	}

	function toggleProjectElementsVisibiity(){
		$('.toggle-elements').bootstrapSwitch({
			onColor: 'primary',
			offColor: 'primary',
			animate: true,
		});
		$('.toggle-elements').on('switchChange.bootstrapSwitch', function () {
			var toggleAction = $(this).attr('action');
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			var checkValue = $(this).val();
			var projectId = '{{$project->id}}';
			$('.loader-overlay').show();
			$.ajax({
				url: '/configuration/project/toggleProjectElementVisibility',
				type: 'POST',
				dataType: 'JSON',
				data: {checkValue, projectId, toggleAction},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			}).done(function(data){
				console.log(data);
				$('.loader-overlay').hide();
				if(data.status){
					$('.'+toggleAction).slideToggle();
				}
			});
		});
	}

	function editProjectPageLabelText(){
		$('.edit-project-page-labels').click(function(){
			var effect= $(this).attr('effect');
			if(effect !=''){
				if(effect == 'expected_return_label_text'){
					$(this).html('<input class="col-md-12" type="text" value="{{$project->projectconfiguration->expected_return_label_text}}" id="'+effect+'" style="color:#000; padding:0px;">');
					$('#'+effect).select();
				}
				$('#'+effect).focusout(function(){
					var baseElement = $(this);
					var newLabelText = baseElement.val();
					if(newLabelText != ''){
						baseElement.css('border-color', '');
						var projectId = '{{$project->id}}';
						$('.loader-overlay').show();
						$.ajax({
							url: '/configuration/project/editProjectPageLabelText',
							type: 'POST',
							dataType: 'JSON',
							data: {effect, projectId, newLabelText},
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
						}).done(function(data){
							console.log(data);
							$('.loader-overlay').hide();
							if(data.status){
								baseElement.replaceWith(data.newLabelText);
							}
						});
					} else {
						$(this).css('border-color', '#ff0000');
						$(this).focus();
					}
				});
			}
		});
	}

	function projectProgress(){
		$('#project_progress_image').change(function(e){
			var file = $('#project_progress_image')[0].files[0];
			if (file){
				$('#progress_image_name').val(file.name);
			}
		});
		$('#project_progress_form').submit(function(e){
			$('.loader-overlay').show();
		});
	}

	function addDocRefFields(){
		$('.add-doc-ref-fields').click(function(e){
			e.preventDefault();
			var docCount = parseInt($('#add_doc_ref_count').val(), 10)+1;
			$('.doc-references').append('<div class="col-md-3 text-left"><img src="{{asset('assets/images/pdf_icon.png')}}" class="pdf-icon" alt="clip" height="30" style="position: initial;"><input type="text" name="doc_ref_title[]" class="form-control" placeholder="Title"><input type="text" name="doc_ref_link[]" class="form-control" placeholder="Document Link" @if(Auth::check()) value="" @endif></div>');
			$('#add_doc_ref_count').val(docCount);
		})
	}
</script>
@stop
