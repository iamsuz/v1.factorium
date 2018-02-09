@extends('layouts.main')

@section('title-section')
Submit a Project | @parent
@stop

@section('css-section')
{!! Html::style('plugins/animate.css') !!}
@stop

@section('content-section')
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<h1 class="text-center wow fadeIn animated"><br><br>Submit Your Project</h1>
			<form action="{{route('offer.store')}}" rel="form" method="POST" enctype="multipart/form-data">
				{!! csrf_field() !!}
				<div class="row" id="section-1">
					<div class="col-md-12">
						<div style="padding:1em 0;">
							<h1>
								<small>I want to: <br>
									<input type="radio" name="sell_or_fund" value="0" checked="true"> Sell a project <br>
									<input type="radio" name="sell_or_fund" value="0" checked="true"> Sell a project <br>
									<input type="radio" name="sell_or_fund" value="1"> Raise funds for the project and run it myself
								</small>
							</h1>
							<h1>
								<small>Is it a debt or equity Project: <br>
									<input type="radio" name="is_debt" value="0" checked="true"> Equity <br>
									<input type="radio" name="is_debt" value="1"> Debt
								</small>
							</h1>
							<br><br>
							<div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-1">Next</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row hide" id="section-2">
					<div class="col-md-12">
						<div style="padding:1em 0;">
							<h1>
								<small><br>
									<input type="radio" name="ownership" value="user" checked="true"> I own the land<br>
									<input type="radio" name="ownership" value="deposit"> I have a deposit or option on the land<br>
									<input type="radio" name="ownership" value="thirdparty"> I am acting as a referral agent and a 3rd party owns the land<br>

								</small>
							</h1>
							<br><br>
							<div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-2">Next</button>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="row hide" id="section-3">
					<div class="col-md-12">
						<div style="padding:1em 0;">
							<div class="row">
								<div class="form-group @if($errors->first('line_1') && $errors->first('line_2')){{'has-error'}} @endif ">
									<div class="col-sm-offset-1 col-sm-11">
										<div class="row">
											<div class="col-sm-6 @if($errors->first('line_1')){{'has-error'}} @endif">
												{!! Form::text('line_1', null, array('placeholder'=>'line 1', 'class'=>'form-control')) !!}
												{!! $errors->first('line_1', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 @if($errors->first('line_2')){{'has-error'}} @endif">
												{!! Form::text('line_2', null, array('placeholder'=>'line 2', 'class'=>'form-control')) !!}
												{!! $errors->first('line_2', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('city') && $errors->first('state')){{'has-error'}} @endif">
									<div class="col-sm-offset-1 col-sm-11">
										<div class="row">
											<div class="col-sm-6 @if($errors->first('city')){{'has-error'}} @endif">
												{!! Form::text('city', null, array('placeholder'=>'City', 'class'=>'form-control')) !!}
												{!! $errors->first('city', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 @if($errors->first('state')){{'has-error'}} @endif">
												{!! Form::text('state', null, array('placeholder'=>'state', 'class'=>'form-control')) !!}
												{!! $errors->first('state', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('postal_code') && $errors->first('country')){{'has-error'}} @endif">
									<div class="col-sm-offset-1 col-sm-11">
										<div class="row">
											<div class="col-sm-6 @if($errors->first('postal_code')){{'has-error'}} @endif">
												{!! Form::text('postal_code', null, array('placeholder'=>'postal code', 'class'=>'form-control')) !!}
												{!! $errors->first('postal_code', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 @if($errors->first('country')){{'has-error'}} @endif">
												<select name="country" class="form-control">
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
							<br><br>
							<div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-3">Next</button>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="row hide" id="section-4">
					<div class="col-md-12">
						<div style="padding:1em 0;">
							<h1>
								<small>Asking Sell Price <br>
									<input type="text" class="form-control" name="asking_sell_price" placeholder="Asking Sell Price" required="required"><br>
								</small>
							</h1>
							<h1>
								<small>Annual %<br>
									<input type="text" class="form-control" name="annual_returns" placeholder="Annual %"><br>
								</small>
							</h1>
							<br><br>
							<div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-4">Next</button>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="row hide" id="section-5">
					<div class="col-md-12">
						<div style="padding:1em 0;">
							<h1>
								<small>Duration<br>
									<input type="text" class="form-control" name="years" placeholder="Duration (years)"><br>
									<input type="text" class="form-control" name="months" placeholder="Months (years)"><br>
								</small>
							</h1>
							<br><br>
							<div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-5">Next</button>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="row hide" id="section-6">
					<div class="col-md-12">
						<div style="padding:1em 0;">
							<h1>
								<small>Land Area<br>
									<input type="text" class="form-control" name="land_area" placeholder="Land Area in square meteres" required="required"><br>
								</small>
							</h1>
							<br><br>
							<div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-6">Next</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row hide" id="section-7">
					<div class="col-md-12">
						<div style="padding:1em 0;">
							<h1>
								<small>I think this is an attractive site because<br>
									<textarea name="site_attractions" rows="3" class="form-control" required="required"></textarea>
								</small>
							</h1>
							<br><br>
							<div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-7">Next</button>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="row hide" id="section-8">
					<div class="col-md-12">
						<div style="padding:1em 0;">
							<h1>
								<small>This site currently has<br>
									<input type="radio" name="has_plan" value="0" checked="true"> No Plans<br>
									<input type="radio" name="has_plan" value="1"> Plans developed but not filed<br>
									<input type="radio" name="has_plan" value="2"> Plans filed in council but not yet endorsed<br>
									<input type="radio" name="has_plan" value="3"> Plans endorsed conditionally<br>
									<input type="radio" name="has_plan" value="4"> Plans endorsed unconditionally<br>
									<input type="radio" name="has_plan" value="5"> Plans in VCAT<br>
									<br>
									<input type="text" class="form-control" name="plan_link" placeholder="Dropbox link of plan"><br>
								</small>
							</h1>
							<br><br>
							<div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-8">Next</button>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="row hide" id="section-9">
					<div class="col-md-12">
						<div style="padding:1em 0;">
							<h1>
								<small>Lets name your project<br>
									<input type="text" name="title" placeholder="suburb name plus project style, for eg: Bentleigh townhouse development" class="form-control" required="required"><br>
								</small>
							</h1>
							<br><br>
							<div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-9">Next</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row hide" id="section-10">
					<div class="col-md-12">
						<div style="padding:1em 0;">
							<h1>
								<small>Upload an Image<br>
								<input type="file" name="thumbnail" class="form-control"><br>
								</small>
							</h1>
							<br><br>
							<div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-10">Next</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row hide" id="section-11">
					<div class="col-md-12">
						<div style="padding:1em 0;">
							<h1>
								<small>We will list your project in our ideas section for people to comment on as part of our crowd diligence process. We ask our users to comment on the viability of the project. You can respond to any queries or comments on your project page. If the project is found sufficiently attractive we will put together an offer to buy the project from you.<br>
								</small>
							</h1>
							<br><br>
							<div class="row">
								<div class="text-center col-md-offset-5 col-md-2 wow fadeIn animated">
									<button class="btn btn-primary btn-block" id="step-11">Next</button>
								</div>
							</div>
						</div>
					</div>
				</div>

			</form>
		</div>
		<div class="col-md-2">
			<img src="{{asset('assets/images/estate_baron_hat1.png')}}" alt="Estate Baron Masoct" class="pull-right img-responsive" style="padding-top:20em;">
		</div>
	</div>
</div>
@stop

@section('js-section')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
{!! Html::script('plugins/wow.min.js') !!}
<script type="text/javascript">
	$(function () {
		$('.scrollto').click(function(e) {
			e.preventDefault();
			$(window).stop(true).scrollTo(this.hash, {duration:1000, interrupt:true});
		});
		$('#step-1').click(function(e) {
			e.preventDefault();
			$('#section-1').hide();
			$('#section-2').removeClass('hide');
		});
		$('#step-2').click(function(e) {
			e.preventDefault();
			$('#section-2').hide();
			$('#section-3').removeClass('hide');
		});
		$('#step-3').click(function(e) {
			e.preventDefault();
			$('#section-3').hide();
			$('#section-4').removeClass('hide');
		});
		$('#step-4').click(function(e) {
			e.preventDefault();
			$('#section-4').hide();
			$('#section-5').removeClass('hide');
		});
		$('#step-4').click(function(e) {
			e.preventDefault();
			$('#section-4').hide();
			$('#section-5').removeClass('hide');
		});
		$('#step-5').click(function(e) {
			e.preventDefault();
			$('#section-5').hide();
			$('#section-6').removeClass('hide');
		});
		$('#step-6').click(function(e) {
			e.preventDefault();
			$('#section-6').hide();
			$('#section-7').removeClass('hide');
		});
		$('#step-7').click(function(e) {
			e.preventDefault();
			$('#section-7').hide();
			$('#section-8').removeClass('hide');
		});
		$('#step-8').click(function(e) {
			e.preventDefault();
			$('#section-8').hide();
			$('#section-9').removeClass('hide');
		});
		$('#step-9').click(function(e) {
			e.preventDefault();
			$('#section-9').hide();
			$('#section-10').removeClass('hide');
		});
		$('#step-10').click(function(e) {
			e.preventDefault();
			$('#section-10').hide();
			$('#section-11').removeClass('hide');
		});
		$('#step-11').click(function(e) {
			$('#section-11').hide();
			$('#section-12').removeClass('hide');
		});
	});
	new WOW().init({
		boxClass:     'wow',
		animateClass: 'animated',
		mobile:       true,
		live:         true
	});
</script>
@stop
