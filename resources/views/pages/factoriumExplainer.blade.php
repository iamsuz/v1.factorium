@extends('layouts.main')

@section('title-section')
    Factorium Explainer
@stop

@section('css-section')
    <style>
        .explainer-carousel-indicators {
            position: relative;
        }
        .explainer-carousel-indicators li {
            border-color: #777;
        }
        .explainer-carousel-indicators .active {
            background-color: #777;
        }

        .explainer-carousel {
            display: flex;
            flex-direction: column;
            min-height: 88vh;
            justify-content: space-between;
        }

        .explainer-carousel .item img {
            max-height: 42vh;
        }

        @media (max-width: 375px) {
            .explainer-carousel .item img {
                max-height: 30vh;
            }
            h1, h2, h3, h4 {
                font-size: 0.9em !important;
            }
        }

        @media (max-width: 768px) {
            .explainer-carousel .item img {
                max-height: 35vh;
            }

            h1, h2, h3, h4 {
                font-size: 1.2em;
            }
        }

        h1, h2, h3, h4 {
            color: {{ '#' . $color->nav_footer_color }};
        }

        @keyframes shadow-pulse {
            0% {
                box-shadow: 0 0 0 0px{{ '#' . $color->heading_color }};
            }
            100% {
                box-shadow: 0 0 0 20px rgba(0, 0, 0, 0);
            }
        }

        .pulse-effect {
            animation: shadow-pulse 1s infinite;
        }

    </style>
@stop

