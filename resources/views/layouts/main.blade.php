<?php
header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
session_start();

$ua = $_SERVER['HTTP_USER_AGENT'];
// 如果是safari
if(strstr($ua, 'Safari')!='' && strstr($ua, 'Chrome')==''){
    // 如果未设置第一方cookie
    if(!isset($_SESSION['safari'])){
        echo '<script type="text/javascript"> window.top.location="/setSession.php?redirect='.$_SERVER['REQUEST_URI'].'"; </script>';
        exit();
    }
}

$_SESSION['code'] = md5(microtime(true));
?>
<!DOCTYPE Html>
<!--[if IE 8]> <Html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <Html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <Html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Estate Baron">
    {{-- <meta name="description" content="Invest in top Australian property developments of your choice with as little as $100. Australia's only platform open to everyone not just wholesale investors."> --}}
    <meta name="copyright" content="Estate Baron Crowdinvest Pty Ltd copyright (c) 2016">

    <?php
    $siteConfiguration = App\Helpers\SiteConfigurationHelper::getConfigurationAttr();
    ?>

    @if($siteConfiguration->title_text != '')
    <title>{!! $siteConfiguration->title_text !!}</title>
    @else
    <title>Best way to invest in Australian Real Estate Projects</title>
    @endif
    @if($siteConfigMedia=$siteConfiguration->siteconfigmedia)
    @if($faviconImg=$siteConfigMedia->where('type', 'favicon_image_url')->first())
    <link rel="shortcut icon" href="{{asset($faviconImg->path)}}?v=<?php echo filemtime($faviconImg->path); ?>" type="image/x-icon">
    @else
    <link rel="shortcut icon" href="/favicon.png?v=<?php echo filemtime('favicon.png'); ?>" type="image/x-icon">
    @endif
    @else
    <link rel="shortcut icon" href="/favicon.png?v=<?php echo filemtime('favicon.png'); ?>" type="image/x-icon">
    @endif
    <!-- Open Graphic -->

    <!-- META DATA -->
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    {!! Html::script('/js/jquery-1.11.3.min.js') !!}
    @section('meta-section')
    @show

    @yield('meta')

    @if (Config::get('analytics.gtm.enable'))
    @include('partials.gtm-script')
    @endif

    <!-- Bootstrap -->
    {!! Html::style('/css/bootstrap.min.css') !!}
    {!! Html::style('/plugins/font-awesome-4.6.3/css/font-awesome.min.css') !!}

    @section('css-app')
    {!! Html::style('/css/app2.css') !!}
    @show

    <!-- JCrop -->
    {!! Html::style('/assets/plugins/JCrop/css/jquery.Jcrop.css') !!}
    {{-- {!! Html::script('/js/jquery-1.11.3.min.js') !!} --}}
    @yield('css-section')

    <!-- Google tag manager header script if set  -->
    @if($siteConfiguration->tag_manager_header)
    {!!$siteConfiguration->tag_manager_header!!}
    @endif

    <!-- Html5 Shim and Respond.js IE8 support of Html5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/Html5shiv/3.7.0/Html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->


    @if($siteConfiguration->font_family != '')
    <link href="https://fonts.googleapis.com/css?family={{preg_replace('/\s+/', '+', $siteConfiguration->font_family)}}" rel="stylesheet">
    @endif
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Mr+De+Haviland" />
    <style type="text/css">
        @if($siteConfiguration->font_family != '')
        /*Override fonts*/
        body, .font-regular, p {
          font-family: {{$siteConfiguration->font_family}};
          font-weight: 400;
        }
        .heading-font-light, .h1-faq, h1>small, h2>small, h3>small, h4>small{
          font-family: {{$siteConfiguration->font_family}};
          font-weight: 300;
        }
        .font-semibold{
          font-family: {{$siteConfiguration->font_family}};
          font-weight: 600;
        }
        h1, h2, h3, h4, a, .font-bold {
          font-family: {{$siteConfiguration->font_family}};
          font-weight: 700;
        }
        @endif
        .investment-title1-description-section, .csef-text {
            color: #fff !important;
        }
        .swal-footer{
            text-align: center;
        }

        .konkrete-slide-link {
            color: #337ab7;
        }

        .konkrete-slide-link:hover {
            color: #23527c !important;
            text-decoration: underline !important;
        }

        .konkrete-slide-link:visited {
            color: #23527c !important;
        }

        .konkrete-slide-link:focus {
            color: #23527c !important;
            text-decoration: underline !important;
        }

    </style>

    <!-- Google Analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-73934803-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body data-spy="scroll">
    <?php
  if(isset($_SESSION['code'])){
    // echo 'code:'.$_SESSION['code'];
  }
  ?>
    <!-- Google tag manager body script if set  -->
    @if($siteConfiguration->tag_manager_body)
    {!!$siteConfiguration->tag_manager_body!!}
    @endif

    @if (Config::get('analytics.gtm.enable'))
    @include('partials.gtm-noscript')
    @endif

    <!-- Loader for jquery Ajax calls. -->
    <div class="loader-overlay" style="display: none;">
        <div class="overlay-loader-image">
            <img id="loader-image" src="{{ asset('/assets/images/loader.GIF') }}">
        </div>
    </div>
    <!-- topbar nav content here -->
    @section('topbar-section')
    <nav class="navbar navbar-default navbar-fixed-top header" id="header" role="navigation"  style='background-color: @if($color)#{{$color->nav_footer_color}}@endif; border-color: transparent;' >
        <!-- topbar nav content here -->
        <div class="container">
            <div class="logo pull-left">
                <a href="{{route('home')}}">
                    @if($siteConfigMedia=$siteConfiguration->siteconfigmedia)
                    @if($mainLogo = $siteConfigMedia->where('type', 'brand_logo')->first())
                    <span class="logo-title"><img src="{{asset($mainLogo->path)}}" alt="Brand logo" id="logo" style="margin-top:0.6em;margin-bottom:0.6em; height: 3.3em;"></span>
                    @else
                    <span class="logo-title"><img src="{{asset('assets/images/main_logo.png')}}" width="55%" alt="Brand logo" id="logo" style="margin-top:0.6em;margin-bottom:0.6em;"></span>
                    @endif
                    @else
                    <span class="logo-title"><img src="{{asset('assets/images/main_logo.png')}}" width="55%" alt="Brand logo" id="logo" style="margin-top:0.6em;margin-bottom:0.6em;"></span>
                    @endif
                </a>
            </div>
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
                    <li class="nav-item"><a href="{{route('home')}}#how-it-works">How it works</a></li>
                    <li class="nav-item" style="color: #eee;"><a href="{{route('home')}}#projects">Investments</a></li>
                    @if($siteConfiguration->show_funding_options != '')
                    <li class="nav-item" style="color: #eee;"><a href="{{route('home')}}#funding">Funding</a></li>
                    @endif
                    <li class="nav-item"><a href="/pages/team">About us</a></li>
                    <!-- <li class="nav-item"><a href="/pages/faq">FAQ</a></li> -->
                    @if (Auth::guest())
                    <li class="nav-item"><a href="{{route('users.create')}}">Register</a></li>
                    <li class="nav-item"><a href="{{route('users.login')}}">Sign in</a></li>
                    @else
                    <li class="dropdown nav-item last">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            My Account <span class="caret"></span>
                        </a>
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
                        <img class="img-responsive" src="{{asset('assets/images/main_logo.png')}}" alt="Logo" width="200">
                        @endif
                        @else
                        <img class="img-responsive" src="{{asset('assets/images/main_logo.png')}}" alt="Logo" width="200">
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
                        <li class="footer-list-item"><a href="{{route('home')}}" style="color:#fff;" class="a-link"><span class="font-semibold" style="font-size: 16px;">Home</span></a></li>
                        <li class="footer-list-item"><a href="{{$siteConfiguration->blog_link_new}}" target="_blank" style="color:#fff;" class="a-link"><span class="font-semibold" style="font-size: 16px;">Blog</span></a></li>
                        <!-- @if($siteConfiguration->show_funding_options != '')
                        <li class="footer-list-item"><a href="{{$siteConfiguration->funding_link}}" style="color:#fff;" class="a-link"><span class="font-semibold" style="font-size: 16px;">Funding</span></a></li><br>
                        @endif -->
                        <li class="footer-list-item"><a href="@if($siteConfiguration->terms_conditions_link){{$siteConfiguration->terms_conditions_link}}@else{{route('site.termsConditions')}}@endif" target="_blank" class="a-link"><span class="font-semibold"  style="color:#fff; style="font-size: 16px;">Terms & conditions</span></a></li>
                        <span style="color:#fff;"> </span>
                        <li class="footer-list-item"><a href="@if($siteConfiguration->privacy_link){{$siteConfiguration->privacy_link}}@else https://estatebaron.com/pages/privacy @endif"  style="color:#fff; target="_blank" class="a-link"><span class="font-semibold" style="font-size: 16px;">Privacy</span></a></li><br>
                        <li class="footer-list-item"><a href="@if($siteConfiguration->financial_service_guide_link){{$siteConfiguration->financial_service_guide_link}}@else https://www.dropbox.com/s/gux7ly75n4ps4ub/Tech%20Baron%20AusFirst%20Financial%20Services%20Guide.pdf?dl=0 @endif"  style="color:#fff; target="_blank" class="a-link"><span class="font-semibold" style="font-size: 16px;">Financial Service Guide</span></a></li>
                        <li class="footer-list-item"><a href="/pages/faq" style="color:#fff;" target="_blank" class="a-link"><span class="font-semibold" style="font-size: 16px;">FAQ</span></a></li>
                        <!-- <li class="footer-list-item"><a href="{{$siteConfiguration->media_kit_link}}" download style="color:#fff;" class="a-link"><span class="font-semibold" style="font-size: 16px;">Media Kit</span></a></li> -->
                    </ul>
