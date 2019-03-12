@extends('layouts.employer')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
<link href="//amp.azure.net/libs/amp/latest/skins/amp-default/azuremediaplayer.min.css" rel="stylesheet">
@stop

@section('content')

<?php
$baseUrl = "http://previewme.co/";
?>

<div ng-controller="EmployerCompany" id="employer_company_edit_content" >

	<div class="text-center splash " ng-show="preload">
	  <div class="cssload-container">
      <h3>Please wait.</h3>
      <h4>While we prepare this page for you.</h4>
      <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
	  </div>
  </div>

	<div id="company_banner_holder" ng-cloak="true" ng-hide="preload">
		<div ng-if="company_banner_url" data-toggle="modal" class="company_banner" style="background-image: url('@{{company_banner_url}}');"></div>
		<div ng-if="!company_banner_url" class="company_banner" style="background-image: url('/images/Default-Header.png');"></div>
    <a href="#" data-toggle="modal" data-target="#companyBannerModal" class="add_photo_button pvm-blue">Update Banner</a>
  </div>

  <div id="job-listing-top-con" ng-cloak="true" ng-hide="preload">
    <div class="job-listing-container company_logo">
     	<div id="job-listing-logo-con" >
        <div ng-if="!logo_url" class="employer_company_logo_holder">
          <img src="/images/default_company_logo.png" height="150px" width="150px" class="img-circle" />
          <a href="#" data-toggle="modal" data-target="#pmvImageModalNew" class="add_photo_button pvm-blue">Update Photo</a>
         	<a href="/company/@{{company_url}}" class="emp_profile_link pvm-green">View Public Profile</a>
        </div>
        <div ng-if="logo_url" class="employer_company_logo_holder">
        	<div class="employer_company_logo">
            <img data-toggle="modal" data-target="#pmvImageModalNew" src="@{{logo_url}}" height="150px" width="150px" class="img-circle pvm-cursor-pointer" />
            <img src="/images/profile_camera_image.png" class="profile_image_camera pvm-cursor-pointer"
            style="margin-top:-84px;margin-left : 65px;" data-toggle="modal" data-target="#pmvImageModalNew">
          </div>
         	<a href="company/@{{company_url}}" class="emp_profile_link pvm-green">View Public Profile</a>
        </div>
  		</div>

      <div id="job-listing-title-con" class="col-md-12">

      	<div class="col-md-7 company_listing_top1">
					<h3 class="col-md-9 candidate-top-fields-holder word-break no-padding-lr">
						<span  editable-text="company_name" onaftersave="updateCompany()" class="editfield pvm-blue">
							@{{company_name || "Update Company" }}
							<span class="glyphicon pencil-icon"></span>
						</span>
					</h3>
					<div class="clearfix"></div>
          <div class="position">
						<form editable-form name="rowform" onaftersave="updateIndustry($data)" autocomplete="off" style="display:inline">
							<span ng-click="rowform.$Show"  e-name="industry" editable-select="industry.data.industry.id" onshow="loadIndustries()" e-ng-options="s.id as s.display_name for s in industries "  class="pvm-cursor-pointer editfield pvm-dark-gray" e-form="rowform">
								@{{industry.data.industry.display_name}}
							</span>
					  	<a href type="button" class="editfield" ng-click="rowform.$Show" ng-show="!rowform.$Visible">
				        <span class="glyphicon pencil-icon"></span>
				    	</a>
							<span ng-if="helper_text" ng-show="!rowform.$Visible">|</span>
							<div class="buttons pull-right">
					      <span ng-show="rowform.$Visible">
					        <button type="submit" class="btn btn-primary-bbt" ng-disabled="rowform.$Waiting">
					        	<span class="glyphicon glyphicon-ok"></span>
					        </button>
					        <button type="button" class="btn btn-default-bbt" ng-disabled="rowform.$Waiting" ng-click="rowform.$Cancel">
					          <span class="glyphicon glyphicon-remove"></span>
					        </button>
					      </span>
							</div>
						</form>
						<span editable-text="helper_text" onaftersave="updateCompany()" class="editfield pvm-dark-gray pvm-cursor-pointer" e-placeholder="Helper text">
							@{{helper_text || ''}}
							<span class="glyphicon pencil-icon"></span>
						</span>
					</div>

					<div class="row details">
						<div class="col-md-5 no-padding-r" style="z-index:999">
							<span>
								<span class="col-md-4 details_title">Size:</span>
								<span class="col-md-8 candidate-top-fields-holder word-break no-padding">
									<a href="#" editable-select="num_of_employees" e-ng-options="s for s in number_of_employees" onaftersave="updateCompany()" class="editfield">
										@{{num_of_employees || "Update number of employees" }}
										<span class="glyphicon pencil-icon"></span>
									</a>
								</span>
							</span>

							<span>
								<span class="col-md-4 details_title">Website:</span>
								<span class="col-md-8 candidate-top-fields-holder word-break no-padding">
								<a href="#" editable-text="website_url"  onaftersave="updateCompany()" class="editfield">
									@{{website_url || "Update website" }}
									<span class="glyphicon pencil-icon"></span>
								</a>
								</span>
							</span>

							<span>
								<span class="col-md-4 details_title">Phone:</span>
								<span class="col-md-8 candidate-top-fields-holder word-break no-padding">
								<a href="#" editable-text="company_phone" onaftersave="updateCompany()" class="editfield">
									@{{company_phone || "Update phone" }}
									<span class="glyphicon pencil-icon"></span>
								</a>
								</span>
							</span>
						</div>

						<div class="col-md-7">
							<form editable-form name="rowform1" onaftersave="updateHeadquarters($data)"  autocomplete="off">
								<span class="col-md-5 details_title">Headquarters:</span>
								<span class="col-md-7 candidate-top-fields-holder word-break no-padding">
									<span ng-click="rowform1.$Show" class="pvm-cursor-pointer editfield pvm-dark-gray"
									editable-text="street_address" e-name="street_address" e-placeholder="Address 1" e-form="rowform1">
								  	@{{ street_address || 'Update address' }}
								  </span>
							    <a href type="button"  class="editfield" ng-click="rowform1.$Show" ng-show="!rowform1.$Visible">
						        <span class="glyphicon pencil-icon"></span>
						    	</a>
						    	<div ng-click="rowform1.$Show" class="pvm-cursor-pointer editfield pvm-dark-gray" editable-select="location.data.country.id"  e-name="country" onshow="LoadCountries()"   e-required  e-ng-options="s.id as s.display_name for s in countries">
							      @{{ location.data.country.display_name || 'Update region"' }}
							    </div>
									<span class="locationAutoComplete">
								    <div ng-click="rowform1.$Show" class="pvm-cursor-pointer editfield pvm-dark-gray " editable-text="location.data.display_name" e-name="area" e-ng-change="GetAreas($data, location.data.country.id)"  >
								      @{{ location.data.display_name || '' }}
								    </div>
		    				    <ul id="autoDataLocation" class="result" ng-hide="hideme" style="display:none">
                      <li ng-repeat="(key, value) in areas">
                        <a href="#" data-value="@{{value.id}}" ng-click="getAutoCompleteData( value  )" class="autodata" style="display:block">@{{value.display_name}}</a>
                      </li>
                    </ul>
                  </span>
								</span>

			    			<div class="buttons pull-right" style="margin-right:24px">
						      <span ng-show="rowform1.$Visible">
						        <button type="submit" class="btn btn-primary-bbt" ng-disabled="rowform1.$Waiting">
						        	<span class="glyphicon glyphicon-ok"></span>
						        </button>
						        <button type="button" class="btn btn-default-bbt" ng-disabled="rowform1.$Waiting" ng-click="rowform1.$Cancel">
						          <span class="glyphicon glyphicon-remove"></span>
						        </button>
						      </span>
								</div>
							</form>
						</div>
					</div>
        </div>

        <div class="col-md-5 company_listing_top2">
					<div id="com-follow-con">
						<div id="com-follow" class="pvm-blue">
							@{{extra_data.followers}} @{{ follower_text}}
						</div>
						<div id="com-follow-btn" class="pvm-blue-background pvm-white">Follow</div>
					</div>
				</div>

      </div>
    </div>
    <div class="clearfix"></div>
  </div>

  <div class="col-md-12" id="job-listing-content-con" ng-cloak="true" ng-hide="preload">
		<div class="job-listing-container">

			<div id="job-listing-buttons-holder" class="col-md-4">
				<div class="job-listing-left-content-holder">
					<!-- <div ng-if="!company_video" class="com_video_holder">
						<video poster="{$ThemeDir}/images/placeholder_vid.png"></video>
						 <a href="#" data-toggle="modal" data-target="#pmvCameraModalNew" class="add_photo_button pvm-blue">Update Video</a>
					</div> -->
					<!-- show if video under loading procing -->
					<style>
						.com_video_holder{position: relative;}
						.showVideoLoding .vid_holder img{position: absolute;top: 50%;left: 50%;margin: -100px 0 0 -130px;transform: translate(50%, 50%);}
						.showVideoLoding .vid_holder div{position: absolute;top: 0;width: 100%;margin: 0 auto;text-align: center;padding: 15px;font-size: 11px;line-height: 12px;}
					</style>
					<!-- <div  class="com_video_holder showVideoLoding" ng-show="showVideoLoding" >
						<span class="vid_holder">
							<img src="{$ThemeDir}/images/ajax-loader-video.gif" >
							<a href="#" data-toggle="modal" style="top:53px;left:54px;" ng-show="videobuttom" data-target="#pmvCameraModalNew" class="add_photo_button2 pvm-blue">Update Video</a>
							<div >
  							We will notify you once you video has uploaded. You can still use the full site while the video is processing.</div>
						</span>
					</div> -->

					<!-- <div ng-show="showError">
						<a href="#" data-toggle="modal" style="top:53px;left:54px;"   data-target="#pmvCameraModalNew" class="add_photo_button2 pvm-blue">Update Video</a>
						@{{ErrorVideo}}
          </div> -->

					<div class="com_video_holder">
						<span class="vid_holder">
							<div ng-show="showVideo">
								<video id="vid1" class="azuremediaplayer amp-default-skin">
							    <p class="amp-no-js">
							      To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
							    </p>
								</video>
							</div>
							<div ng-show="emp_preview_img == 'loading'" class="text-center" style="background: #fff; padding: 4px">
            		<img src="/images/ajax-loader-video.gif" style="width:106px;padding-bottom:10px">
            		<div style="margin-bottom: 25px">
            			We will notify you once your video has been uploaded. You can still use the full site while the video is processing
            		</div>
            	</div>
						</span>
						<div>
							<a href="#" data-toggle="modal" data-target="#pmvCameraModalNew" class="add_photo_button2 pvm-blue" style="float: left; margin: 5px 0;">
								<i class="fa fa-upload"></i>
							</a>
							<div class="cornerstorevid" style="float: right; margin: 5px 0;">
								Need help creating a professional video?<br>
								<a href="cornerstore-professional-videos"> Check out our partners</a>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>

					<br><br>
					<h4 ng-click="rowform2.$Show()" class="pvm-cursor-pointer pvm-blue" style="width:130px;">ABOUT US</h4>
					<div class="content">
						<div class="buttons" ng-show="!rowform2.$Visible" style="position: relative;">
						  <a href="#" ng-click="rowform2.$Show()" style="top:-27px;left:100px;position:absolute">
						  	<span class="glyphicon pencil-icon"></span>
						  </a>
						  <span class="pvm-gray description_content" ng-bind-html="company_description | newlines"></span>
						</div>
						<div class="qualification">
							<span e-form="rowform2" class="editfield" editable-textarea="company_description" e-name="company_description" e-rows="8" e-cols="100"></span>
						</div>
		  			<form editable-form name="rowform2" onbeforesave="updateAbout($data)" ng-show="rowform2.$Visible" class="form-buttons form-inline">
			  			<div class="pull-right">
					      <button type="submit" style="width:124px;padding:10px 20px" ng-disabled="rowform2.$Waiting" class="btn btn-primary-bbt">SAVE</button>
								<button type="button" style="width:124px;padding:10px 20px"  ng-disabled="rowform2.$Waiting" ng-click="rowform2.$Cancel()" class="btn btn-default-bbt">CANCEL</button>
			        </div>
			        <div class="clearfix"></div>
			      </form>
					</div>
					<hr>
					<div>
						<h4 class="pvm-gray" style="width:73px;float:left">Offices</h4>
						<div class="buttons" ng-show="!rowform3.$Visible" style="float:left;margin-top:10px">
						 	<a href="#" ng-click="rowform3.$Show()" >
					  		<span class="glyphicon pencil-icon"></span>
					  	</a>
						</div>
						<div class="clearfix"></div>
					 	<ul ng-if="company_branch_locations.length > 0" ng-show="!rowform3.$Visible" style="padding:0px; list-style:none;">
							<li ng-repeat="location in company_branch_locations track by $index" class="pvm-gray">@{{location.address}} ( @{{location.phone_number}} )</li>
					  </ul>
			  		<form id="branch_form" editable-form name="rowform3" onbeforesave="updateBranches()" ng-show="rowform3.$Visible" class="form-buttons form-inline">
							<div id="multi_location_holder">
	  						<div class="provider_container_con" ng-if="company_branch_locations.length == 0">
									<div class="col-md-10">
										<input type="text" name="location[]" placeholder="Enter location" class="filterQualification" rows="3">
										<input type="text" name="phone[]" placeholder="Enter Phone number" class="filterQualification" rows="3">
									</div>
									<div class="col-md-2 row plus-minus-wrapper">
										<a class="add addNewProvider col-md-6 pvm-green"><span>+</span></a>
									</div>
								</div>
								<div class="provider_container_con" ng-if="company_branch_locations.length >= 0" ng-repeat="(key, location) in company_branch_locations track by $index">
									<div class="col-md-10">@{{key}} --- hre
										<input type="text" name="location[]" value="@{{location.address}}" placeholder="Enter location" class="filterQualification" rows="3">
										<input type="text" name="phone[]" placeholder="Enter Phone number" value="@{{location.phone_number}}" class="filterQualification" rows="3">
									</div>
									<div class="col-md-2 here row plus-minus-wrapper">
										<a class="add addNewProvider col-md-6 pvm-green"><span>+</span></a>
										<a ng-if="key > 0" class="add removeNewProvider col-md-6"><span>-</span></a>
									</div>
									<div class="clearfix"></div>
								</div>
			        </div>
          		<div class="clearfix"></div>
    					<div class="pull-right offices-buttons-wrapper">
				        <button type="submit" class="btn btn-primary-bbt">SAVE</button>
								<button type="button" ng-disabled="rowform3.$Waiting" ng-click="rowform3.$Cancel()" class="btn btn-default-bbt">CANCEL</button>
          		</div>
				    </form>
					</div>
					<div class="clearfix"></div>
					<hr>
					<div>
						<h4 class="pvm-gray">Customise Your Company URL</h4>
						<a href="{$BaseHref}company/@{{company.encode_company_url}}">www.previewme.co/company/@{{company_url}}</a>
						<br><br>
						<form class="form-horizontal">
							<div class="form-group">
								<span class="col-sm-7" style="line-height:3;color:#00afed">previewme.co/company/</span>
								<div class="col-sm-5 no-padding-l">
									<input type="text" name="company_url" id="company_url" class="editable-input form-control" placeholder="Company name" style="height:46px">
									<div class="pull-right" style="width:234px">
								    <button type="submit" onclick="updateCompanyUrl()" style="width:115px; padding:10px 20px" class="btn btn-primary-bbt">SAVE</button>
										<button type="button" onclick="cancelCompanyUrl()" style="width:115px; padding:10px 20px" class="btn btn-default-bbt">CANCEL</button>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
   					</form>
					</div>
				</div>
			</div>

			<div class="col-md-8 com-right-container">
				<div class="company-listing-right-content-holder" style="padding-bottom: 0"></div>
				<div class="con_right_content_holder">
					<div style="background-color:#eee;height:700px;text-align:center">
						<p class="vertical_center">Active roles are listed here</p>
					</div>
					<!-- <div class="col-md-12 con_right_content" ng-repeat="job in extra_data.active_jobs.jobs">
						<div class="col-md-4 row">
							<h4 class="pvm-blue">@{{job.job_title}}</h4>
							<small class="con_addrs_list pvm-gray">@{{job.location.region_name}}, @{{job.location.city_name}}, @{{job.location.suburb_name}}</small>

							<a href="{$BaseHref}job/listing/@{{job.object_id}}" class="btn con_view_listing_btn pvm-blue"><i class="glyphicon glyphicon-eye-open"></i>
							VIEW LISTING
							</a>
						</div>
						<div class="col-md-8" ng-bind-html="job.description"></div>

					</div> -->
				</div>
			</div>

		</div>
	</div>

<!-- <% include CandidateModals %> -->
@include('candidate.candidate_modals')

</div>

@stop

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.13/vue.min.js"></script>
<script type="text/javascript" src="js/minified/login/login.min.js"></script>
<script type="text/javascript" src="js/minified/employers/sidebar.min.js"></script>
<script src= "//amp.azure.net/libs/amp/2.1.0/azuremediaplayer.min.js?ver=2.1"></script>
<script type="text/javascript" src="js/minified/employers/company.edit.min.js"></script>


@stop