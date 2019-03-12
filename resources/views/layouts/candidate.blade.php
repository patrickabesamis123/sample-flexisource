<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="/"><!--[if lte IE 6]></base><![endif]-->
        <title> @yield('title') | PreviewMe </title>
        <meta name="generator" content="SilverStripe - http://silverstripe.org" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5VGT7HC');</script>
        <!-- End Google Tag Manager -->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="css/bootstrap.min.css?ver=3.3.6" />
        <link rel="stylesheet" href="css/minified/style.min.css" />
        <link rel="stylesheet" href="css/font-awesome/css/fontawesome-all.min.css?ver=5.0.13">
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css?ver=4.7.0">
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.animate.css?ver=0.0.6">
        <link rel="stylesheet" href="{{ asset('css/candidate.css') }}">
        <link href="//amp.azure.net/libs/amp/latest/skins/amp-default/azuremediaplayer.min.css" rel="stylesheet">

        <link rel="shortcut icon" href="images/me.ico" />
        <link rel="stylesheet" href="css/minified/custom.min.css" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js?ver=1.11.3"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js?ver=1.3"></script> -->
        <script type="text/javascript" src="js/angular/angular.min.js?ver=1.5.0-rc.2"></script>
        <script type="text/javascript" src="js/angular/angular-cookies.min.js?ver=1.5.8"></script>
        <script type="text/javascript" src="js/angular/angular-route.min.js?ver=1.5.0-rc.2"></script>
        <script type="text/javascript" src="js/angular/angular-mocks.js?ver=1.5.0-rc.2"></script>
        <script type="text/javascript" src="js/angular/ui-bootstrap-tpls.min.js?ver=0.11.0"></script>
        <script type="text/javascript" src="js/angular/angular-sanitize.min.js?ver=1.3.15"></script>
        <script type="text/javascript" src="js/angular/rzslider.js?ver=5.4.1"></script>

        <!-- <script type="text/javascript" src="js/js.cookie.js?ver=2.1.0"></script> -->
        <script type="text/javascript" src="js/xeditable.min.js?ver=0.1.8"></script>
        <script type="text/javascript" src="js/angular/ngDraggable.js?ver=2"></script>
        <script type="text/javascript" src="js/jquery.trackpad-scroll-emulator.min.js?ver=1.0.8"></script>
        <script src="js/angular/angular-socialshare.js?ver=2.2.3"></script>

        <!--  <script src="js/angular/query-string/query-string.js?ver=1"></script> -->
        <script src="js/angular/angular-oauth2/dist/angular-oauth2.min.js?ver=4.1.0"></script>
         <script src="js/angular/azure/azure-storage.common.js"></script>
        <script src="js/angular/azure/azure-storage.blob.js"></script>

        <!-- <script src="js/MediaStreamRecorder.min.js?ver=1"></script>
        <script src="js/recordRTC/DetectRTC.min.js?ver=1"></script>
        <script src="js/Jcrop-master/jquery.Jcrop.min.js?ver=0.9.12"></script>
        <script type="text/javascript" src="js/recordRTC/recordRTC.js?ver=1"></script> -->

        <script src= "//amp.azure.net/libs/amp/2.1.0/azuremediaplayer.min.js?ver=2.1"></script>
        <!-- <script src="js/jquery/jquery.drawPieChart.js?ver=0.3"></script>g
        <script src="js/jquery/jquery.datetimepicker.full.min.js?ver=1"></script> -->
        <script type="text/javascript" src="js/angucomplete.js?ver=1"></script>
        <script type="text/javascript" src="https://vitalets.github.io/checklist-model/checklist-model.js?ver=1"></script>

        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '258829904566714');
        fbq('track', 'PageView');
        </script>
        <!-- <noscript>
        <img height="1" width="1" src="https://www.facebook.com/tr?id=258829904566714&ev=PageView&noscript=1"/>
        </noscript> -->
        <!-- End Facebook Pixel Code -->
        <!-- <style>.amp-default-skin .amp-content-title .logo-title-row>div{display: none!important}</style>-->

        <noscript>
        <meta http-equiv="refresh" content="0;url=no-js">
        <style>
            /**
            * Reinstate scrolling for non-JS clients
            *
            * You coud do this in a regular stylesheet, but be aware that
            * even in JS-enabled clients the browser scrollbars may be visible
            * briefly until JS kicks in. This is especially noticeable in IE.
            * Wrapping these rules in a noscript tag ensures that never happens.
            */
            .tse-scrollable {
            overflow-y: scroll;
            }
            .tse-scrollable.horizontal {
            overflow-x: scroll;
            overflow-y: hidden;
            }
        </style>
        </noscript>

        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js?ver=1.11.4"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.min.css?ver=1.11.4">

        <script type="text/javascript">
        window.heap=window.heap||[],heap.load=function(e,t){window.heap.appid=e,window.heap.config=t=t||{};var r=t.forceSSL||"https:"===document.location.protocol,a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src=(r?"https:":"http:")+"//cdn.heapanalytics.com/js/heap-"+e+".js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(a,n);for(var o=function(e){return function(){heap.push([e].concat(Array.prototype.slice.call(arguments,0))),p=["addEventProperties","addUserProperties","clearEventProperties","identify","removeEventProperty","setEventProperties","track","unsetEventProperty"],c=0;c<p.length;c++)heap[p[c]]=o(p[c])};
            heap.load("131031959");
        </script>

        <link href="css/sidebar-fix.css" rel="stylesheet">

        @yield('styles')
    </head>

    <?php
    $baseUrl = "/";
    ?>

    <!-- Unique class used in angular function to check which page body belongs -->
    @if (Request::segment(2) == 'job-applications')
        
        @php $body_class = 'my-job-applications'; @endphp

    @elseif (Request::segment(2) == 'profile')
        
        @php $body_class = 'settings'; @endphp
    
    @elseif (Request::segment(2) == 'settings')
        
        @php $body_class = 'analytics'; @endphp
    
    @else
        
        @php $body_class = ''; @endphp
    
    @endif

    <body class="Candidate {{ $body_class }}" dir="ltr" ng-app="app">

    <!--% if Candidate  != 'ErrorPage'  %-->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5VGT7HC" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

        @include('includes.candidate_header')

        <div class="container-fluid @yield('title')" role="main" id="PageBody">
            <div class="row"> 
                <div class="container-fluid dashmain ng-scope" ng-controller="CandidateController" id="my_job_application_page">
                    <div class="row ">
                        <div class="col-md-1">
                            @include('includes.candidate_sidebar')
                        </div>
                        <div class="col-md-11">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('includes.candidate_footer')

        <!--Start of Tawk.to Script-->
            <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/58d330f3f97dd14875f59a3d/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
        <!--End of Tawk.to Script-->

        <!-- LOGIN MODAL -->
        <div id="Loginmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog  ">
                <div class="modal-content">
                <div ng-controller="LoginController" class="modalcontainer">
                <div class="col-md-10 col-md-offset-1  ">
                    <button type="button" class="close"  aria-label="Close" ng-click="gohome()"><span aria-hidden="true">&times;</span></button>
                    <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center"> 
                        <h3> 
                        Log into your account to continue
                        </h3>
                    </div>
                    </div>
                    <div class="alert alert-danger" role="alert" ng-show="ErrorMsg">ErrorMsg</div>
                    <div id="result"></div>    
                    <form id="Form_LoginForm" action="/Login_Controller/LoginForm" method="post" enctype="application/x-www-form-urlencoded" ng-submit="login()" onsubmit="return false">
                    <p id="Form_LoginForm_error" class="message " style="display: none"></p>
                    <fieldset>
                        <div id="Form_LoginForm_email_Holder" class="field text nolabel">
                        <div class="middleColumn">
                            <input type="text" name="email" class="text nolabel" id="Form_LoginForm_email" required="required" aria-required="true" ng-model="email" placeholder="EMAIL" />
                        </div>
                        </div>
                        <div id="Form_LoginForm_password_Holder" class="field text password nolabel">
                        <div class="middleColumn">
                            <input type="password" name="password" class="text password nolabel" id="Form_LoginForm_password" required="required" aria-required="true" ng-model="pass" placeholder="PASSWORD" autocomplete="off" />
                        </div>
                        </div>
                        <input type="hidden" name="SecurityID" value="a40330eed03eedd824f38d19f2db8a2f91c1a687" class="hidden" id="Form_LoginForm_SecurityID" />
                        <div class="clear"><!-- --></div>
                    </fieldset>
                    <div class="Actions">
                        <input type="submit" name="action_doSubmit" value="Login" class="action" id="Form_LoginForm_action_doSubmit" />
                    </div>
                    </form>     
                    <div class="text-center ordivider">
                    <div>or</div>
                    <hr>
                    </div>
                    <button ng-click="goToRegister()" class="submitbluegreen text-center">Sign-up Today</button>
                    <br>
                    <div class="text-center">
                    <a href="<?php echo $baseUrl ?>register/password_forgot" class="text-center">Forgot Password?</a>
                    </div>
                    <div ng-hide="preload" class="text-center"><img src="<?php echo $baseUrl ?>/images/preloader.gif" width="25"></div>
                    <br>
                </div>
                <div class="clearfix"></div>
                </div>
                </div>
            </div>
        </div>

        <!-- FORBIDDEN MODAL -->
        <div id="Forbiddenmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog  ">
                <div class="modal-content">
                <div  class="modalcontainer row" ng-controller="LoginController">
                    <div class="col-md-10 col-md-offset-1">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 text-center"> 
                        <button type="button" class="close"  aria-label="Close" ng-click="gohome()"><span aria-hidden="true">&times;</span></button>
                        <h3>YOU SHALL NOT PASS!!!</h3>
                        Seriously you cant! its forbidden for you to be here!<br>
                        <a href="/settings#" ng-click="gohomeforbidden()">Go back home</a> 
                        </div>
                    </div>
                    </div>
                    <div class="clearfix"></div>
                </div> 
                </div>
            </div>
        </div>

        <!--  <div ng-controller="globalFunction">
        <div ng-hide="true" ng-cloak>
        Expire Date: ExpireDate<br>
        Refresh Date: RefreshTime<br>
        Token: Token<br>
        Will Refresh On: RefreshOn
        </div> 
        </div> -->
        <div id="rfs"></div>
        <script src="js/bootstrap.min.js"></script>
        <!-- <script src="js/hideShowPassword.min.js?ver=1"></script> -->
        <script type="text/javascript" src="js/ng/script.js"></script>
        <script type="text/javascript" src="js/config.min.js"></script>
        <script type="text/javascript" src="js/all-separate.min.js"></script>
        <script type="text/javascript" src="js/minified/controllers/global.function.min.js"></script>
        <!-- <script type="text/javascript" src="js/minified/login/login.min.js?ver=3.0"></script> -->

        <script type="text/javascript" src="{{ URL::to('js/ng/candidate/candidate.js') }}"></script>
        <!-- <script type="text/javascript" src="js/minified/candidate/candidate.min.js"></script> -->
        <script type="text/javascript" src="js/minified/candidate/candidate--sidebar.min.js"></script>
        <script type="text/javascript" src="js/minified/candidate/candidate--settings.min.js"></script>
        <script type="text/javascript" src="js/minified/candidate/candidate--dashboard.min.js"></script>
        <script type="text/javascript" src="js/minified/video/video.min.js?ver=3.0"></script>

        <!-- script to hover sidebar -->
        <script type="text/javascript">

          var candidateSidebar = $('#candidate-sidebar');
          var stickyStopper = $('footer');

          var candidateSidebarTop = candidateSidebar.offset().top;
          var candidateSidebarOffset = 0;
          var candidateStopperPosition = stickyStopper.offset().top;
          var diff = candidateStopperPosition + candidateSidebarOffset;
          
          $(window).scroll(function() {
            var windowTop = $(window).scrollTop();

            if (candidateStopperPosition < windowTop) {
              candidateSidebar.css({ position: 'absolute', top: diff });
            } else if (candidateSidebarTop < windowTop + candidateSidebarOffset) {
              candidateSidebar.css({
                position: 'fixed',
                top: candidateSidebarOffset,
              });
            } else {
              candidateSidebar.css({ position: 'absolute', top: 'initial' });
            }
          });  

        </script>

        @yield('scripts')

    </body>
</html>