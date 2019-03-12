@extends('layouts.home')

@section('styles')
<link href="css/base64.css?ver=1" rel="stylesheet">
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')


<div class="container-fluid">
<div class="row">
<div class="col-md-12" id="Register">
<div class="row">
<div class="content-container col-md-12">
<div class="register-form-container">
<div ng-controller="RegisterController" class="ng-scope">
<h1>Forgot Password!</h1>
<form id="Form_forgot" @submit="checkForm" method="post" enctype="application/x-www-form-urlencoded">
<p id="Form_error" class="message " style="display: none"></p>
<fieldset>
<div id="Form_email_Holder" class="field email text nolabel">
<div class="middleColumn">
<input type="email" name="email" class="email text nolabel ng-pristine ng-untouched ng-empty ng-valid-email ng-invalid ng-invalid-required" id="Form_email" required="required" aria-required="true" ng-model="email" v-model="email" placeholder="Email">
<span class="asterisk asterisk3">*</span>
</div>
<input type="hidden" name="SecurityID" value="2db48e5e03c7d2e8b71d73025df63d6b00448104" class="hidden" id="Form_SecurityID">
<div class="clear"></div>
</div></fieldset>
<div class="Actions">
<input type="submit" name="action_doNothing" value="Submit" class="action" id="Form_action_doNothing">
</div>
</form>
<div ng-hide="preload" class="loadme ng-hide"><img src="/images/preloader.gif"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

@stop

@section('scripts')
</script><script type="text/javascript" src="/js/login/forgot.js"></script>
@stop
