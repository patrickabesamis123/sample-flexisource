@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/base64.css?ver=1" />
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<div id="Register">
	<div class="container" role="main">
		<div class="row">
			<div class="col-md-12">
				<div class="content-container">
					<article>
						<div class="content"></div>
						<div class="register-form-container">
							<div>
								<h1>Login</h1>
								<div class="divider"></div>
								<div class="alert alert-danger hidden" role="alert"></div>
								<div id="result"></div>
								<form id="Form_LoginForm" @submit="checkForm" method="post" enctype="application/x-www-form-urlencoded">
									<p id="Form_LoginForm_error" class="message " style="display: none"></p>
									<fieldset>
										<div id="Form_LoginForm_email_Holder" class="field text nolabel">
											<div class="middleColumn">
												<input type="email" name="email" class="text nolabel " id="email" v-model="email" required="required" aria-required="true" placeholder="EMAIL">
											</div>
										</div>
										<div id="Form_LoginForm_password_Holder" class="field text password nolabel">
											<div class="middleColumn">
												<input type="password" name="password" class="text password nolabel" id="password" v-model="password" required="required" aria-required="true" placeholder="PASSWORD" autocomplete="off">
											</div>
										</div>
										<input type="hidden" name="SecurityID" value="93b751866c9dd0e16e87c9489d83de26ac067178" class="hidden" id="Form_LoginForm_SecurityID">
										<div class="clear"></div>
									</fieldset>
									<div class="Actions">
										<input type="submit" name="action_doSubmit" value="Login" class="action" id="Form_LoginForm_action_doSubmit">
									</div>
								</form>
								<a href="/register/forgot_password">Forgot Password?</a><br>
								<a href="register">Don't have an account yet? Register</a>
								<div class="hidden"><img src="/images/preloader.gif" width="15"></div>
								<br>
							</div>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>
</div>

@stop

@section('scripts')
<script type="text/javascript" src="/js/login/login.js"></script>
@stop