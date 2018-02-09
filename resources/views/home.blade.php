@extends('layouts.app')

@section('content')
    @include('partials.header')

    <!-- ******PROMO****** -->
    <section id="promo" class="promo section offset-header">
        <div class="container text-center" style="padding-bottom:50px;">
            <h2 class="title">estate<span class="highlight">Baron</span></h2>
            <p class="intro">Invest in Melbourne real estate developments for as little as $2000</p>
            <div class="btns">
                <a class="btn btn-cta-secondary" href="/users/create" target="_blank">Sign Up</a>
                <a class="btn btn-cta-primary scrollto" href="#listings">Current Listings</a>
            </div>
        </div><!--//container-->
        <div class="social-media" style="padding-bottom:50px;">
            <div class="social-media-inner container text-center">
            </div>
        </div>
    </section><!--//promo-->

    <!-- ******ABOUT****** -->
    <section id="about" class="about section">
        <div class="container">
            <h2 class="title text-center">We are changing the way people invest.</h2>
            <p class="intro text-center">We love property, and love investing in it. But it requires huge amounts of money, locking out most of us.</p>
            <div class="row">
                <div class="item col-md-6 col-sm-6 col-xs-12">
                    <div class="icon-holder">
                        <i class="fa fa-heart"></i>
                    </div>
                    <div class="content">
                        <h3 class="sub-title">Equity crowdfunding</h3>
                        <p class="text-justify">Crowdfunding is a way in which many small investors come together to contribute small amounts towards a project development. Money is then passed to the Project Developers either as Debt or Equity funding and each one of us ends up owning a piece of the pie.</p>
                    </div><!--//content-->
                </div><!--//item-->
                <div class="item col-md-6 col-sm-6 col-xs-12">
                    <div class="icon-holder">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <div class="content">
                        <h3 class="sub-title">Compliance</h3>
                        <p class="text-justify">Equity crowdfunding is essentially a form of financial investment and is hence governed by ASIC regulations. Our partners have worked in the finance industry for decades and after reviewing each project opportunity, partners craft a package that is fully compliant with ASIC regulations.</p>
                    </div><!--//content-->
                </div><!--//item-->
            </div>
            <div class="row">
                <div class="item col-md-6 col-sm-6 col-xs-12">
                    <div class="icon-holder">
                        <i class="fa fa-crosshairs"></i>
                    </div>
                    <div class="content">
                        <h3 class="sub-title">Technology</h3>
                        <p class="text-justify">Our beautiful technology platform lists all the opportunities. You as an investors can review details of projects and then choose to invest in the projects you like. Once you have made your choice, you will be prompted to complete papers necessary to conclude the process. You can then monitor the progress of your investments on a management dashboard.</p>
                    </div><!--//content-->
                </div><!--//item-->
                <div class="item col-md-6 col-sm-6 col-xs-12">
                    <div class="icon-holder">
                        <i class="fa fa-tablet"></i>
                    </div>
                    <div class="content">
                        <h3 class="sub-title">Full solution</h3>
                        <p class="text-justify">That is it really! We have you covered on both compliance and technology side of things. For the first time in Australia, investors can now participate in real estate projects with very small amounts. Real Estate Equity Crowdfunding is here!</p>
                    </div><!--//content-->
                </div><!--//item-->
            </div><!--//row-->
        </div><!--//container-->
    </section>
    <!--//about-->

    <section id="listings" class="" style="padding:20px 0px;">
        <div id="owl-example" class="owl-carousel">
            <div class="tint"><img src="assets/images/sample/1111.jpg" width="425px"></div>
            <div class="tint"><img src="assets/images/sample/2222.jpg" width="425px"></div>
            <div class="tint"><img src="assets/images/sample/3333.jpg" width="425px"></div>
            <div class="tint"><img src="assets/images/sample/4444.jpg" width="425px"></div>
            <div class="tint"><img src="assets/images/sample/5555.jpg" width="425px"></div>
            <div class="tint"><img src="assets/images/sample/6666.jpg" width="425px"></div>
            <div class="tint"><img src="assets/images/sample/7777.jpg" width="425px"></div>
        </div>
    </section>

    <!-- ******DOCS****** -->
    <section id="docs" class="docs section">
        <div class="container">
            <h2 class="title text-center">How it works</h2>
            <div class="row">
                <div class="col-md-offset-1 col-md-5 card">
                    <div class="text-center"><i class="fa fa-laptop fa-5x ico"></i></div>
                    <h3 class="sub-title text-center">Sign up for free</h3>
                    <p class="text-justify">Its free and easy! Once you have your account you gain direct access to exclusive real estate opportunities with high quality property developers.</p>
                </div>
                <div class="col-md-5 card">
                    <div class="text-center"><i class="fa fa-newspaper-o fa-5x ico"></i></div>
                    <h3 class="sub-title text-center">Browse opportunities</h3>
                    <p class="text-justify">For every opportunity we provide you with detailed information, including estimated length of the project, expected returns, property and location information info and a profile for the property development company behind the project.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-5 card">
                    <div class="text-center"><i class="fa fa-check-square-o fa-5x ico"></i></div>
                    <h3 class="sub-title text-center">Pick your choice</h3>
                    <p class="text-justify">When you pick the deal you like, simply click the expression of interest button and our team will be in touch with you to complete your investment.</p>
                </div>
                <div class="col-md-5 card">
                    <div class="text-center"><i class="fa fa-line-chart fa-5x ico"></i></div>
                    <h3 class="sub-title text-center">Monitor your projects</h3>
                    <p class="text-justify">On your user account you can monitor progress of projects you have participated in, receive regular updates and manage all documents.</p>
                </div>
            </div>
        </div><!--//container-->
    </section><!--//features-->

    <!-- ******CONTACT****** -->
    <section id="opinions" class="contact section has-pattern">
        <div class="container">
            <div class="contact-inner">
                <h2 class="title  text-center">what our users say!</h2>
                <div class="author-message">
                    <div class="profile">
                        <img class="img-responsive" src="assets/images/profile.png" alt="" />
                    </div><!--//profile-->
                    <div class="speech-bubble">
                        <h3 class="sub-title">easy to use and trustworthy!</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit corporis libero aperiam repudiandae dolorum voluptatum id. Reprehenderit natus enim architecto, mollitia excepturi cumque, nam. Facilis ad magnam ipsum blanditiis. Minus.</p>
                    </div><!--//speech-bubble-->
                </div><!--//author-message-->
            </div><!--//contact-inner-->
        </div><!--//container-->
    </section>
    <!--//contact-->
@stop