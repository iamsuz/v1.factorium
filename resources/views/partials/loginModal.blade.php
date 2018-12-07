<div class="container">
	<div class="modal fade" id="loginModal" role="dialog">
		<div class="modal-dialog " style="margin-top: 5em;">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="row">
								<div class="col-md-12">
									<br>
									@if (Session::has('message'))
									{!! Session::get('message') !!}
									@endif
									<br>
									<div class="text-left">
										<h1 class="wow fadeIn animated font-bold first_color" data-wow-duration="1.5s" data-wow-delay="0.2s" style="font-weight:600 !important; font-size:2.625em; color:#2d2a6e;">Login</h1>
										<h3 class="font-regular first_color" style="font-size:1.375em;">It seems you are an existing user please enter your password to continue</h3>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<section id="loginForm" style="padding:0 10px;">
										{!! Form::open(array( 'route'=>'users.auth.eoi', 'class'=>'form-horizontal', 'role'=>'form', 'name'=>'offer_user_login_form', 'id'=>'offer_user_login_form' )) !!}
										<input type="hidden" name="redirectNotification" value="">
										<fieldset>
											<div class="form-group <?php if($errors->first('email')){echo 'has-error';}?> has-feedback">
												{!! Form::email('email', null, array('placeholder'=>'Email (you@somewhere.com)', 'class'=>'form-control hide', 'tabindex'=>'1','id'=>'loginEmailEoi')) !!}
												{!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="form-group <?php if($errors->first('password')){echo 'has-error';}?> has-feedback">
												{!! Form::password('password', array('placeholder'=>'password', 'class'=>'form-control', 'tabindex'=>'2','id'=>'loginPwdEoi')) !!}
												{!! $errors->first('password', '<small class="text-danger">:message</small>') !!}
											</div>
											@if($project->eoi_button)
											<input type="hidden" value="projects/{{$project->id}}/eoi" id="next" name="next">
											<input type="hidden" value="eoiLogin" id="eoiLogin" name="eoiLogin">
											<input type="text" class="hidden" name="first_name" id="eoiFName">
											<input type="text" class="hidden" name="last_name" id="eoiLName">
											{{-- <input type="text" class="hidden" name="lname" id="eoiLName"> --}}
											<input type="text" class="hidden" name="phone_number" id="eoiPhone">
											<input type="text" class="hidden" name="investment_period" id="eoiInvestmentPeriod">
											<input type="text" class="hidden" name="investment_amount" id="eoiInvestmentAmount">
											<input type="text" class="hidden" name="project_id" id="eoiProjectId">
											@endif
											<div class="form-group" style="width:75%;">
												{!! Form::submit('Continue with Estate Baron account', array('class'=>'btn btn-block second_color_btn hide', 'tabindex'=>'4', 'style'=>'border-radius:50px; background-color:#fed405;font-size:1.125em;color:#2d2d4b;')) !!}
												<button type="submit" class='btn btn-lg btn-danger font-semibold text-right second_color_btn' id="submitformlogin" href='#' style="width:300px; background-color: #fed405; font-size:1em; color:#000;border-radius:50px; border: 0px;" data-toggle="tooltip" title="If you are an existing EstateBaron.com user you can use the same username and password here without having to sign up again"><img class="pull-left" src="{{asset('assets/images/estatebaronLogo.png')}}" style="width: 20px;"> Login with Estate Baron account</button>
											</div>
											<p class="text-left hide" style="margin-left: -25px"> <a class="btn btn-link" href="{{ url('/password/email') }}"> Forgot Your Password?</a></p>
										</fieldset>
										{!! Form::close() !!}
										<br>
										<h4 class="text-left font-regular first_color hide" style="margin-left: -15px; font-size:1.375em;color:#2d2a6e;" id="eoiRegisterBtn">Don't have an account yet?
											<b><a href=""></a>{!! Html::linkRoute('users.create', 'Register here') !!}</b>
										</h4>
									</section>
								</div>
								<div class="col-md-2 hide" style="position:relative;">
									<div style="position: absolute; margin: auto;top:50%;left:50%;margin-top:-25px;margin-left:-25px;">
										<div class="second_color_btn" style="border-radius: 100%"><img class="img-responsive" src="{{asset('assets/images/Ellipse1.png')}}" style="opacity: 0;" /></div> <p class="text-center" style="margin-top: -70%;font-size: 1.2em;font-weight: 600;color:#F7C228;">OR</p>
									</div>
									<br><br>
									<br><br>
									<br>
								</div>
								<div class="col-md-4 hide">
									<div class="row" style="text-align:center;">
										<div class="btn-group" style="box-shadow:3px 3px 3px #888888;">
											<!-- <a class='btn btn-lg btn-danger'><i class="fa fa-google-plus" style="width:16px;"></i></a> -->
											<a class='btn btn-lg btn-danger text-right font-semibold google-btn' href='/auth/google' style="width:243px; background-color: #F1F1F1; border-color: #F1F1F1; font-size:1em; color:#000;border-radius:0;"><img class="pull-left" src="{{asset('assets/images/google_login.png')}}"> Sign in with Google</a>
										</div>
										<br><br>
										<div class="btn-group" style="box-shadow:3px 3px 3px #888888;">
											<!-- <a class='btn btn-lg btn-info disabled' style="background: #4873b4;border-color: #4875b4;"><i class="fa fa-linkedin" style="width:16px;"></i></a> -->
											<a class='btn btn-lg btn-info font-semibold linkedin-btn' href='/auth/linkedin' style="width:243px; background-color: #127AB6; border-color: #127AB6; font-size:1em; color:#fff; border-radius:0;"><img class="pull-left" src="{{asset('assets/images/linkedin_login.png')}}" style="width:25px; background-color:#fff;"> Sign in with Linkedin</a>
										</div>
										<br><br>
										<div class="btn-group" style="box-shadow:3px 3px 3px #888888;">
											<a class='btn btn-lg btn-primary font-semibold facebook-btn' href='/auth/facebook' style="width:243px; background-color: #375599; border-color: #375599; font-size:1em; color:#fff; border-radius:0;"><img class="pull-left" src="{{asset('assets/images/fb_login.png')}}" style=" margin:-10px -12px; background-color: #fff; width:45px;"> Sign in with Facebook</a>
										</div>
									</div>
								</div>
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
