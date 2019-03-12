@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<div id="static-pricing-content">
    <div class="container-fluid" role="main">    
        <div class="row">
            <div class="col-12 text-center">
                <h1>Our Prices</h1>
                <h2>A BIG FAT DONUT!</h2>
                <h4>Seriously, no hidden costs. We are on a mission to redefine value in recruitment.</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 padb-40">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-12 text-center">
                            <img src="images/rocket.png" class="pricing-img">
                            <h3>CANDIDATES : <span class="pvm-blue">IT'S FREE!</span></h3>
                            <p class="pricing-desc2">WHAT ARE YOU WAITING FOR?</p>
                            <a href="/register" data-ajax="false" class="custom-link btn gtm-pricing-candidate">
                                <span data-hover="JOIN NOW! YOUR CAREER IS WAITING">JOIN NOW! YOUR CAREER IS WAITING</span>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-6 col-12 text-center">
                            <img src="images/coupon.png" class="pricing-img pricing-img--right">
                            <h3>EMPLOYERS : <span class="pvm-blue">IT'S FREE!</span></h3>
                            <p class="pricing-desc2">EVERYTHING FROM LISTING AN OPPORTUNITY TO PROCESS CANDIDATES IS FREE. THERE ARE NO HIDDEN COSTS.</p>
                            <a href="/register" data-ajax="false" class="custom-link btn gtm-pricing-employer">
                                <span data-hover="JOIN NOW! WHAT ARE YOU WAITING FOR?">JOIN NOW! WHAT ARE YOU WAITING FOR?</span>
                            </a>
                        </div>
                    </div><!-- eof row -->
                </div>
            </div>
        </div><!-- eof row -->
    </div>
</div>

@stop

@section('scripts')

@stop