@section('content-section')
    <div class="container text-center">
        <br>
        <div id="explainer_carousel" class="carousel slide explainer-carousel" data-interval="false" data-wrap="false">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img src="{{ asset('assets/images/explainer/1.png') }}">
                    <h3 class="">Welcome to Factorium, an invoice factoring market place</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/2.png') }}">
                    <h3>Businesses often face cash flow issues</h3>
                </div>
                <div class="item">
                    <img class="img-responsive" src="{{ asset('assets/images/explainer/3.png') }}">
                    <h3>They will often offer payment terms in lieu of their invoices to buyers of their goods and services to conclude a sale</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/4.png') }}">
                    <h3>However while the business is waiting for their payments to come through often their own expenses come due landing them in trouble</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/5.png') }}">
                    <h3>Businesses can resolve this by a process known as factoring</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/6.png') }}">
                    <h3>A financier will issue the business an advance against the invoice upto a certain portion</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/7.png') }}">
                    <h3>For eg If a $100 invoice was to be paid in 30 days, the financier may offer the business $90</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/8.png') }}">
                    <h3>The business is able to get access to this money right away rather than wait for the payments to come through</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/9.png') }}">
                    <h3>While the financier pockets the $10 profit when the invoice gets paid</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/10.png') }}">
                    <h3>Factorium is a marketplace where financiers, buyers and sellers can engage in the process of factoring</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/11.png') }}">
                    <h3>As a seller who offers his buyers payment terms you may be able to get payments right away using Factorium</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/12.png') }}">
                    <h3>As a buyer who is looking for payment terms on a purchase you can Factor the invoice issued to you</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/13.png') }}">
                    <h3>And as a financier you may be able to achieve strong returns by buying invoices up for sale at a discount</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/f-14.png') }}">
                    <h3>Once you are setup you will find several invoices up for sale</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/f-15.png') }}">
                    <h3>The Invoice amount is the full amount of the invoice</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/f-16.png') }}">
                    <h3>The days remaining is the time remaining for this invoice to get paid in full</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/f-17.png') }}">
                    <h3>And the Asking amount is the amount the invoice is currently selling for</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/f-18.png') }}">
                    <h3>You can click on the buy now button and fill a small application form to complete your purchase of an invoice</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/f-19.png') }}">
                    <h3>You will notice the Asking amount is usually less than the Invoice amount. Once the days remaining runs out the full Invoice amount will be paid to you assuming you bought the invoice</h3>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/explainer/20.png') }}">
                    <h3>That is all, lets get started by checking some invoices for sale</h3>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control hide" href="#explainer_carousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control hide" href="#explainer_carousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>

            <div class="relative-items">
                <br><br>
                <!-- Indicators -->
                <ol class="carousel-indicators explainer-carousel-indicators">
                    <li data-target="#explainer_carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#explainer_carousel" data-slide-to="1"></li>
                    <li data-target="#explainer_carousel" data-slide-to="2"></li>
                    <li data-target="#explainer_carousel" data-slide-to="3"></li>
                    <li data-target="#explainer_carousel" data-slide-to="4"></li>
                    <li data-target="#explainer_carousel" data-slide-to="5"></li>
                    <li data-target="#explainer_carousel" data-slide-to="6"></li>
                    <li data-target="#explainer_carousel" data-slide-to="7"></li>
                    <li data-target="#explainer_carousel" data-slide-to="8"></li>
                    <li data-target="#explainer_carousel" data-slide-to="9"></li>
                    <li data-target="#explainer_carousel" data-slide-to="10"></li>
                    <li data-target="#explainer_carousel" data-slide-to="11"></li>
                    <li data-target="#explainer_carousel" data-slide-to="12"></li>
                    <li data-target="#explainer_carousel" data-slide-to="13"></li>
                    <li data-target="#explainer_carousel" data-slide-to="14"></li>
                    <li data-target="#explainer_carousel" data-slide-to="15"></li>
                    <li data-target="#explainer_carousel" data-slide-to="16"></li>
                    <li data-target="#explainer_carousel" data-slide-to="17"></li>
                    <li data-target="#explainer_carousel" data-slide-to="18"></li>
                    <li data-target="#explainer_carousel" data-slide-to="19"></li>
                </ol>

                <hr>
                <div class="text-center carousel-nav-buttons">
                    <button type="button" class="btn left btn-custom-theme hidden-xs" onclick="slideLeft()" style="width: 100px"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Previous </button> &nbsp;
                    <button type="button" class="btn left btn-custom-theme hidden-sm hidden-md hidden-lg" onclick="slideLeft()" style="width: 50px"> <i class="fa fa-arrow-left" aria-hidden="true"></i></button> &nbsp;
                    <button type="button" class="btn skip btn-custom-theme"> Skip... </button> &nbsp;
                    <button type="button" class="btn right btn-custom-theme hidden-xs" onclick="slideRight()" style="width: 100px;"> Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    <button type="button" class="btn right btn-custom-theme hidden-sm hidden-md hidden-lg" onclick="slideRight()" style="width: 50px;"> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
                <br><br>
            </div>

        </div>
    </div>

@stop

@section('js-section')
    <script>
        $(document).ready(function () {

            $('.carousel-nav-buttons .skip').click(function () {
               location.href = '{{ route('users.user.type') }}';
            });

            enableDisableNavsBtn();
        });

        function slideLeft() {
            $('#explainer_carousel .carousel-control.left').trigger('click');
            enableDisableNavsBtn();
        }

        function slideRight() {
            $('#explainer_carousel .carousel-control.right').trigger('click');
            enableDisableNavsBtn();
        }

        function enableDisableNavsBtn() {
            let slidesCount = $('.carousel-indicators li').length-1;

            if ($('.carousel-indicators li').eq(0).hasClass('active')) {
                $('.carousel-nav-buttons .left').attr('disabled', 'disabled');
            } else if ($('.carousel-indicators li').eq(slidesCount).hasClass('active')) {
                $('.carousel-nav-buttons .right').attr('disabled', 'disabled');
                $('.carousel-nav-buttons .skip').addClass('pulse-effect');
                $('.carousel-nav-buttons .skip').html(' Get Started ');
            } else {
                $('.carousel-nav-buttons button').removeAttr('disabled');
                $('.carousel-nav-buttons .skip').removeClass('pulse-effect');
                $('.carousel-nav-buttons .skip').html(' Skip... ');
            }
        }
    </script>
@stop