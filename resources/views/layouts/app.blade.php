<!DOCTYPE Html>
<!--[if IE 8]> <Html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <Html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <Html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Vestabyte">
    <meta name="description" content="Australian Property and Venture Crowdfunding. Vestabyte.com is an online marketplace offering crowdfunding for property investment and venture opportunities.">
    <meta name="copyright" content="Vestabyte copyright (c) 2016">
    <title>Vestabyte.com - Equity Crowdfunding | Flexible Crowd Sourced Equity Funding Solutions</title>
    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
    <!-- Open Graphic -->
    <meta property="og:image" content="https://www.vestabyte.com//assets/images/main_bg.png">
    <meta property="og:site_name" content="Vestabyte">
    <meta property="og:url" content="https://www.vestabyte.com">
    <meta property="og:type" content="website">
    <!-- META DATA -->
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">

    @section('meta-section')
    <meta property="og:title" content="Vestabyte.com - Equity Crowdfunding | Flexible Crowd Sourced Equity Funding Solutions">
    <meta property="og:description" content="Australian Property and Venture Crowdfunding. Vestabyte.com is an online marketplace offering crowdfunding for property investment and venture opportunities.">
    <meta name="description" content="Australian Property and Venture Crowdfunding. Vestabyte.com is an online marketplace offering crowdfunding for property investment and venture opportunities.">
    @show

    @if (Config::get('analytics.gtm.enable'))
    @include('partials.gtm-script')
    @endif
    
    <!-- Bootstrap -->
    {!! Html::style('/css/bootstrap.min.css') !!}
    {!! Html::style('/plugins/font-awesome-4.6.3/css/font-awesome.min.css') !!}

    @section('css-app')
    {!! Html::style('/css/app2.css') !!}
    @show

    @yield('css-section')

    <!-- Html5 Shim and Respond.js IE8 support of Html5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/Html5shiv/3.7.0/Html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body data-spy="scroll">
    @if (Config::get('analytics.gtm.enable'))
    @include('partials.gtm-noscript')
    @endif

   <!-- topbar nav content here -->
<!-- header content here -->
<!-- body content here -->
<div class="content">
    @yield('content-section')
</div>

<!-- footer content here -->
@section('footer-section')
{{-- <footer id="footer" class="chunk-box">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                <img src="{{asset('assets/images/estatebaron-logo-black.png')}}" alt="estate baron" width="300">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.3s">
                <a href="http://www.facebook.com/estatebaron" class="footer-social-icon" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a>
                <a href="http://www.twitter.com/estatebaron" class="footer-social-icon" target="_blank"><i class="fa fa-twitter-square fa-2x"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <ul class="list-inline footer-list wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.4s" style="margin:0px;">
                    <li class="footer-list-item"><a href="#promo" class="scrollto"><h3>Home</h3></a></li>
                    <li class="footer-list-item"><a href="/blog"><h3>Blog</h3></a></li>
                    <li class="footer-list-item"><a href="{{route('pages.terms')}}"><h3>Terms & conditions</h3></a></li>
                    <li class="footer-list-item"><a href="http://www.meetup.com/Real-Estate-Crowdfunding-and-Syndication-Investors/"><h3>Meetup</h3></a></li>
                    <li class="footer-list-item"><a href="{{route('projects.create')}}"><h3>Developer Finance</h3></a></li>
                    <li class="footer-list-item"><a href="{{route('pages.privacy')}}"><h3>Privacy</h3></a></li>
                    <li class="footer-list-item"><a href="{{asset('media_kit/EB_Media_Kit.zip')}}" download><h3>Media Kit</h3></a></li>
                    <li class="footer-list-item"><a href="{{route('pages.financial')}}"><h3>Financial Service Guide</h3></a></li>
                </ul>
                <address style="margin:0px;"><h3 class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.8s" style="margin:0px;"><small>350 Collins st, Melbourne 3000. <i class="fa fa-phone"></i> 1 300 033 221</small></h3></address>
                <h3 class="copyright wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.9s" style="margin:0px;"><small>© 2016 <a href="{{route('home')}}">Estatebaron</a>. All Rights Reserved. Made with <i class="fa fa-heart"></i> in Melbourne</small></h3>
            </div>
        </div>
    </div>
</footer> --}}
@show


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
{!! Html::script('/js/jquery-1.11.3.min.js') !!}
{!! Html::script('/js/bootstrap.min.js') !!}

<script type="text/javascript">
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
            .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
        }
        $('#accordion').on('hidden.bs.collapse', toggleChevron);
        $('#accordion').on('shown.bs.collapse', toggleChevron);
        $("iframe[name ='google_conversion_frame']").attr('style', 'height: 0px; display: none !important;');
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