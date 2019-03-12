<script type="text/ng-template" id="loginModal">
<div class="modal-body">
    <button type="button" class="close" id="dismissSecurity" aria-label="Close" data-dismiss="modal" ng-click="closeModal()"><span aria-hidden="true">&times;</span></button>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center">
            <h3>
                Please enter your email and password before we make the changes.
            </h3>
            <h2>
                @{{ msg }}
            </h2>
        </div>
    </div>
    <div class="alert alert-danger" role="alert" ng-show="ErrorMsg">ErrorMsg</div>
    <div id="result"></div>
    <form id="Form_LoginForm" method="post" enctype="application/x-www-form-urlencoded" ng-submit="validatelogin(login)"
        class="ng-pristine ng-invalid ng-invalid-required">
        <p id="Form_LoginForm_error" class="message " style="display: none"></p>
        <fieldset>
            <div id="Form_LoginForm_email_Holder" class="field text nolabel">
                <div class="middleColumn">
                    <input type="text" name="email" id="Form_LoginForm_email" required="required" aria-required="true"
                        ng-model="login.email" placeholder="EMAIL">
                </div>
            </div>
            <div id="Form_LoginForm_password_Holder" class="field text password nolabel">
                <div class="middleColumn">
                    <input type="password" name="password" id="Form_LoginForm_password" required="required"
                        aria-required="true" ng-model="login.password" placeholder="PASSWORD" autocomplete="off">
                </div>
            </div>
            <div class="clear">
                <!-- -->
            </div>
        </fieldset>
        <div class="Actions">
            <input type="submit" name="action_doSubmit" value="Login" class="action" id="Form_LoginForm_action_doSubmit">
        </div>
    </form>
</div>
</script>


