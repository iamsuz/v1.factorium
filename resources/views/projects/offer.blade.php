@extends('layouts.project')
@section('title-section')
Offer Doc
@stop

@section('meta-section')
<meta name="csrf-token" content="{{csrf_token()}}" />
@stop

@section('css-section')
@parent
<style type="text/css">
.navbar{
	display: none;
}
.content{
	margin-top: 1em;
}
.check1{
	padding: 2px !important;
}
.check1, .wholesale_invest_checkbox {
	display: inline;
	vertical-align: middle;
}
.switch-field {
	font-family: "Lucida Grande", Tahoma, Verdana, sans-serif;
	padding: 40px;
	overflow: hidden;
}

.switch-title {
	margin-bottom: 6px;
}

.switch-field input {
	position: absolute !important;
	clip: rect(0, 0, 0, 0);
	height: 1px;
	width: 1px;
	border: 0;
	overflow: hidden;
}

.switch-field label {
	float: left;
}

.switch-field label {
	display: inline-block;
	width: 130px;
	background-color: #e4e4e4;
	color: rgba(0, 0, 0, 0.6);
	font-size: 14px;
	font-weight: normal;
	text-align: center;
	text-shadow: none;
	padding: 6px 14px;
	border: 1px solid rgba(0, 0, 0, 0.2);
	-webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
	box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
	-webkit-transition: all 0.1s ease-in-out;
	-moz-transition:    all 0.1s ease-in-out;
	-ms-transition:     all 0.1s ease-in-out;
	-o-transition:      all 0.1s ease-in-out;
	transition:         all 0.1s ease-in-out;
}

.switch-field label:hover {
	cursor: pointer;
}

.switch-field input:checked + label {
	background-color: #A5DC86;
	-webkit-box-shadow: none;
	box-shadow: none;
}

.switch-field label:first-of-type {
	border-radius: 4px 0 0 4px;
}

.switch-field label:last-of-type {
	border-radius: 0 4px 4px 0;
}
.scribd_iframe_embed{
	height: 75vh;
}
@media screen and (max-width: 768px) {
	#terms_accepted_button{
		font-size: 11px;
	}
}
@media screen and (max-width: 320px){
	#terms_accepted_button{
		font-size: 9px;
	}
}
#footer{
    display: none;
}
</style>
@stop
@section('content-section')

<div class="loader-overlay hide" style="display: none;">
	<div class="overlay-loader-image">
		<img id="loader-image" src="{{ asset('/assets/images/loader.GIF') }}">
	</div>
