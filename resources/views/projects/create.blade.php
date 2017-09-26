@extends('layouts.main')

@section('title-section')
Create New Project | @parent
@stop

@section('css-section')
{!! Html::style('plugins/animate.css') !!}
@stop

@section('content-section')
<div class="container">
	<section id="project-form">
		<div class="row ">
			<div class="col-md-6 col-md-offset-3 wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.5s">
				<h2 class="text-left display-4 wow fadeIn animated font-bold first_color" data-wow-duration="0.8s" data-wow-delay="0.5s" style="font-size:2.625em;">Submit</h2><br>
				<h3 class="text-left font-regular wow fadeIn animated first_color" data-wow-duration="1s" data-wow-delay="0.5s" style="margin-top:-13px; font-size:1.375em;">Do you require funding for a Property Development or Business Venture?</h3>
				@if (Session::has('message'))
				<br>
				{!! Session::get('message') !!}
				<br>
				@endif
				@if ($errors->has())
				<br>
				<div class="alert alert-danger">
					@foreach ($errors->all() as $error)
					{{ $error }}<br>
					@endforeach
				</div>
				<br>
				@endif
				{!! Form::open(array('route'=>'projects.store', 'class'=>'form-horizontal', 'role'=>'form', 'files'=>true)) !!}
				<br><br>
				<fieldset>
					<div class="row text-center">
						<div class=" @if($errors->first('property_type')){{'has-error'}} @endif">
							<h4 class="font-bold text-center first_color" style="font-size:1.375em;">Select Property Development or Venture to get started.</h4><br>
							<div class="btn-group col-md-12" data-toggle="buttons" >
								<label class="pro-dev btn btn-n2 active eb-checkbox col-md-6 col-xs-12">
									<input type="radio" name="property_type" id="property_development" autocomplete="off" value="1" checked tabindex="1" >
									<img src="{{asset('assets/images/development_p.png')}}" class="img-responsive pull-left" style="padding-top:2px;">
									<font class="font-regular" style="font-size:1.7rem;color:#fff; margin-left:-8px;">Property Development </font>
								</label>
								<label class="ven btn btn-n2 eb-checkbox col-md-6 col-xs-12">
									<input type="radio" name="property_type" id="venture" autocomplete="off" value="2" tabindex="2">
									<img src="{{asset('assets/images/venture_p.png')}}" class="img-responsive pull-left">
									<font class="font-regular" style="font-size:1.7rem; color:#fff; margin-left:-29px;"> Venture</font> 
								</label>
							</div>
						</div>
					</div>
					<br><br><br>
					<div class="row">
						<div class=" @if($errors->first('title')){{'has-error'}} @endif">
							<div class="col-md-12">
								<h4 id="name" class="first_color">Development Name</h4>
								{!! Form::text('title', null, array('placeholder'=>' eg. Right Street Project', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
								{!! $errors->first('title', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
		<div class="row ">
			<br>
			<div class="col-md-6 col-md-offset-3 wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.5s">
				<fieldset>
					<div class="row">
						<div class="form-group @if($errors->first('line_1') && $errors->first('line_2')){{'has-error'}} @endif ">
							<div class="col-sm-12">
								<h4 id="location" class="first_color">Development Location</h4>
								<div class="@if($errors->first('line_1')){{'has-error'}} @endif">
									{!! Form::text('line_1', null, array('placeholder'=>'Street Address', 'class'=>'form-control', 'tabindex'=>'2')) !!}
									{!! $errors->first('line_1', '<small class="text-danger">:message</small>') !!}
								</div>
									<!-- <div class="col-sm-6 @if($errors->first('line_2')){{'has-error'}} @endif">
										{!! Form::text('line_2', null, array('placeholder'=>'line 2', 'class'=>'form-control', 'tabindex'=>'4')) !!}
										{!! $errors->first('line_2', '<small class="text-danger">:message</small>') !!}
									</div> -->
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="form-group @if($errors->first('city') && $errors->first('state')){{'has-error'}} @endif">
								<div class=" col-sm-12">
									<div class="row">
										<div class="col-sm-6 @if($errors->first('city')){{'has-error'}} @endif">
											{!! Form::text('city', null, array('placeholder'=>'City', 'class'=>'form-control', 'tabindex'=>'3')) !!}
											{!! $errors->first('city', '<small class="text-danger">:message</small>') !!}
										</div>
										<div class="col-sm-6 @if($errors->first('state')){{'has-error'}} @endif">
											{!! Form::text('state', null, array('placeholder'=>'State', 'class'=>'form-control', 'tabindex'=>'4')) !!}
											{!! $errors->first('state', '<small class="text-danger">:message</small>') !!}
										</div>
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="form-group @if($errors->first('postal_code') && $errors->first('country')){{'has-error'}} @endif">
								<div class=" col-sm-12">
									<div class="row">
										<div class="col-sm-6 @if($errors->first('postal_code')){{'has-error'}} @endif">
											{!! Form::text('postal_code', null, array('placeholder'=>'Postal code', 'class'=>'form-control', 'tabindex'=>'5')) !!}
											{!! $errors->first('postal_code', '<small class="text-danger">:message</small>') !!}
										</div>
										<div class="col-sm-6 @if($errors->first('country')){{'has-error'}} @endif">
											<select name="country" class="form-control" tabindex="6">
												@foreach(\App\Http\Utilities\Country::aus() as $country => $code)
												<option value="{{$code}}">{{$country}}</option>
												@endforeach
											</select>
											{!! $errors->first('country', '<small class="text-danger">:message</small>') !!}
										</div>
									</div>
								</div>
							</div>
						</div>
						<br>
						<br>
						<h4 class="first_color">Description</h4>
						<div class="row">
							<div class="form-group @if($errors->first('description')){{'has-error'}} @endif">
								<div class=" col-sm-12">
									{!! Form::textarea('description', null, array('placeholder'=>'Please describe the details of your Development', 'class'=>'form-control', 'tabindex'=>'7', 'rows'=>'5')) !!}
									{!! $errors->first('description', '<small class="text-danger">:message</small>') !!}
								</div>
							</div>
						</div>
						<br><br>
						<h4 class="first_color">Additional Information</h4>
						<div class="row">
							<div class="form-group @if($errors->first('additional_info')){{'has-error'}} @endif">
								<div class="col-sm-12">
									{!! Form::textarea('additional_info', null, array('placeholder'=>'Please provide any additional information', 'class'=>'form-control', 'tabindex'=>'8', 'rows'=>'10')) !!}
									{!! $errors->first('additional_info', '<small class="text-danger">:message</small>') !!}
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			<div class="row hide">
				<div class="col-md-6 col-md-offset-3 wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.5s">
					<br>
					<fieldset>
						<h4 id="plan" class="font-bold first_color" style="font-size:1.125em; color:#2d2d4b">Upload Development Proposal</h4>
						<h5 class="font-bold first_color" style="font-size:1em; color:#282a73;">Please include:</h5>

						<p class="font-regular first_color" style="font-size:0.875em;color:#282a73;">
							<ul id="pro-dev" class="first_color">
								<li>Business Plan</li>
								<li>Profile of Developer and Permits</li>
								<li>Feasibilty</li>
								<li>Land Title</li>
							</ul>
							<ul id="ven" class="hide first_color">
								<li>Amount of Funding Required</li>
								<li>Details of your offer</li>
								<li>Business Plan</li>
							</ul>
						</p>
						<h5 class="font-bold first_color" style="font-size:1em;color:#282a73;">Where available the following:</h5>
						<p class="font-regular" style="font-size:0.875em;color:#282a73;">
							<ul id="pro-dev1" class=" first_color">
								<li>Valuation of Land</li>
								<li>Gross Realisation Valuation</li>
								<li>Total Development Cost Valuation</li>
								<li>Fixed Price Building Contract</li>
								<li>Quantity Surveyors Report</li>
								<li>Profile of Builder and Projects</li>
								<li>Planning Permit</li>
								<li>Town Planning Drawings</li>
								<li>Contract of Sale</li>
								<li>Option to Purchase Land</li>
							</ul>
							<ul id="ven1" class="hide first_color">
								<li>Business Valuation</li>
							</ul>
						</p>
						<br><br>
						<br>
						<div class="row">
							<div class="form-group first_color @if($errors->first('doc1')){{'has-error'}} @endif">
								{!!Form::label('doc1', 'Attachment 1', array('class'=>'col-sm-4 control-label'))!!}
								<div class="col-sm-8">
									{!! Form::file('doc1', array('class'=>'form-control', 'tabindex'=>'9')) !!}
									{!! $errors->first('doc1', '<small class="text-danger">:message</small>') !!}
									<p>*<small>Pdf or Doc Only</small></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group first_color @if($errors->first('doc2')){{'has-error'}} @endif">
								{!!Form::label('doc2', 'Attachment 2', array('class'=>'col-sm-4 control-label'))!!}
								<div class="col-sm-8">
									{!! Form::file('doc2', array('class'=>'form-control', 'tabindex'=>'10')) !!}
									{!! $errors->first('doc2', '<small class="text-danger">:message</small>') !!}
									<p>*<small>Pdf or Doc Only</small></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group first_color @if($errors->first('doc3')){{'has-error'}} @endif">
								{!!Form::label('doc3', 'Attachment 3', array('class'=>'col-sm-4 control-label'))!!}
								<div class="col-sm-8">
									{!! Form::file('doc3', array('class'=>'form-control', 'tabindex'=>'11')) !!}
									{!! $errors->first('doc3', '<small class="text-danger">:message</small>') !!}
									<p>*<small>Pdf or Doc Only</small></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group first_color @if($errors->first('doc4')){{'has-error'}} @endif">
								{!!Form::label('doc4', 'Attachment 4', array('class'=>'col-sm-4 control-label'))!!}
								<div class="col-sm-8">
									{!! Form::file('doc4', array('class'=>'form-control', 'tabindex'=>'13')) !!}
									{!! $errors->first('doc4', '<small class="text-danger">:message</small>') !!}
									<p>*<small>Pdf or Doc Only</small></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group first_color @if($errors->first('doc5')){{'has-error'}} @endif">
								{!!Form::label('doc5', 'Attachment 5', array('class'=>'col-sm-4 control-label'))!!}
								<div class="col-sm-8">
									{!! Form::file('doc5', array('class'=>'form-control', 'tabindex'=>'14')) !!}
									{!! $errors->first('doc5', '<small class="text-danger">:message</small>') !!}
									<p>*<small>Pdf or Doc Only</small></p>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			<!-- <hr style="height:1px;border:none;color:#333;background-color:#333; width:60%; " /> -->
			<br><br>
			<div class="row text-center" style="border-radius:80px !important;">
				<fieldset>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">
							{!! Form::submit('Submit a Project', array('class'=>'btn btn-n3 h1-faq second_color_btn', 'tabindex'=>'15','style'=>'color:#fff;font-size:1em;border-radius:6px !important;')) !!}
						</div>
					</div>
				</fieldset>
				{!! Form::close() !!}
			</div>
			<br>
		</section>
	</div>
	@stop
	@section('js-section')
	<script>
		$(document).ready(function(){
			$('input[name="property_type"]').on('change', function(){
				if ($(this).val()=='1') {
         		//change to "show update"
         		$("#name").text("Development Name");
         		$("#location").text("Development Location");
         		$("#plan").text("Upload Development Proposal");
         		$("#ven").addClass("hide");
         		$("#pro-dev").removeClass("hide");
         		$("#ven1").addClass("hide");
         		$("#pro-dev1").removeClass("hide");
         	} else  {
         		$("#name").text("Venture Name");
         		$("#location").text("Venture Location");
         		$("#plan").text("Upload Investment Proposal");
         		$("#ven").removeClass("hide");
         		$("#pro-dev").addClass("hide");
         		$("#ven1").removeClass("hide");
         		$("#pro-dev1").addClass("hide");
         	}
         });
		});
	</script>
	@stop
