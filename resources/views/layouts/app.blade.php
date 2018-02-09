<?php
header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
session_start();

$ua = $_SERVER['HTTP_USER_AGENT'];
// 如果是safari
if(strstr($ua, 'Safari')!='' && strstr($ua, 'Chrome')==''){
    // 如果未设置第一方cookie
    if(!isset($_SESSION['safari'])){
        echo '<script type="text/javascript"> window.top.location="/setSession.php"; </script>';
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
    <meta name="description" content="Invest in top Australian property developments of your choice with as little as $100. Australia's only platform open to everyone not just wholesale investors.">
    <meta name="copyright" content="Estate Baron Crowdinvest Pty Ltd copyright (c) 2016">
    @if(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->title_text != '')
    <title>{!! App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->title_text !!}</title>
    @else
    <title>Invest in Australian Real Estate Projects</title>
    @endif
    @if($siteConfigMedia=App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->siteconfigmedia)
    @if($faviconImg=$siteConfigMedia->where('type', 'favicon_image_url')->first())
    <link rel="shortcut icon" href="{{asset($faviconImg->path)}}?v=<?php echo filemtime($faviconImg->path); ?>" type="image/x-icon">
    @else
    <link rel="shortcut icon" href="/favicon.png?v=<?php echo filemtime('favicon.png'); ?>" type="image/x-icon">
    @endif
    @else
    <link rel="shortcut icon" href="/favicon.png?v=<?php echo filemtime('favicon.png'); ?>" type="image/x-icon">
    @endif
    <!-- Open Graphic -->
    <meta property="og:image" content="https://www.estatebaron.com/images/hero-image-1.jpg">
    <meta property="og:site_name" content="Estate Baron" />
    <meta property="og:url" content="https://www.estatebaron.com" />
    <meta property="og:type" content="website">
    <!-- META DATA -->
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">

    @section('meta-section')
    <meta property="og:title" content="Best way to invest in Australian Real Estate Projects" />
    <meta property="og:description" content="Invest in Melbourne Real Estate Developments from $100. View listing now. " />
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

    <!-- Google analytics -->
    <script>
       (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
           (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
           m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
       })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

       ga('create', 'UA-73934803-1', 'auto');
       ga('send', 'pageview');
    </script>

    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body data-spy="scroll">
    @if (Config::get('analytics.gtm.enable'))
    @include('partials.gtm-noscript')
    @endif
<?php
  if(isset($_SESSION['code'])){
    // echo 'code:'.$_SESSION['code'];
  }
  ?>
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
                    <!-- <li class="footer-list-item"><a href="/blog"><h3>Blog</h3></a></li> -->
                    <li class="footer-list-item"><a href="https://estatebaron.com/blog/"><h3>Blog</h3></a></li>
                    <!-- <li class="footer-list-item"><a href="{{route('pages.terms')}}"><h3>Terms & conditions</h3></a></li> -->
                    <li class="footer-list-item"><a href="{{route('site.termsConditions')}}"><h3>Terms & conditions</h3></a></li>
                    <li class="footer-list-item"><a href="http://www.meetup.com/Real-Estate-Crowdfunding-and-Syndication-Investors/"><h3>Meetup</h3></a></li>
                    <li class="footer-list-item"><a href="{{route('projects.create')}}"><h3>Developer Finance</h3></a></li>
                    <!-- <li class="footer-list-item"><a href="{{route('pages.privacy')}}"><h3>Privacy</h3></a></li> -->
                    <li class="footer-list-item"><a href="https://estatebaron.com/pages/privacy"><h3>Privacy</h3></a></li>

                    <!-- <li class="footer-list-item"><a href="{{asset('media_kit/EB_Media_Kit.zip')}}" download><h3>Media Kit</h3></a></li> -->
                    <!-- <li class="footer-list-item"><a href="{{route('pages.financial')}}"><h3>Financial Service Guide</h3></a></li> -->
                    <li class="footer-list-item"><a href="https://www.dropbox.com/s/koxscf3j3zw078c/TB%20FSG%20Ver%201.0.pdf?dl=0"><h3>Financial Service Guide</h3></a></li>

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

        @if($color=App\Helpers\SiteConfigurationHelper::getSiteThemeColors())
        $('p').css('color', '#{{$color->nav_footer_color}}');
        $('.first_color').css('color', '#{{$color->nav_footer_color}}');
        $('.second_color_btn').css('background-color', '#{{$color->heading_color}}');
        $('.second_color').css('color','#{{$color->heading_color}}');
        $("a").mouseover(function() {
            $(this).css('color', '#{{$color->heading_color}}');
        }).mouseout(function() {
            $(this).css('color', '');
        });
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
