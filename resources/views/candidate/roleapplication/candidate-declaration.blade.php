@extends('layouts.roleapplication')



@section('content')

<div class="container-fluidx" role="main">
    <div class="rowx">
        
        <main id="role-app" class="candidate-dec role-app emp-new-role emp-new-role--can clear-float ng-scope" ng-controller="RoleAppMainCtrl">
            <section class="ar__company-top--header flexbox-sb-c">
                <div class="fullwidth">
                    <img nng-if="company.company.logo_url" class="ar__company-logo--title pvm-phone-invisible ng-scope" src="https://pvmlive.blob.core.windows.net/4io7e0o/8ztnl/1520803415_J001498_SocialCollateral_ProfilePictures_NR_2_(1).png">
                    <h1 class="role__title ar__company-name--title ng-binding">Accountant (Business Advisory) 5+ exp</h1>
                </div>

                <button class="btn btn-save pull-right"><i class="fa fa-save"></i>Save &amp; Finish Later</button>
            </section>
            <section class="top-pane floated">
                <div class="limited ng-scope" style="background-image: url(https://pvmlive.blob.core.windows.net/4io7e0o/8ztnl/1520308690_PM_Home-4.jpg);" ng-iif="company.company.company_banner_url"></div>
            </section>

            <div class="role-tabs">
                <section class="left-pane">
                    <div class="role__steps-handler">
                        <div class="ar__company-logo-div">
                            <img ng-iif="company.company.logo_url" class="company__logo-img  ng-scope" src="https://pvmlive.blob.core.windows.net/4io7e0o/8ztnl/1520803415_J001498_SocialCollateral_ProfilePictures_NR_2_(1).png">
                        </div>
                        <div class="ar__company-info-div">
                            <p class="ar__company-name pvm_blue ng-binding">PreviewMe</p>
                            <p class="ar__company-location pvm-tablet-land-invisible ng-binding">Auckland, New Zealand</p>
                            <p class="ar__company-location pvm-tablet-land-visible ng-binding">Auckland<br> New Zealand</p>
                        </div>

                        <ul class="role__steps-list pvm-tablet-land-invisible">
                            <li class="role__steps-item active">
                                <a href="#" role="tab" class="tab__link">Pre-application Questions</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="role__steps-item">
                                    <a href="#general-info" role="tab" class="tab__link">General Profile Information</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="role__steps-item">
                                <a href="#standard-question" role="tab" class="tab__link">Standard Questions</a>
                            </li>
                        </ul>

                        <ul class="role__steps-list pvm-tablet-land-visible role__step-menu" id="role-menu">
                            <li class="role__steps-item active">
                                <a href="#quick-question" role="tab" class="tab__link">Pre-application Questions</a>
                                <div class="triangle-with-shadow"></div>
                            </li>
                            <li class="role__steps-item">
                                <a href="#general-info" role="tab" class="tab__link">General Profile Information</a>
                                <div class="triangle-with-shadow"></div>
                            </li>
                            <li class="role__steps-item">
                                <a href="#standard-question" role="tab" class="tab__link">Standard Questions</a>
                                <div class="triangle-with-shadow"></div>
                            </li>
                        </ul>
                    </div>
                </section>

                <div class="tab-content">
                    <section class="candidate-declaration middle-pane middle-pane--ra tab-pane active in">
                        <h1>Just one more thing...</h1>
                        <div class="text">
                            <input type="checkbox" name="" id="toggle">
                            <p>I declare that all representations, whether oral or in writing, made by me when applying for this role are true and correct. I have not deliberately failed to disclose any matter that may materially    influence Naturals Inc.'s decision to interview, or offer to employ, me. I understand that if the pre-application checks uncover any adverse information or if false information is given or material suppressed by me, my application may be declined, or if a contract for employment has been offered, it may be withdrawn.</p>
                        </div>
                    </section>
                </div>
            </div>

            <section class="bottom-pane pvm-tablet-invisible">
                <span class="role__btn-handler">
                    <a href="/job/application?id=s5tQ3e3GiMSf53D5p3tQMqgC#" class="btn-pvm btn-mini btn-primary role__prev-btn" ng-click="checkPrev()"><i class="fa fa-arrow-left"></i></a>
                    <a href="/job/application?id=s5tQ3e3GiMSf53D5p3tQMqgC#" class="btn-pvm btn-mini btn-tertiary role__save-btn"><i class="fa fa-save"></i> </a>
                </span>
                <button class="btn-pvm btn-primary role__next-btn submit" disabled="disabled"><i class="fa fa-arrow-right"></i> Submit </button>
            </section>

            <section class="bottom-pane pvm-tablet-visible flexbox-sb-c hidden-xs">
                <a href="#" class="btn-pvm btn-primary role__prev-btn ng-scope"><i class="fa fa-arrow-left"></i> Previous</a>
                <div>
                    <button class="btn-pvm btn-primary role__next-btn submit" disabled="disabled"><i class="fas fa-sign-out-alt"></i> Submit Application </button>
                    <button class="btn btn-save pull-right"><i class="fa fa-save"></i>Save &amp; Finish Later</button>
                </div>
                <div style="opacity: 0;"></div>
            </section>
    
        </main>

    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/candidate/role-app.js') }}"></script>
    <script>
        $('.role-tabs .tab__link').click(function (e) {
            event.preventDefault();
        });

        $('#toggle').click(function () {
            //check if checkbox is checked
            if ($(this).is(':checked')) {
                $('.submit').removeAttr('disabled'); //enable input
            } else {
                $('.submit').attr('disabled', true); //disable input
            }
        });
    </script>
@endsection