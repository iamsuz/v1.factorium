@extends('layouts.main')

@section('title-section')
What is Property or Real Estate Crowdfunding?
@stop

@section('meta-section')
<meta property="og:title" content="What is Property or Real Estate Crowdfunding?" />
<meta property="og:description" content="How does Property Crowdfunding work? What is the Return on Investment? What is Security? Retail AFSL Full PDS Open to Retail investors Duration of project" />

<meta name="description" content="How does Property Crowdfunding work? What is the Return on Investment? What is Security? Retail AFSL Full PDS Open to Retail investors Duration of project">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content-section')
<div class="container">
	<br>
	@if (Session::has('message'))
		<div class="alert alert-success text-center" role="alert">
			{!! Session::get('message') !!}
		</div>
	@endif

	<h1 class="text-center first_color" id="general" style="font-size:2.625em;">Frequently Asked Questions</h1>
	<div class="row">
		{{-- <div class="col-md-4 col-sm-12 text-right" style="padding-top:70px;">
			<h4 class="font-regular">
				<a href="/pages/faq/#general" class="scrollto-faq font-regular first_color" style="color:#fed405; font-size:1.375em;">General</a>
			</h4>
			<h4 class="font-regular">
				<a href="/pages/faq/#investor" class="scrollto-faq font-regular first_color" style="color: #282a73; font-size:1.375em;">Investor</a>
			</h4>
			<h4 class="font-regular" style="margin-left:-2em;">
				<a href="/pages/faq/#pdv" class="scrollto-faq font-regular first_color" style="color: #282a73; font-size:1.375em;">Property Development & Venture</a>
			</h4>
		</div> --}}
		<div class="col-md-8 col-sm-8">
			{{-- <h1 class="h1-faq first_color" style="font-size:3.25em;color:#2d2d4b;">General</h1>
			<h3 class="font-regular first_color" style="font-size:1.375em;color:#282a73;">Basics</h3>
			<div class="panel-group" id="accordion">
				@if (count($faqGeneralBasics) > 0)
					@foreach($faqGeneralBasics as $basics)
					<div class="panel panel-info">
						<div data-toggle="collapse" data-target="#collapse{{$basics->id}}"  class="panel-heading collapse-header" style="display: inline-block;">
							<i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="panel-title font-bold first_color">{{$basics->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$basics->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$basics->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;">
								<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($basics->answer)) !!}</p>
							</div>
						</div>
					</div>
					@endforeach
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif

				<h3 class="font-regular first_color" style="font-size:1.375em;color:#282a73;">Regulatory</h3>
				@if (count($faqGeneralRegulatory) > 0)
					@foreach($faqGeneralRegulatory as $regulatory)
					<div class="panel panel-info">
						<div data-toggle="collapse" data-target="#collapse{{$regulatory->id}}" class="panel-heading collapse-header" style="display: inline-block;"><i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="font-bold panel-title first_color">{{$regulatory->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$regulatory->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$regulatory->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;"><p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($regulatory->answer)) !!}</p>
							</div>
						</div>
					</div>
					@endforeach
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif

				<h3 class="font-regular first_color" style="font-size:1.375em;color:#282a73;">Legal Structure</h3>
				@if (count($faqGeneralLegalStructure) > 0)
					@foreach($faqGeneralLegalStructure as $legalStructure)
					<div class="panel panel-info">
						<div data-toggle="collapse" data-target="#collapse{{$legalStructure->id}}" class="panel-heading collapse-header" style="display: inline-block;"><i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="font-bold panel-title first_color">
								{{$legalStructure->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$legalStructure->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$legalStructure->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;"><p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($legalStructure->answer)) !!}</p>
							</div>
						</div>
					</div>
					@endforeach
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif

				<h3 class="font-regular first_color" style="font-size:1.375em;color:#282a73;">Fees</h3>
				@if (count($faqGeneralFees) > 0)
					@foreach($faqGeneralFees as $fees)
					<div class="panel panel-info">
						<div data-toggle="collapse" data-target="#collapse{{$fees->id}}" class="panel-heading collapse-header" style="display: inline-block;"><i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="font-bold panel-title first_color">
								{{$fees->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$fees->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$fees->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;"><p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($fees->answer)) !!}</p>
							</div>
						</div>
					</div>
					@endforeach
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif

				<h3 class="font-regular first_color" style="font-size:1.375em;color:#282a73;">Website</h3>
				@if (count($faqGeneralWebsite) > 0)
					@foreach($faqGeneralWebsite as $website)
					<div class="panel panel-info">
						<div data-toggle="collapse" data-target="#collapse{{$website->id}}" class="panel-heading collapse-header" style="display: inline-block;"><i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="font-bold panel-title first_color">
								{{$website->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$website->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$website->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;"><p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($website->answer)) !!}</p>
							</div>
						</div>
					</div>
					@endforeach
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif

				<div id="investor" style="min-height: 40px;"></div>

				<h1 class="h1-faq first_color" style="font-size:3.25em;color:#2d2d4b;">Investor</h1>
				<h3 class="font-regular" style="font-size:1.375em;color:#282a73;">Investing Basics</h3>
				@if (count($faqInvestorInvestingBasics) > 0)
					@foreach($faqInvestorInvestingBasics as $investingBasics)
					<div class="panel panel-info" >
						<div data-toggle="collapse" data-target="#collapse{{$investingBasics->id}}" class="panel-heading collapse-header" style="display: inline-block;"><i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="font-bold panel-title first_color">
								{{$investingBasics->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$investingBasics->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$investingBasics->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;"><p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($investingBasics->answer)) !!}
							</p>
							</div>
						</div>
					</div>
					@endforeach
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif

				<h3 class="font-regular first_color" style="font-size:1.375em;color:#282a73;">Investment Type</h3>
				@if(count($faqInvestorInvestmentType) > 0)
					@foreach($faqInvestorInvestmentType as $investmentType)
					<div class="panel panel-info">
						<div data-toggle="collapse" data-target="#collapse{{$investmentType->id}}" class="panel-heading collapse-header" style="display: inline-block;"><i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="font-bold panel-title first_color">
								{{$investmentType->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$investmentType->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$investmentType->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;"><p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($investmentType->answer)) !!}</p>
							</div>
						</div>
					</div>
					@endforeach
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif

				<h3 class="font-regular first_color" style="font-size:1.375em;color:#282a73;">Investment Specific</h3>
				@if (count($faqInvestorInvestmentSpecific) > 0)
					@foreach($faqInvestorInvestmentSpecific as $investmentSpecific)
					<div class="panel panel-info">
						<div data-toggle="collapse" data-target="#collapse{{$investmentSpecific->id}}" class="panel-heading collapse-header" style="display: inline-block;"><i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="font-bold panel-title first_color">
								{{$investmentSpecific->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$investmentSpecific->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$investmentSpecific->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;"><p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($investmentSpecific->answer)) !!}</p>
							</div>
						</div>
					</div>
					@endforeach
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif
				
				<h3 class="font-regular first_color" style="font-size:1.375em;color:#282a73;">Investment Support</h3>
				@if (count($faqInvestorInvestmentSupport) > 0)
					@foreach($faqInvestorInvestmentSupport as $investmentSupport)
					<div class="panel panel-info">
						<div data-toggle="collapse" data-target="#collapse{{$investmentSupport->id}}" class="panel-heading collapse-header" style="display: inline-block;"><i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="font-bold panel-title first_color">
								{{$investmentSupport->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$investmentSupport->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$investmentSupport->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;"><p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($investmentSupport->answer)) !!}</p>
							</div>
						</div>
					</div>
					@endforeach
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif

				<h3 class="font-regular first_color" style="font-size:1.375em;color:#282a73;">Investment Risks</h3>
				@if (count($faqInvestorInvestmentRisks) > 0)
					@foreach($faqInvestorInvestmentRisks as $investmentRisk)
					<div class="panel panel-info">
						<div data-toggle="collapse" data-target="#collapse{{$investmentRisk->id}}" class="panel-heading collapse-header" style="display: inline-block;"><i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="font-bold panel-title first_color">
								{{$investmentRisk->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$investmentRisk->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$investmentRisk->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;"><p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($investmentRisk->answer)) !!}</p>
							</div>
						</div>
					</div>
					@endforeach
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif

				<div id = "pdv" style="min-height: 40px;"></div>

				<h1 class="h1-faq first_color" style="font-size:3.25em;color:#2d2d4b;">Property Development & Venture</h1>
				@if (count($faqPropertyDevelopmentVenture) > 0)
					@foreach($faqPropertyDevelopmentVenture as $venture)
					<div class="panel panel-info">
						<div data-toggle="collapse" data-target="#collapse{{$venture->id}}" class="panel-heading collapse-header" style="display: inline-block;"><i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="font-bold panel-title first_color">
								{{$venture->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$venture->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$venture->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;"><p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($venture->answer)) !!}</p>
							</div>
						</div>
					</div>
					@endforeach	
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif
 --}}
 				@if (count($faq) > 0)
					@foreach($faq as $venture)
					<div class="panel panel-info">
						<div data-toggle="collapse" data-target="#collapse{{$venture->id}}" class="panel-heading collapse-header" style="display: inline-block; border-color: #fff;"><i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>
							<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="font-bold panel-title first_color">
								{{$venture->question}}
							</h4>
						</div>
						@if($isAdmin)
						<span class="faq-delete" value="{{$venture->id}}" style="display: inline-block;"><i class="fa fa-trash" aria-hidden="true" style="color:#f75733; cursor: pointer;"></i></span>
						@endif
						<div id="collapse{{$venture->id}}" class="panel-collapse collapse">
							<div class="panel-body" style="padding-left:45px;"><p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">{!! nl2br(e($venture->answer)) !!}</p>
							</div>
						</div>
					</div>
					@endforeach	
				@else
					<div class="alert alert-danger"><strong>No FAQ available for this category</strong></div>
				@endif
				@if($isAdmin)
				<button type="button" name="add_new_faq" id="add_new_faq" onclick="location.href='{{ URL::route('pages.faq.create') }}'" class="btn btn-primary btn-block" style="margin: 30px 0px 30px 0px;">Add New FAQ</button>
				@endif
			</div> 
		</div>
		<br><br>
{{--		<div class="panel-group col-md-8 col-md-offset-2 text-justify" id="accordion">--}}
{{--			<div class="panel panel-info">--}}
{{--				<div data-toggle="collapse" data-target="#collapse1"  class="panel-heading collapse-header" style="display: inline-block;">--}}
{{--					<i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>--}}
{{--					<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="panel-title font-bold first_color">What does this site do--}}
{{--					</h4>--}}
{{--				</div>--}}
{{--				<div id="collapse1" class="panel-collapse collapse">--}}
{{--					<div class="panel-body" style="padding-left:45px;">--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">This site lists various opportunities to invest in primarily real estate related projects.</p>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="panel panel-info">--}}
{{--				<div data-toggle="collapse" data-target="#collapse2"  class="panel-heading collapse-header" style="display: inline-block;">--}}
{{--					<i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>--}}
{{--					<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="panel-title font-bold first_color">How does this work?--}}
{{--					</h4>--}}
{{--				</div>--}}
{{--				<div id="collapse2" class="panel-collapse collapse">--}}
{{--					<div class="panel-body" style="padding-left:45px;">--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">Various property related investment opportunities are listed on this site. You can read through the details which will be provided on the Project details page in the form of a Prospectus (or a similar offer document such as an Information Memorandum or Product Disclosure Statement.</p>--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">It will have all the details regarding the project such as location, duration, expected return and  potential risks. You should read through it carefully and determine if this is an appropriate investment for you and if necessary consult your financial adviser. If you decide the specific project is something you wish to invest in then you can click on the invest now or express interest button and fill up the application form online which will be listed there with your details and the amount you wish to invest.</p>--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">You will be provided Bank account details of the project company where you should then proceed to transfer the required funds. If your application is accepted then you will be issued a share or unit certificate indicating your investment in the project.</p>--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">You will also be provided regular updates in the form of pictures, videos etc as the project progresses on the website as well as via email.</p>--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">Once the project concludes you will be paid your promised return based on the Projects performance and in accordance with the offer documents terms.</p>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="panel panel-info">--}}
{{--				<div data-toggle="collapse" data-target="#collapse3"  class="panel-heading collapse-header" style="display: inline-block;">--}}
{{--					<i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>--}}
{{--					<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="panel-title font-bold first_color">What is the expected Return, Duration?--}}
{{--					</h4>--}}
{{--				</div>--}}
{{--				<div id="collapse3" class="panel-collapse collapse">--}}
{{--					<div class="panel-body" style="padding-left:45px;">--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">Every project is different and details of the projects expected returns and duration can be found on that particular projects detail page and on the Prospectus or other offer document.</p>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="panel panel-info">--}}
{{--				<div data-toggle="collapse" data-target="#collapse4"  class="panel-heading collapse-header" style="display: inline-block;">--}}
{{--					<i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>--}}
{{--					<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="panel-title font-bold first_color">Who owns this site?--}}
{{--					</h4>--}}
{{--				</div>--}}
{{--				<div id="collapse4" class="panel-collapse collapse">--}}
{{--					<div class="panel-body" style="padding-left:45px;">--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">This site is owned by {!! App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->client_name !!}. </p>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="panel panel-info">--}}
{{--				<div data-toggle="collapse" data-target="#collapse5"  class="panel-heading collapse-header" style="display: inline-block;">--}}
{{--					<i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>--}}
{{--					<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="panel-title font-bold first_color">Who operates this site?--}}
{{--					</h4>--}}
{{--				</div>--}}
{{--				<div id="collapse5" class="panel-collapse collapse">--}}
{{--					<div class="panel-body" style="padding-left:45px;">--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">Tech Baron PTY LTD (ABN 67617252909) (TB) provides technology infrastructure and support services to operate this site. TB is a Corporate Authorised Representative {!! App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->car_no !!} of AFSL {!! App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->afsl_no !!} and is authorized to deal in securities. TB is however not responsible for the content of this website which is the responsibility of {!! App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->client_name !!}. The responsibility of the specific offers made on this website is that of the specific Project principals whose details can be found on the Prospectus or the Offer document.</p>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="panel panel-info">--}}
{{--				<div data-toggle="collapse" data-target="#collapse6"  class="panel-heading collapse-header" style="display: inline-block;">--}}
{{--					<i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>--}}
{{--					<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="panel-title font-bold first_color">Can everyone invest in the opportunities listed here?</h4>--}}
{{--				</div>--}}
{{--				<div id="collapse6" class="panel-collapse collapse">--}}
{{--					<div class="panel-body" style="padding-left:45px;">--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">Typically most offers here will be made on the back of a Prospectus and will be open to Retail investors across Australia.</p>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="panel panel-info">--}}
{{--				<div data-toggle="collapse" data-target="#collapse7"  class="panel-heading collapse-header" style="display: inline-block;">--}}
{{--					<i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>--}}
{{--					<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="panel-title font-bold first_color">Can international investors invest?--}}
{{--					</h4>--}}
{{--				</div>--}}
{{--				<div id="collapse7" class="panel-collapse collapse">--}}
{{--					<div class="panel-body" style="padding-left:45px;">--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">The offers are made to only investors in Australia and are not made in other jurisdictions such as the USA where it may not be valid to do so.</p>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="panel panel-info">--}}
{{--				<div data-toggle="collapse" data-target="#collapse8"  class="panel-heading collapse-header" style="display: inline-block;">--}}
{{--					<i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>--}}
{{--					<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="panel-title font-bold first_color">Can I invest using my SMSF?--}}
{{--					</h4>--}}
{{--				</div>--}}
{{--				<div id="collapse8" class="panel-collapse collapse">--}}
{{--					<div class="panel-body" style="padding-left:45px;">--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">Investments typically take the form of shares in a Public Unlisted companies. If your SMSF allows investment in securities then it may be suitable. Please consult your financial adviser.</p>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="panel panel-info">--}}
{{--				<div data-toggle="collapse" data-target="#collapse9"  class="panel-heading collapse-header" style="display: inline-block;">--}}
{{--					<i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>--}}
{{--					<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="panel-title font-bold first_color">Are the returns guaranteed or is the investment risky?--}}
{{--					</h4>--}}
{{--				</div>--}}
{{--				<div id="collapse9" class="panel-collapse collapse">--}}
{{--					<div class="panel-body" style="padding-left:45px;">--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">Every investment carries risk, you should consider loss of entire invested capital. You should also review the Prospectus or other offer documents in detail for a list of potential risks and if necessary consult a financial adviser to determine if this is a suitable investment for you.</p>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="panel panel-info">--}}
{{--				<div data-toggle="collapse" data-target="#collapse10"  class="panel-heading collapse-header" style="display: inline-block;">--}}
{{--					<i class="indicator second_color glyphicon glyphicon-plus  pull-left" style="color:#fed405;"></i>--}}
{{--					<h4 style="padding-left:30px; color:#282a73; font-size:1em;" class="panel-title font-bold first_color">What are the tax implications of this investment?--}}
{{--					</h4>--}}
{{--				</div>--}}
{{--				<div id="collapse10" class="panel-collapse collapse">--}}
{{--					<div class="panel-body" style="padding-left:45px;">--}}
{{--						<p style="font-size:0.875em; color:#2d2a6e;" class="font-regular first_color">We cannot give you Tax advice, please consult your Tax adviser. You should also review the Prospectus which may have details about the tax impact of that particular investment.</p>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--	</div>--}}
	<br><br>
	<a href="#" class="go-top font-regular" style="z-index:1000;"> <i class="fa fa-chevron-up" aria-hidden="true"></i> Go Top</a>
<!--inner pages end -->
</div>

@if($isAdmin)
<div id="confirm" class="hide" style="display: block;">
  <div id="confirm_faq_delete" class="modal" style="background-color: #FFFFFF; border: 10px; max-height: 150px; max-width: 380px; left: 35%;top: 20%; text-align: center; border-radius: 5px; padding: 20px 0px 0px 0px;">
	  <div class="modal-body">
	    Are you sure, you want to delete the FAQ?
	  </div>
	  <div class="modal-footer">
	    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
	    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
	  </div>
  </div>
</div>
@endif


@stop

@section('js-section')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>

<script type="text/javascript">

	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	$(document).ready(function() {
		$(window).scroll(function() {
			if ($(this).scrollTop() > 200) {
				$('.go-top').fadeIn(200);
			} else {
				$('.go-top').fadeOut(200);
			}
		});

		$('.go-top').click(function(event) {
			event.preventDefault();

			$('html, body').animate({scrollTop: 0}, 300);
		});

		$('.collapse-header').on('click', function () {
			$($(this).data('target')).collapse('toggle');
		});
		$('.scrollto-faq').click(function(e) {
			e.preventDefault();
			$(window).stop(true).scrollTo(this.hash, {duration:1000, interrupt:true});
		});
		var reflowFixedPositions = function () {
			document.documentElement.style.paddingRight = '1px';
			setTimeout(function () {
				document.documentElement.style.paddingRight = '';
			}, 0);
		}
		window.scrollTo(0, 1);
		reflowFixedPositions();

		$('.faq-delete').on('click',function(){
			var faq_id = $(this).attr('value');
			$('#confirm').removeClass('hide');
			$('#confirm_faq_delete').modal({ backdrop: 'static', keyboard: false })
        		.one('click', '#delete', function() {
        			var newRoute = "{{ URL::route('pages.faq.delete', ['%faq_id%']) }}";
        			newRoute = newRoute.replace('%faq_id%', faq_id);
        			console.log(newRoute);
        			document.location.href = newRoute;
        	});
		});
	});
</script>
@endsection