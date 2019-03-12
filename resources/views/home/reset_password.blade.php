@extends('layouts.home')

@section('content')

<?php 
$baseUrl = "http://previewme.co/";
?>
<div class="col-md-12" id="Register" style="background-image: url('/images/register_bg.jpg');">
    <div class="row">
        <div class="content-container col-md-12">
        	
        	<div class="register-form-container">
            	<div ng-controller="RegisterController">
            		<h1>Reset Password!</h1>
            		
              		<!-- <form id="Form" action="/register/" method="post" enctype="application/x-www-form-urlencoded" ng-submit="reset_password()" onsubmit="return false" class="ng-pristine ng-invalid ng-invalid-required"> -->
                    <form id="Form_reset" @submit="checkForm" method="get" enctype="application/x-www-form-urlencoded">
                        <p id="Form_error" class="message " style="display: none"></p>
                        <fieldset>
                            <div id="Form_first_password_Holder" class="field text password nolabel">
                                <div class="middleColumn">
                                    <input type="password" name="first_password" class="text password nolabel ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_first_password" required="required" aria-required="true" v-model="first_password" placeholder="Password" ng-blur="passwordHack($event)" autocomplete="off">
                                    <span class="asterisk asterisk4">*</span>
                                </div>
                                
                                <div id="Form_second_password_Holder" class="field text password nolabel">
                                    <div class="middleColumn">
                                        <input type="password" name="second_password" class="text password nolabel ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_second_password" required="required" aria-required="true" v-model="second_password" placeholder="Confirm Password" autocomplete="off">
                                        <span class="asterisk asterisk5">*</span>
                                    </div>

                                    <input type="hidden" name="token" class="hidden nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_token" v-model="token" value="{{ app('request')->input('token') }}">
                                    <input type="hidden" name="SecurityID" value="0f5cecf352a438a351e6f305fea7d0f1b1790d63" class="hidden" id="Form_SecurityID">
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="Actions">
                        <input type="submit" name="action_doNothing" value="Submit" class="action" id="Form_action_doNothing">
                        </div>
                    </form>
                  

            		<!-- <div ng-hide="preload"  class="loadme"><img src="{$BaseHref}/themes/bbt/images/preloader.gif"></div> -->

            		
            	</div>
        	</div>   
        </div>
    </div>
</div>
@stop

@section('scripts')
<script type="text/javascript" src="js/minified/login/register.min.js"></script>

<script type="text/javascript" src="https://unpkg.com/vue"></script>
<script>
  const apiUrl = '/api/';
  const Form_reset = new Vue({
    el: '#Form_reset',
    headers: {
      Authorization: 'Bearer' + '{{ app('request')->input('token') }}'
    },
    data: {
      first_password: '',
      second_password: '',
      token: '{{ app('request')->input('token') }}'
    },
    methods:{
      checkForm: function (e) {
        e.preventDefault();

        if (this.first_password === '') {
              alert('Password required!');
        } else if (this.second_password === '') {
              alert('Password confirmation required!');
        } else if (this.second_password != this.first_password) {
              alert('Passwords do not match!');
        } else {
          fetch(apiUrl + 'reset?token=' + encodeURIComponent(this.token) + '&password=' + encodeURIComponent(this.first_password))
          .then(res => res.json())
          .then(res => {
            if (res.success == false) {
              alert(res.error.email);
            } else {
              // redirect to a new URL, or do something on success
              //window.location.href = "/login"
              alert(res.data.message);
              window.location.href = "/login"
            }
          });
        }
      }
    }
  });
</script>
@stop