@extends('layouts.employer')

@section('styles')

@endsection

@section('content')

<div class="TMS-page" id="EmployerManageTalent" ng-controller="EmployerManageTalent">
    <section class="TMS-splasher" ng-show="preload">
        <h3>Please wait.</h3>
        <h4>While we prepare this page for you.</h4>
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
    </section>

    @include('employer.role_creation.tms.TMS_job_details')

    <section class="TMS-applicant-section" ng-hide="preload" ng-cloak>
        <h4 class="TMS__header">RECRUIT</h4>
        <p class="TMS__desc">Drag and drop to organise your candidates</p>
        <p ng-hide="moving">Moving applicant, please wait <i class="fa fa-spinner fa-spin"></i></p>
        <ul class="TMS__bucket-list" role="tablist">
            <li id="bucket@{{step.id}}" class="TMS__bucket-item tab-pane tab-item tab-nav-item" ng-class="{'active in': step.id == getMyBucketId }" class="answers" ng-if="step.name != 'Unsure' " ng-repeat="step in tmsSteps.steps" role="tabpanel" ng-drop="true" ng-drop-success="onDropComplete($data,$event, step.id)">
                <a href="#tab@{{step.id}}" id="tabnav@{{step.id}}" class="TMS__drop-section-link" aria-controls="tab@{{step.id}}" data-toggle="tab" role="tab" ng-click="removeOpened( step.id  )" ng-attr-title="@{{step.slug_name=='rejected' && 'When you put candidates into NOT SUCCESSFUL, there is a 96 hour delay before their dashboard is updated or they are notified by email.' || '' }}">
                <p class="data-loading" ng-show="dataLoad && step.id == getMyBucketId"><i class="fa fa-spinner fa-spin"></i></p>
                <h3 class="count TMS__bucket-count" ng-hide="dataLoad && (step.id == getMyBucketId)" id="count@{{step.id}}">@{{step.counter}}</h3>
                <p>@{{step.name}}</p>
                <p class="TMS__bucket-label TMS__bucket-label--@{{step.custom}}" title="@{{step.customMsg}}"><i class="fa fa-circle"></i></p>
                </a>
            </li>
        </ul>
        <div class="alert alert-success TMS-email" role="alert" ng-hide="sentmail">
            <span>Mail Sent</span>
            <i class="TMS-email__close fa fa-close" ng-click="hideAleart()"></i>
        </div>
        <button type="button" id="bulkEmail_@{{step.id}}" data-toggle="modal" data-target="#BulkEmailModal"
            ng-repeat="(key, step) in tmsSteps.steps"
            ng-show="step.counter != 0 && (step.id == getMyBucketId)"
            ng-click="bulkEmail( step.id, step.name )"
            class="TMS__email-button TMS__email-button@{{step.id}}">
        Bulk Email @{{step.name}}
        </button>
        <!-- Bulk Email modal BEGIN -->
        <div class="modal fade" id="BulkEmailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <form ng-submit="SubmitBulkEmail( bulkemail.stepid ) ">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Send bulk email to @{{bulkemail.stepname}}</h4>
                    </div>
                    <div class="modal-body">
                    <div class="form-group">
                        <label for="subjectEmail">Email Subject</label>
                        <input type="text" name="email_subject" ng-model="email_subject" class="form-control" id="subjectEmail" placeholder="Email Subject" required="required">
                    </div>
                    <div class="form-group">
                        <label for="messageEmail">Message</label>
                        <textarea name="email_body" ng-model="email_body" placeholder="Message" required="required" id="messageEmail"></textarea>
                    </div>
                    <span class="lightgray MontserratLight" style="font-size:12px">
                            Feel free to copy &amp; paste the following merge tags into your message to personalise it for your recipients:
                            <br>
                            [CandidateFirstName]<br>
                            [CandidateLastName]<br>
                            [JobTitle]<br>
                            [CompanyName]
                            </span>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="emptyBulkEmail()">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- Bulk Email modal END -->

        @include('employer.role_creation.tms.TMS_filter')
        
        @include('employer.role_creation.tms.TMS_candidate')

    </section>

    <div class="modal fade" id="vidModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">@{{Modalfirst_name}} @{{Modallast_name}}'s Video</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center" ng-show="LoadingModalVid">
                        <h3 >Loading Video</h3>
                        <img src="https://previewme.co/themes/bbt/images/preloader.gif" width="25px">
                    </div>

                    <div  class="com_video_holder" ng-show="!showVideoLoding" >
                        <img src="/images/ajax-loader-video.gif" >
                        <p >We will notify you once your video has uploaded. You can still use the full site while the video is processing.</p>
                    </div>
                    <div ng-show="ShowVideoError "  class="text-center">
                        @{{errorVideo}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="js/minified/employers/sidebar.min.js"></script>
<script type="text/javascript" src="js/minified/employers/manage.talent.min.js"></script>

@endsection
