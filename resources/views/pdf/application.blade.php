<style type="text/css">
*{
	font-family: 'Open Sans', sans-serif;
	text-align: justify;
}
input[type="text"]{
	width: 100% !important;
	min-height: 32px !important;
	padding: 0.5em 1em;
	/*border-radius: 5px;*/
}
hr{
	width: 100% !important;
}
input[type=checkbox]:before {
	font-family: DejaVu Sans;
}
input[type=checkbox] { display: inline; }
</style>
<?php
$siteConfiguration = App\Helpers\SiteConfigurationHelper::getConfigurationAttr()
?>
<div>
	<h2 align="center"><b>Prospectus Application – {{$siteConfiguration->website_name}}</b></h2><br>
	<h4><b>Project SPV Name</b></h4>
	<input type="text" name="" class="form-control" placeholder="Project SPV Name" @if($investment->project->projectspvdetail) value="{{$investment->project->projectspvdetail->spv_name}}" @endif style="width: 100%;"><br>
	<p>( Name of the Company established as a Special Purpose Vehicle for this project that you are investing in )</p>
	<p>This Application Form is important. If you are in doubt as to how to deal with it, please contact your professional adviser without delay. You should read the entire prospectus carefully before completing this form. To meet the requirements of the Corporations Act, this Application Form must not be distributed unless included in, or accompanied by, the prospectus.</p>
	<br>
	<h4><b>I/we apply for <span class="red">*</span></b></h4>
	<input type="text" name="" class="form-control" placeholder="5000" value="{{$investment->amount}}"><br>
	@if($investment->project->share_vs_unit == 1)
	<p>Number of Redeemable Preference Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</p>
	@elseif($investment->project->share_vs_unit == 2)
	<p>Number of Preference Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</p>
	@elseif($investment->project->share_vs_unit == 3)
	<p>Number of Ordinary Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</p>
	@else
	<p>Number of Units at $1 per Unit or such lesser number of Units which may be allocated to me/us</p>
	@endif<br>
	<h4><b>I/we lodge full Application Money</b></h4>
	<input type="text" name="" class="form-control" placeholder="$5000" value="A$ {{$investment->amount}}"><br>
	<p>Individual/Joint applications - refer to naming standards for correct forms of registrable title(s)</p><br>
	<h4><b>You are investing as</b></h4>
	@if(!$investment->investing_as)
	Individual Investor <br>
	@endif
	@if($investment->investing_as)
	@if($investment->investing_as == 'Individual Investor') Individual Investor <br>
	@else
	@if($investment->investing_as == 'Joint Investor') Joint Investor <br>
	@else
	@if($investment->investing_as != 'Individual Investor' && $investment->investing_as != 'Joint Investor') Trust or Company <br>
	@else
	{{$investment->investing_as}}
	@endif
	@endif
	@endif
	@endif
	<br>
	@if($investment->investing_as)
	@if($investment->investing_as != 'Individual Investor' && $investment->investing_as != 'Joint Investor')
	<h4><b>Company or Trust Name</b></h4>
	<input type="text" name="" class="form-control" placeholder="Company or Trust Name" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->investing_company}}@endif @endif"><br>
	@endif
	@endif
	<h4><b>Given Name(s)</b></h4>
	<input type="text" name="" class="form-control" placeholder="Given Name(s)" value="{{$user->first_name}}"><br>
	<h4><b>Surname</b></h4>
	<input type="text" name="" class="form-control" placeholder="Surname" value="{{$user->last_name}}"><br>
	@if($investment->investing_as)
	@if($investment->investing_as == 'Joint Investor')
	<h4><b>Joint Investor Details</b></h4>
	<div style="width: 100%; display: inline;">
		<div style="width: 49%; float: left;">
			<input type="text" name="" class="form-control" placeholder="Investor First Name" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->joint_investor_first_name}}@endif @endif"><br>
		</div>
		<div style="width: 49%; float: right;">
			<input type="text" name="" class="form-control" placeholder="Investor Last Name" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->joint_investor_last_name}}@endif @endif"><br>
		</div>
	</div>
	@endif
	@endif
	<br>
	<h4><b>AML/CTF requirements</b></h4>
	<p>If investing via a Financial Adviser they will provide the Trustee the necessary verification otherwise you need to lodge the following information.</p>
	<h5><b>Individuals</b></h5>
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
	<i>Foreign documents must be accompanied by Accredited Translation into English</i><br>
	<h5><b>Partnerships</b></h5>
	<p>Original or Certified Copy of</p>
	<ul>
		<li>the Partnership Agreement</li>
		<li>minutes of a Partnership Meeting</li>
		<li>for one of the Partners, the Individual documents (see above)</li>
	</ul>
	<h5><b>Company</b></h5>
	<p>A Full ASIC Extract i.e. including Director and Shareholder details</p>
	<h5><b>Trust</b></h5>
	<p>Original or Certified Copy of</p>
	<ul>
		<li>the Trust Deed</li>
		<li>list of Beneficiaries</li>
		<li>Individual or Company details for the Trustee (see above)</li>
	</ul>
	<h5><b>Document Certification</b></h5>
	People that can certify documents include the following
	<ul>
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
	<br>
	<h4><b>Contact Details</b></h4>
	<p>Enter your Postal Address:</p><br>
	<p>Address Line 1</p>
	<input type="text" class="form-control" name="" placeholder="Address Line 1" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->line_1}}@else{{$user->line_1}}@endif @else{{$user->line_1}}@endif"><br>
	<p>Address Line 2</p>
	<input type="text" class="form-control" name="" placeholder="Address Line 2" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->line_2}}@else{{$user->line_2}}@endif @else{{$user->line_2}}@endif"><br>
	<p>City</p>
	<input type="text" class="form-control" name="" placeholder="City" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->city}}@else{{$user->city}}@endif @else{{$user->city}}@endif"><br>
	<p>State / Province / Region</p>
	<input type="text" class="form-control" name="" placeholder="State / Province / Region" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->state}}@else{{$user->state}}@endif @else{{$user->state}}@endif"><br>
	<p>ZIP / Postal Code</p>
	<input type="text" class="form-control" name="" placeholder="ZIP / Postal Code" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->postal_code}}@else{{$user->postal_code}}@endif @else{{$user->postal_code}}@endif"><br>
	<p>Country</p>
	<input type="text" class="form-control" name="" placeholder="Country" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->country}}@else{{$user->country}}@endif @else{{$user->country}}@endif"><br>
	<p>Phone</p>
	<input type="text" class="form-control" name="" placeholder="Phone" @if($user->phone_number) value="{{$user->phone_number}}" @endif><br>
	<p>Email</p>
	<input type="text" class="form-control" name="" placeholder="Email" value="{{$user->email}}"><br><br>
	<h4><b>Tax File Number</b></h4>
	<input type="text" class="form-control" name="" placeholder="Tax File Number" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->tfn}}@else{{$user->tfn}}@endif @else{{$user->tfn}}@endif">
	<p>You are not required to provide your TFN, but in it being unavailable we will be required to withhold tax at the highest marginal rate of 49.5%</p><br>
	<hr><br>
	<p>Account Name</p>
	<input type="text" class="form-control" name="" placeholder="Account Name" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->account_name}}@else{{$user->account_name}}@endif @else{{$user->account_name}}@endif"><br>
	<p>BSB</p>
	<input type="text" class="form-control" name="" placeholder="BSB" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->bsb}}@else{{$user->bsb}}@endif @else{{$user->bsb}}@endif"><br>
	<p>Account Number</p>
	<input type="text" class="form-control" name="" placeholder="Account Number" value="@if($investment->investing_as)@if($investment->investing_as != 'Individual Investor'){{$investment->investingJoint->account_number}}@else{{$user->account_number}}@endif @else{{$user->account_number}}@endif"><br><br>
	<h4><b>ID DOCS</b></h4>
	@if($investment->userInvestmentDoc->count() > 0)
	@foreach($investment->userInvestmentDoc as $doc)
	<a href="{{$investment->project_site}}/{{$doc->path}}" target="_blank">
		{{$doc->filename}}
	</a><br>
	@endforeach
	@else
	No Document Available
	@endif
	<br>
	<p>If you have not completed your verification process, please upload a copy of your Driver’s License or Passport for AML/CTF purposes</p><br>

	I/We confirm that I/We have not been provided Personal or General Financial Advice by Tech Baron PTY LTD which provides Technology services as platform operator. I/We have relied only on the contents of this @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif (($siteConfiguration->prospectus_text)) {{($siteConfiguration->prospectus_text)}} @else Prospectus @endif in deciding to invest and will seek independent adviser from my financial adviser if needed. I/we as Applicant declare (i) that I/we have read the entire @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif (($siteConfiguration->prospectus_text)) {{($siteConfiguration->prospectus_text)}} @else Prospectus @endif, (ii) that if an electronic copy of the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif (($siteConfiguration->prospectus_text)) {{($siteConfiguration->prospectus_text)}} @else Prospectus @endif has been used, that I/we obtained the entire @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif (($siteConfiguration->prospectus_text)) {{($siteConfiguration->prospectus_text)}} @else Prospectus @endif, not just the application form; and (iii) that I/we have not obtained any personal financial advice from Tech Baron Pty Ltd or any of its employees. I/we agree to be bound by the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif (($siteConfiguration->prospectus_text)) {{($siteConfiguration->prospectus_text)}} @else Prospectus @endif (as amended from time to time) and acknowledge that neither Tech Baron Pty Ltd nor any of its employees guarantees the performance of any offers, the payment of distributions or the repayment of capital. I/we acknowledge that any investment is subject to investment risk (as detailed in the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif (($siteConfiguration->prospectus_text)) {{($siteConfiguration->prospectus_text)}} @else Prospectus @endif). I/we confirm that we have provided accurate and complete documentation requested for AML/CTF investor identification and verification purposes.
	@if($project->add_additional_form_content)
	<br>
	{{$project->add_additional_form_content}}
	@endif
	<br><br>
	@if($investment->interested_to_buy)
	<p>
		I am also interested in purchasing one of the properties being developed. Please have someone get in touch with me with details
	</p>
	<br>
	@endif
	<br><br>
	<div align="right">
		<h4 align="right"><b>Signature &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></h4>
		@if($investment->signature_type == 0)
		@if($investment->signature_data)
		<img src="data:image/png;base64,{!!$investment->signature_data!!}">
		@endif
		@else
		<p style="font-size: 80px;height: 100px;font-family: cursive; font-style: italic; font-variant: normal; font-weight: 100; line-height: 15px; ">{{$investment->signature_data_type}}</p>
		@endif
	</div>
</div>
