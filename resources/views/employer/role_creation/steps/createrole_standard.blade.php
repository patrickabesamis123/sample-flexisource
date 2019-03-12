<h2 class="role__label">Standard Questions</h2>
<!--<a href="#" class="btn-pvm btn-mini btn-primary role__pull-btn--standard">Pull from Existing</a>-->
<div class="role__inspirations" ng-init="insp = false">
  <h3 class="role__sublabel">Stuck? Have some inspiration</h3>
  <i class="fa" ng-click="insp = !insp" ng-class="{'fa-minus' : insp, 'fa-plus' : !insp}"></i>
  <p class="role__subdesc" ng-show="insp">Here are some question suggestions. Simply drag & drop the snippets into your questions text box</p>
  <ul class="role__inspiration-list" ng-show="insp">
    <li class="role__inspiration-item" ng-repeat="inspirationItem in preInspirationList" ng-click="pushInspirationStan(inspirationItem)">@{{inspirationItem.name}}</li>
  </ul>
  <span class="role__shuffle" ng-show="insp">
    <i class="fa fa-random"></i>
  </span>
</div>
<div class="role__bespoke" ng-init="bespoke = false">
  <h3 class="role__sublabel">Bespoke Subscription only questions</h3>
  <i class="fa" ng-click="bespoke = !bespoke" ng-class="{'fa-minus' : insp, 'fa-plus' : !insp}"></i>
  <p class="role__subdesc" ng-show="bespoke">Here are some more in-depth questions that you may want to ask your candidates.</p>
  <ul class="role__bespoke-list" ng-show="bespoke">
    <!--rca 237 please change the ng-show condition below-->
    <li class="role__bespoke-item" ng-show="beSpokeTagList.length <= 0" ng-repeat="beSpokeTagItem in beSpokeTagList" ng-click="pushBespoke(beSpokeTagItem)">@{{beSpokeTagItem.tag_label}}</li>
    <li class="role__bespoke-item" ng-show="beSpokeTagList.length > 0">No records found.</li>
  </ul>
  <!--<span class="role__shuffle" ng-show="bespoke">
    <i class="fa fa-random"></i>
  </span> rca 237-->
</div>

<label class="role__declaration">
  <input type="checkbox" checklist-model="setDeclaration" checklist-value="true"> Company Intro Declaration
</label>

<label class="role__declaration">
  <input type="checkbox" checklist-model="setDeclarationCan" checklist-value="true"> Candidate Declaration
</label>

