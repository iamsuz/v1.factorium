<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body{
			padding: 2em 6em;
		}
		*{
			font-family: 'Open Sans', sans-serif;
			text-align: justify;
		}
		input[type="text"]{
			width: 100% !important;
			min-height: 32px !important;
			padding: 0.5em 1em;
			font-size: 16px;
			/*border-radius: 5px;*/
		}
		hr{
			width: 100% !important;
		}
		input[type=checkbox]:before {
			font-family: DejaVu Sans;
		}
		input[type=checkbox] { display: inline; }
		table {
			border-collapse: collapse;
		}

		table, th, td {
			border: 1px solid black;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Mr+De+Haviland" />
</head>
<body>
	<?php
	$siteConfiguration = App\Helpers\SiteConfigurationHelper::getConfigurationAttr()
	?>
	<div>
		<h2 align="center"><b>Application</b></h2><br>
		<h4><b>Receivable Name</b></h4>
		<input type="text" name="" class="form-control" placeholder="Project SPV Name" @if($investment->project->projectspvdetail) value="{{$investment->project->projectspvdetail->spv_name}}" @endif style="width: 100%;"><br>
		<p>This Application Form is important. If you are in doubt as to how to deal with it, please contact your professional adviser without delay. You should read the entire Factoring Arrangement carefully before completing this form.</p>
		<h4><b>Purchase price</b></h4>
		<input type="text" name="" class="form-control" placeholder="5000" value="{{$investment->amount}}"><br>
		<br><br>
		<h4><b>Given Name(s)</b></h4>
		<input type="text" name="" class="form-control" placeholder="Given Name(s)" value="{{$user->first_name}}"><br>
		<h4><b>Surname</b></h4>
		<input type="text" name="" class="form-control" placeholder="Surname" value="{{$user->last_name}}"><br>
		<br><br><br>
		<h4><b>Contact Details:</b></h4>
		<p>Postal Address:</p><br>
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
		<br><br>
		I/We confirm that I/We have not been provided Personal or General Financial Advice by Konkrete Distributed Registries Ltd (or any of its employees) which provides Technology services as platform operator. I/We have relied only on the contents of this @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Factoring Arrangement @endif in deciding to purchase the receivable and will seek independent adviser from my financial adviser if needed. I/we agree to be bound by the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Factoring Arrangement @endif and acknowledge that neither Konkrete Distributed Registries Ltd nor any of its employees guarantees the performance of any offers, the payment of the receivable. I/we acknowledge that any investment is subject to investment risk (as detailed in the @if($project->project_prospectus_text!='') {{$project->project_prospectus_text}} @elseif ((App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)) {{(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text)}} @else Factoring Arrangement @endif). I/we confirm that we have provided accurate and complete documentation requested for AML/CTF investor identification and verification purposes.
		@if($project->add_additional_form_content)
		<br>
		{{$project->add_additional_form_content}}
		@endif
		<br><br>
		<br><br>
		<div align="right">
			<h4 align="right"><b>Signature &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></h4>
			@if($investment->signature_type == 0)
			@if($investment->signature_data)
			<img src="data:image/png;base64,{!!$investment->signature_data!!}">
			@endif
			@else
			<p style="font-size: 80px;height: 100px;font-family: 'Mr De Haviland' !important; font-style: italic; font-variant: normal; font-weight: 100; line-height: 15px; ">{{$investment->signature_data_type}}</p>
			@endif
		</div>
		@include('dashboard.projects.invoiceTearmsCond')
	</div>

</body>
</html>
