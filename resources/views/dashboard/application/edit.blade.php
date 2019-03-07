@extends('layouts.main')
@section('title-section')
Edit {!! $investment->user->first_name !!} | Dashboard | @parent
@stop

@section('css-section')
@parent
@stop
@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>1])
		</div>
		<div class="col-md-10 well">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<section id="signUpForm">
				<div class="row">
					<div class="col-md-12 center-block">
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
								<form action="{{route('dashboard.application.update', [$investment->id])}}" rel="form" method="POST" enctype="multipart/form-data" id="myform">
									{!! csrf_field() !!}
									<div class="row" id="section-1">
										<div class="col-md-12">
											<h2 class="text-center">INV{{$investment->id}}</h2><br>
											<div>
												<label class="form-label">Project Name</label><br>
												<input class="form-control" type="text" name="project_spv_name" placeholder="Project Name" style="width: 60%;" @if($projects_spv) value="{{$projects_spv->spv_name}}" disabled @endif >
												<br>
												<p>
													This Application Form is important. If you are in doubt as to how to deal with it, please contact your professional adviser without delay. You should read the entire @if($investment->project->project_prospectus_text!='') {{$investment->project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif carefully before completing this form. To meet the requirements of the Corporations Act, this Application Form must  not be distributed unless included in, or accompanied by, the @if($investment->project->project_prospectus_text!='') {{$investment->project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif.
												</p>
												<label>I/We apply for *</label>
												<input type="number" name="amount_to_invest" class="form-control" onkeypress="return isNumber(event)" placeholder="Minimum Amount A${{$investment->project->investment->minimum_accepted_amount}}" style="width: 60%" id="apply_for" min="{{$investment->project->investment->minimum_accepted_amount}}" step="100" required value="{{$investment->amount}}">
												@if($investment->project->share_vs_unit == 1)
												<h5>Number of Redeemable Preference Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</h5>
												@elseif($investment->project->share_vs_unit == 2)
												<h5>Number of Preference Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</h5>
												@elseif($investment->project->share_vs_unit == 3)
												<h5>Number of Ordinary Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</h5>
												@else
												<h5>Number of Units at $1 per Unit or such lesser number of Units which may be allocated to me/us</h5>
												@endif
												<label>I/We lodge full Application Money</label>
												<input type="text" name="apply_for" class="form-control" placeholder="$5000" value="A$ {{number_format(round($investment->amount, 2))}}" disabled="" style="width: 60%; background-color: #fff" id="application_money">
												<input type="text" name="project_id" @if($investment->projects_spv) value="{{$investment->projects_spv->project_id}}" @endif hidden >
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
																If investing via a Financial Adviser please provide the @if($investment->project->md_vs_trustee)Managing Director @else Trustee @endif the necessary verification otherwise you need to lodge the following information.
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
									{{-- @if(!Auth::guest() && !$investment->user->idDoc) --}}
									<div class="row " id="section-2">
										<div class="col-md-12">
											<div >
												<h5>Individual/Joint applications - refer to naming standards for correct forms of registrable title(s)</h5>
												<br>
												<h4>Are you Investing as</h4>
												<input type="radio" name="investing_as" value="Individual Investor" @if($investment->investing_as == "Individual Investor") checked @endif> Individual Investor<br>
												<input type="radio" name="investing_as" value="Joint Investor" @if($investment->investing_as =="Joint Investor") checked @endif> Joint Investor<br>
												<input type="radio" name="investing_as" value="Trust or Company" @if($investment->investing_as == "Trust or Company") checked @endif > Company, Trust or SMSF<br>
												<hr>
											</div>

										</div>
									</div>
									<div class="row " id="section-3">
										<div class="col-md-12">
											<div @if($investment->investing_as !== 'Trust or Company') style="display: none;" @endif id="company_trust">
												<label>Company or Trust Name</label>
												<div class="row">
													<div class="col-md-9">
														<input type="text" name="investing_company_name" class="form-control" placeholder="Trust or Company" value="@if($investment->investingJoint){{$investment->investingJoint->investing_company}} @endif"  >
													</div>
												</div><br>
											</div>
											<div id="normal_name">
												<label>Given Name(s)</label>
												<div class="row">
													<div class="col-md-9">
														<input type="text" name="first_name" class="form-control" placeholder="First Name" required @if(!Auth::guest() && $investment->user->first_name) value="{{$investment->user->first_name}}" @endif>
													</div>
												</div><br>
												<label>Surname</label>
												<div class="row">
													<div class="col-md-9">
														<input type="text" name="last_name" class="form-control" placeholder="Last Name" required @if(!Auth::guest() && $investment->user->last_name) value="{{$investment->user->last_name}}" @endif>
													</div>
												</div><br>
											</div>
											<div @if($investment->investing_as !== 'Joint Investor') style="display: none; background-color: blue;" @endif id="joint_investor">
												<label>Joint Investor Details</label>
												<div class="row">
													<div class="col-md-6">
														<input type="text" name="joint_investor_first" class="form-control" placeholder="Investor First Name"  @if($investment->investingJoint) value="{{$investment->investingJoint->joint_investor_first_name}}" @endif>
													</div>
													<div class="col-md-6">
														<input type="text" name="joint_investor_last" class="form-control" placeholder="Investor Last Name"  @if($investment->investingJoint) value="{{$investment->investingJoint->joint_investor_last_name}}" @endif>
													</div>
												</div>
												<br>
												<hr>
											</div>
										</div>
									</div>
									{{-- @endif --}}


									<div class="@if($investment->project->retail_vs_wholesale) hide @endif">
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
																	{!! Form::text('line_1', isset($investment->user->line_1) ? $investment->user->line_1 : null, array('placeholder'=>'line 1', 'class'=>'form-control','required')) !!}
																	{!! $errors->first('line_1', '<small class="text-danger">:message</small>') !!}
																</div>
																<div class="col-sm-6 @if($errors->first('line_2')){{'has-error'}} @endif">
																	{!! Form::text('line_2', isset($investment->user->line_2) ? $investment->user->line_2 : null, array('placeholder'=>'line 2', 'class'=>'form-control')) !!}
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
																	{!! Form::text('city', isset($investment->user->city) ? $investment->user->city :null, array('placeholder'=>'City', 'class'=>'form-control','required')) !!}
																	{!! $errors->first('city', '<small class="text-danger">:message</small>') !!}
																</div>
																<div class="col-sm-6 @if($errors->first('state')){{'has-error'}} @endif">
																	{!! Form::text('state', isset($investment->user->state) ? $investment->user->state : null, array('placeholder'=>'state', 'class'=>'form-control','required')) !!}
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
																	{!! Form::text('postal_code', isset($investment->user->postal_code) ? $investment->user->postal_code :null, array('placeholder'=>'postal code', 'class'=>'form-control','required')) !!}
																	{!! $errors->first('postal_code', '<small class="text-danger">:message</small>') !!}
																</div>
																<div class="col-sm-6 @if($errors->first('country')){{'has-error'}} @endif">
																	<select name="country" class="form-control">
																		@foreach(\App\Http\Utilities\Country::all() as $country => $code)
																		<option @if(!Auth::guest() && $investment->user->country == $country) value="{{$country}}" selected="selected" @else value="{{$country}}" @endif>{{$country}}</option>
																		@endforeach
																	</select>
																	{!! $errors->first('country', '<small class="text-danger">:message</small>') !!}
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>
									<br>
									<div class="row " id="section-6">
										<div class="col-md-12">
											<div>
												<label>Tax File Number (applicable to Australian investors only)</label>
												<input type="text" class="form-control" name="tfn" placeholder="Tax File Number (applicable to Australian investors only)" @if(!Auth::guest() && $investment->user->tfn) value="{{$investment->user->tfn}}" @endif>
												<p><small>You are not required to provide your TFN, but in it being unavailable we will be required to withhold tax at the highest marginal rate of 49.5% </small></p><br>
												<div class="row">
													<div class="col-md-6">
														<label>Phone</label>
														<input type="text" name="phone" class="form-control" placeholder="Phone" required @if(!Auth::guest() && $investment->user->phone_number) value="{{$investment->user->phone_number}}" @endif>
													</div>
													<div class="col-md-6">
														<label>Email</label>
														<input type="text" name="email" id="offerEmail" class="form-control" placeholder="Email" required @if(!Auth::guest() && $investment->user->email)disabled value="{{$investment->user->email}}" @endif @if(isset($eoi))disabled value="{{$investment->user->email}}" @endif style="background:transparent;">
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
														<input type="text" name="account_name" class="form-control" placeholder="Account Name"  @if(!Auth::guest() && $investment->user->account_name) value="{{$investment->user->account_name}}" @endif>
													</div>
													<div class="col-md-4">
														<label>BSB</label>
														<input type="text" name="bsb" class="form-control" placeholder="BSB"  @if(!Auth::guest() && $investment->user->bsb) value="{{$investment->user->bsb}}" @endif>
													</div>
													<div class="col-md-4">
														<label>Account Number</label>
														<input type="text" name="account_number" class="form-control" placeholder="Account Number"  @if(!Auth::guest() && $investment->user->account_number) value="{{$investment->user->account_number}}" @endif>
													</div>
												</div>
											</div>
										</div>
									</div>
									<br>
									{{-- <div class="row " id="section-2">
										<div class="col-md-12">
											<div >
												<h5>Individual/Joint applications - refer to naming standards for correct forms of registrable title(s)</h5>
												<br>
												<h4>Are you Investing as</h4>
												<input type="radio" name="investing_as" value="Individual Investor" @if($investment->investing_as=="Individual Investor") checked @endif> Individual Investor<br>
												<input type="radio" name="investing_as" value="Joint Investor" @if($investment->investing_as=="Joint Investor") checked @endif> Joint Investor<br>
												<input type="radio" name="investing_as" value="Trust or Company" @if($investment->investing_as=="Trust or Company") checked @endif > Company, Trust or SMSF<br>
												<hr>
											</div>

										</div>
									</div>
									<br> --}}
									<div class="row @if(!$investment->project->show_interested_to_buy_checkbox) hide @endif">
										<div class="col-md-12">
											<div>
												<input type="hidden" name="interested_to_buy" value="0">
												<input type="checkbox" name="interested_to_buy" value="1" @if($investment->interested_to_buy) checked @endif>  I am also interested in purchasing one of the properties being developed. Please have someone get in touch with me with details
											</div>
										</div>
										<br>
									</div>
									<br><br>
									<div class="row " id="11">
										<div class="col-md-12">
											<div>
												<input type="submit" name="submitoffer" class="btn btn-primary btn-block" value="Submit" id="offerSubmit">
											</div>
										</div>
									</div>
								</form>
								<br><br>
							</div>
							<div class="col-md-2">
								<img src="{{asset('assets/images/estate_baron_hat1.png')}}" alt="Estate Baron Masoct" class="pull-right img-responsive" style="padding-top:23em;position: fixed;width: 150px;">
							</div>
						</div>
					</div>

					@if ($investment->project->show_download_pdf_page)
					<div class="col-md-5 hide">
						<br>
						<table class="table table-hover">
							<tr >
								<td class="font-regular">
									<!-- Read this Document for the fund structure and other technical/legal details -->
									This @if($investment->project->project_prospectus_text!='') {{$investment->project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif contains forward looking statements. Those statements are based upon the Directors’ current expectations in regard to future events or results. All forecasts in this @if($investment->project->project_prospectus_text!='') {{$investment->project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif are based upon the assumptions described in Section 10.1. Actual results may be materially affected by changes in circumstances, some of which may be outside the control of the Company. The reliance that investors place on the forecasts is a matter for their own commercial judgment. No representation or warranty is made that any forecast, assumption or estimate contained in this @if($investment->project->project_prospectus_text!='') {{$investment->project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif will be achieved.
									<br><br>
									Seek professional advice from your accountant, lawyer or other professional adviser before deciding whether to invest. The information provided in this @if($investment->project->project_prospectus_text!='') {{$investment->project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif does not constitute personal financial product advice and has been prepared without taking into account your investment objectives, financial situation or particular needs. It is important that you read this @if($investment->project->project_prospectus_text!='') {{$investment->project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif in its entirety before deciding to invest and consider the risk factors that could affect the Company’s performance.
									<br>
									<a class="btn btn-primary btn-block font-bold download-prospectus-btn" style="background-color:#2d2d4b;font-size:1em;color:#ffffff;border-color: #2d2d4b;" href="@if($investment->project->investment){{$investment->project->investment->PDS_part_1_link}}@else#@endif" target="_blank">Download @if($investment->project->project_prospectus_text!='') {{$investment->project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif</a>
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
					</div>
					@endif

				</div>
			</div>
		</div>
	</div>
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

		$(document).ready(function(){
		var qty=$("#apply_for");
			qty.bind('keyup mouseup', function (){
				var total='A$ '+qty.val().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				$("#application_money").val(total);
			});
		});

</script>
@stop
