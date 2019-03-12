 <div id="Securitymodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog  ">
    <div class="modal-content">
       
         <div  class="modalcontainer">

            <div class="col-md-10 col-md-offset-1  ">
                <button type="button" class="close"  id="dismissSecurity" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center"> 
                        <h3> 
                        Please enter your email and password before we make the changes.
                        </h3>
                    </div>
                </div>

            <div class="alert alert-danger" role="alert" ng-show="ErrorMsg">@{{ErrorMsg}}</div>
                <div id="result">$FormResult</div>
                <form id="Form_LoginForm" action="/bitbucket/previewme/login/LoginForm" method="post" enctype="application/x-www-form-urlencoded" ng-submit="validatelogin()" onsubmit="return false" class="ng-pristine ng-invalid ng-invalid-required">
                <p id="Form_LoginForm_error" class="message " style="display: none"></p>
                <fieldset>


                <div id="Form_LoginForm_email_Holder" class="field text nolabel">
                <div class="middleColumn">
                <input type="text" name="email"   id="Form_LoginForm_email" required="required" aria-required="true" ng-model="emailfield" placeholder="EMAIL">
                </div>
                </div>


                <div id="Form_LoginForm_password_Holder" class="field text password nolabel">

                <div class="middleColumn">
                <input type="password" name="password"   id="Form_LoginForm_password" required="required" aria-required="true" ng-model="pass" placeholder="PASSWORD" autocomplete="off">
                </div>
                 
                </div>


                <div class="clear"><!-- --></div>
                </fieldset>


                <div class="Actions">


                <input type="submit" name="action_doSubmit" value="Login" class="action" id="Form_LoginForm_action_doSubmit">



                </div>


                </form>
                  
                
                 <div ng-hide="preload" class="text-center"><img src="{$BaseHref}/themes/bbt/images/preloader.gif" width="25"></div>
                 <br>
             
            </div>
            <div class="clearfix"></div>
        
        </div>
    </div>
  </div>
</div>