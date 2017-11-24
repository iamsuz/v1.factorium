@extends('layouts.main')

@section('title-section')
Australia's Top Real Estate Equity Crowdfunding team
@stop

@section('meta-section')
<meta property="og:title" content="Australia's Top Real Estate Equity Crowdfunding team" />
<meta property="og:description" content="Benni Aroni, lead Developer Eureka towers, Australia108, Adrian Stone, founder at AngelCube, Moresh Kokane CEO Cofounders Shuang Li, Mark Winslade, Luke Hindson" />
<meta name="description" content="Benni Aroni, lead Developer Eureka towers, Australia108, Adrian Stone, founder at AngelCube, Moresh Kokane CEO Cofounders Shuang Li, Mark Winslade, Luke Hindson">
@stop

@section('content-section')
@if($aboutus)
<section class="chunk-box">
	<div class="container">
		<div class="row text-justify">
			<div class="col-md-6 col-md-offset-3">
				@if($adminedit != 0) <a href="/pages/team/edit" class="pull-right">Edit</a> @endif
				<h2 class="font-regular first_color text-justify" style=" font-size:2.625em; color:#282a73;"><b>{!! $aboutus->main_heading !!}</b></h2>
				<h3 class="h1-faq first_color text-justify" style="font-size:1.375em;">{!! $aboutus->sub_heading !!}</h3>
				<p style="font-size:0.875em;" class="text-justify">
					{!! $aboutus->content !!}
				</p>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="chunk-box">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="heading-font-semibold second_color @if(count($member)==1) text-center @endif" style=" font-size:2.625em; color:#fed405; letter-spacing:3px;">@if($aboutus->founder_label) {{$aboutus->founder_label}} @else Founders @endif</h1>
					<br>
					@if($aboutus)
					<!-- <h2 class="second_color">Founders</h2> -->
					@if(count($member)==1)
					<div class="row">
						@foreach($member->chunk(3) as $sets)
						<div class="row">
							@foreach($sets as $members)
							<div class="col-sm-4 col-md-4 col-sm-offset-4">
								<img class="img-responsive img-circle center-block" align="middle" width="90%" height="90%" src="{{asset($members->founder_image_url)}}" alt="{{$members->founder_image_url}}" />
								<div class="caption text-center">
									<h3 class="font-regular second_color" style=" font-size:1.5em; color:#fed405;">
										<b>{{$members->founder_name}}</b>
									</h3>
									<p class="font-regular" style="font-size:1.2em;color:#282a73; margin-top:-10px;">
										{{$members->founder_subheading}}
									</p>
									<p style="font-size:0.95em;" class="text-justify">
										{!! $members->founder_content !!}
									</p>
									<!-- <input type="button" onclick="change2()" id="button2" class="btn btn-xs btn-default" data-toggle="collapse" data-target="#more2" value="Read More"> -->
								</div>
							</div>
							@endforeach
						</div>
						@endforeach
					</div>
					@else
					<div class="row">
						@foreach($member->chunk(3) as $sets)
						<div class="row">
							@foreach($sets as $members)
							<div class="col-sm-4 col-md-4">
								<img class="img-responsive img-circle" width="70%" height="70%" style="margin: 0 auto;" src="{{asset($members->founder_image_url)}}" alt="{{$members->founder_image_url}}" />
								<div class="caption text-left">
									<h3 class="font-regular second_color" style=" font-size:1.375em; color:#fed405;">
										<b>{{$members->founder_name}}</b>
									</h3>
									<p class="font-regular" style="font-size:1em;color:#282a73; margin-top:-10px;">
										{{$members->founder_subheading}}
									</p>
									<p style="font-size:0.875em;" class="text-justify">
										{!! $members->founder_content !!}
									</p>
									<!-- <input type="button" onclick="change2()" id="button2" class="btn btn-xs btn-default" data-toggle="collapse" data-target="#more2" value="Read More"> -->
								</div>
							</div>
							@endforeach
						</div>
						@endforeach
					</div>
					@endif
					@endif
				</div>
			</div>
		</div>
	</div>
</section>
<br>
@else
<section class="chunk-box">
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-md-offset-5">
				@if($adminedit != 0) <a href="/pages/team/edit" class="btn btn-primary btn-block text-center" style="font-size: 1em;font-weight: 100">Create new Team</a> @endif
			</div>
		</div>
	</div>
</section>
@endif
@stop