</div>
<div class="container-fluid" id="mainPage">
	<div class="row" id="forScroll">
		<div class="col-md-12">
			<div style="display:block;margin:0;padding:0;border:0;outline:0;color:#000!important;vertical-align:baseline;width:100%;">
				<div class="row">
					<div class="col-md-12 investment-gform" id="offer_frame" style="border-right: 11px solid #F1F1F1;">
						<div class="row">
							<div class="col-md-offset-1 col-md-10" ><br>
								@if ($errors->has())
								<br>
								<div class="alert alert-danger">
									@foreach ($errors->all() as $error)
									{{ $error }}<br>
									@endforeach
								</div>
								<br>
								@endif
								@if (Session::has('message'))
								<div class="alert alert-success text-center">{{ Session::get('message') }}</div>
								@endif
								<div class="well text-center cursor-pointer fill-form-request-container">
									@if (Session::has('requestStatus'))
									<i class="fa fa-check-circle-o fa-3x" aria-hidden="true" style="color: green;"></i><br>
									<h3>Your request is submitted</h3>
									<h5>We will contact you soon</h5>
									@else
									<h5>Need Help Filling Form? Click the below button to request for form fillup. Our executive will contact you once your request is received.</h5>
									<a href="{{route('projects.interest.request', [$project->id])}}"><button type="button" class="btn btn-primary send-form-filling-request"><i class="fa fa-file-text fa-lg" aria-hidden="true"></i> &nbsp;&nbsp;Send Request</button></a>
									@endif
								</div>
								<hr>
								<form action="{{route('offer.store')}}" rel="form" method="POST" enctype="multipart/form-data" id="myform">
									{!! csrf_field() !!}
									<div class="row" id="section-1">
										<div class="col-md-12">
											<div>
												<label class="form-label">Project Name</label><br>
												<input class="form-control" type="text" name="project_spv_name" placeholder="Project Name" style="width: 60%;" @if($projects_spv) value="{{$projects_spv->spv_name}}" disabled @endif >
												{{-- <h5>Name of the Entity established as a Special Purpose Vehicle for this project that you are investing in</h5> --}}
												<br>
												<p>
													This Application Form is important. If you are in doubt as to how to deal with it, please contact your professional adviser without delay. You should read the entire @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif carefully before completing this form. To meet the requirements of the Corporations Act, this Application Form must  not be distributed unless included in, or accompanied by, the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif.
												</p>
												<label>I/We apply for *</label>
												<input type="number" name="amount_to_invest" class="form-control" onkeypress="return isNumber(event)" placeholder="Minimum Amount A${{$project->investment->minimum_accepted_amount}}" style="width: 60%" id="apply_for" min="{{$project->investment->minimum_accepted_amount}}" step="100" required value="@if(isset($eoi)) {{$eoi->investment_amount}} @endif">
												@if($project->share_vs_unit == 1)
												<h5>Number of Redeemable Preference Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</h5>
												@elseif($project->share_vs_unit == 2)
												<h5>Number of Preference Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</h5>
												@elseif($project->share_vs_unit == 3)
												<h5>Number of Ordinary Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</h5>
												@else
												<h5>Number of Units at $1 per Unit or such lesser number of Units which may be allocated to me/us</h5>
												@endif
												<label>I/We lodge full Application Money</label>
												<input type="text" name="apply_for" class="form-control" placeholder="$5000" value="A$ @if(isset($eoi)) {{number_format(round($eoi->investment_amount, 2))}} @else 0.00 @endif" disabled="" style="width: 60%; background-color: #fff" id="application_money">
												<input type="text" name="project_id" @if($projects_spv) value="{{$projects_spv->project_id}}" @endif hidden >

												{{-- <div class="row">
													<div class="text-left col-md-3 wow fadeIn animated">
														<button class="btn btn-primary btn-block" id="step-1">Next</button>
													</div>
												</div> --}}
											</div>
										</div>
									</div>
									<br><br>
									<div class="row">
										<div class="col-md-12">
											<div>
												<h4 class="aml-requirements-link cursor-pointer">AML/CTF requirements &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></h4>
												<small>** Expand to read the Requirements</small>
												<div class="row aml-requirements-section">
													<div class="col-md-12">
														<div class="aml-requirements-content text-justify">
															<small class="text-dark-grey">
																If investing via a Financial Adviser please provide the @if($project->md_vs_trustee)Managing Director @else Trustee @endif the necessary verification otherwise you need to lodge the following information.
																<br>
																<h4><small><b>Individuals</b></small></h4>
																Original or Certified Copy of <b>one</b> of the following :
																<ul>
																	<li>Australian or Foreign Drivers License (containing photograph).</li>
																	<li>Australian or Foreign Passport.</li>
																</ul>
																<b>OR</b><br>
																Original or Certified Copy of <b>one</b> of the following :
																<ul>
																	<li>Australian or Foreign Birth Certificate</li>
																	<li>Australian or Foreign Citizenship Certificate <b>plus</b> an Original of one of the following that are not more than 12 months old</li>
																	<li>a notice from the Australian Taxation Office containing your name and address</li>
																	<li>a rates notice from local government or utilities provider</li>
																</ul>
																<i>Foreign documents must be accompanied by Accredited Translation into English</i>
																<h4><small><b>Partnerships</b></small></h4>
																Original or Certified Copy of
																<ul>
																	<li>the Partnership Agreement</li>
																	<li>minutes of a Partnership Meeting</li>
																	<li>for one of the Partners, the Individual documents (see above)</li>
																</ul>
																<h4><small><b>Company</b></small></h4>
																A Full ASIC Extract i.e. including Director and Shareholder details
																<h4><small><b>Trust</b></small></h4>
																Original or Certified Copy of
																<ul>
																	<li>the Trust Deed</li>
																	<li>list of Beneficiaries</li>
																	<li>Individual or Company details for the Trustee (see above)</li>
																</ul>
																<h4><small><b>Document Certification</b></small></h4>
																People that can certify documents include the following
																<ul style="list-style: none;">
																	<li>Lawyer</li>
																	<li>Judge</li>
																	<li>Magistrate</li>
																	<li>Registrar or Deputy Registrar of a Court</li>
																	<li>Justice of the Peace</li>
																	<li>Notary</li>
																	<li>Police Officer</li>
																	<li>Postmaster</li>
																	<li>Australian Consular or Diplomatic Officer</li>
																	<li>Financial Services Licensee or Authorised Representative with at least two years of continuous service</li>
																	<li>Accountant - CA, CPA or NIA with at least two years of continuous membership</li>
																</ul>
															</small>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<br><br>
									@if(!Auth::guest() && !$user->idDoc)
									<div class="row " id="section-2">
										<div class="col-md-12">
											<div >
												<h5>Individual/Joint applications - refer to naming standards for correct forms of registrable title(s)</h5>
												<br>
												<h4>Are you Investing as</h4>
												<input type="radio" name="investing_as" value="Individual Investor" checked> Individual Investor<br>
												<input type="radio" name="investing_as" value="Joint Investor" > Joint Investor<br>
												<input type="radio" name="investing_as" value="Trust or Company" > Company, Trust or SMSF<br>
												<hr>
											</div>

										</div>
									</div>
									<div class="row " id="section-3">
										<div class="col-md-12">
											<div style="display: none;" id="company_trust">
												<label>Company or Trust Name</label>
												<div class="row">
													<div class="col-md-9">
														<input type="text" name="investing_company_name" class="form-control" placeholder="Trust or Company" required disabled="disabled" >
													</div>
												</div><br>
											</div>
											<div id="normal_name">
												<label>Given Name(s)</label>
												<div class="row">
													<div class="col-md-9">
														<input type="text" name="first_name" class="form-control" placeholder="First Name" required @if(!Auth::guest() && $user->first_name) value="{{$user->first_name}}" @endif>
													</div>
												</div><br>
												<label>Surname</label>
												<div class="row">
													<div class="col-md-9">
														<input type="text" name="last_name" class="form-control" placeholder="Last Name" required @if(!Auth::guest() && $user->last_name) value="{{$user->last_name}}" @endif>
													</div>
												</div><br>
											</div>
											<div style="display: none;" id="joint_investor">
												<label>Joint Investor Details</label>
												<div class="row">
													<div class="col-md-6">
														<input type="text" name="joint_investor_first" class="form-control" placeholder="Investor First Name" required disabled="disabled" @if($user->idDoc && $user->idDoc->investing_as == 'Joint Investor') value="{{$user->idDoc->joint_first_name}}" readonly @endif>
													</div>
													<div class="col-md-6">
														<input type="text" name="joint_investor_last" class="form-control" placeholder="Investor Last Name" required disabled="disabled" @if($user->idDoc && $user->idDoc->investing_as == 'Joint Investor') value="{{$user->idDoc->joint_last_name}}" readonly @endif>
													</div>
												</div>
												<br>
												<hr>
											</div>
										</div>
									</div>
									@endif
									@if(Auth::guest())
									<div class="row " id="section-2">
										<div class="col-md-12">
											<div >
												<h5>Individual/Joint applications - refer to naming standards for correct forms of registrable title(s)</h5>
												<br>
												<h4>Are you Investing as</h4>
												<input type="radio" name="investing_as" value="Individual Investor" checked> Individual Investor<br>
												<input type="radio" name="investing_as" value="Joint Investor" > Joint Investor<br>
												<input type="radio" name="investing_as" value="Trust or Company" > Company, Trust or SMSF<br>
												<hr>
											</div>

										</div>
									</div>
									<div class="row " id="section-3">
										<div class="col-md-12">
											<div style="display: none;" id="company_trust">
												<label>Company of Trust Name</label>
												<div class="row">
													<div class="col-md-9">
														<input type="text" name="investing_company_name" class="form-control" placeholder="Trust or Company" required disabled="disabled" >
													</div>
												</div><br>
											</div>
											<div id="normal_name">
												<label>Given Name(s)</label>
												<div class="row">
													<div class="col-md-9">
														<input type="text" name="first_name" class="form-control" placeholder="First Name" required @if(!Auth::guest() && $user->first_name) value="{{$user->first_name}}" @endif>
													</div>
												</div><br>
												<label>Surname</label>
												<div class="row">
													<div class="col-md-9">
														<input type="text" name="last_name" class="form-control" placeholder="Last Name" required @if(!Auth::guest() && $user->last_name) value="{{$user->last_name}}" @endif>
													</div>
												</div><br>
											</div>
											<div style="display: none;" id="joint_investor">
												<label>Joint Investor Details</label>
												<div class="row">
													<div class="col-md-6">
														<input type="text" name="joint_investor_first" class="form-control" placeholder="Investor First Name" required disabled="disabled" @if(!Auth::guest() && $user->idDoc && $user->idDoc->investing_as == 'Joint Investor') value="{{$user->idDoc->joint_first_name}}" readonly @endif>
													</div>
													<div class="col-md-6">
														<input type="text" name="joint_investor_last" class="form-control" placeholder="Investor Last Name" required disabled="disabled" @if(!Auth::guest() && $user->idDoc && $user->idDoc->investing_as == 'Joint Investor') value="{{$user->idDoc->joint_last_name}}" readonly @endif>
													</div>
												</div>
												<br>
												<hr>
											</div>
										</div>
									</div>
									@endif
									{{-- <div class="row" id="section-4" style="display: none;">
										<div class="col-md-12">
											<div id="trust_doc" style="display: none;">
												<label>Trust or Company DOCS</label>
												<input type="file" name="trust_or_company_docs" class="form-control" disabled="disabled" required><br>

												<p>Please upload the first and last pages of your trust deed or Company incorporation papers</p>
											</div>
											<div id="normal_id_docs">
												@if(!Auth::guest() && $user->investmentDoc->where('user_id', $user->id AND 'type','normal_name'))
												<div class="row">
													<div class="col-md-6">
													</div>
												</div>
												<br>
												@else
												@endif
												<label>ID DOCS</label>
												@if($user->idDoc && $user->idDoc->investing_as != 'Company or Trust')<br>
												<a href="/{{$user->idDoc->get()->last()->path}}" target="_blank">User ID Doc</a>
												@else
												<input type="file" name="user_id_doc" class="form-control" required ><br>

												@endif
												<p>If you have not completed your verification process. Please upload a copy of your Driver License or Passport for AML/CTF purposes</p>
											</div>

											<div id="joint_investor_docs" style="display: none;">
												<label>Joint Investor ID DOCS</label>
												@if($user->idDoc && $user->idDoc->investing_as == 'Joint Investor')<br>
												<a href="/{{$user->idDoc->get()->last()->joint_id_path}}" target="_blank">Joint Investor ID Doc</a>
												@else
												<input type="file" name="joint_investor_id_doc" class="form-control" disabled="disabled" required><br>
												@endif
												<p>Please upload a copy of the joint investors Driver License or Passport for AML/CTF purposes</p>
											</div>
										</div>
									</div> --}}
									<div class="@if($project->retail_vs_wholesale) hide @endif">
										<div class="row" id="wholesale_project">
											<div class="col-md-12"><br>
												<h4>Investor Qualification</h4>
												<p>An issue of securities to the public usually requires a disclosure document (like a prospectus) to ensure participants are fully informed about a range of issues including the characteristics of the offer and the present position and future prospects of the entity offering the securities.</p>
												<p>However an issue of securities can be made to particular kind of investors, in the categories described below, without the need for a registered disclosure document. Please tell us which category of investors applies:</p>
												<hr>
												<b style="font-size: 1.1em;">Which option closely describes you?</b><br>
												<div style="margin-left: 1.3em; margin-top: 5px;">
													<input type="checkbox" name="wholesale_investing_as" value="Wholesale Investor (Net Asset $2,500,000 plus)" style="margin-right: 6px;" class="wholesale_invest_checkbox"><span class="check1">I have net assets of at least $2,500,000 or a gross income for each of the last two financial years of at least $250,000 a year.</span><br>
													<input type="checkbox" name="wholesale_investing_as" value="Sophisticated Investor" style="margin-right: 6px;" class="wholesale_invest_checkbox"><span class="check1">I have experience as to: the merits of the offer; the value of the securities; the risk involved in accepting the offer; my own information needs; the adequacy of the information provided.</span><br>
													<input type="checkbox" name="wholesale_investing_as" value="Inexperienced Investor" style="margin-right: 6px;" class="wholesale_invest_checkbox"><b><span class="check1">I have no experience in property, securities or similar</span></b><br>
												</div>
											</div>
										</div>

										<div class="row" id="accountant_details_section" style="display: none;">
											<br>
											<div class="col-md-12">
												<h4>Accountant's details</h4>
												<p>Please provide the details of your accountant for verification of income and/or net asset position.</p>
												<hr>
												<label for="asd" class="form-label"><b>Name and firm of qualified accountant</b></label>
												<input type="text" name="accountant_name_firm_txt" id="asd" class="form-control"><br />
												<label for="asda" class="form-label"><b>Qualified accountant's professional body and membership designation</b></label>
												<input type="text" name="accountant_designation_txt" id="asda" class="form-control"><br />
												<label for="asds" class="form-label"><b>Email</b></label>
												<input type="email" name="accountant_email_txt" id="asds" class="form-control"><br />
												<label for="asdd" class="form-label"><b>Phone</b></label>
												<input type="number" name="accountant_phone_txt" id="asdd" class="form-control"><br />
											</div>
										</div>

										<div class="row" id="experienced_investor_information_section" style="display: none;">
											<div class="col-md-12">
												<br>
												<h4>Experienced investor information</h4>
												<p>Please complete all of the questions below:</p>
												<hr>

												<label>Equity investment experience (please be as detailed and specific as possible):</label><br>
												<textarea class="form-control" rows="5" name="equity_investment_experience_txt"></textarea><br>

												<b>How much investment experience do you have? (tick appropriate)</b>
												<div style="margin-left: 1.3em; margin-top: 5px;">
													<input type="radio" name="experience_period_txt" style="margin-right: 6px;" value="Very little knowledge or experience" checked=""><span class="check1">Very little knowledge or experience</span><br>
													<input type="radio" name="experience_period_txt" style="margin-right: 6px;" value="Some investment knowledge and understanding"><span class="check1">Some investment knowledge and understanding</span><br>
													<input type="radio" name="experience_period_txt" style="margin-right: 6px;" value="Experienced private investor with good investment knowledge"><span class="check1">Experienced private investor with good investment knowledge</span><br>
													<input type="radio" name="experience_period_txt" style="margin-right: 6px;" value="Business Investor"><span class="check1">Business Investor</span><br>
												</div>
												<br>

												<label>What experience do you have with unlisted invesments ?</label><br>
												<textarea class="form-control" rows="5" name="unlisted_investment_experience_txt"></textarea><br>

												<label>Do you clearly understand the risks of investing with this offer ?</label><br>
												<textarea class="form-control" rows="5" name="understand_risk_txt"></textarea><br>

											</div>
										</div>
									</div>

									<div class="row" >
										<div class="col-md-12">
											<div style="">
												<h3>
													Contact Details
												</h3>
												<hr>
												<label>Enter your Postal Address</label>
												<div class="row">
													<div class="form-group @if($errors->first('line_1') && $errors->first('line_2')){{'has-error'}} @endif ">
														<div class="col-sm-12">
															<div class="row">
																<div class="col-sm-6 @if($errors->first('line_1')){{'has-error'}} @endif">
																	{!! Form::text('line_1', isset($user->line_1) ? $user->line_1 : null, array('placeholder'=>'line 1', 'class'=>'form-control','required')) !!}
																	{!! $errors->first('line_1', '<small class="text-danger">:message</small>') !!}
																</div>
																<div class="col-sm-6 @if($errors->first('line_2')){{'has-error'}} @endif">
																	{!! Form::text('line_2', isset($user->line_2) ? $user->line_2 : null, array('placeholder'=>'line 2', 'class'=>'form-control')) !!}
																	{!! $errors->first('line_2', '<small class="text-danger">:message</small>') !!}
																</div>
															</div>
														</div>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="form-group @if($errors->first('city') && $errors->first('state')){{'has-error'}} @endif">
														<div class="col-sm-12">
															<div class="row">
																<div class="col-sm-6 @if($errors->first('city')){{'has-error'}} @endif">
																	{!! Form::text('city', isset($user->city) ? $user->city :null, array('placeholder'=>'City', 'class'=>'form-control','required')) !!}
																	{!! $errors->first('city', '<small class="text-danger">:message</small>') !!}
																</div>
																<div class="col-sm-6 @if($errors->first('state')){{'has-error'}} @endif">
																	{!! Form::text('state', isset($user->state) ? $user->state : null, array('placeholder'=>'state', 'class'=>'form-control','required')) !!}
																	{!! $errors->first('state', '<small class="text-danger">:message</small>') !!}
																</div>
															</div>
														</div>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="form-group @if($errors->first('postal_code') && $errors->first('country')){{'has-error'}} @endif">
														<div class="col-sm-12">
															<div class="row">
																<div class="col-sm-6 @if($errors->first('postal_code')){{'has-error'}} @endif">
																	{!! Form::text('postal_code', isset($user->postal_code) ? $user->postal_code :null, array('placeholder'=>'postal code', 'class'=>'form-control','required')) !!}
																	{!! $errors->first('postal_code', '<small class="text-danger">:message</small>') !!}
																</div>
																<div class="col-sm-6 @if($errors->first('country')){{'has-error'}} @endif">
																	<select name="country" class="form-control">
																		@foreach(\App\Http\Utilities\Country::all() as $country => $code)
																		<option @if(!Auth::guest() && $user->country == $country) value="{{$country}}" selected="selected" @else value="{{$country}}" @endif>{{$country}}</option>
																		@endforeach
																	</select>
																	{!! $errors->first('country', '<small class="text-danger">:message</small>') !!}
																</div>
															</div>
														</div>
													</div>
												</div>
												{{-- <br><br>
												<div class="row">
													<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
														<button class="btn btn-primary btn-block" id="step-3">Next</button>
													</div>
												</div> --}}
											</div>

										</div>
									</div>
									<br>
									<div class="row " id="section-6">
										<div class="col-md-12">
											<div>
												<label>Tax File Number (applicable to Australian investors only)</label>
												<input type="text" class="form-control" name="tfn" placeholder="Tax File Number (applicable to Australian investors only)" @if(!Auth::guest() && $user->tfn) value="{{$user->tfn}}" @endif>
												<p><small>You are not required to provide your TFN, but in it being unavailable we will be required to withhold tax at the highest marginal rate of 49.5% </small></p><br>
												<div class="row">
													<div class="col-md-6">
														<label>Phone</label>
														<input type="text" name="phone" class="form-control" placeholder="Phone" required @if(!Auth::guest() && $user->phone_number) value="{{$user->phone_number}}" @endif>
													</div>
													<div class="col-md-6">
														<label>Email</label>
														<input type="text" name="email" id="offerEmail" class="form-control" placeholder="Email" required @if(!Auth::guest() && $user->email)disabled value="{{$user->email}}" @endif @if(isset($eoi))disabled value="{{$user->email}}" @endif style="background:transparent;">
													</div>
												</div>
											</div>
										</div>
									</div>
									<br>
									<div class="row " id="section-7">
										<div class="col-md-12">
											<h3>Nominated Bank Account</h3>
											<h5 style="color: #000">Please enter your bank account details where you would like to receive any Dividend or other payments related to this investment</h5>
											<hr>
											<div>
												<div class="row">
													<div class="col-md-4">
														<label>Account Name</label>
														<input type="text" name="account_name" class="form-control" placeholder="Account Name"  @if(!Auth::guest() && $user->account_name) value="{{$user->account_name}}" @endif>
													</div>
													<div class="col-md-4">
														<label>BSB</label>
														<input type="text" name="bsb" class="form-control" placeholder="BSB"  @if(!Auth::guest() && $user->bsb) value="{{$user->bsb}}" @endif>
													</div>
													<div class="col-md-4">
														<label>Account Number</label>
														<input type="text" name="account_number" class="form-control" placeholder="Account Number"  @if(!Auth::guest() && $user->account_number) value="{{$user->account_number}}" @endif>
													</div>
												</div>

												{{-- <div class="row">
													<div class="text-left col-md-offset-5 col-md-2 wow fadeIn animated">
														<button class="btn btn-primary btn-block" id="step-7">Next</button>
													</div>
												</div> --}}
											</div>

										</div>
									</div>
									@if(Auth::guest())
									<input type="password" name="password" class="hidden" id="passwordOffer">
									<input type="text" name="role" class="hidden" value="investor">
									@endif
									<br>
									<div class="row " id="section-8">
										<div class="col-md-12">
											<div>
												<input type="checkbox" name="confirm" checked>	I/We confirm that I/We have not been provided Personal or General Financial Advice by Tech Baron PTY LTD which provides Technology services as platform operator. I/We have relied only on the contents of this @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif in deciding to invest and will seek independent adviser from my financial adviser if needed.
												I/we as Applicant declare (i) that I/we have read the entire @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif, (ii) that if an electronic copy of the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif has been used, that I/we obtained the entire @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif, not just the application form; and (iii) that I/we have not obtained any personal financial advice from Tech Baron Pty Ltd or any of its employees. I/we agree to be bound by the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif (as amended from time to time) and acknowledge that neither Tech Baron Pty Ltd nor any of its employees guarantees the performance of any offers, the payment of distributions or the repayment of capital. I/we acknowledge that any investment is subject to investment risk (as detailed in the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif). I/we confirm that we have provided accurate and complete documentation requested for AML/CTF investor identification and verification purposes.

												@if($project->add_additional_form_content)
												<p style="margin-top: 0.3em;">{{$project->add_additional_form_content}}</p>
												@endif
												{{-- <div class="row">
													<div class="text-left col-md-offset-5 col-md-2 wow fadeIn animated">
														<button class="btn btn-primary btn-block" id="step-8">Next</button>
													</div>
												</div> --}}
											</div>

										</div>
									</div>
									@if(Auth::guest())
									@else
									@if(App\Helpers\SiteConfigurationHelper::isSiteAdmin())
									<div class="row text-left">
										<a href="#myModal" class="fa fa-pencil edit-pencil-style show-content-edit-modal-btn" style="font-size: 20px; color: #000; border: 1.5px solid #000; border-radius: 50px; padding: 5px; margin-right: 3px; margin-top: 5px;" data-toggle="modal" title="Add additional content" data-placement="top"></a>
										<b>Add Additional Content Here</b>
									</div>
									@endif
									@endif
									<br>
									<div class="row @if(!$project->show_interested_to_buy_checkbox) hide @endif">
										<div class="col-md-12">
											<div>
												<input type="hidden" name="interested_to_buy" value="0">
												<input type="checkbox" name="interested_to_buy" value="1">  I am also interested in purchasing one of the properties being developed. Please have someone get in touch with me with details
											</div>
										</div>
										<br>
									</div>
									<div class="row text-center">
										<div class="col-md-8 col-md-offset-4">
											<div class="switch-field">
												<input type="radio" id="switch_left" name="signature_type" value="0" checked/>
												<label for="switch_left">Draw to sign</label>
												<input type="radio" id="switch_right" name="signature_type" value="1" />
												<label for="switch_right">Type to sign</label>
											</div>
										</div>
									</div>
									<div class="row hidden" id="typeSignatureDiv">
										<div class="col-md-8 col-md-offset-2">
											<input type="text" name="signature_data_type" class="form-control" id="typeSignatureData" style="font-size: 80px;height: 120px;font-family: 'Mr De Haviland' !important; font-variant: normal; font-weight: 100; line-height: 15px; padding-left: 10px; text-align: center;" disabled>
										</div>
									</div>
									<script type="text/javascript" src="/assets/plugins/jSignature/flashcanvas.js"></script>
									<script src="/assets/plugins/jSignature/jSignature.min.js"></script>
									<div id="signature"><button class="btn pull-right" id="signatureClear">Clear</button></div>
									<h4 class="text-center">Please Sign Here</h4>
									<input type="hidden" name="signature_data" id="signature_data" value="">
									<script>
										$(document).ready(function() {
											$("#signature").jSignature();
											$("#signatureClear").click(function (e) {
												e.preventDefault();
												$("#signature").jSignature("reset");
											});
											$("#signature").bind('change', function(e){
												var svgData = $(this).jSignature("getData", "image");
												$('#signature_data').val(svgData[1]);
											});
										});
									</script>
									<br><br>
									<div class="row " id="11">
										<div class="col-md-12">
											<div>
												<input type="submit" name="submitoffer" class="btn btn-primary btn-block" value="Submit" id="offerSubmit">
											</div>
										</div>
									</div>
									<textarea class="g-recaptcha-response hide" name="g-recaptcha-response"></textarea>
								</form>
								<br><br>
							</div>
							<div class="col-md-2">
								<img src="{{asset('assets/images/estate_baron_hat1.png')}}" alt="Estate Baron Masoct" class="pull-right img-responsive" style="padding-top:23em;position: fixed;width: 150px;">
							</div>
						</div>
					</div>

					@if ($project->show_download_pdf_page)
					<div class="col-md-5 hide">
						<br>
						<!-- <p class="" style="font-size:1em;color:#282a73;">Please read the following PDS and Financial Services
							Guide carefully and when you are ready to invest, fill the application form electronically and transfer your funds to the following account
						</p> -->
						<!-- <table class="table table-bordered" width="100%">
							<tr>
								<th>Bank</th>
								<th> NAB Pitt St Sydney</th>
							</tr>
							<tr>
								<th>Account Name</th>
								<th>AETL acf The Guardian Investment Fund</th>
							</tr>
							<tr>
								<th>BSB </th>
								<th>082-067</th>
							</tr>
							<tr>
								<th>Account No</th>
								<th> 84542 8121</th>
							</tr>
							<tr>
								<th>Reference</th>
								<th>Price St < Investor Name > </th>
							</tr>
						</table> -->
						<!-- @if($project->investment) -->
						<!-- @if($project->investment->bank) -->
						<!-- <table class="table table-bordered table-hover">
							<tr><td>Bank</td><td>{!!$project->investment->bank!!}</td></tr>
							<tr><td>Account Name</td><td>{!!$project->investment->bank_account_name!!}</td></tr>
							<tr><td>BSB </td><td>{!!$project->investment->bsb!!}</td></tr>
							<tr><td>Account No</td><td>{!!$project->investment->bank_account_number!!}</td></tr>
							<tr><td>Reference</td><td>{!!$project->investment->bank_reference!!}</td></tr>
						</table> -->
						<!-- @endif -->
						<!-- @endif -->
						<!-- <p>We will get in touch with you to confirm receipt and provide investor unit certificates to reflect your investment in the project</p> -->
						<table class="table table-hover">
							<!-- <tr >
								<td class="font-regular">
									Read this Document to get all details of the {{$project->title}}<br>
									<a class="btn btn-primary btn-block font-bold " style="background-color:#2d2d4b;font-size:1em;color:#ffffff;border-color: #2d2d4b;" href="{{$project->investment->PDS_part_2_link}}" target="_blank">Download Part 2 PDS</a>
								</td>
							</tr> -->
							<tr >
								<td class="font-regular">
									<!-- Read this Document for the fund structure and other technical/legal details -->
									This @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif contains forward looking statements. Those statements are based upon the Directors’ current expectations in regard to future events or results. All forecasts in this @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif are based upon the assumptions described in Section 10.1. Actual results may be materially affected by changes in circumstances, some of which may be outside the control of the Company. The reliance that investors place on the forecasts is a matter for their own commercial judgment. No representation or warranty is made that any forecast, assumption or estimate contained in this @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif will be achieved.
									<br><br>
									Seek professional advice from your accountant, lawyer or other professional adviser before deciding whether to invest. The information provided in this @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif does not constitute personal financial product advice and has been prepared without taking into account your investment objectives, financial situation or particular needs. It is important that you read this @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif in its entirety before deciding to invest and consider the risk factors that could affect the Company’s performance.
									<br>
									<a class="btn btn-primary btn-block font-bold download-prospectus-btn" style="background-color:#2d2d4b;font-size:1em;color:#ffffff;border-color: #2d2d4b;" href="@if($project->investment){{$project->investment->PDS_part_1_link}}@else#@endif" target="_blank">Download @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif</a>
								</td>
							</tr>
							<tr >
								<td class="font-regular">
									<b>Tech Baron PTY LTD Declaration</b><br>
									We have to provide this document to you along with the application form, it defines the services we are providing as an authorized Representative of our license holding partner
									<br>
									<a class="btn btn-primary btn-block font-bold" style="background-color:#2d2d4b;font-size:1em;color:#ffffff;border-color: #2d2d4b;" href="@if(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->financial_service_guide_link){{App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->financial_service_guide_link}}@else{{'https://www.dropbox.com/s/gux7ly75n4ps4ub/Tech%20Baron%20AusFirst%20Financial%20Services%20Guide.pdf?dl=0'}}@endif" target="_blank">Download Financial Services Guide
									</a>
								</td>
							</tr>
						</table>
						<!-- <a class="btn btn-primary btn-block" href="{{asset('offer_doc_pdf/Mount_Waverley_PDS_Bank_acct_FSG.pdf')}}" target="_blank">PDF Download</a> -->
					</div>
					@endif

				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal For Additional Form Content -->
