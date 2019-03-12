<footer id="footer" role="contentinfo">
    <section class="pvm-footer">
        <a href="/" class="pvm-gray-logo" rel="home">
        <img src="images/footer-logo.png" id="footerLogo" title="PreviewMe">
        </a>
        <ul class="footer-list clear-float">
            <li class="footer-item">
                <h5>For Candidates</h5>
                <a data-ajax="false" href="/features/candidates" class="footer__link">Features</a>
            </li>
            <li class="footer-item">
                <h5>For Employers</h5>
                <a data-ajax="false" href="/features/employers" class="footer__link">Features</a>
            </li>

            <li class="footer-item footer-item--up">
                <a data-ajax="false" href="/about-us" class="footer__link">ABOUT US</a>
                <a data-ajax="false" href="/contact-us" class="footer__link">CONTACT US</a>
                <a data-ajax="false" href="/pricing" class="footer__link">PRICING</a>
                <a data-ajax="false" href="/our-partners" class="footer__link">PARTNERS</a>
            </li>
            <li class="footer-item footer-item--up">
                <a data-ajax="false" href="/faq" class="footer__link">FAQ</a>
                <a data-ajax="false" href="/job-search" class="footer__link">JOB SEARCH</a>
                <a data-ajax="false" href="/help" class="footer__link">HELP</a>
                <a data-ajax="false" href="/resources" class="footer__link">CONTENT</a>
            </li>
        </ul>
        <p class="footer__copyright">
            &copy; 2016 PreviewMe. All rights reserved
            <a href="/privacy-policy" data-ajax="false">Privacy Policy</a>
            <a href="/terms-and-conditions" data-ajax="false">T's and C's</a>
        </p>
    </section>
</footer>

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

<div id="Loginmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div ng-controller="LoginController" class="modalcontainer">
                <div class="col-md-10 col-md-offset-1  ">
                <button type="button" class="close" aria-label="Close" ng-click="gohome()"><span aria-hidden="true">&times;</span></button>
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
                    <input type="hidden" name="SecurityID" value="70af9f12439bcd6ed19a009dcb3fd3cfdbdf2ee5" class="hidden" id="Form_LoginForm_SecurityID" />
                    <div class="clear"></div>
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
                    <a href="/register/password_forgot" class="text-center">Forgot Password?</a>
                </div>
                <div ng-hide="preload" class="text-center"><img src="/images/preloader.gif" width="25"></div>
                <br>
                </div>
            <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<div id="Forbiddenmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modalcontainer row" ng-controller="LoginController">
                <div class="col-md-10 col-md-offset-1">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 text-center">
                            <button type="button" class="close" aria-label="Close" ng-click="gohome()"><span aria-hidden="true">&times;</span></button>
                            <h3>YOU SHALL NOT PASS!!!</h3>
                            Seriously you cant! its forbidden for you to be here!<br>
                            <a href="/#" ng-click="gohomeforbidden()">Go back home</a>
                        </div>
                    </div>
                </div>
            <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
