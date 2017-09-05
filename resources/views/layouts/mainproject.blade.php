<!DOCTYPE Html>
<!--[if IE 8]> <Html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <Html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <Html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.metatags')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Estate Baron">
    <meta name="description" content="Invest with small amounts in the construction of 2 townhouses in the prestigious mount waverley school zone. 20% returns in 18 months, Refer to PDS for details">
    <meta name="copyright" content="Estate Baron Crowdinvest Pty Ltd copyright (c) 2016">
    <!-- <link rel="shortcut icon" href="/favicon.png" type="image/x-icon"> -->
    <link rel="shortcut icon" href="/favicon.png?v=<?php echo filemtime('favicon.png'); ?>" type="image/x-icon">
    <!-- Open Graphic -->

    <meta property="og:image" content="https://www.estatebaron.com/images/hero-image-1.jpg" />
    <meta property="og:site_name" content="Estate Baron" />
    <meta property="og:url" content="https://www.estatebaron.com" />
    <meta property="og:type" content="website" />
    <!-- META DATA -->
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">

    @if (Config::get('analytics.gtm.enable'))
    @include('partials.gtm-script')
    @endif
    
    @section('meta-section')
    @show

    <title>
        @section('title-section')
        EstateBaron : Crowd Funding Real Estate Investment
        @show
    </title>
    <!-- Bootstrap -->
    {!! Html::style('/css/bootstrap.min.css') !!}
    {!! Html::style('/plugins/font-awesome-4.4.0/css/font-awesome.min.css') !!}

    @section('css-app')
    {!! Html::style('/css/app3.css') !!}
    @show

    @yield('css-section')

    <!-- Html5 Shim and Respond.js IE8 support of Html5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/Html5shiv/3.7.0/Html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- End Inspectlet Embed Code -->
