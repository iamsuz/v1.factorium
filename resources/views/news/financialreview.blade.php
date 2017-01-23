@extends('layouts.main')

@section('title-section')
Financial Service Guide | @parent
@stop

@section('content-section')
<div class="containerouter">
	<div class="title" style="min-height:300px; background:#50B0DC; margin-top:-50px;">
		<div class="container">
			<h1 style="padding-top:120px; color:#FFFFFF;" class="text-center">Estate Baron pulls a crowd to fund its first two developments</h1>
			<p style="color:#FFFFFF; text-align:center; padding-bottom:100px">
			</p>
		</div>
	</div>
	<div class="container">
		<div class="left_container" style="padding-top:20px;">
			<div class="container">
			<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<p class="text-justify"><p>Estate Baron, the crowdfunding platform backed by investors Adrian Stone and Benni Aroni, says it has closed Australia's first two funding rounds for residential developments.</p>

					<p>Like a syndicated loan only smaller – $5000 is the minimum investment in this case – crowdfunding is well-established elsewhere, including in China, but less so here.</p>

					<p>Software-based crowdfunding is one of a number of new approaches being taken to raise capital for residential development in Australia. Separately in Melbourne, a group of architects is developing projects funded by small individual investors.</p>

					<p>Estate Baron is starting with baby steps. The first two projects to be funded by the tech platform are a two-townhouse development in Melbourne's Caulfield and a nine-studio-apartment building in Frankston, south east of the city.</p>

					<p>It wasn't even trying to raise the full cost. The Caulfield development has a $2.4 million price tag, but they only sought to raise $1m, with Equity Baron's investors providing the balance, co-founder Moresh Kokane told The Australian Financial Review on Wednesday.</p>

					<p>"We could have raised $2.4 million but we weren't sure what sort of response we would get," Mr Kokane said. "That project was filled up within three days."</p>

					<p>It took longer to raise the $500,000 – half of the total needed – for the Frankston project, in part because would-be investors were cautious about putting money into the area, he said.</p>

					<h3><strong>ROUGHER NEIGHBOURHOOD</strong></h3>

					<p>"People are still emotionally involved," he said. "Frankston is a rougher neighbourhood."</p>

					<p>Victorian builder Watersun is due to start construction on the Caulfield project in September.</p>

					<p>The $500,000 raised for the Frankston project by 22 investors is matched by a further $500,000 in debt guaranteed by Ricard Securities principal Michael Van Cuylenburg.</p>

					<p>Mr van Cuylenburg is trustee of funds in the managed investment scheme investors have bought into. He is overseeing the project and financial governance.</p>

					<p>Estate Baron now hopes to get the licences that will allow it to accept more investors and expand the size of its projects.</p>

					<p><em>"By the end of the year we are looking at a major tower,"</em> Mr Kokane said.</p>
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
						Posted on <time datetime="2015-08-12 18:51">August 12, 2015</time> by Michael Bleby.
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