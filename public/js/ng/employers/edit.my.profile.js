(function() {
    'use strict';
    var app = angular.module('app');
    var base_url = $('body').data('base_url');

    app.controller('EmployerMyAccount', ['GlobalConstant', 'fileUploadService', '$scope', '$cookies', '$window', '$http', '$filter', '$timeout', '$location',
        function(GlobalConstant, fileUploadService, $scope, $cookies, $window, $http, $filter, $timeout, $location) {

            $scope.token = $cookies.get('token');
            $scope.contentloader = true;
            $scope.base_url = base_url;


            // Video/Image Modal buttons
            $scope.record_btn = false;
            $scope.record_again_btn = false;
            $scope.stop_btn = false;
            $scope.save_btn = false;
            $scope.change_btn = false;
            // Video/Image Modal Sections
            $scope.showSection1 = false;
            $scope.showSection2 = true;
            $scope.modal_percent = true;
            // Modal drag drop images
            $scope.ondragoverout_image = false;
            $scope.ondragover_image = true;

            $scope.crop_data = {
                w: 240,
                h: 240,
                x: 80,
                y: 0
            };




            // Get Employer Profile
            $scope.params = {
                access_token: $scope.token
            };
            $scope.employerdata = [];
            $http({
                method: 'GET',
                params: $scope.params,
                url: GlobalConstant.APIRoot + 'employer/profile'
            }).then(function(response) {
                var data = response.data.data;
                $scope.employerdata = data;
                // console.log('data')                
                console.log(data)
                $scope.profile_image = data.profile_picture_url;
                $scope.first_name = data.first_name;
                $scope.last_name = data.last_name;
                $scope.nickname = data.nickname;
                $scope.last_name = data.last_name;
                $scope.phone_number = data.phone_number;
                $scope.phone_extension = data.phone_extension;
                $scope.mobile_number = data.mobile_number;
                $scope.work_title = data.work_title;
                $scope.work_dept = data.work_dept;
                $scope.azure_container_key = data.azure_container_key;
                $scope.email = 'Static email';
                if(!$cookies.get('obkey')){
                     $cookies.put('obkey', $scope.azure_container_key, {'path': '/'});
                }
                

            });


            $scope.updateUserName = function() {
                var formData = {
                    "data": {
                        first_name: $scope.first_name,
                        last_name: $scope.last_name,
                        nickname: $scope.nickname
                    }
                };
                UpdateUser(formData);
            }

            $scope.updatePhone = function() {
                  var formData = {
                    "data": {
                        phone_number: $scope.phone_number,
                        phone_extension: $scope.phone_extension
                    }
                };

                UpdateUser(formData);
            }

            var UpdateUser = function(formData) {

                $http({
                        url: GlobalConstant.EmployerProfileApi + '?access_token=' + $scope.token,
                        method: 'put',
                        data: formData,
                        headers: {
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(function(response) {
                        alert('update success')
                    }, function(response) {
                        //Error Condition
                        console.log(response);
                        alert('some error');
                    });

            }

            $scope.updateUser = function() {

                var field = this.$editable.name;
                var formData = '{"data": {"' + field + '" : "' + this.$data + '"}}';
                formData = JSON.parse(formData);
                UpdateUser(formData);

            }

            $scope.buttonsHideShow = function(a,b,c,d,e) {
                $scope.record_btn = a;
                $scope.record_again_btn = b;
                $scope.stop_btn = c;
                $scope.save_btn = d;
                $scope.change_btn = e;
            }

            $scope.sectionsHideShow = function(a,b) {
                $scope.showSection1 = a;
                $scope.showSection2 = b;
            }




              // camera modal on close event, force webcam to close if open
            $('#pmvCameraModal, #pmvCameraModalNew, #pmvImageModalNew').on('hidden.bs.modal', function() {

                if (window.stream) {
                    stream.stop();
                    window.stream = "";
                }


                $scope.buttonsHideShow(false,false,false,false,false);
                $scope.sectionsHideShow(false,true);
                // hide percentage
                $scope.modal_percent = true;
                // reset preview video
                $('#preview_new').attr('src', '');
                $('#preview_img_new').attr('src', '');
            })



        /* Image Uploading and Capture */
         var preview_img_new = document.getElementById('preview_img_new');

         $scope.startVideoImage = function() {

            $scope.sectionsHideShow(true,false);
            // $scope.buttonsHideShow(true,true,true,false,false);
             $scope.buttonsHideShow(false,true,true,true,true)
           
            if ($('#preview_img_new').attr('src')) {
                $('#preview_img_new').attr('src', '');
                window.stream = '';
            }

            !window.stream && navigator.getUserMedia({
                audio: false,
                video: true
            }, function(stream) {
                window.stream = stream;

                preview_img_new.src = window.URL.createObjectURL(stream);
                preview_img_new.play();

            }, function(error) {
                alert(JSON.stringify(error, null, '\t'));
            });

            

        }

        // $scope.take_photo = function() {

        //     var errorCallback = function(e) {
        //         console.log('Reeeejected!', e);
        //       };

        //       // Not showing vendor prefixes.
        //      navigator.getUserMedia  = navigator.getUserMedia ||
        //                               navigator.mediaDevices.getUserMedia ||
        //                               navigator.webkitGetUserMedia ||
        //                               navigator.mozGetUserMedia ||
        //                               navigator.msGetUserMedia;

        //     var video = document.querySelector('#preview_img_new');
        //     // alert(video.videoHeight)
        //     // alert(video.videoWidth)

        //     var canvas = document.querySelector('#my_canvas');
        //     var ctx = canvas.getContext('2d');
        //     var localMediaStream = null;

        //     canvas.width = 320;
        //     canvas.height = 240;

        //     var snapshot = function() {

        //           ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        //           // "image/png" works in Chrome.
        //           // $('#image_preview').attr('src', canvas.toDataURL('image/png'));
        //           $('#preview_img_new').attr('src', "");
        //           $('#preview_img_new').attr('poster', canvas.toDataURL('image/png'));
        //           // $scope.base64Image = canvas.toDataURL('image/png');

        //           $scope.record_btn = true;
        //           $scope.record_again_btn = false;
        //           $scope.save_btn = false;

        //           if (window.stream) {
        //             stream.stop();
        //             window.stream = "";
        //         }


        //     }

        //     snapshot();

        // }

        $scope.take_photo = function() {
            fileUploadService.take_photo($scope);
        }

        $scope.take_photo_again = function() {
             window.stream = '';
           $scope.startVideoImage();
        }

        $scope.change = function() {

            // $scope.hidePreview();
            $scope.sectionsHideShow(false,true);
             $scope.buttonsHideShow(false,false,false,false,false);

             if ($('#preview_new').attr('data-old_file')) {
                var filename = $('#preview_new').attr('data-old_file');
                var folder = $('#preview_new').attr('data-file_folder');
                $scope.delete_old_file(filename, folder);

            }else if($('#preview_img_new').attr('data-old_file')){
                 var filename = $('#preview_img_new').attr('data-old_file');
                var folder = $('#preview_img_new').attr('data-file_folder');
                $scope.delete_old_file(filename, folder);
            }


        }

        // $scope.save_photo = function() {

        //     if($('#preview_img_new').attr('poster')){

        //         var filename_path = $('#preview_img_new').attr('poster');
        //         var ext = filename_path.split('.').pop();
        //             ext = ext.toLowerCase();
        //         var imgArr = ['jpg','png','gif'];
        //         var filename = filename_path.split('/').pop();

            
        //         // Image File upload
        //        if(imgArr.indexOf(ext) != -1){

        //          $.ajax({ 
        //             type: "POST", 
        //             // url: GlobalConstant.EmployerController + '/upload_to_cloud',
        //             url: GlobalConstant.FileUploadUrl + '/upload_to_cloud',
        //             dataType: 'json',
        //             data: {
        //                filename : filename,
        //                obkey : $scope.azure_container_key,
        //                folder : 'image' 
        //             },
        //             beforeSend : function() {
        //                 alert('Profile image saved. Please wait a few moment to update.')
        //                 $('#pmvImageModalNew').modal('hide');
        //             },
        //             success : function(data) {
        //                 if(data){
                         
        //                   if(data.response == 200) {
                          
        //                     $scope.profile_image = data.url;
        //                     $('#top_profile_image img').attr('src', data.url);

        //                   }
        //                 }
        //             }
        //         });


        //          // Image taken from user's web camera
        //        }else{

        //           $.ajax({ 
        //             type: "POST", 
        //             // url: GlobalConstant.EmployerController + '/take_photo_submit?ob_key=' + $scope.azure_container_key,
        //             url: GlobalConstant.FileUploadUrl + '/take_photo_submit?ob_key=' + $scope.azure_container_key,
        //             dataType: 'text',
        //             data: {
        //                 base64data : $('#preview_img_new').attr('poster')
        //             },
        //             beforeSend : function() {
        //                 alert('Profile image saved. Please wait a few moment to update.')
        //                 $('#pmvImageModalNew').modal('hide');
        //             },
        //             success : function(data) {
                      
        //                 if(data){
        //                    var data = JSON.parse(data);
        //                   if(data.response == 200) {
                         
        //                     $scope.profile_image = data.url;
        //                     $('#top_profile_image img').attr('src', data.url);

        //                   }
        //                 }
        //             }
        //         });

        //        }

              
        //     }

        // }

        var selectAreaToCrop = function(c) {
            // console.log(c);
            $scope.crop_data = c;
        }

         $scope.save_photo = function() {
            $scope.url_type = 'profile_picture_url';

            fileUploadService.save_photo($scope);
        }

         $scope.new_image_upload_modal = function(evt) {

            var fileField = document.getElementById("image_upload_modal_new");
            var file_data = fileField.files[0];
            // drag drop
            if (evt) {
                file_data = evt.dataTransfer.files[0];
            }

            // delete old file if exists
            if($('#image_save').attr('data-filename')){
                var filename = $('#image_save').attr('data-filename');
                var folder = $('#image_save').attr('data-folder');
                $scope.delete_old_file(filename,folder);
            }
           
           
            var allowed_files = ['png', 'jpg', 'gif'];
            var filename = file_data.name;
            var last_dot = filename.lastIndexOf('.');
            var file_folder = 'image';
            var ext = filename.substr(last_dot + 1).toLowerCase();
            if (allowed_files.indexOf(ext) == -1) {
                alert('Invalid file must be .png, jpg. .gif extension');
                return false;
            }
            var ob_key = $scope.azure_container_key;
            var form_data = new FormData();
            form_data.append('file', file_data);
            var params = '?ob_key=' + ob_key + '&file_folder=' + file_folder;
            $scope.modal_file_percent_value = 0;

            $.ajax({
                // url: GlobalConstant.EmployerController + '/upload_image_submit' + params,
                url: GlobalConstant.FileUploadUrl + '/upload_submit' + params,
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(res) {
                    res = JSON.parse(res);
                    console.log(res);
                    if (res.response == 200) {
                         
                        fileField.value = '';
                        // hide percent image
                        $scope.modal_percent = true;

                        $('#preview_img_new').attr('poster', 'assets/Uploads/Image/'+res.filename)
                        $('#preview_img_new').attr('data-old_file', res.filename);
                        $('#preview_img_new').attr('data-file_folder', 'image');

                        $scope.sectionsHideShow(true,false);
                        $scope.buttonsHideShow(true,true,true,false,false);


                        $('#preview_img_new').Jcrop({
                         aspectRatio : 1/1,
                         setSelected : [20,20,250,220],
                         onChange : selectAreaToCrop,
                         minSize : [150,150]

                        });

                        $('#preview_img_newRE').Jcrop({
                             aspectRatio : 1/1,
                             setSelected : [20,20,250,220],
                             onChange : selectAreaToCrop,
                             minSize : [150,150]

                        });


                    }
                },
                beforeSend: function() {
                    $scope.modal_percent_value = 0;

                    // show percent image
                    $scope.modal_percent = false;

                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            $scope.modal_percent_value = Math.ceil((evt.loaded / evt.total) * 100);
                        }
                    }, false);

                    return xhr;
                },


            });
        }


         $('#image_upload_modal_new').change(function() {
            $scope.new_image_upload_modal();
        });

          document.dropImageModalNew = function(ev) {
             ev.preventDefault();
             $scope.new_image_upload_modal(ev);
        }

        /*** end Image Uploading and Capture  */



        } // end controller function
    ]); // end controller EmployerMyAccount




}());