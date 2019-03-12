(function () {  
    'use strict';
        
    var app = angular.module('app');
    var base_url = $('body').data('base_url');
    
     app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(false);
    }]);
        
    app.controller('VideoController', ['GlobalConstant','fileUploadService','$scope','$window','$http', '$cookies','$location',     function(GlobalConstant, fileUploadService, $scope, $window, $http, $cookies,  $location  ) {
        
        //Validate guid
        var pathname = $window.location.pathname
        var explodeURL = pathname.split('/');
        var guid = explodeURL[explodeURL.length - 1];
        
        if (guid == 'redo-video'  || guid == '') {
            //Redirect to homepage if no available guid
            $window.location.href = base_url
        } 

        console.log( guid )
        

        $scope.showSection2 = true;
        
        //Check if webcam is set up
        if (!(DetectRTC.hasMicrophone && DetectRTC.hasWebcam) && !$scope.mobile_agent) {
            $('#pmvCameraModalNew .errorUpload').show();
            $('#pmvCameraModalNew .modal-button-right-con').html('<p class="text-danger">Recording unavailable. see error below</p>')
            if (DetectRTC.hasMicrophone == false) {
                $('#pmvCameraModalNew .errorUpload span').html('<p class="text-danger">Microphone not set</p>');
            }
            if (DetectRTC.hasWebcam == false) {
                $('#pmvCameraModalNew .errorUpload span').html('<p class="text-danger">Camera not set</p>');            
            }

            if (isSafari) {
                $('#pmvCameraModalNew .errorUpload span').html('<p class="text-danger">Your browser not supported.</p>');
            }

            return false;
        } 


        //Video control buttons
        $scope.stopVideo = function() {
            fileUploadService.stopVideo($scope);
        }

        $scope.recordVideo = function() {
            fileUploadService.recordVideo($scope);
        }

        $scope.recordVideoAgain = function() {
            $scope.buttonsHideShow(false, true, true, true, true);
        }

        $scope.changeVideo = function() {
            fileUploadService.changeVideo($scope);
        }

        $scope.buttonsHideShow = function(a,b,c,d,e) {
            $scope.record_btn = a;
            $scope.record_again_btn = b;
            $scope.stop_btn = c;
            $scope.save_btn = d;
            $scope.change_btn = e;
        }

        function checkBrowsers() {
          var nVer = navigator.appVersion;
          var nAgt = navigator.userAgent;
          $scope.browserName  = navigator.appName;
          var fullVersion  = ''+parseFloat(navigator.appVersion);
          var majorVersion = parseInt(navigator.appVersion,10);
          var nameOffset,verOffset,ix;

          // In Opera, the true version is after "Opera" or after "Version"
          if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
            $scope.browserName = "Opera";
            fullVersion = nAgt.substring(verOffset+6);
            if ((verOffset=nAgt.indexOf("Version"))!=-1)
              fullVersion = nAgt.substring(verOffset+8);
          }
          // In MSIE, the true version is after "MSIE" in userAgent
          else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
            $scope.browserName = "IE";
            fullVersion = nAgt.substring(verOffset+5);
          }
          // In Chrome, the true version is after "Chrome"
          else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
            $scope.browserName = "Chrome";
            fullVersion = nAgt.substring(verOffset+7);
          }
          // In Safari, the true version is after "Safari" or after "Version"
          else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
            $scope.browserName = "Safari";
            fullVersion = nAgt.substring(verOffset+7);
            if ((verOffset=nAgt.indexOf("Version"))!=-1)
              fullVersion = nAgt.substring(verOffset+8);
          }
          // In Firefox, the true version is after "Firefox"
          else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
            $scope.browserName = "Firefox";
            fullVersion = nAgt.substring(verOffset+8);
          }
          // In most other browsers, "name/version" is at the end of userAgent
          else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) <
              (verOffset=nAgt.lastIndexOf('/')) )
          {
            $scope.browserName = nAgt.substring(nameOffset,verOffset);
            fullVersion = nAgt.substring(verOffset+1);
            if (browserName.toLowerCase()==browserName.toUpperCase()) {
              $scope.browserName = navigator.appName;
            }
          }
          // trim the fullVersion string at semicolon/space if present
          if ((ix=fullVersion.indexOf(";"))!=-1)
            fullVersion=fullVersion.substring(0,ix);
          if ((ix=fullVersion.indexOf(" "))!=-1)
            fullVersion=fullVersion.substring(0,ix);

          majorVersion = parseInt(''+fullVersion,10);
          if (isNaN(majorVersion)) {
            fullVersion  = ''+parseFloat(navigator.appVersion);
            majorVersion = parseInt(navigator.appVersion,10);
          }

          $('body').addClass($scope.browserName + ' ' + $scope.browserName + '-' + majorVersion);
        }

        $scope.startVideo = function() {
          checkBrowsers();
          if($scope.isSafari || $scope.browserName == "Safari") {
                alert('Oh oh looks like you\'re using Safari! Use Chrome or Firefox to record a video using your webcam.')
            }else{
                 fileUploadService.startVideo($scope);
            }
        }

        //Drag and drop function
        $scope.ondragoverout_image = false;
        $scope.ondragover_image = true;

        document.dropVideoModalNew = function(ev) {
            ev.preventDefault();
            $scope.ondragoverout_image = false;
            $scope.ondragover_image = true;
            $scope.video_uploader('', ev);
        }

        document.allowDrop = function(ev) {
            ev.preventDefault();
            $scope.ondragoverout_image = true;
            $scope.ondragover_image = false;
        }

        document.leaveIt = function(ev) {
            $scope.ondragoverout_image = false;
            $scope.ondragover_image = true;
        }


        $('#video_upload_modal_new').change(function() {
            $scope.video_uploader('video_upload_modal_new');
        })

        //Upload video to azure using the file upload
        $scope.video_uploader = function(file_elm, evt) {
            console.log('uploading stuff')
            fileUploadService.video_upload($scope, file_elm, evt, 'redo_video', guid);
        }

        //Upload video to azure using video recorder
        $scope.saveVideo = function() {
            fileUploadService.saveVideo($scope, 'redo_video', guid);
        }
        
                
                   
              
             
    }]);
}());




    