<form name="SQForm" novalidate>
  <ul class="role__QandA-list">

    <!-- <li class="role__QandA-item" ng-repeat="standardList in roleCreate_watch.questions.application" ng-mouseleave="checkMyBack(standardList)"> -->

    <!-- PQB-39: SQ sequence and placements, declaration separations -->
    <li class="role__QandA-item" ng-repeat="standardList_compdecl in sq_view" ng-if="standardList_compdecl.question_type == 'comp_declaration'" ng-mouseleave="checkMyBack(standardList_compdecl)">
      <span class="role__QandA">Q.</span>
      <span class="role__QandA-details">
        <textarea class="role__questions" ng-model="standardList_compdecl.question" required></textarea>
      </span>
      <span class="role__close-btn" ng-click="deleteQuestion(standardList_compdecl)"><i class="fa fa-close"></i></span>
    </li>

    <!-- PQB-39: SQ sequence and placements, declaration separations -->
    <li class="role__QandA-item" ng-repeat="standardList in sq_view" ng-if="standardList.question_type != 'comp_declaration' && standardList.question_type != 'can_declaration' && standardList.question_type != 'declaration'" ng-mouseleave="checkMyBack(standardList)">
      <span class="role__QandA">Q.</span>
      <span class="role__QandA-details">
        <textarea class="role__questions" ng-model="standardList.question" required></textarea>
      </span>
      <span class="role__QandA">A.</span>
      <span class="role__QandA-details">
        <div class="role__mult-box" ng-show="standardList.question_type != 'comp_declaration' && standardList.question_type != 'can_declaration' && standardList.question_type != 'declaration'">
          <label class="role__answers-mult" ng-repeat="answerChoice in answerChoices">
            <input type="checkbox" checklist-model="standardList.answer_type" checklist-value="answerChoice.value"> @{{answerChoice.label}}
          </label>
          <!--<label class="role__answers-mult" ng-repeat="answerChoice in standardList.answer_type" ng-class="{'role__answers-mult--disabled': answerChoice.disabled}">
            <input type="checkbox" checklist-model="answerChoiceSelMum[0].answerChoiceSel" ng-disabled="answerChoice.disabled" checklist-value="answerChoice.id"> @{{answerChoice.label}}
          </label>-->
        </div>
        <ul class="role__mult-choice-list" ng-if="standardList.answer_type.indexOf('multiple_choice') > -1">
          <li class="role__mult-choice-item" ng-repeat="answerMult in standardList.answer_choicesDisplay">
            <span class="role__mult-choice-label">@{{abc[$index]}}.</span>
            <textarea class="pvm-input-text role__mult-text" ng-model="answerMult.value"></textarea>
            <span class="role__close-btn" ng-click="deleteChoices(standardList , answerMult)"><i class="fa fa-close"></i></span>
          </li>
          <li class="role__mult-choice-item role__mult-choice-item--add">
            <a href="#" class="role__mult-more" ng-click="addAnswerMultDB(standardList)">Add more option</a>
            <label class="role__answers-mult">
              <input type="checkbox"> Only one answer is allowed
            </label>
          </li>
        </ul>
      </span>
      <a href="#" ng-click="saveSingleQuestion($index, 'doc')" class="link" ng-hide="JobIsActive">Do you want to upload a Reference Document? (click to upload)</a><br />
      <div>
        <p ng-if="!standardList.question_document.doc_url">No reference record found/uploaded yet</p>
        <p ng-if="standardList.question_document.doc_url">
          <a href="@{{standardList.question_document.doc_url}}">@{{standardList.question_document.doc_filename}}</a>
        </p>
      </div>
      <a href="#" ng-click="saveSingleQuestion($index, 'vid')" class="link" ng-hide="JobIsActive">Want to use video to ask this question? (click to upload)</a> <br />
      <div id="@{{'vid_outercon_' + standardList.id}}">
        <video id="@{{'vid_container_' + standardList.id}}" class="azuremediaplayer amp-default-skin amp-big-play-centered" tabindex="0" ng-show="standardList.video_document.VideoStatus == ''">
          <p class="amp-no-js">
            To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
          </p>
        </video>
      </div>

      <!-- standardList.video_document -->
      <div class="role__QandA-video text-center" ng-show="standardList.video_document.VideoStatus == 'uploading'">
        <div>
          <h4>Video is uploading and being encoded..</h4>
        </div>
        <div style="margin-bottom: 25px">
          "You do not need to wait on this page while your video is ‘processing’. <br>As you continue with the role creation, your video will be saved."
          <br /><br /><br /><br /><br />
          <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br />
          @{{standardList.video_document.encoding_job_status}} @{{standardList.video_document.encoding_progress + '%'}}
          <p ng-if="standardList.video_document.encoding_progress == 100">Video is almost ready. Please wait for a few seconds..</p>
        </div>
      </div>
      <br>

      <!-- PQB-39: SQ sequence and placements, declaration separations -->
      <div ng-if="standardList.question_type == 'can_declaration'">
        <span class="role__QandA-details">
          <textarea class="role__questions" ng-model="standardList.question" required></textarea>
        </span>
      </div>


      <!-- <a href="#" ng-click="openVideoModal()" class="link" ng-hide="JobIsActive">Upload a Reference Document</a> -->
      <span class="role__close-btn" ng-click="deleteQuestion(standardList)"><i class="fa fa-close"></i></span>
    </li>

    <li class="role__QandA-item" ng-repeat="standardList_candecl in sq_view" ng-if="standardList_candecl.question_type == 'can_declaration'" ng-mouseleave="checkMyBack(standardList_candecl)">
      <span class="role__QandA">Q.</span>
      <span class="role__QandA-details">
        <textarea class="role__questions" ng-model="standardList_candecl.question" required></textarea>
      </span>
      <span class="role__close-btn" ng-click="deleteQuestion(standardList_candecl)"><i class="fa fa-close"></i></span>
    </li>


  </ul>
  <a href="#" class="btn-pvm btn-mini btn-primary role__add-pre-app" ng-click="addBlankStandard()">Add</a>
</form>