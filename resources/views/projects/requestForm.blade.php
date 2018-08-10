@extends('layouts.main')
@section('title-section')
Offer Doc
@stop

@section('css-section')
@parent
@stop
@section('content-section')
<div class="loader-overlay hide" style="display: none;">
	<div class="overlay-loader-image">
	   <img id="loader-image" src="{{ asset('/assets/images/loader.GIF') }}">
	</div>
</div>
<div class="container-fluid">
	<div class="row" id="forScroll">
		<div class="col-md-12">
			<div style="display:block;margin:0;padding:0;border:0;outline:0;color:#000!important;vertical-align:baseline;width:100%;margin-bottom: 2em;">
				<div class="row">
					<div class="col-md-12 investment-gform" id="offer_frame" >
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
								@if($investmentRequest->is_link_expired)
								<div class="well text-center cursor-pointer fill-form-request-container">
									<i class="fa fa-times fa-3x" aria-hidden="true" style="color: red;"></i><br>
									<h3>The link you are trying is expired.</h3>
								</div>
								@else
								<form action="{{route('offer.store')}}" rel="form" method="POST" enctype="multipart/form-data" id="myform" class="col-md-8 col-md-offset-2">
									{!! csrf_field() !!}
									<div class="row" id="section-1">
										<div class="col-md-12">
											<div>
												<input type="hidden" name="investment_request_id" value="{{$investmentRequest->id}}">
												<label class="form-label">Applicant Name</label><br>
												<i class="text-dark-grey">{{$user->first_name}} {{$user->last_name}}</i><br><br>
												<label class="form-label">Project SPV Name</label><br>
												<i class="text-dark-grey">@if($projects_spv){{$projects_spv->spv_name}} @else - @endif</i>
												<h5>Name of the Entity established as a Special Purpose Vehicle for this project that you are investing in</h5><br>
												<label>User apply for *</label>
												<input type="number" name="amount_to_invest" class="form-control" onkeypress="return isNumber(event)" placeholder="Minimum Amount A${{$project->investment->minimum_accepted_amount}}" style="width: 60%" id="apply_for" step="100" min="{{$project->investment->minimum_accepted_amount}}" required value="@if(isset($eoi)) {{$eoi->investment_amount}} @endif">
												@if($project->share_vs_unit)
													<h5>Number of Redeemable Preference Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</h5>
												@else
													<h5>Number of Units at $1 per Unit or such lesser number of Units which may be allocated to me/us</h5>
												@endif
												<br>
												<label>User lodge full Application Money</label>
												<input type="text" name="apply_for" class="form-control" placeholder="$5000" value="A$ @if(isset($eoi)) {{number_format(round($eoi->investment_amount, 2))}} @else 0.00 @endif" disabled="" style="width: 60%; background-color: #fff" id="application_money">
												<input type="text" name="project_id" @if($projects_spv) value="{{$projects_spv->project_id}}" @endif hidden >
											</div>
										</div>
									</div>
									<br><br>
									@if(!$user->idDoc)
									<div class="row " id="section-2">
										<div class="col-md-12">
											<div >
												<h5>Individual/Joint applications - refer to naming standards for correct forms of registrable title(s)</h5>
												<br>
												<h4>User Investing as</h4>
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
									@endif
									{{-- <div class="row " id="section-4">
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
													<input type="checkbox" name="wholesale_investing_as" value="Wholesale Investor (Net Asset $2,500,000 plus)" style="margin-right: 6px;" class="wholesale_invest_checkbox"><span class="check1">I have net assets of at least $2,500,000 or a gross income for each of the last 2 financial investors of at lease $2,50,000 a year.</span><br>
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
												<label>Enter Postal Address</label>
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
														<input type="text" class="form-control" placeholder="Email" required disabled @if($user->email) value="{{$user->email}}" @endif style="background:transparent;">
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
											</div>

										</div>
									</div>
									<br>
									<div class="row " id="section-8">
										<div class="col-md-12">
											<div>
												<input type="checkbox" name="confirm" checked>	I/We confirm that I/We have not been provided Personal or General Financial Advice by Tech Baron PTY LTD which provides Technology services as platform operator. I/We have relied only on the contents of this @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif in deciding to invest and will seek independent adviser from my financial adviser if needed.
												I/we as Applicant declare (i) that I/we have read the entire @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif, (ii) that if an electronic copy of the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif has been used, that I/we obtained the entire @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif, not just the application form; and (iii) that I/we have not obtained any personal financial advice from Tech Baron Pty Ltd or any of its employees. I/we agree to be bound by the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif (as amended from time to time) and acknowledge that neither Tech Baron Pty Ltd nor any of its employees guarantees the performance of any offers, the payment of distributions or the repayment of capital. I/we acknowledge that any investment is subject to investment risk (as detailed in the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Prospectus @endif). I/we confirm that we have provided accurate and complete documentation requested for AML/CTF investor identification and verification purposes.

												@if($project->add_additional_form_content)
													<p style="margin-top: 0.3em;">{{$project->add_additional_form_content}}</p>
												@endif
											</div>

										</div>
									</div>
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

									<script type="text/javascript" src="/assets/plugins/jSignature/flashcanvas.js"></script>
									<script src="/assets/plugins/jSignature/jSignature.min.js"></script>
									<div id="signature"></div>
									<h4 class="text-center">Please Sign Here</h4>
									<input type="hidden" name="signature_data" id="signature_data" value="">
									<script>
										$(document).ready(function() {
											$("#signature").jSignature();
											$("#signature").bind('change', function(e){
												var svgData = $(this).jSignature("getData", "image");
												$('#signature_data').val(svgData[1]);
											});
										})
									</script>
									<br><br>
									<div class="row " id="11">
										<div class="col-md-6">
											<div>
												<input type="submit" name="submit" class="btn btn-primary btn-block btn-lg" value="Submit">
											</div>
										</div>
										<div class="col-md-6">
											<div>
												<a href="{{route('project.interest.cancel', [$investmentRequest->id])}}" class="btn btn-default btn-lg btn-block cancel-form-request">Cancel Request</a>
											</div>
										</div>
									</div>
								</form>
								<br><br>
								@endif
							</div>
						</div>
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
<script>
	function isNumber(evt) {
	    evt = (evt) ? evt : window.event;
	    var charCode = (evt.which) ? evt.which : evt.keyCode;
	    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    return true;
	}
	$(document).ready(function(){
	    $('#myform').submit(function() {
		    $('.loader-overlay').show(); // show animation
		    return true; // allow regular form submission
		});
	});
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

		// Submit Request for Form Filling
		$('.send-form-filling-request').click(function(e){
			if (confirm('This will raise a request for form filling. Do you want to continue ?')) {
				console.log('confirmed');
			} else {
				e.preventDefault();
			}
		});

		// Confirm Request Form Cancellation
		$('.cancel-form-request').click(function(e){
			if (confirm('Are you sure, you want to cancel the form request? You will be redirected to home page once successfully cancelled.')) {
				console.log('confirmed');
			} else {
				e.preventDefault();
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
