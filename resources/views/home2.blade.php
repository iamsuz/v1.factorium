<!DOCTYPE Html>
<!--[if IE 8]> <Html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <Html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <Html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Estate Baron">
	<meta name="description" content="Invest in Melbourne Real Estate Developments from $2000. View listing now.">
	<meta name="copyright" content="moppet pvt. ltd. copyright (c) 2015">
	<link rel="shortcut icon" href="favicon.ico">
	<title>
		@section('title-section')
		EstateBaron : Crowd Funding Real Estate Investment
		@show
	</title>
	<!-- Bootstrap -->
	{!! Html::style('css/bootstrap.min.css') !!}
	{!! Html::style('plugins/font-awesome-4.3.0/css/font-awesome.min.css') !!}

	@section('css-section')
	{!! Html::style('css/app.css') !!}
	@show
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,700,200italic,400italic,700italic' rel='stylesheet' type='text/css'>

	<!-- Html5 Shim and Respond.js IE8 support of Html5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/Html5shiv/3.7.0/Html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body data-spy="scroll">
	<!-- topbar nav content here -->
	<header id="header" class="header">
		<div class="container">
			<h1 class="logo pull-left">
				<a class="scrollto" href="#promo">
					<span class="logo-title">estateBaron</span>
				</a>
			</h1><!--//logo-->
			<nav class="main-nav navbar-right" id="main-nav" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					{{-- {!! Html::linkRoute('home', 'estateBaron', null, array('class'=>'navbar-brand', 'style'=>'font-weight: bold'))!!} --}}
				</div>

				<div class="collapse navbar-collapse" id="navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active nav-item"><a href="#promo" class="scrollto">Home</a></li>
						<li class="nav-item"><a href="#what-is-this" class="scrollto">What is This</a></li>
						<li class="nav-item"><a href="#stats" class="scrollto">Stats</a></li>
						<li class="nav-item"><a href="#">Team</a></li>
						<li class="nav-item"><a href="#">FAQ</a></li>
						@if (Auth::guest())
						<li class="nav-item">{!! Html::linkRoute('users.create', 'Register') !!}</li>
						<li class="nav-item last">{!! Html::linkRoute('users.login', 'Sign In') !!}</li>
						@else
						<li class="dropdown last">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{!! Auth::user()->first_name !!} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li>{!! Html::linkRoute('users.index', 'All Users') !!}</li>
								<li>{!! Html::linkRoute('users.show', 'Profile', Auth::id()) !!}</li>
								<li>{!! Html::linkRoute('users.edit', 'Edit User', Auth::id()) !!}</li>
								<li>{!! Html::linkRoute('users.logout', 'logout') !!}</li>
							</ul>
						</li>
						@endif
					</ul>
				</div>
			</nav>
		</div>
	</header>
	@show

	<!-- header content here -->
	<section id="promo" class="parallax">
		<img src="/assets/images/ESTATE-BARON_White.png" alt="estate baron" width="300" id="center-logo">
		<h1 class="text-center" id="center-text">
			Own a piece of Sydney<br>
			for as little as $2000
		</h1>
	</section>
	<section style="margin-bottom:30px;">
		<h1 class="text-center"><small>We connect you directly with developers and institutional quality development opportunities</small></h1>
	</section>
	<section id="what-is-this" class="chunk-box">
		<div class="container">
			<h1 class="text-center">Invest in Property with small amounts</h1><br>
			<div class="row">
				<div class="col-md-7">
					<h2 class="text-left">Property Investments are expensive</h2>
					<hr>
					<p class="text-justify">Australians love property, and it is a great asset to invest in. But investing in real estate typically requires huge amounts of money, locking out most investors. Real Estate Equity crowdfunding is a way in which many small investors come together to contribute small amounts towards a project development.</p>
				</div>
				<div class="col-md-5">
					<img src="assets/images/imga46.png" alt="side image" width="450" class="pull-right img-responsive">
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<img src="assets/images/imga47.png" alt="side image" width="450" class="pull-left img-responsive">
				</div>
				<div class="col-md-7">
					<h2 class="text-right">Invest with small amounts</h2>
					<hr>
					<p class="text-justify">Pooled money is then passed to the Project Developer and each investor ends up owning a piece of the pie. Equity crowdfunding is essentially a form of financial investment and is hence governed by ASIC regulations. Our partners have worked in the finance industry for decades and after reviewing each project opportunity, partners craft a package that is fully compliant with ASIC regulations.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-7">
					<h2 class="text-left">Pick and Choose</h2>
					<hr>
					<p class="text-justify">Our beautiful technology platform lists all the opportunities. You as an investors can review details of projects and then choose to invest in the projects you like. Once you have made your choice, you will be prompted to complete papers necessary to conclude the process. You can then monitor the progress of your investments on a management dashboard.</p>
				</div>
				<div class="col-md-5">
					<img src="assets/images/imga48.png" alt="side image" width="450" class="pull-right img-responsive">
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<img src="assets/images/imga49.png" alt="side image" width="450" class="pull-left img-responsive">
				</div>
				<div class="col-md-7">
					<h2 class="text-right">Full solution</h2>
					<hr>
					<p class="text-justify">That is it really! We have you covered on both compliance and technology side of things. For the first time in Australia, investors can now participate in real estate projects with very small amounts. Real Estate Equity Crowdfunding is here!</p>
				</div>
			</div>
		</div>
	</section>
	<section id="how" class="chunk-box">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<div class="embed-responsive embed-responsive-16by9" style="margin-bottom:4em;position: relative;padding-bottom: 53%;padding-top: 25px;height: 0;">
						<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/135224804" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="news" class="chunk-box">
		<div class="container">
			<h1 class="text-center">What Australia's talking about us.</h1>
			<div class="row">
				<div class="col-md-6 text-left">
					<blockquote>
						<p><i class="fa fa-quote-left fa-3x fa-pull-left" style="color:#aaa;"></i><a href="http://www.estatebaron.com/page/financialreview" style="color:#6a6a6a;">Estate Baron pulls a crowd to fund its first two developments</a>"</p>
						<footer><cite><a href="http://www.estatebaron.com/page/financialreview" style="color:#6a6a6a;">afr.com</a></cite>
							<a href="http://www.estatebaron.com/page/financialreview"><img src="http://www.estatebaron.com/public/images/Financial_Review_logo.png" class="img-responsive pull-right" style="max-height:30px;" alt="Estate Baron pulls a crowd to fund its first two developments."></a>
						</footer>
					</blockquote>
				</div>
				<div class="col-md-6 text-left">
					<blockquote>
						<p><i class="fa fa-quote-left fa-3x fa-pull-left" style="color:#aaa;"></i><a href="http://www.estatebaron.com/page/startupsmart" style="color:#6a6a6a;">Founding Stone a good support for real estate crowdfunder</a>"</p>
						<footer><cite><a href="http://www.estatebaron.com/page/startupsmart" style="color:#6a6a6a;">startupsmart.com.au</a></cite>
							<a href="http://www.estatebaron.com/page/startupsmart"><img src="http://www.estatebaron.com/public/images/StartupSmart-Logo.jpg" class="img-responsive pull-right" style="max-height:40px;" alt="Founding Stone a good support for real estate crowdfunder."></a>
						</footer>
					</blockquote>
				</div>
			</div>
		</div>
	</section>
	<section id="stats" class="parallax chunk-box">
		<div class="container">
			<h2 class="text-center">##### stats ######</h2>
		</div>
	</section>

	<section class="chunk-box">
		<div class="container"><div class="row">
			<div class="col-md-12">
				<h2 class="text-center"><small>We would love to meet you and answer any queries<br>
					click here to schedule a meeting with us or request a phone call.</small></h2>
				</div>
			</div>
		</div>
	</section>
	<footer id="footer" class="chunk-box">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<ul class="list-inline">
						<li><h3>Blog</h3></li>
						<li><h3>Terms & conditions</h3></li>
						<li><h3>Privacy</h3></li>
						<li><h3>Media Kit</h3></li>
					</ul>
					<h4><address>350 Collins st, Melbourne 3000. <i class="fa fa-phone"></i> 1 300 033 221</address></h4>
					<h3 class="copyright"><small>Made with <i class="fa fa-heart"></i> by developers at <a href="/">Estate Baron</a>. © 2015 Estatebaron. All Rights Reserved. </small></h3>
				</div>
			</div>
		</div>
	</footer>
	@show

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	{!! Html::script('js/jquery-1.11.3.min.js') !!}
	{!! Html::script('js/bootstrap.min.js') !!}
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>

	@section('js-section')
	@show
	<script type="text/javascript">
		(function(){
			var parallax = document.querySelectorAll(".parallax"),
			speed = 0.5;

			window.onscroll = function(){
				[].slice.call(parallax).forEach(function(el,i){

					var windowYOffset = window.pageYOffset,
					elBackgrounPos = "50% -" + (windowYOffset * speed) + "px";

					el.style.backgroundPosition = elBackgrounPos;

				});
			};
		})();

		// You can avoid the document.ready if you put the script at the bottom of the page
		$(document).ready(function() {
			/* ======= Scrollspy ======= */
			$('body').scrollspy({ target: '#header', offset: 400});

			/* ======= Fixed header when scrolled ======= */

			$(window).bind('scroll', function() {
				if ($(window).scrollTop() > 50) {
					$('#header').addClass('navbar-fixed-top');
				}
				else {
					$('#header').removeClass('navbar-fixed-top');
				}
			});
			$('.scrollto').click(function(e) {
				e.preventDefault();
				$(window).stop(true).scrollTo(this.hash, {duration:1000, interrupt:true});
			});
		});
	</script>
</body>
</Html>