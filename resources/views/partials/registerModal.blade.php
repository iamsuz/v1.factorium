<div class="container">
	<div class="modal fade" id="registerModal" role="dialog" style="overflow: auto;	">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<div class="row">
							<div class="col-md-12">
								<div id="session_message">
									<br>
									@if (Session::has('message'))
									{!! Session::get('message') !!}
									@endif
									<br>
								</div>
								<div class="text-left">
									<h3 class="font-bold first_color" style="font-weight:600 !important; font-size:2.625em; color:#2d2a6e;visibility: visible;">You are almost there!</h3>
									<h4 class="font-regular first_color" style=" margin-top:-20px; font-size:1.375em; color:#2d2a6e;visibility: visible;"><br>Please set a password for your account to complete the process</h4>
									<br>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<section id="registerForm" style="padding:0 10px;">
									<h4 class="font-bold first_color hide" style="font-weight:500 !important; font-size:1.125em; color:#2d2d4b;">Register with an email</h4>
									{!! Form::open(array('route'=>'registrations.store', 'class'=>'form-horizontal', 'role'=>'form','id'=>'regForm', 'name'=>'offer_user_registration_form'))!!}
									<div class="row form-group hide user-name-details-section">
										<div class="col-md-6 <?php if($errors->first('reg_first_name')){echo 'has-error';}?> wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.7s" style="z-index:3;" id="err_msg">
											{!! Form::text('reg_first_name', null, array('placeholder'=>'First Name', 'class'=>'form-control input-box', 'tabindex'=>'1', 'id'=>'reg_first_name')) !!}
											{!! $errors->first('reg_first_name', '<small class="text-danger">:message</small>') !!}
										</div>
										<div class="col-md-6 <?php if($errors->first('reg_last_name')){echo 'has-error';}?> wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.7s" style="z-index:3;" id="err_msg">
											{!! Form::text('reg_last_name', null, array('placeholder'=>'Last Name', 'class'=>'form-control input-box', 'tabindex'=>'1', 'id'=>'reg_last_name')) !!}
											{!! $errors->first('reg_last_name', '<small class="text-danger">:message</small>') !!}
										</div>
									</div>
									<div class="row form-group">
										<!-- <div> -->
											<div class="col-md-12 <?php if($errors->first('email')){echo 'has-error';}?> wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.7s" style="z-index:3;" id="err_msg">
												{!! Form::email('email', null, array('placeholder'=>'Email', 'class'=>'form-control', 'tabindex'=>'2', 'id'=>'eoiREmail', 'data-toggle'=>'popover', 'data-trigger'=>'hover', 'data-placement'=>'bottom', 'data-content'=>'', 'required'=>'true')) !!}
												{!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
											</div>
											<!-- </div> -->
										</div>
										<div class="row form-group">
											<!-- <div> -->
												<div class="col-md-12 <?php if($errors->first('phone_number')){echo 'has-error';}?> wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.7s" style="z-index:3;" id="err_msg">
													{!! Form::text('request_form_phone_number', null, array('placeholder'=>'Phone number', 'class'=>'form-control', 'tabindex'=>'3', 'id'=>'requestFormPhoneNumber', 'data-toggle'=>'popover', 'data-trigger'=>'hover', 'data-placement'=>'bottom', 'data-content'=>'','style'=>'display:none;')) !!}
													{!! $errors->first('phone_number', '<small class="text-danger">:message</small>') !!}
												</div>
												<!-- </div> -->
											</div>
											<div class="row form-group">
												<!-- <div> -->
													<div class="col-md-12 <?php if($errors->first('password')){echo 'has-error';}?>" data-wow-delay="0.2s">
														{!! Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control input-box','name'=>'password', 'Value'=>'', 'id'=>'RegPassword', 'tabindex'=>'3','required')) !!}
														{!! $errors->first('password', '<small class="text-danger">:message</small>') !!}
													</div>
													<div class="col-md-12 <?php if($errors->first('registration_site')){echo 'has-error';}?>" data-wow-delay="0.2s" hidden >
														<input type="text" name="registration_site" class="form-control" value="<?php echo url(); ?>">
													</div>
													<div class="col-md-12 <?php if($errors->first('eoiReg')){echo 'has-error';}?>" data-wow-delay="0.2s" hidden >
														<input type="text" name="eoiReg" class="form-control" value="eoiReg">
													</div>
													<input type="hidden" value="projects/{{$project->id}}/eoi" id="regnext" name="regnext">
													<input type="hidden" value="eoiLogin" id="eoiLogin" name="eoiLogin">
													<input type="text" class="hidden" name="first_name" id="eoiRFName">
													<input type="text" class="hidden" name="last_name" id="eoiRLName">
													{{-- <input type="text" class="hidden" name="lname" id="eoiLName"> --}}
													<input type="text" class="hidden" name="phone_number" id="eoiRPhone">
													<input type="text" class="hidden" name="phone" id="eoiRPhone1">
													<input type="text" class="hidden" name="investment_period" id="eoiRInvestmentPeriod">
													<input type="text" class="hidden" name="investment_amount" id="eoiRInvestmentAmount">
													<input type="text" class="hidden" name="eoi_project" id="eoiRProjectId">
													<input type="text" class="hidden" name="accreditedEoi" id="accreditedEoiR">
													<input type="text" class="hidden" name="country_code" id="country_codeR">
													<!-- </div> -->
												</div>
												<p class="font-bold hide" style="font-size:1.125em;color:#2d2d4b;">What best describes you?</p>
												<div class="row text-left hide">
													<div class="col-md-12 wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.4s">
														<div class="btn-group" data-toggle="buttons">
															<input type="radio" name="role" id="investor_role" autocomplete="off" value="investor" checked tabindex="1"><span class="font-regular" style="font-size:0.875em; color:#2d2a6e;">&nbsp;&nbsp;&nbsp; I am an Investor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
															<div class="hide" style="display: inline;"><input type="radio" name="role" id="developer_role" autocomplete="off" value="developer" tabindex="2"><span class="font-regular" style="font-size:0.875em;color:#2d2a6e;">&nbsp;&nbsp;&nbsp; I have a venture </span></div>
														</div>
													</div>
												</div><br>
												<div class="row form-group">
													<div class="col-md-12" data-wow-delay="0.2s">
														{!! Form::text('invite_code',NULL, array('placeholder'=>'Invite code', 'class'=>'form-control', 'tabindex'=>'2', 'id'=>'invite_code', 'data-toggle'=>'popover', 'data-trigger'=>'hover', 'data-placement'=>'bottom', 'data-content'=>'','required'=>'required')) !!}
														@if(session()->has('invite_code_error'))
														<div class="alert alert-danger">
															{{ session()->get('invite_code_error') }}
														</div>
														@endif
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-md-12">
														<div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
														{!! $errors->first('g-recaptcha-response', '<small class="text-danger">:message</small>') !!}
														<br><br>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12 " style="visibility: visible !important;">
														<input type="submit" value="Register" id="submit1" name="submit"  class="btn btn-block font-bold hide" hidden style="height:40px; width:50%; font-size: 1.125em; background-color:#fed405; border-radius:0px;color:#2d2d4b;" tabindex="8">
														<button type="button" class='btn btn-lg btn-danger font-semibold text-right second_color_btn' id="submitform"  style="width:243px; background-color: #fed405; font-size:1em; color:#000;border-radius:50px; border: 0px;"><img class="pull-left" src="{{asset('assets/images/estatebaronLogo.png')}}" style="width: 20px;"> Register</button>
													</div>
													<div class="col-md-12">
														<span><small>** If you are an existing EstateBaron.com user you can use the same username and password here without having to sign up again.</small></span>
													</div>
												</div>
												{!! Form::close() !!}
												<br>
												<h4 class="text-left font-regular first_color hide" style="font-size:1.375em;color:#2d2a6e;">If you have an account. <b>{!! Html::linkRoute('users.login', 'Sign In Here') !!}</b>
												</section>
											</div>
											{{-- <div class="col-md-3" style="position:relative;">
											<div style="position: absolute; margin: auto;top:50%;left:50%;margin-top:-25px;">
										<div class="second_color_btn" style="border-radius: 100%;"><img class="img-responsive" src="{{asset('assets/images/Ellipse1.png')}}" style="opacity: 0;" /></div><p class="text-center" style="margin-top: -70%;font-size: 1.2em;font-weight: 600;color:#F7C228;">OR</p>
									</div>
									<br><br>
									<br><br>
									<br>
								</div> --}}
								{{-- <div class="col-md-3">
									<div class="row" style="text-align:center;">
										<div class="btn-group" style="box-shadow:3px 3px 3px #888888;">
											<!-- <a class='btn btn-lg btn-danger'><i class="fa fa-google-plus" style="width:16px;"></i></a> -->
											<a class='btn btn-lg btn-danger font-semibold text-right' href='/auth/google' style="width:243px; background-color: #F1F1F1; border-color: #F1F1F1; font-size:1em; color:#000;border-radius:0;"><img class="pull-left" src="{{asset('assets/images/google_login.png')}}"> Sign in with Google</a>
										</div>
										<br><br>
										<div class="btn-group" style="box-shadow:3px 3px 3px #888888;">
											<!-- <a class='btn btn-lg btn-info disabled' style="background: #4875b4;border-color: #4875b4;"><i class="fa fa-linkedin" style="width:16px;"></i></a> -->
											<a class='btn btn-lg btn-info  font-semibold' href='/auth/linkedin' style="width:243px; background-color: #127AB6; border-color: #127AB6; font-size:1em; color:#fff; border-radius:0;"><img class="pull-left" src="{{asset('assets/images/linkedin_login.png')}}" style="width:25px; background-color:#fff;"> Sign in with Linkedin</a>
										</div>
										<br><br>
										<div class="btn-group" style="box-shadow:3px 3px 3px #888888;">
											<a class='btn btn-lg btn-primary font-semibold' href='/auth/facebook' style="width:243px; background-color: #375599; border-color: #375599; font-size:1em; color:#fff; border-radius:0;"><img class="pull-left" src="{{asset('assets/images/fb_login.png')}}" style=" margin:-10px -12px; background-color: #fff; width:45px;"> Sign in with Facebook</a>
										</div>
										<br><br>
									</div>
								</div> --}}
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
