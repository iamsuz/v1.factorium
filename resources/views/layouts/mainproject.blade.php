<!DOCTYPE Html>
<!--[if IE 8]> <Html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <Html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <Html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.metatags')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Sujit Mahavarkar">
    <meta name="description" content="Invest with small amounts in the construction of 2 townhouses in the prestigious mount waverley school zone. 20% returns in 18 months, Refer to PDS for details">
    <meta name="copyright" content="Konkrete Distributed Registries Ltd">
    <!-- <link rel="shortcut icon" href="/favicon.png" type="image/x-icon"> -->
    <link rel="shortcut icon" href="/favicon.png?v=<?php echo filemtime('favicon.png'); ?>" type="image/x-icon">
    <!-- Open Graphic -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:image" content="https://www.estatebaron.com/images/hero-image-1.jpg" />
    <meta property="og:site_name" content="Factorium" />
    <meta property="og:url" content="https://factorium.co" />
    <meta property="og:type" content="website" />
    <!-- META DATA -->
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
     <?php
    $siteConfiguration = App\Helpers\SiteConfigurationHelper::getConfigurationAttr();
    ?>
    @if (Config::get('analytics.gtm.enable'))
    @include('partials.gtm-script')
    @endif

    @section('meta-section')
    @show
    <?php
    if(isset($_SESSION['code'])){
        echo 'code:'.$_SESSION['code'];
    }
    ?>
    <title>
        @section('title-section')
        Factorium : Crowd Investment Real Estate Investment
        @show
    </title>
    <!-- Bootstrap -->
    {!! Html::style('/css/bootstrap.min.css') !!}
    {{-- {!! Html::style('/plugins/font-awesome-4.4.0/css/font-awesome.min.css') !!} --}}
    @section('css-app')
    {!! Html::style('/css/app3.css') !!}
    @show
    {!! Html::style('plugins/font-awesome-4.6.3/css/font-awesome.min.css') !!}
    @yield('css-section')
    <noscript>
        You need to enable JavaScript to run this app. The Factorium dApp is a distributed application to interact with the Factorium Protocol on the Ethereum blockchain. This app requires JavaScript to run. If you are interested in learning more about Factorium, please visit <a href="https://factorium.co">https://factorium.co</a>.
    </noscript>
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
     <!-- Loader for jquery Ajax calls. -->
    <div class="loader-overlay" style="display: none;">
        <div class="overlay-loader-image">
            <img id="loader-image" src="{{ asset('/assets/images/loader1.gif') }}">
        </div>
    </div>
    <!-- topbar nav content here -->
    @section('topbar-section')
    <nav class="navbar navbar-default header hide hidden" id="header" role="navigation">
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
    <footer id="footer" class="chunk-box" @if($color) style='background-color: #{{$color->nav_footer_color}}' @endif>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center " data-wow-duration="1.5s" data-wow-delay="0.2s">
                    <center>
                        @if($siteConfigMedia=$siteConfiguration->siteconfigmedia)
                        @if($mainLogo = $siteConfigMedia->where('type', 'brand_logo')->first())
                        <img class="img-responsive" src="{{asset($mainLogo->path)}}" alt="Logo" width="200">
                        @else
                        <img class="img-responsive" src="/assets/images/white.png" alt="Logo" width="200">
                        @endif
                        @else
                        <img class="img-responsive" src="/assets/images/white.png" alt="Logo" width="200">
                        @endif
                    </center>
                </div>
            </div>
            <br>
            <div class="row @if(!$siteConfiguration->show_social_icons) hide @endif">
                <div class="col-md-12 text-center " data-wow-duration="1.5s" data-wow-delay="0.3s">
                    <a href="{{ $siteConfiguration->facebook_link }}" target="_blank">
                        <span class="fa-stack fa">
                            <i class="fa fa-circle fa-stack-2x fa-inverse"></i>
                            <i class="fa fa-facebook fa-stack-1x fa-inverse" style="color:#21203a;"></i>
                        </span>
                    </a>
                    <a href="{{ $siteConfiguration->twitter_link }}" class="footer-social-icon" target="_blank">
                        <span class="fa-stack fa">
                            <i class="fa fa-twitter fa-stack-2x fa-inverse"></i>
                        </span>
                    </a>
                    <a href="{{ $siteConfiguration->youtube_link }}" class="footer-social-icon" target="_blank">
                        <span class="fa-stack fa">
                            <i class="fa fa-circle fa-stack-2x fa-inverse"></i>
                            <i class="fa fa-youtube fa-stack-1x fa-inverse" style="color:#21203a;"></i>
                        </span>
                    </a>
                    <a href="{{ $siteConfiguration->linkedin_link }}" class="footer-social-icon" target="_blank">
                        <span class="fa-stack fa">
                            <i class="fa fa-linkedin-square fa-stack-2x fa-inverse"></i>
                        </span>
                    </a>
                    <a href="{{ $siteConfiguration->google_link }}" class="footer-social-icon" target="_blank">
                        <span class="fa-stack fa">
                            <i class="fa fa-google-plus fa-stack-2x fa-inverse" style="padding:4px; margin-left:-3px; font-size:24px !important;"></i>
                        </span>
                    </a>
                    <a href="{{ $siteConfiguration->instagram_link }}" class="footer-social-icon" target="_blank">
                        <span class="fa-stack fa">
                            <i class="fa fa-instagram fa-stack-2x fa-inverse"></i>
                        </span>
                    </a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4 col-md-offset-4 text-center">
                    <ul class="list-inline footer-list " data-wow-duration="1.5s" data-wow-delay="0.4s" style="margin:0px;">
                        <li class="footer-list-item"><a href="{{route('home')}}" style="color:#fff;" class="a-link fold-text-color"><span class="font-semibold" style="font-size: 16px;">Home</span></a></li>
                        <li class="footer-list-item"><a href="{{$siteConfiguration->blog_link_new}}" target="_blank" style="color:#fff;" class="a-link fold-text-color"><span class="font-semibold" style="font-size: 16px;">Blog</span></a></li>
                        <!-- @if($siteConfiguration->show_funding_options != '')
                        <li class="footer-list-item"><a href="{{$siteConfiguration->funding_link}}" style="color:#fff;" class="a-link"><span class="font-semibold" style="font-size: 16px;">Funding</span></a></li><br>
                        @endif -->
                        {{-- <li class="footer-list-item"><a href="@if($siteConfiguration->terms_conditions_link){{$siteConfiguration->terms_conditions_link}}@else{{route('site.termsConditions')}}@endif" target="_blank" class="a-link fold-text-color"><span class="font-semibold" style="font-size: 16px;">Terms & conditions</span></a></li> --}}
                        <span style="color:#fff;"> </span>
                        <li class="footer-list-item"><a href="@if($siteConfiguration->privacy_link){{$siteConfiguration->privacy_link}}@else https://estatebaron.com/pages/privacy @endif"  style="color:#fff;" target="_blank" class="a-link fold-text-color"><span class="font-semibold" style="font-size: 16px;">Privacy</span></a></li><br>
                        <li class="footer-list-item"><a href="https://www.legislation.gov.au/Details/F2017L01198" style="color:#fff;" target="_blank" class="a-link fold-text-color"><span class="font-semibold" style="font-size: 16px;">ASIC Corporations (Factoring Arrangements) Instrument 2017/794</span></a></li>
                        {{-- <li class="footer-list-item"><a href="/pages/faq" style="color:#fff;" target="_blank" class="a-link"><span class="font-semibold" style="font-size: 16px;">FAQ</span></a></li> --}}
                        <!-- <li class="footer-list-item"><a href="{{$siteConfiguration->media_kit_link}}" download style="color:#fff;" class="a-link"><span class="font-semibold" style="font-size: 16px;">Media Kit</span></a></li> -->
                        <li class="footer-list-item">
                            <a href="https://www.legislation.gov.au/Details/F2017L01198" style="color:#fff;" target="_blank" class="a-link fold-text-color"><span class="font-semibold" style="font-size: 16px;">EXPLANATORY STATEMENT for ASIC Corporations (Factoring Arrangements) Instrument 2017/794</span></a>
                        </li>
                        <li class="footer-list-item">
                            <a href="{{ route('pages.dispute') }}" style="color:#fff;" target="_blank" class="a-link fold-text-color"><span class="font-semibold" style="font-size: 16px;">Internal Dispute Resolution Process</span></a>
                        </li>
                        <li class="footer-list-item">
                            <a href="https://download.asic.gov.au/media/3797986/rg185-published-24-march-2016.pdf" target="_blank" class="a-link fold-text-color"><span class="font-semibold" style="font-size: 16px; color:#fff;">Non Cash Payment Facility</span></a>
                        </li>
                    </ul>
                </div>
                <br>
            </div>
            <div class="row text-center @if(!App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->show_powered_by_estatebaron) hide @endif" style="padding-top: 20px;">
                <a href="https://konkrete.io" target="_blank"><img style="width: 50px;" src="{{asset('assets/images/konkrete.png')}}"></a>
                <p>
                    <span style="color: #fff;" class="fold-text-color">Built on </span><a href="https://konkrete.io" target="_blank" style="cursor: pointer; color: #fff;" class="a-link fold-text-color">Konkrete</a>
                </p>
            </div>
            <br>
            <p class="investment-title1-description-section text-justify" style="font-size:16px;">
                <small><small class="fold-text-color">@if($siteConfiguration->compliance_description != '')
                    {!!html_entity_decode($siteConfiguration->compliance_description)!!} @else
                    The content provided on this website has been prepared without taking into account your financial situation, objectives and needs. Before making any decision in relation to any products offered on this website you should read the Factoring Arrangement terms and conditions or any other offer documents relevant to that offer and consider whether they are right for you. Konkrete Distributed Registries Ltd (ABN 67617252909) (Konkrete) provides technology, administrative and support services for the operation of this website. Konkrete is not a party to the offers made on the website.
                @endif</small></small>
            </p>
        </div>
    </footer>
    @show

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {!! Html::script('/js/jquery-1.11.3.min.js') !!}
    {!! Html::script('/js/bootstrap.min.js') !!}
    {!! Html::script('/js/circle-progress.js')!!}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js" integrity="sha256-nWBTbvxhJgjslRyuAKJHK+XcZPlCnmIAAMixz6EefVk=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/assets/abi/smartInvoiceABI.js"></script>
    <script type="text/javascript" src="/assets/abi/daiABI.js"></script>
    <script type="text/javascript" src="/assets/js/error.js"></script>
    <script type="text/javascript" src="/assets/js/app.js"></script>

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
