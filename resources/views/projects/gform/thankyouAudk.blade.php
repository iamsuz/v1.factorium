	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Thank You for expressing interest</title>
		{!! Html::style('/css/app2.css') !!}
		{!! Html::style('/css/bootstrap.min.css') !!}
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,700,200italic,400italic,700italic' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div class="container">
			<br>
			<section id="section-colors-left" class="color-panel-right panel-open-left center" style="position: static;">
				<div class="color-wrap-left" style="">
					<div class="row">
						<div class="col-md-10 col-md-offset-1 text-center">
							<br><br>
							<h2>
								@if($transactionAUDK)
								Thank you for applying to invest ${{$amount}} in {{$project->title}}.
								{{$amount}} AUDK has been deducted from your wallet and sent to the issuers wallet. Once the application has been accepted, you will receive the security tokens for the {{$project->title}} in your wallet. We will be in touch with next steps.
								@else
								Thank you <br><div style="margin-top: 1.2rem;"> Please deposit ${{number_format($amount)}} to</div>
								@endif
							</h2>
						</div>
					</div>
					<br>
					@if(!$transactionAUDK)
					{{-- @if($project->investment->bank) --}}
					<div class="row">
						<div class="col-md-offset-2 col-md-8 text-justify">
							@if($audkProject->investment)
							<table class="table table-bordered">
								<tr><td>Bank</td><td>{!!$audkProject->investment->bank!!}</td></tr>
								<tr><td>Account Name</td><td>{!!$audkProject->investment->bank_account_name!!}</td></tr>
								<tr><td>BSB </td><td>{!!$audkProject->investment->bsb!!}</td></tr>
								<tr><td>Account No</td><td>{!!$audkProject->investment->bank_account_number!!}</td></tr>
								<tr><td>SWIFT Code</td><td>{!!$audkProject->investment->swift_code!!}</td></tr>
								<tr><td>Reference</td><td>{!!$audkProject->investment->bank_reference!!}</td></tr>
							</table>
							@endif
						</div>
					</div>
					<br>
					{{-- @endif --}}
					@endif
				</div>
			</section>
			<div class="row">
				<div class="col-md-12 text-center">
					<a href="javascript:void(0);" onclick="top.window.location.href='@if($project->custom_project_page_link) {{$project->custom_project_page_link}} @else {{route('home')}} @endif';">BACK TO HOME</a>
				</div>
			</div>
		</div>
		{!! Html::script('/js/jquery-1.11.3.min.js') !!}
		{!! Html::script('/js/bootstrap.min.js') !!}
		@if($siteConfig=App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->conversion_pixel)
		{!!$siteConfig!!}
		@endif
	</body>
	</html>
