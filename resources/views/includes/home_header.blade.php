<header class="header pvm-header pvm-header--is-login  clear-float" role="banner" ng-controller="LoginmenuController" id="NewHeader">
<section class="pvm-logo-handler">
<a href="/" class="brand" rel="home" ng-click="goToLink($event)"><img src="images/logo.png" title="PreviewMe"></a>
</section>
<section class="pvm-menu-handler tablet-land-invisible">
<div class="container-fluid" id="header-link">
<div id="custom-bootstrap-menu" class="navbar head__navbar" role="navigation">
<div class="collapse navbar-collapse navbar-menubuilder" ng-controller="LoginmenuController">
<ul class="nav navbar-nav navbar-right">
<li>
<a href="/" data-ajax="false" @if (Request::segment(1) == "")  class="pvm-blue" @endif>HOME</a>
</li>
<li>
<a href="/features" data-ajax="false" @if (Request::segment(1) == "features")  class="pvm-blue" @endif>FEATURES</a>
</li>
<li>
<a href="/about-us" data-ajax="false" @if (Request::segment(1) == "about-us")  class="pvm-blue" @endif>ABOUT</a>
</li>
<li>
<a href="/resources" data-ajax="false" @if (Request::segment(1) == "resources")  class="pvm-blue" @endif>CONTENT</a>
</li>
<li>
<a href="/contact-us" data-ajax="false" @if (Request::segment(1) == "contact-us")  class="pvm-blue" @endif>CONTACT US</a>
</li>
<li>
<a href="/faq" data-ajax="false" @if (Request::segment(1) == "faq")  class="pvm-blue" @endif>FAQ</a>
</li>
<li>
<a href="/pricing" data-ajax="false" @if (Request::segment(1) == "pricing")  class="pvm-blue" @endif>PRICING</a>
</li>
<li>
<a href="login" data-ajax="false" class=" visible-xs visible-sm visible-md ">LOGIN</a>
</li>
<li>
<a href="register" data-ajax="false" class=" visible-xs visible-sm visible-md">REGISTER</a>
</li>
</ul>
</div>
</div>
</div>
</section>
<section ng-cloak class="pvm-nav-handler clear-float" ng-class="{'pvm-nav-handler--hide':!logged(val)}">
<ul id="HeaderLoginButton">
<li><a ng-click="goToLink($event)" href="/login">Login</a></li>
<li><a ng-click="goToLink($event)" href="/register">Register for Free</a></li>
</ul>
</section>
<section ng-cloak class="pvm-menu-handler tablet-land-visible" ng-class="{'pvm-menu-handler--remove-padding-top':!logged(val)}">	
<div class="container-fluid" id="header-link">
<div id="custom-bootstrap-menu" class="navbar head__navbar" role="navigation">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
</div>
<div class="collapse navbar-collapse navbar-menubuilder" ng-controller="LoginmenuController">
<ul class="nav navbar-nav navbar-right">
<li>
<a href="/" data-ajax="false" class=" pvm-blue ">HOME</a>
</li>
<li>
<a href="/features" data-ajax="false" class="">FEATURES</a>
</li>
<li>
<a href="/about-us" data-ajax="false" class="">ABOUT</a>
</li>
<li>
<a href="/resources" data-ajax="false" class="">CONTENT</a>
</li>
<li>
<a href="/contact-us" data-ajax="false" class="">CONTACT US</a>
</li>
<li>
<a href="/faq" data-ajax="false" class="">FAQ</a>
</li>
<li>
<a href="/pricing" data-ajax="false" class="">PRICING</a>
</li>
<li ng-hide="logged(val)">
<a href="login" data-ajax="false" class=" visible-xs visible-sm visible-md ">LOGIN</a>
</li>
<li ng-hide="logged(val)">
<a href="register" data-ajax="false" class=" visible-xs visible-sm visible-md">REGISTER</a>
</li>
</ul>
</div>
</div>
</div>
</section>
</header>