<!--                     <span style="margin:0 0 1px;">
                        <a href="mailto:info@vestabyte.com" style="color:#fed405; font-size: 14px;" class="font-semibold second_color">info@vestabyte.com</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="tel:+61398117015" class="font-semibold second_color" style="color:#fed405; font-size: 14px;">+61398117015</a>
                    </span> -->
                <!-- <address style="margin:0px;">
                    <p class="h1-faq" data-wow-duration="1.5s" data-wow-delay="0.8s" style="color:#fff;">
                        569/585 Little Collins Street Melbourne VIC 3000.
                    </p>
                </address> -->
            </div>
            <div class="col-md-6 col-md-offset-3 text-center">
                <ul class="list-inline footer-list " data-wow-duration="1.5s" data-wow-delay="0.4s" style="margin:0px;">
                    <li class="footer-list-item">
                        <a href="https://www.legislation.gov.au/Details/F2017L01198" style="color:#fff;" target="_blank" class="a-link"><span class="font-semibold" style="font-size: 16px;">EXPLANATORY STATEMENT for ASIC Corporations (Factoring Arrangements) Instrument 2017/794</span></a>
                    </li>
                    <li class="footer-list-item">
                        <a href="{{ route('pages.dispute') }}" style="color:#fff;" target="_blank" class="a-link"><span class="font-semibold" style="font-size: 16px;">Internal Dispute Resolution Process</span></a>
                    </li>
                </ul>
            </div>
            <br>
        </div>
        <div class="row text-center @if(!App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->show_powered_by_estatebaron) hide @endif" style="padding-top: 20px;">
          <img style="width: 50px;" src="{{asset('assets/images/estatebaronLogo_white.png')}}">
          <p>
            <span style="color: #fff;">Powered by </span><a href="https://estatebaron.com/whitelabel-property-crowdfunding" target="_blank" style="cursor: pointer; color: #fff" class="a-link">Estate Baron</a>
          </p>
        </div>
        <br>
        <p class="investment-title1-description-section text-justify" style="font-size:16px;">
        <small><small>@if($siteConfiguration->compliance_description != '')
        {!!html_entity_decode($siteConfiguration->compliance_description)!!} @else
        The content provided on this website has been prepared without taking into account your financial situation, objectives and needs. Before making any decision in relation to any products offered on this website you should read the prospectus, product disclosure statement, information memorandum or any other offer documents relevant to that offer and consider whether they are right for you. The specific offer document is available at the Project and Project Application Pages. Tech Baron PTY LTD (ABN 67617252909) (Tech Baron) which is a Corporate Authorised Representative @if($siteConfiguration->car_no != '') {{$siteConfiguration->car_no}} @else 001264952 @endif of AFSL @if($siteConfiguration->afsl_no != '') {{$siteConfiguration->afsl_no}} @else 299812 @endif provides technology, administrative and support services for the operation of this website. Tech Baron is authorised to deal in securities only and is not party to the offers made on the website. Here is a copy of our <a href="@if(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->financial_service_guide_link){{App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->financial_service_guide_link}} @else https://www.dropbox.com/s/gux7ly75n4ps4ub/Tech%20Baron%20AusFirst%20Financial%20Services%20Guide.pdf?dl=0 @endif" target="_blank"><span style="text-decoration: none; color: #fff;">Financial Services Guide</span></a>.
        @endif</small></small>
        </p>
        <p class="csef-text text-justify"><small><small>In particular note that this website does not rely on the Crowd Sourced Equity Funding (CSEF) regulation (RG261) and does not have an ASIC authorization to act as a Crowdfunding intermediary platform. Any use of the term crowdfunding anywhere on this site should not be be construed to mean that such an authorization exists. Investment offers listed here typically rely on RG228 to provide effective disclosure to Retail investors using a Prospectus. We believe the CSEF regulation is unsuited for Property development investment opportunities and have hence relied on providing a full prospectus to provide clear concise and effective disclosure.</small></small></p>
    </div>
