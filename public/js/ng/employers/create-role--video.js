! function() {
  "use strict";
  var e = angular.module("app");
  $("body").data("base_url");
  e.controller("CreateRoleVideo", ["GlobalConstant", "$scope", "$window", "$http", "$cookies", "$filter", "$timeout", "$compile", "fileUploadService", "EmployerRoleHttp", function(e, o, a, t, i, r, s, d, n, l) {
      function p(a) {
          t.get(e.APIRoot + "video/" + a + "/status").then(function(e) {
              console.log("Vid progress: ", e.data.data), o.video_status = e.data.data.video_status, "processing_completed" != e.data.data.video_status ? (o.encoding_progress = e.data.data.encoding_progress ? e.data.data.encoding_progress : 0, o.encoding_job_status = e.data.data.encoding_job_status ? e.data.data.encoding_job_status : "Ready for encoding", p(a)) : (o.VideoStatus = "", o.renderVideo(e.data.data.streaming_url, "vid1"))
          })
      }

      function g() {
          var e = (navigator.appVersion, navigator.userAgent);
          o.browserName = navigator.appName;
          var a, t, i, r = "" + parseFloat(navigator.appVersion),
              s = parseInt(navigator.appVersion, 10); - 1 != (t = e.indexOf("Opera")) ? (o.browserName = "Opera", r = e.substring(t + 6), -1 != (t = e.indexOf("Version")) && (r = e.substring(t + 8))) : -1 != (t = e.indexOf("MSIE")) ? (o.browserName = "IE", r = e.substring(t + 5)) : -1 != (t = e.indexOf("Chrome")) ? (o.browserName = "Chrome", r = e.substring(t + 7)) : -1 != (t = e.indexOf("Safari")) ? (o.browserName = "Safari", r = e.substring(t + 7), -1 != (t = e.indexOf("Version")) && (r = e.substring(t + 8))) : -1 != (t = e.indexOf("Firefox")) ? (o.browserName = "Firefox", r = e.substring(t + 8)) : (a = e.lastIndexOf(" ") + 1) < (t = e.lastIndexOf("/")) && (o.browserName = e.substring(a, t), r = e.substring(t + 1), browserName.toLowerCase() == browserName.toUpperCase() && (o.browserName = navigator.appName)), -1 != (i = r.indexOf(";")) && (r = r.substring(0, i)), -1 != (i = r.indexOf(" ")) && (r = r.substring(0, i)), s = parseInt("" + r, 10), isNaN(s) && (r = "" + parseFloat(navigator.appVersion), s = parseInt(navigator.appVersion, 10)), $("body").addClass(o.browserName + " " + o.browserName + "-" + s)
      }
      o.role_create_tab_loader = 1;
      var u;
      o.$on("$destroy", function() {
          u.dispose()
      }), o.encoding_progress = 0, o.encoding_job_status = "", o.video_status = "";
      var c = i.get("icebreakerguid");
      o.roleId = o.$parent.$parent.objURL.id, o.roleId || (o.roleId = i.get("jobObjectId")), o.$watch("guid_response_profile", function(e, a) {
          e && (u && u.dispose(), o.VideoStatus = "uploading", p(e))
      }), o.renderVideo = function(e, o) {
          console.log("render video: ", e);
          var a = '<video id="' + o + '" class="azuremediaplayer amp-default-skin" height="500">';
          a += '<p class="amp-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p>', a += "</video>", $("#role_video_container").html(a), u = amp(o, {
              techOrder: ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
              nativeControlsForTouch: !1,
              autoplay: !1,
              controls: !0,
              width: "100%",
              logo: {
                  enabled: !1
              },
              poster: ""
          }, function() {}), u.src([{
              src: e,
              type: "application/vnd.ms-sstr+xml"
          }])
      }, o.showVideoTop = !1, o.showVideoLoding = !1, o.VideoStatus = "nothing", o.Init_jobdetails_get = function() {
          l.getData(o.roleId).then(function(e) {
              o.meta_video = e.job_meta, e && (o.role_create_tab_loader = 0), console.log("JOB DETAILS INIT ", o.meta_video), o.showVideoLoding = !0, o.VideoStatus = "", o.meta_video.job_video_url && 0 != o.meta_video.job_video_url && "" != o.meta_video.job_video_url ? (console.log("Video 1"), o.renderVideo(o.meta_video.job_video_url, "vid1"), o.showVideoTop = !0, o.showVideoLoding = !1, o.VideoStatus = "") : o.meta_video.job_video_url ? 0 == o.meta_video.job_video_url ? (console.log("Video 2"), o.VideoStatus = "uploading", o.showVideoTop = !1, o.showVideoLoding = !1, p(c)) : (console.log("Video 3"), o.showVideoTop = !1, o.showVideoLoding = !0, o.VideoStatus = "") : (console.log("NOTHING"), o.VideoStatus = "nothing", o.showVideoTop = !1, o.showVideoLoding = !1), console.log("myPlayer: ", u)
          })
      }, o.Init_jobdetails_get(), o.modal_percent = !0, o.showVideo = !1, o.openVideoModal = function() {
          $("#pmvCameraModalNew").modal("show"), o.$parent.$parent.sectionsHideShow(0, 1)
      }, o.startVideo = function() {
          if (o.$parent.$parent.sectionsHideShow(1, 0), g(), o.isSafari || "Safari" == o.browserName) alert("Oh oh this feature is not yet supported by your browser. Drag and drop a video file instead, or use Chrome, Firefox or Microsoft Edge to record a video using your webcam.");
          else {
              n.startVideo(o) && o.Init_jobdetails_get()
          }
      }
  }])
}();