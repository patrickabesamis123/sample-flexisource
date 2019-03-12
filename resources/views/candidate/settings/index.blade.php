@extends('layouts.candidate')

@section('styles')
<link href="css/candidate-settings.css" rel="stylesheet">
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<?php 
$baseUrl = "http://previewme.co/";
?>
<main class="user-settings user-settings--candidate" ng-controller="CandidateController" id="CandidateSettings">
    <section ng-controller="CandidateSettingsController" class="can-settings" style="width: 100%">

        <ul class="pvm-tab-list pvm-tab-list--settings">
            <li ng-class="{'active' : tab1}" class="pvm-tab__item">
                <a ng-disabled="tab1" ng-click="!tab1 && updateTab('tab1')" href="javascript:void(0)">Account settings</a>
            </li>
            <li ng-class="{'active' : tab2}" class="pvm-tab__item">
                <a ng-disabled="tab2" ng-click="!tab2 && updateTab('tab2')" href="javascript:void(0)">Communication
                    settings</a>
            </li>
            <li ng-class="{'active' : tab3}" class="pvm-tab__item">
                <a ng-disabled="tab3" ng-click="!tab3 && updateTab('tab3')" href="javascript:void(0)">Privacy /
                    Visibility settings</a>
            </li>
        </ul>

        <div class="pvm-tab-content settings settings--account">
            @include('candidate.settings.account')
            @include('candidate.settings.communication')
            @include('candidate.settings.privacy')
        </div>

        <div class="pvm__modal-popup pvm__modal-popup--confirm" ng-class="{'pvm_modal_active': animateShowModal}" ng-if="tab3==true && modalStatus == true && publicPrivateToggle == true">
            <div class="pvm__modal-popup__content">
                <a ahref="/settings#" ng-click="cancelModal()" class="close pvm-color-red"><i class="fa fa-times"
                        aria-hidden="true"></i></a>
                <p>This feature enables you to share your Profile with people off PreviewMe. Please be careful with
                    what you share and who you share it with. </p>
                <p>We encourage you to consider using the visibility controls below to protect your content.</p>
                <p>PreviewMe is not liable for disclosure of your Profile content to third parties (or third parties
                    on-sharing your profile URL) when Public. </p>
                <div class="modal_btn_container">
                    <button ng-click="aggreeUpdate('privatePublicSetting')" class="btn-pvm modal_btn modal_btn--green">I
                        agree</button>
                    <button ng-click="cancelModal()" class="btn-pvm modal_btn modal_btn--red">I decline</button>
                </div>
            </div>
        </div>
        <div class="pvm__modal-popup pvm__modal-popup--confirm" ng-class="{'pvm_modal_active': animateShowModal}" ng-if="tab3==true && modalStatus == true && seoSwitchToggle == true">
            <div class="pvm__modal-popup__content">
                <a ahref="/settings#" ng-click="cancelModal()" class="close pvm-color-red"><i class="fa fa-times"
                        aria-hidden="true"></i></a>
                <p>By enabling this function you are making your profile searchable on public search engines (eg:
                    Google, Yahoo!, Bing, etc) and anyone can view all of your profile.</p>
                <p>Before enabling this feature please consider whether a mix of any of the other privacy controls that
                    PreviewMe offers will suit you better and let you pursue opportunities in a way that gives you more
                    control of your profile and protects your information.. For example, restricting visibility to some
                    elements using the toggles below or utilising out 'Intros' feature (click <a href="">here</a> to
                    find out more).</p>
                <p>PreviewMe is not liable for disclosure of your profile to third parties or how those third parties
                    use your profile once they have obtained it when Search Engine mode is enabled.</p>
                <div class="modal_btn_container">
                    <button ng-click="aggreeUpdate('seoSwitchSetting')" class="btn-pvm modal_btn modal_btn--green">I
                        agree</button>
                    <button ng-click="cancelModal()" class="btn-pvm modal_btn modal_btn--red">I decline</button>
                </div>
            </div>
        </div>
        <div class="pvm__modal-popup pvm__modal-popup--confirm" ng-class="{'pvm_modal_active': animateShowModal}" ng-if="tab3==true && modalStatus == true && showHelper == true">
            <div class="pvm__modal-popup__content">
                <a ahref="/settings#" ng-click="cancelModal()" class="close pvm-color-red"><i class="fa fa-times"
                        aria-hidden="true"></i></a>
                <p>Private mode is our default setting for you.</p>
                <p>We take your privacy seriously and this gives you the ultimate control over your profile. </p>
                <p>Employers registered on PreviewMe who have received an application from you through PreviewMe have
                    access to your profile and if an employer on PreviewMe who you have not submitted an application to
                    does somehow get hold of your URL they must submit a request to view directly to you (which you can
                    accept, reject and revoke at anytime). </p>
                <div class="modal_btn_container">
                    <button ng-click="cancelModal()" class="btn-pvm modal_btn modal_btn--red">Close</button>
                </div>
            </div>
        </div>
        <div class="pvm__modal-popup pvm__modal-popup--confirm" ng-class="{'pvm_modal_active': animateShowModal}" ng-if="tab3==true && modalStatus == true && showDataStatusAlert == true">
            <div class="pvm__modal-popup__content">
                <a ahref="/settings#" ng-click="cancelModal()" class="close pvm-color-red"><i class="fa fa-times"
                        aria-hidden="true"></i></a>
                <p>You haven't clicked on Confirm Changes yet. Discard changes?</p>
                <div class="modal_btn_container">
                    <button ng-click="updateBeforeLeave('yes')" class="btn-pvm modal_btn modal_btn--green">Yes</button>
                    <button ng-click="updateBeforeLeave('cancel')" class="btn-pvm modal_btn modal_btn--red">Cancel</button>
                </div>
            </div>
        </div>

        <div class="pvm__modal-popup pvm__modal-popup--confirm" ng-class="{'pvm_modal_active': animateShowModal}" ng-if="tab3==true && modalStatus == true && messageModal == true">
            <div class="pvm__modal-popup__content pvm__modal-popup__content--large">
                <a ahref="/settings#" ng-click="cancelModal()" class="close pvm-color-red"><i class="fa fa-times"
                        aria-hidden="true"></i></a>
                <div class="modal_btn_container">
                    <button ng-click="cancelModal()" class="btn-pvm modal_btn modal_btn--red">Close</button>
                </div>
            </div>
        </div>
        <!-- End TAB 3 -->
    </section>
