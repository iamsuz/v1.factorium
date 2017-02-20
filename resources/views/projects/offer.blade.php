@extends('layouts.main')
@section('title-section')
Offer Doc
@stop

@section('css-section')
@parent
@stop
@section('content-section')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div style="display:block;margin:0;padding:0;border:0;outline:0;color:#000!important;vertical-align:baseline;width:100%;">
				<div class="row">
					<div class="col-md-7"><br>
						<iframe src="{{$project->investment? $project->investment->embedded_offer_doc_link : 'test'}}&amp;project_name={{$project->title}}&amp;project_id={{$project->id}}&amp;user_id={{Auth::user()->id}}&amp;first_name={{Auth::user()->first_name}}&amp; last_name={{Auth::user()->last_name}}&amp;email={{Auth::user()->email}}&amp;phone_number={{Auth::user()->phone_number}}&amp;request_url={{Auth:user()->registration_site}}" width="100%" height="500" frameBorder="0" class="gfiframe"></iframe>
						<script src="https://www.vestabyte.com/registry/wp-content/plugins/gravity-forms-iframe-master/assets/scripts/gfembed.min.js" type="text/javascript"></script>
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
									This Prospectus contains forward looking statements. Those statements are based upon the Directors’ current expectations in regard to future events or results. All forecasts in this Prospectus are based upon the assumptions described in Section 10.1. Actual results may be materially affected by changes in circumstances, some of which may be outside the control of the Company. The reliance that investors place on the forecasts is a matter for their own commercial judgment. No representation or warranty is made that any forecast, assumption or estimate contained in this Prospectus will be achieved.
									<br><br>
									Seek professional advice from your accountant, stockbroker, lawyer or other professional adviser before deciding whether to invest. The information provided in this Prospectus does not constitute personal financial product advice and has been prepared without taking into account your investment objectives, financial situation or particular needs. It is important that you read this Prospectus in its entirety before deciding to invest and consider the risk factors that could affect the Company’s performance.
									<br>
									<a class="btn btn-primary btn-block font-bold" style="background-color:#2d2d4b;font-size:1em;color:#ffffff;border-color: #2d2d4b;" href="{{$project->investment->PDS_part_1_link}}" target="_blank">Download Prospectus</a>
								</td>
							</tr>
							<tr >
								<td class="font-regular">
									We have to provide this document to you along with the application form, it defines the services we are providing as an authorized Representative of our license holding partner
									<br>
									<a class="btn btn-primary btn-block font-bold" style="background-color:#2d2d4b;font-size:1em;color:#ffffff;border-color: #2d2d4b;" href="{{App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->financial_service_guide_link}}" target="_blank">Download Financial Services Guide</a>
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
<!-- <section id="section-colors-right" class="color-panel-right panel-close-right center" style="opacity: .8;">
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
		var mq = window.matchMedia("(min-width: 768px)");
		if(mq.matches){
		}else{
			$('#section-colors').addClass('hide');
			$('#section-colors-left').addClass('hide');
		}
	});
</script>
@stop