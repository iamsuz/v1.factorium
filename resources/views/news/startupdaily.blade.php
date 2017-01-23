@extends('layouts.main')

@section('title-section')
Financial Service Guide | @parent
@stop

@section('content-section')
<div class="containerouter">
	<div class="title" style="min-height:300px; background:#50B0DC; margin-top:-50px;">
		<div class="container">
			<h1 style="padding-top:120px; color:#FFFFFF;" class="text-center">Property crowdfunding platform EstateBaron wants to make investing in real estate accessible to everyone</h1>
			<p style="color:#FFFFFF; text-align:center; padding-bottom:100px">
			</p>
		</div>
	</div>
	<div class="container">
		<div class="left_container" style="padding-top:20px;">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<p class="text-justify"><p>It’s almost impossible to go a day in Sydney without having at least one conversation about property prices. The city is consumed with property prices, with news of record sales figures on our screens and in the newspapers almost every night. But even though we’re all talking about it, most of us can’t actually afford property – <strong>just 23.7 percent</strong> of Sydneysiders aged between 20 and 34 are expected to own their own homes in 2019, and the same is expected to happen in other cities around the country.</p>

					<p>Founded by Moresh Kokane, Shuang Li, Luke Hindson, and Mark Winslade, Melbourne startup EstateBaron can’t solve this problem, but it can help people get a slice of the real estate pie through its crowdfunding platform. For a fee, EstateBaron allows developers and financial advisors to list real estate opportunities, in which an interested user can invest anything upwards of $2,000 into a trust to fund the development of a property. A listing will detail things such as expected returns, risk, length of development, and plans for the property post development.</p>

					<p>Co-founder Shuang Li said the drive behind the platform was the fact that booming property prices were leaving a significant number of people out of the market.</p>

					<p>“Property investment is a big commitment. We allow people to start with smaller amounts and diversify while investing in institutional-quality projects. Unlike a REIT [real estate investment trust] there are no fund manager fees for selecting properties, and you get to pick and choose the specific property you wish to invest in,” he said.</p>

					<p>“You also get to participate in the growth of your community by investing in local projects.”</p>

					<p>Li said around 400 investors are currently using the platform, raising over $900,000 so far for two projects in Melbourne.</p>

					<p>“We are intentionally keeping all promotions local to Melbourne. Even though this is an online platform, people in early days need to know where their funds are going. Property is a tangible investment and we let people drive over to the sites if they wish to,” he said.</p>

					<p>Li explained that the team has purposely been slow to bring developers on board to ensure the quality of offers listed.</p>

					<p>“We are not focused on onboarding developers as early on we realized that developers were not the problem; we were approached by many developers big and small to raise funds. But our focus is our investors, to ensure that we take on projects that we are able to complete the fundraise for, and present deals that are attractive enough.”</p>

					<p>Investors can keep track of the progress of their investments through EstateBaron. Exits for investors differ from property to property; for example, upon completion of a development, a property may be sold and investors paid out, or it may be held as a rental asset and investors kept on board.</p>

					<p>The launch of EstateBaron comes a few months after that of Sydney-based BrickX and Perth-based CrowdfundUP. While BrickX is currently only open to wholesale investors worth at least $2.5 million, the purpose of EstateBaron and CrowdfundUP is the same – to open up the property market beyond high-net worth investors – but CrowdfundUP boasts a few extra features.</p>

					<p>While EstateBaron merely lists investment opportunities and then connects an interested user to the developer or advisor behind the listing, CrowdfundUP facilitates the transaction itself. It will help an interested user draft a formal expression of interest letter and, once they receive an invitation of investment, an acceptance letter, and will collect payment. It also allows users to invest as little as $100.</p>

					<p>However, Li explained the advertising of a $100 investment doesn’t properly reflect reality. Because it is open to retail investors, the regulations under which a platform such as EstateBaron operates mandates that a developer is only allowed to bring on board 20 retail investors a year.</p>

					<p>“If the issuer takes your offer of $100 or $66, they are essentially wasting a seat out of the 20 on you and they will have to compensate for it from the remainder. So sure, you can make an offer to buy a ‘brick’ for $66 but chances are your offer won’t be accepted,” he said.</p>

					<p>Having raised a “healthy” angel round from investors including Angel Cube’s Adrian Stone and Benni Aroni, one of the men behind the Eureka Towers, EstateBaron will be focused on Melbourne for the next six months or so. The team is currently planning for the launch of a “large iconic tower project” in the city, after which it will start looking to expand into other cities.</p>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<p class="text-right">
						Posted on <time datetime="2015-08-04 13:00">August 04, 2015</time> by Gina Baldassarre.
					</p>
				</div>
			</div>
		</div>
	</footer>
	@if(Auth::guest())
	<section id="register" class="chunk-box">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h2 class="wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.2s" style="font-weight:100;">You are almost there! <br>
						<small class="wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-size:.5em">Sign up for free, to see the current opportunities.</small>
					</h2>
				</div>
			</div>
			@if ($errors->has())
			<br>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="alert alert-danger text-center">
						@foreach ($errors->all() as $error)
						{{ $error }}<br>
						@endforeach
					</div>
				</div>
			</div>
			<br>
			@endif
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(array('route'=>'registrations.store', 'class'=>'form-horizontal', 'role'=>'form','onsubmit'=>'return checkvalidi();','id'=>'form'))!!}
					<div class="row text-center">
						<div class="col-md-12 wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.4s">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-primary active eb-checkbox">
									<input type="radio" name="role" id="investor_role" autocomplete="off" value="investor" checked tabindex="1"> I am an Investor
								</label>
								<label class="btn btn-primary eb-checkbox">
									<input type="radio" name="role" id="developer_role" autocomplete="off" value="developer" tabindex="2"> I am a Developer
								</label>
							</div>
						</div>
					</div>
					<br>
					<div class="row text-center">
						<div class="col-md-8 col-md-offset-2">
							<div class="row">
								<div class="form-group">
									<div class="col-md-6 col-md-offset-3 <?php if($errors->first('email')){echo 'has-error';}?> wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.7s" style="z-index:3;" id="err_msg">
										{!! Form::email('email', null, array('placeholder'=>'you@somwehere.com', 'class'=>'form-control', 'tabindex'=>'2', 'id'=>'email', 'data-toggle'=>'popover', 'data-trigger'=>'hover', 'data-placement'=>'bottom', 'data-content'=>'We will never share your contact details with unaffiliated parties, we use your email to notify you of the new and exciting projects on our site', 'required'=>'true')) !!}
										{!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group" id="password_form" style="display:none">
									<div class="col-md-6 col-md-offset-3 <?php if($errors->first('password')){echo 'has-error';}?>" data-wow-delay="0.2s">
										{!! Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control input-box','name'=>'password', 'Value'=>'', 'id'=>'password', 'tabindex'=>'3')) !!}
										{!! $errors->first('password', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="1s">
									<input type="submit" value="See the Opportunities" id="submit" name="submit"  class="btn btn-primary btn-danger" style="height:40px; width:244px;font-size: 1.2em; margin:10px 10px; " tabindex="8">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="1s" style="padding-top:10px;">
							You have an account!
							{!! Html::linkRoute('users.login', 'Sign In Here') !!}
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</section>
	@endif
	@stop