</main>

<!-- UPDATE MODAL -->
<div id="Securitymodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modalcontainer">
                <div class="col-md-10 col-md-offset-1  ">
                    <button type="button" class="close" id="dismissSecurity" aria-label="Close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span></button>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 text-center">
                            <h3>
                                Please enter your email and password before we make the changes.
                            </h3>
                        </div>
                    </div>
                    <div class="alert alert-danger" role="alert" ng-show="ErrorMsg">ErrorMsg</div>
                    <div id="result"></div>
                    <form id="Form_LoginForm" method="post" enctype="application/x-www-form-urlencoded"
                        ng-submit="validatelogin()" class="ng-pristine ng-invalid ng-invalid-required">
                        <p id="Form_LoginForm_error" class="message " style="display: none"></p>
                        <fieldset>
                            <div id="Form_LoginForm_email_Holder" class="field text nolabel">
                                <div class="middleColumn">
                                    <input type="text" name="email" id="Form_LoginForm_email" required="required"
                                        aria-required="true" ng-model="emailfield" placeholder="EMAIL">
                                </div>
                            </div>
                            <div id="Form_LoginForm_password_Holder" class="field text password nolabel">
                                <div class="middleColumn">
                                    <input type="password" name="password" id="Form_LoginForm_password" required="required"
                                        aria-required="true" ng-model="pass" placeholder="PASSWORD" autocomplete="off">
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
                    <!-- <div ng-hide="preload" class="text-center"><img src="<?php echo $baseUrl ?>/images/preloader.gif" width="25"></div> -->
                    <br>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script type="text/javascript" src="js/minified/candidate/candidate--settings.min.js"></script>
@stop

@stop
