<div class="text-center splashdata" ng-show="joblisting.length == 0">
        <img src="/images/preloader.gif" width="30">
        <h4>Loading data</h4>
</div>

<div id="job-listing-buttons-holder" class="col-md-12" ng-show="joblisting != 0"">
    <div class="job-listing-left-content-holder">
        <h3 class="pvm-blue">WE ARE LOOKING FOR</h3>
        <div ng-bind-html="joblisting.job_description"></div>
             <br>
           
           
            <div ng-show="joblisting.job_video_url">
            <video id="JobVideo_@{{$parent.job.object_id}}" class="azuremediaplayer amp-default-skin" height="300" >
                <p class="amp-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
                </p>
            </video>

             </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="job-listing-left-content-holder" ng-if="joblisting.accountabilities.length">
        <div class="col-md-3 padding-l-zero  ">
            <h4>On a normal day <br>  you'll get to...</h4>
        </div>
        <div class="col-md-7 col-md-offset-2 padding-l-zero">
            <ul class="listme">
                <li ng-repeat=" accountability in joblisting.accountabilities"> @{{accountability.name}}</li>
            </ul>
        </div>
        <div class=clearfix></div>
    </div>
    <div class="job-listing-left-content-holder" ng-if="joblisting.requirements.length">
        <div class="col-md-3 padding-l-zero  ">
            <h4>To apply,  <br> you need to meet  <br> the following requirements...</h4>
        </div>
        <div class="col-md-7 col-md-offset-2 padding-l-zero">
            <ul class="listme">
                <li ng-repeat=" requirement in joblisting.requirements">@{{requirement.name}}</li>
            </ul>
        </div>
        <div class=clearfix></div>
    </div>
    <div class="job-listing-left-content-holder" ng-if="joblisting.objectives.length">
        <div class="col-md-3 padding-l-zero  ">
            <h4>You will want  to work with us because...</h4>
        </div>
        <div class="col-md-7 col-md-offset-2 padding-l-zero">
            <ul class="listme">
                <li ng-repeat=" objective in joblisting.objectives">@{{objective.name}}</li>
            </ul>
        </div>
        <div class=clearfix></div>
    </div>
   
</div>