</head>
<body data-spy="scroll">
    @if (Config::get('analytics.gtm.enable'))
    @include('partials.gtm-noscript')
    @endif
    <!-- topbar nav content here -->
    @section('topbar-section')
    <nav class="navbar navbar-default header hide" id="header" role="navigation">
        <div class="container" id="containernav">
            <div class="logo pull-left">
                <a href="{{route('home')}}">
                <span class="logo-title"><img src="{{asset('assets/images/main_logo.png')}}" width="100" alt="estate baron logo" id="logo" style="margin-top:0em;"></span>
                </a>
            </div><!--//logo-->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item"><a href="{{route('home')}}" class="scrollto hide" id="nav_home">Home</a></li>
                    <!-- <li class="nav-item"><a href="{{route('home')}}#what-is-this" class="scrollto">WHAT IS THIS</a></li> -->
                    <li class="nav-item"><a href="{{route('home')}}#how-it-works" class="scrollto">How it works</a></li>
                    <li class="nav-item" style="color: #eee;"><a href="{{route('home')}}#projects" class="scrollto">Ventures</a></li>
                    <li class="nav-item"><a href="{{route('home')}}#security" class="scrollto">Security</a></li>
                    <li class="nav-item"><a href="/pages/team">About us</a></li>
                    <li class="nav-item"><a href="/pages/faq">FAQ</a></li>
                    @if (Auth::guest())
                    <li class="nav-item"><a href="{{route('users.create')}}">Register</a></li>
                    <li class="nav-item"><a href="{{route('users.login')}}">Sign in</a></li>
                    @else
                    <li class="dropdown nav-item last">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> My Account <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @if(Auth::user()->roles->contains('role', 'admin') || Auth::user()->roles->contains('role', 'master'))
                            <li class="nav-item"><a href="{{route('dashboard.index')}}">Dashboard</a></li>
                            @endif
                            <li class="nav-item"><a href="{{route('users.show',[Auth::user()])}}">Profile</a></li>
                            <li class="nav-item"><a href="{{route('users.logout')}}">Logout</a></li>
                        </ul>
                    </li>
                    <li class="hide"><a href="#"><i class="fa fa-bell"></i></a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @show

    <!-- header content here -->
    @section('header-section')
    @stop

    <!-- body content here -->
    <div class="content">
        @yield('content-section')
    </div>

    <!-- footer content here -->
    @section('footer-section')
    <footer id="footer" class="chunk-box">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center " data-wow-duration="1.5s" data-wow-delay="0.2s">
                    <center>
                        <!-- <h1>Vestabyte</h1> -->
                        <img class="img-responsive" src="{{asset('assets/images/main_logo.png')}}" alt="estate baron" width="200">
                    </center>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 text-center " data-wow-duration="1.5s" data-wow-delay="0.3s">
                    <a href="http://www.facebook.com/Vestabyte-183997715331116" class="footer-social-icon" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a>
                    <a href="http://www.twitter.com/vestabyte" class="footer-social-icon" target="_blank"><i class="fa fa-twitter-square fa-2x"></i></a>
                    <a href="http://www.twitter.com/vestabyte" class="footer-social-icon" target="_blank"><i class="fa fa-twitter-square fa-2x"></i></a>
                    <a href="http://www.twitter.com/vestabyte" class="footer-social-icon" target="_blank"><i class="fa fa-twitter-square fa-2x"></i></a>
                    <a href="http://www.twitter.com/vestabyte" class="footer-social-icon" target="_blank"><i class="fa fa-twitter-square fa-2x"></i></a>
                    <a href="http://www.twitter.com/vestabyte" class="footer-social-icon" target="_blank"><i class="fa fa-twitter-square fa-2x"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <ul class="list-inline footer-list " data-wow-duration="1.5s" data-wow-delay="0.4s" style="margin:0px;">
                        <li class="footer-list-item"><a href="#promo" class="scrollto"><h3>Home</h3></a></li>
                        <li class="footer-list-item"><a href="/blog"><h3>Blog</h3></a></li>
                        <li class="footer-list-item"><a href="#"><h3>Terms & conditions</h3></a></li>
                        <li class="footer-list-item"><a href="#"><h3>Venture Finance</h3></a></li>
                        <li class="footer-list-item"><a href="#"><h3>Privacy</h3></a></li>
                        <li class="footer-list-item"><a href="#" download><h3>Media Kit</h3></a></li>
                        <li class="footer-list-item"><a href="{{asset('assets/documents/FSG.pdf')}}" target="_blank"><h3>Financial Service Guide</h3></a></li>
                    </ul>
                    <address style="margin:0px;"><h3 class="" data-wow-duration="1.5s" data-wow-delay="0.8s" style="margin:0px;"><small>Suite 569 - 585 Little Collins Street Melbourne VIC 3000. <i class="fa fa-phone"></i> +61 3 98117015</small></h3></address>
                    <h3 class="copyright " data-wow-duration="1.5s" data-wow-delay="0.9s" style="margin:0px;"><small>© 2016 <a href="{{route('home')}}">Vestabyte</a>. All Rights Reserved.</small></h3>
                </div>
            </div>
        </div>
    </footer>
    @show

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {!! Html::script('/js/jquery-1.11.3.min.js') !!}
    {!! Html::script('/js/bootstrap.min.js') !!}
    {!! Html::script('/js/circle-progress.js')!!}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
            $('a[data-disabled]').click(function (e) {
                e.preventDefault();
            });
            $('body').scrollspy({ target: '#header', offset: 400});
            var mq = window.matchMedia("(min-width: 1140px)");
            $(window).bind('scroll', function() {
                if ($(window).scrollTop() > 50) {
                    $('#header').addClass('navbar-fixed-top');
                    $('#logo').removeClass('hide');
                    $('#nav_home').removeClass('hide');
                    $('#header').removeClass('hide');
                    if(mq.matches){
                        $('#section-colors-left').removeClass('hide');
                    }else{
                    }   
                }
                else {
                    $('#header').removeClass('navbar-fixed-top');
                    $('#logo').addClass('hide');
                    $('#nav_home').addClass('hide');
                    $('#header').addClass('hide');
                    if(mq.matches){
                        $('#section-colors-left').addClass('hide');
                    }else{
                    }
                }
            });
        });
    </script>
    @yield('js-section')
</body>
</Html>