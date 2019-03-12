<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="/"><!--[if lte IE 6]></base><![endif]-->
    <title> My Settings | PreviewMe </title>
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

    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/jquery.datetimepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/minified/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/xeditable.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/font-awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/font-awesome/css/font-awesome.animate.css') }}">
    <link href="http://amp.azure.net/libs/amp/latest/skins/amp-default/azuremediaplayer.min.css?ver=1" rel="stylesheet">
    <link rel="shortcut icon" href="images/me.ico" />
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/minified/custom.min.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js?ver=1.11.3"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/angular.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/angular-cookies.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/angular-route.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/angular-mocks.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/ui-bootstrap-tpls.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/angular-sanitize.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/rzslider.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/xeditable.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/ngDraggable.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/jquery.trackpad-scroll-emulator.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/angular-socialshare.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/rzslider.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/angular-oauth2/dist/angular-oauth2.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/azure/azure-storage.common.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angular/azure/azure-storage.blob.js') }}"></script>
    <script src= "//amp.azure.net/libs/amp/2.1.0/azuremediaplayer.min.js?ver=2.1"></script>
    <script type="text/javascript" src="{{ URL::to('js/jquery/jquery.datetimepicker.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/angucomplete.js') }}"></script>
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

    <!-- <link href="css/sidebar-fix.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/sidebar-fix.css') }}">

    @yield('styles')

</head>

<?php 
$baseUrl = "/";
?>

<body class="Candidate my-profile ng-scope" dir="ltr" ng-app="app" data-base_url="<?php echo $baseUrl ?>">

@include('includes.candidate_header')
<div class="container-fluid" role="main" id="PageBody">
@yield('content')
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
        <div ng-hide="preload" class="text-center"><img src="/images/preloader.gif" width="25"></div>
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
<script type="text/javascript" src="{{ URL::to('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/ng/script.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/config.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/all-separate.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/minified/controllers/global.function.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/ng/candidate/candidate.js') }}"></script>
<!-- <script type="text/javascript" src="{{ URL::to('js/minified/candidate/candidate--sidebar.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/minified/candidate/candidate--settings.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/minified/candidate/candidate--dashboard.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/minified/video/video.min.js') }}"></script> -->

@yield('scripts')

</body>
</html>