<div class="bs-example">
	<div id="myModal" class="modal fade">
		<div class="modal-dialog">
			<form method="POST" action="{{route('AdditionalFormContent', $project->id)}}">
				{{csrf_field()}}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Add Content</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<input type="text" class="form-control" name="add_additional_form_content" value="{{$project->add_additional_form_content}}">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- <section id="section-colors-right" class="color-panel-right panel-close-right left" style="opacity: .8;">
	<div class="color-wrap-right">
		<h3>Updates</h3>
		<p style="color:#000;">Someone In <b><span id="addlocation"></span></b>, Victoria Invested <b>$<span id="addamount"></span></b> in Mount Waverley townhouse Development</p>
	</div>
</section>
<section id="section-colors-left" class="color-panel-left panel-open-left center" style="opacity: .8;">
	<div class="color-wrap-left">
		<p style="color:#000;"><b><span id="numberofpeople"></span></b> people reading this offer document right now!</p>
	</div>
</section> -->
@if($project->investment)
@include('projects.offer.terms')
@endif
@if(Auth::guest())
@include('partials.loginModal');
@include('partials.registerModal');
@include('partials.emailCheck');
@endif
@stop
@section('js-section')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
{!! Html::script('plugins/wow.min.js') !!}
<!-- Script for reCaptcha -->
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
	$(function () {
		// Function that runs with interval for side panel
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
		}, 120000);
		var d = new Date();
		var n = d.getHours();
		if(n>=6){
			var y = (Math.floor(Math.random() * 15) + 5);
			$('#numberofpeople').html(y);
			window.setInterval(function(){
				$('#section-colors-left').removeClass('panel-close-left');
				$('#section-colors-left').addClass('panel-open-left');
				var y = (Math.floor(Math.random() * 15) + 5);
				$('#numberofpeople').html(y);
				// document.getElementById("numberofpeople").innerHTML = y;
			},60000);
		}else{
			$('#section-colors-left').toggleClass('panel-open-left panel-close-left');
		}
		$('#gform_submit_button_11').click(function(event){
			$('html, body').animate({
				scrollTop: $("#forScroll").offset().top
			}, 2000);
		});
		var mq = window.matchMedia("(min-width: 768px)");
		if(mq.matches){
		}else{
			$('#section-colors').addClass('hide');
			$('#section-colors-left').addClass('hide');
		}
	});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
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
	$(document).ready(function(){
		var qty=$("#apply_for");
		qty.bind('keyup mouseup', function (){
			var total='A$ '+qty.val().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			$("#application_money").val(total);
		});
	});
	$(document).ready( function() {
		$("input[name='investing_as']").on('change',function() {
			if($(this).is(':checked') && $(this).val() == 'Individual Investor')
			{
				$('#normal_id_docs').removeAttr('style');
				$('#joint_investor_docs').attr('style','display:none;');
				$('#trust_doc').attr('style','display:none;');
				$('#company_trust').attr('style','display:none;');
				$('#joint_investor').attr('style','display:none;');
				$("input[name='joint_investor_first']").attr('disabled','disabled');
				$("input[name='joint_investor_last']").attr('disabled','disabled');
				$("input[name='investing_company_name']").attr('disabled','disabled');
				$("input[name='user_id_doc']").removeAttr('disabled');
				$("input[name='trust_or_company_docs']").attr('disabled','disabled');
				$("input[name='joint_investor_id_doc']").attr('disabled','disabled');
			}
			else if($(this).is(':checked') && $(this).val() == 'Joint Investor')
			{
				$('#joint_investor_docs').removeAttr('style');
				$('#normal_id_docs').removeAttr('style');
				$('#trust_doc').attr('style','display:none;');
				$('#company_trust').attr('style','display:none;');
				$('#joint_investor').removeAttr('style');
				$("input[name='joint_investor_first']").removeAttr('disabled');
				$("input[name='joint_investor_last']").removeAttr('disabled');
				$("input[name='investing_company_name']").attr('disabled','disabled');
				$("input[name='joint_investor_id_doc']").removeAttr('disabled');
				$("input[name='trust_or_company_docs']").attr('disabled','disabled');
				$("input[name='user_id_doc']").removeAttr('disabled');
			}
			else
			{
				$('#trust_doc').removeAttr('style');
				$('#normal_id_docs').attr('style','display:none;');
				$('#joint_investor_docs').attr('style','display:none;');
				$('#joint_investor').attr('style','display:none;');
				$('#company_trust').removeAttr('style');
				$("input[name='joint_investor_first']").attr('disabled','disabled');
				$("input[name='joint_investor_last']").attr('disabled','disabled');
				$("input[name='investing_company_name']").removeAttr('disabled');
				$("input[name='joint_investor_id_doc']").attr('disabled','disabled');
				$("input[name='trust_or_company_docs']").removeAttr('disabled');
				$("input[name='user_id_doc']").attr('disabled','disabled');
			}

		});
		@if(!Auth::guest() && $user->idDoc && $user->idDoc->investing_as == 'Individual Investor')
		$("input[value='Individual Investor']").trigger("initCheckboxes");
		@elseif(!Auth::guest() && $user->idDoc && $user->idDoc->investing_as == 'Joint Investor')
		console.log($("input[name='investing_as']"));
		$("input[value='Joint Investor']").trigger("click");
		@elseif(!Auth::guest() && $user->idDoc && $user->idDoc->investing_as == 'Trust or Company')
		$("input[value='Trust or Company']").trigger("initCheckboxes");
		@endif
		// Slide and show the aml requirements section
		$('.aml-requirements-link').click(function(e){
			$('.aml-requirements-section').slideToggle();
			if($('.aml-requirements-link i').hasClass('fa-plus')){
				$('.aml-requirements-link i').removeClass('fa-plus');
				$('.aml-requirements-link i').addClass('fa-minus');
			}
			else{
				$('.aml-requirements-link i').removeClass('fa-minus');
				$('.aml-requirements-link i').addClass('fa-plus');
			}
		});
		// Submit Request for Form Filling
		$('.send-form-filling-request').click(function(e){
			@if(Auth::guest())
			e.preventDefault();
			$('#checkEmail').modal('show');
			$('.checkEmailRequest').on('click', function (event) {
				event.preventDefault();
				var _token = $('meta[name="csrf-token"]').attr('content');
				var email = $('#defaultForm-email').val();
				$.post('/users/login/check',{email:email,_token:_token},function (data) {
					if(data == email){
						$('#checkEmail').modal('hide');
						$('#loginEmailEoi').val(email);
						$("#loginModal").modal('show');
						$('#offer_user_login_form').submit(function (t) {
							t.preventDefault();
							var password = $('#loginPwdEoi').val();
							$('#passwordOffer').val(password);
    						// $('#myform').submit();
    						$('#offerEmail').removeAttr('disabled');
    						$('#offerEmail').attr('disabled');
    						$('.loader-overlay').show();
    						var projectId = {{$project->id}};
    						$.ajax({
    							type: "POST",
    							url: "/users/login/requestformfilling",
    							data: { email: email, password: password, project_id: projectId,_token:_token },
    							datatype: 'json',
    							success: function (data) {
    								if(data.success == true){
    									$('#loginModal').modal('hide');
    									window.location.href = "/projects/"+projectId+"/interest/request";
    								}else{
    									$('.loader-overlay').hide();
    									$('#loginErrors').html();
    									$('#loginErrors').html('<div class="alert alert-danger">Authentication failed! Please check your password.</div>');
    								}
    							},
    							error: function (data) {
    								$('.loader-overlay').hide();
    								$('#session_message').html(data);
    								return false;
    							}
    						});
    					});
					}else{
						$('#checkEmail').modal('hide');
						$('#eoiREmail').val(email);
						$('#eoiREmail').prop('disabled',true);
						$('#requestFormPhoneNumber').css('display','block');
						$('.user-name-details-section').removeClass('hide');
						$('#registerModal').modal({
							keyboard: false,
							backdrop: 'static'
						});
						$('#submitform').on('click', function (e) {
							var projectId = {{$project->id}};
							e.preventDefault();

							if($.trim($('#reg_first_name').val()) == '') {
								$('#reg_first_name').siblings('.text-danger').remove();
								$('#reg_first_name').after('<div class="text-danger"><small>First name is required</small></div>');
								return false;
							} else {
								$('#reg_first_name').siblings('.text-danger').remove();
							}
							if($.trim($('#reg_last_name').val()) == '') {
								$('#reg_last_name').siblings('.text-danger').remove();
								$('#reg_last_name').after('<div class="text-danger"><small>Last name is required</small></div>');
								return false;
							} else {
								$('#reg_last_name').siblings('.text-danger').remove();
							}
							$('#RegPassword').on('input',function (e) {
								var name=$('#RegPassword').val();
								if(name.length == 0){
									$('#RegPassword').siblings('.text-danger').remove();
									$('#RegPassword').after('<div class="text-danger"><small>Password is Required</small></div>');
								}
							});
							var password = $('#RegPassword').val();
							if(password.length == 0){
								$('#RegPassword').siblings('.text-danger').remove();
								$('#RegPassword').after('<div class="text-danger"><small>Password is Required</small></div>');
								return false;
							}
							$('#requestFormPhoneNumber').on('input',function (e) {
								var phone_number = $('#requestFormPhoneNumber').val();
								if(phone_number.length == 0){
									$('#requestFormPhoneNumber').siblings('.text-danger').remove();
									$('#requestFormPhoneNumber').after('<div class="text-danger"><small>Phone number is Required</small></div>');
									return false;
								}
							});
							var phone_number = $('#requestFormPhoneNumber').val();
							if(phone_number.length == 0){
								$('#requestFormPhoneNumber').siblings('.text-danger').remove();
								$('#requestFormPhoneNumber').after('<div class="text-danger"><small>Phone number is Required</small></div>');
								return false;
							}
							var captchaToken = $('#g-recaptcha-response').val();
							$('.g-recaptcha-response').val(captchaToken);
							if (captchaToken.length == 0) {
								$('.g-recaptcha-response').siblings('.text-danger').remove();
								$('.g-recaptcha-response').after('<div class="text-danger"><small>Recaptcha is Required</small></div>');
								return false;
							}
							$('#passwordOffer').val(password);
							$('.loader-overlay').show();
							$.ajax({
								type: "POST",
								headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
								url: "/users/register/"+projectId+"/requestformfilling",
								data: {
									email:email,
									password:password,
									_token:_token,
									request_form_project_id:projectId,
									phone_number:phone_number,
									first_name: $('#reg_first_name').val(),
									last_name: $('#reg_last_name').val()
								},
								dataType: 'json',
								success: function (data) {
									if(data.success){
										$('#registerModal').modal('hide');
										$('.loader-overlay').hide();
    									setTimeout(function(){// wait for 5 secs(2)
           								window.location.href = "/users/register/offer/code?fn="+data.data.first_name+"&ln="+data.data.last_name; // then reload the page.(3)
           							}, 100);
    									console.log('inside success');
    								} else {
    									$('.loader-overlay').hide();
    									if(data.errors) {
    										var errorsText = '';
    										$.each(data.errors, function(k, v) {
    											errorsText += "- " + v + "<br>";
    										});
    										$('#session_message').html('<div class="alert alert-danger"><small>'+errorsText+'</small></div>');
    									}
    								}
    							},
    							error: function (error) {
    								$('.loader-overlay').hide();
    								$('#session_message').html(error);
    								console.log('You are in error');
    							}
    						});
						});
					}
				});
			});
@else
if (confirm('This will raise a request for form filling. Do you want to continue ?')) {
	console.log('confirmed');
} else {
	e.preventDefault();
}
@endif
});
});

