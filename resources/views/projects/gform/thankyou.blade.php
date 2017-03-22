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
		<section id="section-colors-left" class="color-panel-right panel-open-left center" style="">
			<div class="color-wrap-left" style="margin-top: 1093px !important;">
				<div class="row">
					<div class="col-md-12 text-center">
						<h2>
							Thank you <br> Please deposit ${{number_format($amount)}} to
						</h2>
					</div>
				</div>
				<br>
				@if($project->investment)
				@if($project->investment->bank)
				<div class="row">
					<div class="col-md-offset-3 col-md-8 text-justify">
						<table class="table table-bordered">
							<tr><td>Bank</td><td>{!!$project->investment->bank!!}</td></tr>
							<tr><td>Account Name</td><td>{!!$project->investment->bank_account_name!!}</td></tr>
							<tr><td>BSB </td><td>{!!$project->investment->bsb!!}</td></tr>
							<tr><td>Account No</td><td>{!!$project->investment->bank_account_number!!}</td></tr>
							<tr><td>Reference</td><td>{!!$project->investment->bank_reference!!}</td></tr>
						</table>
					</div>
				</div>
				<br>
				@endif
				@endif
			</div>
		</section>
		<div class="row">
			<div class="col-md-12 text-center">
				<a href="javascript:void(0);" onclick="top.window.location.href='{{route('home')}}';">BACK TO HOME</a>
			</div>
		</div>
	</div>
	{!! Html::script('/js/jquery-1.11.3.min.js') !!}
	{!! Html::script('/js/bootstrap.min.js') !!}
</body>
</html>