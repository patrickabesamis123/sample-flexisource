@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5VGT7HC" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>

<div id="about-me-content">
    <div class="container-fluid" role="main">    
        <div class="row">
            <div class="col-12 text-center">
                <h1>About Us</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <div class="aboutus-video-container-box">
                    <video id="about_video" class="azuremediaplayer amp-default-skin">
                        <p class="amp-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p>
                    </video>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 text-center padt-30">
                <h4>PreviewMe is an Employment Technology Company.</h4>
                <p>We are changing the way employers and candidates interact to drive better employment outcomes through the use of video and data.</p>
                <p>PreviewMe delivers time and cost savings to candidates and employers by enabling the creation and processing of text and visual content as part of a standardise role application process.</p>
                <p>We help employers accurately preview more candidates by focusing on skills, competence and culture fit early in the recruitment process.</p>
                <p>We are also curbing candidate frustrations around the lack of transparency and feedback in the recruitment process through automated role analytics.</p>
                <p>In a nutshell, more information makes for better decision making and results. Through PreviewMe candidates can better understand whether they should develop or pivot. For employers, accessing accurate information faster will enhance collaboration and productivity.</p>
                <br><br>
                <p>Come see for yourself.</p>
                <br><br>
            </div>
        </div>
    </div>
</div>    

@stop

@section('scripts')
@stop