$(document).ready( function() {
	$("input[name='wholesale_investing_as']").on('change',function() {
		if($(this).is(':checked') && $(this).val() == 'Wholesale Investor (Net Asset $2,500,000 plus)')
		{
			$('#accountant_details_section').show();
			$('#experienced_investor_information_section').hide();
		}
		else if($(this).is(':checked') && $(this).val() == 'Sophisticated Investor')
		{
			$('#experienced_investor_information_section').show();
			$('#accountant_details_section').hide();
		}
		else
		{
			$('#experienced_investor_information_section').hide();
			$('#accountant_details_section').hide();
		}
	});

	$(".wholesale_invest_checkbox").change(function() {
		var checked = $(this).is(':checked');
		$(".wholesale_invest_checkbox").prop('checked',false);
		if(checked) {
			$(this).prop('checked',true);
		}
	});
		// Track users downloading prospectus
		$('.download-prospectus-btn').click(function(){
			var projectId = {{$project->id}};
			$.ajax({
				url: '/projects/prospectus',
				type: 'POST',
				dataType: 'JSON',
				data: {projectId:projectId},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			}).done(function(data){
				console.log(data);
				location.reload('/');
			});
		});
	});
$(document).ready(function(){
	$('#myTermsModal').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#switch_right').click(function () {
		$('#typeSignatureDiv').removeClass('hidden');
		$('#signature').addClass('hidden');
		$('#signature_data').prop('disabled',true);
		$('#typeSignatureData').prop('disabled',false);
	});
	$('#switch_left').click(function () {
		$('#signature').removeClass('hidden');
		$('#typeSignatureDiv').addClass('hidden');
		$('#signature_data').prop('disabled',false);
		$('#typeSignatureData').prop('disabled',true);
	});
	$('#myform').submit(function(event) {
		@if(Auth::guest())
		var $this = $(this);
		event.preventDefault();
		var email = $('#offerEmail').val();
		var _token = $('meta[name="csrf-token"]').attr('content');
		$.post('/users/login/check',{email: email,_token:_token},function (data) {
			if(data == email){
    			// $('#myform').attr('action','/users/login/offer');
    			$('#loginEmailEoi').val(email);
    			$("#loginModal").modal();
    			$('#offer_user_login_form').submit(function (e) {
    				e.preventDefault();
    				var password = $('#loginPwdEoi').val();
    				$('#passwordOffer').val(password);
    				// $('#myform').submit();
    				$('#offerEmail').removeAttr('disabled');
    				var offerData = $('#myform').serialize();
    				$('#offerEmail').attr('disabled');
    				$('.loader-overlay').show();
    				$.ajax({
    					type: "POST",
    					url: "/users/login/offer",
    					data: offerData,
    					datatype: 'html',
    					success: function (data) {
    						if(!data.success){
    							$('.loader-overlay').hide();
    							$('#loginModal #loginErrors').html('<div class="alert alert-danger text-center" style="color:red;">Authentication failed please check your password</div>');
    							return false;
    						}
    						$('.loader-overlay').hide();
    						$('#loginModal').modal('hide');
    						$('#mainPage').html(data.html);
    						$("html, body").animate({ scrollTop: 0 }, "slow");

    					},
    					error: function (data) {
    						$('.loader-overlay').hide();
    						$('#session_message').html(data);
    						return false;
    					}
    				});
    			});
    		}else{
    			// $('#eoiREmail').val(email);
    			// $('#registerModal').modal({
    			// 	keyboard: false,
    			// 	backdrop: 'static'
    			// });
    			// var offerData = $('#myform').serialize();
    			// console.log(offerData);
    			// $('#submitform').click(function (e) {
    			// 	var projectId = {{$project->id}};
    			// 	e.preventDefault();
    			// 	$('#RegPassword').on('input',function (e) {
    			// 		var name=$('#RegPassword').val();
    			// 		if(name.length == 0){
    			// 			$('#RegPassword').after('<div class="red">Password is Required</div>');
    			// 		}
    			// 	});
    			// 	var password = $('#RegPassword').val();
    			// 	if(password.length == 0){
    			// 		$('#RegPassword').after('<div class="red">Password is Required</div>');
    			// 		return false;
    			// 	}
    			// 	$('#passwordOffer').val(password);
    			// 	$('.loader-overlay').show();
    			// 	var offerData = $('#myform').serialize();
    			// 	console.log(offerData);
    			// 	$.ajax({
    			// 		type: "POST",
    			// 		headers: {
    			// 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    			// 		},
    			// 		url: "/users/register/"+projectId+"/offer",
    			// 		data: offerData,
    			// 		dataType: 'json',
    			// 		success: function (data) {
    			// 			$('#registerModal').modal('hide');
    			// 			$('.loader-overlay').hide();
    			// 			setTimeout(function(){// wait for 5 secs(2)
       //     						window.location.href = "/users/register/offer/code"; // then reload the page.(3)
       //     					}, 100);
    			// 			console.log('inside success');
    			// 		},
    			// 		error: function (error) {
    			// 			$('.loader-overlay').hide();
    			// 			$('#session_message').html(error);
    			// 			console.log('You are in error');
    			// 		}
    			// 	});
    			// });


    			/* Start of section - Register user without verification email */
    			$('#eoiREmail').val(email);
    			$('.user-name-details-section').addClass('hide');
    			$('#registerModal').modal({
    				keyboard: false,
    				backdrop: 'static'
    			});

    			$('#submitform').unbind('click');
				$('#submitform').on('click', function(){
    				$('#submit1').trigger('click');
    			});

    			$('form[name=offer_user_registration_form]').unbind('submit');
    			$('form[name=offer_user_registration_form]').on('submit', function(e) {
    				var captchaToken = $('#g-recaptcha-response').val();
    				$('.g-recaptcha-response').val(captchaToken);
    				$('#offerEmail').val($('#eoiREmail').val());
    				var projectId = {{$project->id}};
    				e.preventDefault();
    				$('#RegPassword').on('input',function (e) {
    					var name=$('#RegPassword').val();
    					if(name.length == 0){
    						$('#RegPassword').siblings('.text-danger').remove();
    						$('#RegPassword').after('<div class="text-danger"><small>Password is Required</small></div>');
    					} else {
    						$('#RegPassword').siblings('.text-danger').remove();
    					}
    				});
    				var password = $('#RegPassword').val();
    				if(password.length == 0){
    					$('#RegPassword').siblings('.text-danger').remove();
    					$('#RegPassword').after('<div class="text-danger"><small>Password is Required</small></div>');
    					return false;
    				}
    				$('#passwordOffer').val(password);
    				$('.loader-overlay').show();
    				var offerData = $('#myform').serialize();
    				console.log(offerData);
    				$.ajax({
    					type: "POST",
    					headers: {
    						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    					},
    					url: "/users/register/login/"+projectId+"/offer",
    					data: offerData,
    					dataType: 'json',
    					success: function (data) {
    						if(data.status) {
    							$('#myform').unbind('submit').submit();
    							console.log('offer submitted');
    						} else {
    							$('#session_message').html('<div class="alert alert-danger alert-sm"><small>'+data.message+'</small></div>');
    							$('.loader-overlay').hide();
    						}
    					},
    					error: function (error) {
    						$('.loader-overlay').hide();
    						$('#session_message').html(error);
    						console.log('You are in error');
    					}
    				});
    			});
    			/* End of section - Register user without verification email */
    		}
    	});
@else
    	$('.loader-overlay').show(); // show animation
    	return true; // allow regular form submission
    	@endif
    });
});
function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
</script>
</script>
@stop