</footer>
@show


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script> -->
{!! Html::script('/js/bootstrap.min.js') !!}
{!! Html::script('/js/circle-progress.js')!!}
{!! Html::script('/js/clipboard.min.js') !!}
{!! Html::script('/js/clipboard-action.js') !!}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- JCrop -->
{!! Html::script('/assets/plugins/JCrop/js/jquery.Jcrop.js') !!}

<!-- Begin Inspectlet Embed Code -->
<script type="text/javascript" id="inspectletjs">
    window.__insp = window.__insp || [];
    __insp.push(['wid', 916939494]);
    (function() {
        function ldinsp(){if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };
        setTimeout(ldinsp, 500); document.readyState != "complete" ? (window.attachEvent ? window.attachEvent('onload', ldinsp) : window.addEventListener('load', ldinsp, false)) : ldinsp();
    })();
</script>
<!-- End Inspectlet Embed Code -->
<script type="text/javascript">

    // Signin bonus message
        @if (Session::has('loginaction'))
        @if(\Cookie::get('login_bonus'))
        swal("Welcome back {{Auth::user()->first_name}}", "We have added {{\Cookie::get('login_bonus')}} KONKRETE as a sign in bonus", "success", {
            buttons: {
                start_over: "Continue to site >>"
            }
        });
        $('.swal-icon').replaceWith('<div style="margin-top: 25px;"><center><a href="https://konkrete.io" target="_blank"><img src="{{asset('assets/images/konkrete_logo_dark.png')}}" width="100px"></a></center></div>');
        $('.swal-text').replaceWith('<div class="swal-text text-center"><p>We have added {{\Cookie::get("login_bonus")}} KONKRETE as a sign in bonus</p><a href="https://www.konkrete.io" target="_blank" class="konkrete-slide-link">What is the KONKRETE crypto token?</a><br><small class="text-grey">Login everyday to receive bonus KONKRETE every 24 hours</small></div>');
        @else
        $('body').append('<div id="session_flash_message" style=" position: fixed;top: 0;left: 0;width: 100%;height: 100%;z-index: 10000;background-color: rgba(255,255,255,0.7); display: none;"><div class="text-center" style="position: absolute; background-color: rgba(0, 0, 0, 0.7); border-radius: 10px; padding: 30px 30px; color: #fff; top: 50%; left:20%; border: 1px solid rgba(0, 0, 0, 0.2); font-size: 250%; width: 60%"><span>Welcome {{Auth::user()->first_name}}</span></div></div>');
        $('#session_flash_message').show()
        setInterval(function() {
            $('#session_flash_message').fadeOut(500);
        }, 2500);
        @endif
        @endif

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
        $('a[data-disabled]').click(function (e) {
            e.preventDefault();
        });

        function toggleChevron(e) {
            $(e.target)
            .prev('.panel-heading')
            .find("i.indicator")
            .toggleClass('glyphicon-plus glyphicon-minus');
        }
        $('#accordion').on('hidden.bs.collapse', toggleChevron);
        $('#accordion').on('shown.bs.collapse', toggleChevron);
        $("iframe[name ='google_conversion_frame']").attr('style', 'height: 0px; display: none !important;');
        @if($color)
        $('p').css('color', '#{{$color->nav_footer_color}}');
        $('.avoid-p-color').css('color', '#fff')
        $('.first_color').css('color', '#{{$color->nav_footer_color}}');
        $('.second_color_btn').css('background-color', '#{{$color->heading_color}}');
        $('.second_color').css('color','#{{$color->heading_color}}');
        $("a").mouseover(function() {
            $(this).css('color', '#{{$color->heading_color}}');
        }).mouseout(function() {
            $(this).css('color', '');
        });
        $(".a-link").mouseover(function() {
            $(this).css('color', '#{{$color->heading_color}}');
        }).mouseout(function() {
            $(this).css('color', '#fff');
        });
        @endif

        //sidebar active tab color
        @if($color)
        @if($color->heading_color)
        $('.list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover').css('background-color', '#{{$color->heading_color}}');
        $('.list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover').css('border-color', '#{{$color->heading_color}}');
        @endif
        @endif
    });
    function checkvalidi() {
        if ((document.getElementById('email').value != '')) {
            document.getElementById('password_form').style.display = 'block';
            if (document.getElementById('password').Value == '') {
                document.getElementById('err_msg').innerHTML = 'Just one more step, lets enter a password !';                 document.getElementById('password').focus();
                return false;
            }
            if (document.getElementById('password').value != '') {
                return true;
            }
            return false;
        }
        return true;
    }
</script>
@yield('js-section')
</body>
</Html>
