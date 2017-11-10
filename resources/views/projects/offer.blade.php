@extends('layouts.main')
@section('title-section')
Offer Doc
@stop

@section('css-section')
@parent
@stop
@section('content-section')
<div class="container-fluid">
	<div class="row" id="forScroll">
		<div class="col-md-12">
			<div style="display:block;margin:0;padding:0;border:0;outline:0;color:#000!important;vertical-align:baseline;width:100%;">
				<div class="row">
					<div class="col-md-7 investment-gform" id="offer_frame" style="overflow-y: scroll;height: 600px;">
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
								<form action="{{route('offer.store')}}" rel="form" method="POST" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<div class="row" id="section-1">
										<div class="col-md-12">
											<div>
												<label class="form-label">Project SPV Name</label><br>
												<input class="form-control" type="text" name="project_spv_name" placeholder="Project SPV Name" style="width: 60%;" @if($projects_spv) value="{{$projects_spv->spv_name}}" @endif >
												<h5>Name of the Company established as a Special Purpose Vehicle for this project that you are investing in</h5>
												<p>
													This Application Form is important. If you are in doubt as to how to deal with it, please contact your professional adviser without delay. You should read the entire @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif carefully before completing this form. To meet the requirements of the Corporations Act, this Application Form must  not be distributed unless included in, or accompanied by, the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif.
												</p>
												<label>I/We apply for *</label>
												<input type="text" name="amount_to_invest" class="form-control" placeholder="5000" style="width: 60%" id="apply_for" required>
												@if($project->share_vs_unit)
													<h5>Number of Redeemable Preference Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</h5>
												@else
													<h5>Number of Units at $1 per Unit or such lesser number of Units which may be allocated to me/us</h5>
												@endif
												<label>I/We lodge full Application Money</label>
												<input type="text" name="apply_for" class="form-control" placeholder="$5000" value="A$ 0.00" style="width: 60%" id="application_money">
												<input type="text" name="project_id" @if($projects_spv) value="{{$projects_spv->project_id}}" @endif hidden >
												
												{{-- <div class="row">
													<div class="text-left col-md-3 wow fadeIn animated">
														<button class="btn btn-primary btn-block" id="step-1">Next</button>
													</div>
												</div> --}}
											</div>
										</div>
									</div>
									<div class="row " id="section-2">
										<div class="col-md-12">
											<div >
												<h5>Individual/Joint applications - refer to naming standards for correct forms of registrable title(s)</h5>
												<br>
												<h4>Are you Investing as</h4>
												<input type="radio" name="investing_as" value="Individual Investor" checked> Individual Investor<br>
												<input type="radio" name="investing_as" value="Joint Investor"> Joint Investor<br>
												<input type="radio" name="investing_as" value="Trust or Company"> Trust or Company<br>
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
														<input type="text" name="investing_company_name" class="form-control" placeholder="Trust or Company" required disabled="disabled">
													</div>
												</div><br>
											</div>
											<div id="normal_name">
												<label>Given Name(s)</label>
												<div class="row">
													<div class="col-md-9">
														<input type="text" name="first_name" class="form-control" placeholder="First Name" required @if($user->first_name) value="{{$user->first_name}}" @endif>
													</div>
												</div><br>
												<label>Surname</label>
												<div class="row">
													<div class="col-md-9">
														<input type="text" name="last_name" class="form-control" placeholder="Last Name" required @if($user->last_name) value="{{$user->last_name}}" @endif>
													</div>
												</div><br>
											</div>
											<div style="display: none;" id="joint_investor">
												<label>Joint Investor Details</label>
												<div class="row">
													<div class="col-md-6">
														<input type="text" name="joint_investor_first" class="form-control" placeholder="Investor First Name" required disabled="disabled">
													</div>
													<div class="col-md-6">
														<input type="text" name="joint_investor_last" class="form-control" placeholder="Investor Last Name" required disabled="disabled">
													</div>
												</div>
												<br>
												<hr>
											</div>
										</div>
									</div>
									<div class="row " id="section-4">
										<div class="col-md-12">
											<div id="trust_doc" style="display: none;">
												<label>Trust or Company DOCS</label>
												<input type="file" name="trust_or_company_docs" class="form-control" disabled="disabled" required><br>

												<p>Please upload the first and last pages of your trust deed or Company incorporation papers</p>
											</div>
											<div id="normal_id_docs">
												@if($user->investmentDoc->where('user_id', $user->id AND 'type','normal_name'))
												<div class="row">
													<div class="col-md-6">
													</div>
												</div>
												<br>
												@else
												@endif
												<label>ID DOCS</label>
												<input type="file" name="user_id_doc" class="form-control" required><br>
												<p>If you have not completed your verification process. Please upload a copy of your Driver License or Passport for AML/CTF purposes</p>
											</div>
											
											<div id="joint_investor_docs" style="display: none;">
												<label>Joint Investor ID DOCS</label>
												<input type="file" name="joint_investor_id_doc" class="form-control" disabled="disabled" required><br>

												<p>Please upload a copy of the joint investors Driver License or Passport for AML/CTF purposes</p>
											</div>
										</div>
									</div>
									<div class="@if($project->retail_vs_wholesale) hide @endif">
										<div class="row" id="wholesale_project">
											<div class="col-md-12"><br>
												<h4>Investor Qualification</h4>
												<p>An issue of securities to the public usually requires a disclosure document (like a prospectus) to ensure participants are fully informed about a range of issues including the characteristics of the offer and the present position and future prospects of the entity offering the securities.</p>
												<p>However an issue of securities can be made to particular kind of investors, in the categories described below, without the need for a registered disclosure document. Please tell us which category of investors applies:</p>
												<hr>
												<b style="font-size: 1.1em;">Which option closely describes you?</b><br>
												<div style="margin-left: 1.3em; margin-top: 5px;">
													<input type="checkbox" name="wholesale_investing_as" value="Wholesale Investor (Net Asset $2,500,000 plus)" style="margin-right: 6px;" class="wholesale_invest_checkbox">I have net assets of at least $2,500,000 or a gross income for each of the last 2 financial investors of at lease $2,50,000 a year.<br>
													<input type="checkbox" name="wholesale_investing_as" value="Sophisticated Investor" style="margin-right: 6px;" class="wholesale_invest_checkbox">I have experience as to: the merits of the offer; the value of the securities; the risk involved in accepting the offer; my own information needs; the adequacy of the information provided.<br>
													<input type="checkbox" name="wholesale_investing_as" value="Inexperienced Investor" style="margin-right: 6px;" class="wholesale_invest_checkbox"><b>I have no experience in property, securities or similar</b><br>
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
												<input type="radio" name="experience_period_txt" style="margin-right: 6px;" value="Very little knowledge or experience" checked="">Very little knowledge or experience<br>
												<input type="radio" name="experience_period_txt" style="margin-right: 6px;" value="Some investment knowledge and understanding">Some investment knowledge and understanding<br>
												<input type="radio" name="experience_period_txt" style="margin-right: 6px;" value="Experienced private investor with good investment knowledge">Experienced private investor with good investment knowledge<br>
												<input type="radio" name="experience_period_txt" style="margin-right: 6px;" value="Business Investor">Business Investor<br>
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
																	{!! Form::text('line_1', null, array('placeholder'=>'line 1', 'class'=>'form-control','required', 'Value'=> $user->line_1)) !!}
																	{!! $errors->first('line_1', '<small class="text-danger">:message</small>') !!}
																</div>
																<div class="col-sm-6 @if($errors->first('line_2')){{'has-error'}} @endif">
																	{!! Form::text('line_2', null, array('placeholder'=>'line 2', 'class'=>'form-control', 'Value'=> $user->line_2)) !!}
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
																	{!! Form::text('city', null, array('placeholder'=>'City', 'class'=>'form-control','required', 'Value'=> $user->city)) !!}
																	{!! $errors->first('city', '<small class="text-danger">:message</small>') !!}
																</div>
																<div class="col-sm-6 @if($errors->first('state')){{'has-error'}} @endif">
																	{!! Form::text('state', null, array('placeholder'=>'state', 'class'=>'form-control','required', 'Value'=> $user->state)) !!}
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
																	{!! Form::text('postal_code', null, array('placeholder'=>'postal code', 'class'=>'form-control','required', 'Value'=> $user->postal_code)) !!}
																	{!! $errors->first('postal_code', '<small class="text-danger">:message</small>') !!}
																</div>
																<div class="col-sm-6 @if($errors->first('country')){{'has-error'}} @endif">
																	<select name="country" class="form-control">
																		@foreach(\App\Http\Utilities\Country::all() as $country => $code)
																		<option @if($user->country == $country) value="{{$country}}" selected="selected" @else value="{{$country}}" @endif>{{$country}}</option>
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
												<label>Tax File Number</label>
												<input type="text" class="form-control" name="tfn" placeholder="Tax File Number" @if($user->tfn) value="{{$user->tfn}}" @endif>
												<p><small>You are not required to provide your TFN, but in it being unavailable we will be required to withhold tax at the highest marginal rate of 49.5% </small></p><br>
												<div class="row">
													<div class="col-md-6">
														<label>Phone</label>
														<input type="text" name="phone" class="form-control" placeholder="Phone" required @if($user->phone_number) value="{{$user->phone_number}}" @endif>
													</div>
													<div class="col-md-6">
														<label>Email</label>
														<input type="text" name="email" class="form-control" placeholder="Email" required @if($user->email) value="{{$user->email}}" @endif>
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
														<input type="text" name="account_name" class="form-control" placeholder="Account Name" required @if($user->account_name) value="{{$user->account_name}}" @endif>
													</div>
													<div class="col-md-4">
														<label>BSB</label>
														<input type="text" name="bsb" class="form-control" placeholder="BSB" required @if($user->bsb) value="{{$user->bsb}}" @endif>
													</div>
													<div class="col-md-4">
														<label>Account Number</label>
														<input type="text" name="account_number" class="form-control" placeholder="Account Number" required @if($user->account_number) value="{{$user->account_number}}" @endif>
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
									<br>
									<div class="row " id="section-8">
										<div class="col-md-12">
											<div>
												<input type="checkbox" name="confirm" checked>	I/We confirm that I/We have not been provided Personal or General Financial Advice by Tech Baron PTY LTD which provides Technology services as platform operator. I/We have relied only on the contents of this @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif in deciding to invest and will seek independent adviser from my financial adviser if needed.
												{{-- <div class="row">
													<div class="text-left col-md-offset-5 col-md-2 wow fadeIn animated">
														<button class="btn btn-primary btn-block" id="step-8">Next</button>
													</div>
												</div> --}}
											</div>

										</div>
									</div>
									<br>
									<script type="text/javascript" src="/assets/plugins/jSignature/flashcanvas.js"></script>
									<script src="/assets/plugins/jSignature/jSignature.min.js"></script>
									<div id="signature"></div>
									<h4 class="text-center">Please Sign Here</h4 class="text-center">
										<script>
											$(document).ready(function() {
												$("#signature").jSignature()
											})
										</script>
										<br>
										<div class="row " id="11">
											<div class="col-md-12">
												<div>
													<input type="submit" name="submit" class="btn btn-primary" value="Submit">
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
						
						@if ($project->show_download_pdf_page)
						<div class="col-md-5">
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
									<a class="btn btn-primary btn-block font-bold" style="background-color:#2d2d4b;font-size:1em;color:#ffffff;border-color: #2d2d4b;" href="{{$project->investment->PDS_part_1_link}}" target="_blank">Download @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif</a>
								</td>
							</tr>
							<tr >
								<td class="font-regular">
									<b>Tech Baron PTY LTD Declaration</b><br>
									We have to provide this document to you along with the application form, it defines the services we are providing as an authorized Representative of our license holding partner
									<br>
									<a class="btn btn-primary btn-block font-bold" style="background-color:#2d2d4b;font-size:1em;color:#ffffff;border-color: #2d2d4b;" href="https://www.dropbox.com/s/koxscf3j3zw078c/TB%20FSG%20Ver%201.0.pdf?dl=0" target="_blank">Download Financial Services Guide</a>
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
@stop
@section('js-section')
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
			qty.keyup(function(){
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
					$("input[name='id_docs']").removeAttr('disabled');
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
		});  
	</script>
@stop