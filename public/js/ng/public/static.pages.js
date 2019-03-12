(function () {
    'use strict';
    var app = angular.module('app');
    var base_url = $('body').data('base_url');

    // FAQ Page
    $('.openFilter1, .openFilter7, .openFilter2, .openFilter3, .openFilter4, .openFilter5, .openFilter6, .openFilter8, .openFilter9').click(function () {
        var o = $(this);

        $("#" + o.attr('data-target')).slideToggle("normal", function () {
            var caretButton = o.find('small');
            if (caretButton.hasClass('fa-angle-down')) {
                caretButton.removeClass('fa-angle-down');
                caretButton.addClass('fa-angle-up');
            } else {
                caretButton.removeClass('fa-angle-up');
                caretButton.addClass('fa-angle-down');

            }
        });
    });

    app.controller('ContactUsController', ['GlobalConstant', '$scope', '$http', function (GlobalConstant, $scope, $http) {

        $scope.submitContactUs = () => {
            var formData = $('#contactUsForm').serializeArray();
            var oData = {};
            angular.forEach(formData, (v, k) => {
                oData[v.name] = v.value;
            })

            $scope.emailSent = false;
            $scope.submit = true;

            $http({
                method: 'POST',
                url: window.location.origin + '/api/contact-us',
                data: oData,
            }).then(response => {
                if (response.status === 200) {
                    $('#contactUsForm').find('input:text').val("");
                    $('#email_address').removeClass('ng-touched');
                    $('#email_address').val("");
                    $('#subject').removeClass('ng-touched');
                    $('#contactUsForm').find('textarea').val("");
                    $('#contactUsForm').find('select option:first').attr('selected', 'selected');
                    $scope.emailSent = true;
                    $scope.submit = false;
                    $scope.loader = false;
                }
            }, (response) => {
                console.log('Error Occurred');
            })
        }

        $scope.submitHarmfulComm = () => {
            var formData = $('#harmfulForm').serializeArray();
            var oData = {};
            angular.forEach(formData, (v, k) => {
                oData[v.name] = v.value;
            })

            $scope.emailSent = false;
            $scope.submit = true;

            $http({
                method: 'POST',
                url: window.location.origin + '/api/harmful-complaint',
                data: oData,
            }).then(response => {
                if (response.status === 200) {
                    $('#harmfulForm').find('input:text').val("");
                    $('#harmfulForm').find('textarea').val("");
                    $('#email_address').removeClass('ng-touched');
                    $("#user_consent").attr('checked', false);
                    $('#email_address').val("");
                    $('#harmfulForm').find('select option:first').attr('selected', 'selected');
                    $scope.emailSent = true;
                    $scope.submit = false;
                    $scope.loader = false;
                }
            }, (response) => {
                console.log('Error Occurred');
            })
        }

        $scope.submitted = false;
        $scope.submitCornerStore = function () {
            var formData = $('#contactUsForm').serializeArray();
            var oData = {
                data: {}
            };
            angular.forEach(formData, function (v, k) {
                oData.data[v.name] = v.value;
            })

            $http({
                method: 'post',
                url: GlobalConstant.APIRoot + 'static/user-form/cornerstore_professional_videos',
                data: oData,

            }).then(function (response) {
                $scope.submitted = true;
                $('#contactUsForm').find('input').val("")
                $('#contactUsForm').find('textarea').val("")
                $('#contactUsForm').find('select option:first').attr('selected', 'selected')
            }, function (response) {
                alert('error')
            })
            console.log($scope.submitted)
        }
    }]);


    app.controller('FeaturesBenefitController', ['GlobalConstant', '$scope', '$http', '$location', function (GlobalConstant, $scope, $http, $location) {

        /*
        Open tab on page reload based on url path
        */
        $scope.activaTab = function (tab) {
            angular.element($('#TabberNavs a.' + tab)).tab('show');
        };


        var path = $location.path().substr(1);

        switch (path) {
            case 'employers':
                var activate = 'tabnav1'
                break;
            case 'candidates':
                var activate = 'tabnav2'
                break;
            default:
                var activate = 'tabnav1'
        }

        $scope.activaTab(activate);


        $scope.EmployerNav = [{
                "text": "Pre-Application Assessment",
                "val": "Pre-Application Assessment"
            },
            {
                "text": "Video",
                "val": "Video"
            },
            {
                "text": "Profile",
                "val": "Profile"
            },
            {
                "text": "TMS",
                "val": "TMS"
            },
            {
                "text": "Dashboards",
                "val": "Dashboards"
            },
            {
                "text": "Messaging",
                "val": "Messaging"
            },
            {
                "text": "Social Media Sharing",
                "val": "Social Media Sharing"
            },
            {
                "text": "Data insights",
                "val": "Data insights"
            },
            {
                "text": "Teams",
                "val": "Teams"
            },
            {
                "text": "Pricing",
                "val": "Pricing"
            },
        ];


        $scope.CandidateNav = [{
                "text": "Video",
                "val": "Video"
            },
            {
                "text": "Dashboard",
                "val": "Dashboard"
            },
            {
                "text": "Analytics",
                "val": "Analytics"
            },
            {
                "text": "Job Pairing",
                "val": "Job Pairing"
            },
            {
                "text": "Messaging and notifications",
                "val": "Messaging and notifications"
            },
            {
                "text": "Privacy",
                "val": "Privacy"
            },
            {
                "text": "Pricing",
                "val": "Pricing"
            },
        ];



        $scope.batchEmployer = Math.ceil($scope.EmployerNav.length / 7);

        $scope.employerby7items = []
        var x = 0;
        while (x < $scope.batchEmployer) {

            if (x != 0) {
                var startthis = x * 7;
            } else {
                var startthis = x;
            }
            $scope.employerby7items.push({
                start: startthis,
                end: (x + 1) * 7
            })

            x++;
        }

        //Add fix position
        angular.element($(window)).scroll(function () {
            var navOffset = angular.element($('.contentfeatures.active')).offset();
            var windowOffset = angular.element($(window)).scrollTop();

            if (windowOffset >= navOffset.top) {

                angular.element($('.contentfeatures.active .FeatureContentNavSlider')).addClass('fixthisnav');
                angular.element($('.contentfeatures.active .MainContentFeatureContainer')).css('padding-top', '85px')

                if (windowOffset >= navOffset.top + 20) {
                    angular.element($('.contentfeatures.active .MainContentFeatureContainer')).addClass('fixanimate')
                }

                angular.element('.backtoTop').show()

            } else {
                angular.element($('.contentfeatures.active .FeatureContentNavSlider')).removeClass('fixthisnav');
                angular.element($('.contentfeatures.active .MainContentFeatureContainer')).css('padding-top', '0')
                angular.element($('.contentfeatures.active .MainContentFeatureContainer')).removeClass('fixanimate');

                angular.element('.backtoTop').hide()
            }


        });


    }]);

}());

$(document).ready(function () {

    // Terms and conditions page
    if ($('body').hasClass('terms-and-conditions')) {

        $('#user_agreement').click(function () {
            $('.openFilter1').click()
        })

    }

    // About Us
    if ($('#about_video').length) {

        var myPlayer = amp('about_video', {
            "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
            "nativeControlsForTouch": false,
            autoplay: true,
            controls: true,
            width: "498",
            height: "280",
            logo: {
                "enabled": false
            },
            poster: ""
        });

        myPlayer.src([{
            // src: 'https://pvmlive.streaming.mediaservices.windows.net/e58e3f83-0904-4886-836e-ac28303831fe/INTRO VID.ism/manifest',
            src: 'https://518761399c1a4eb19173af408d10c8d6.azureedge.net/d094ce61-de38-4620-89bf-146d79233936/Preview Me_FINAL.ism/manifest',
            type: "application/vnd.ms-sstr+xml"
        }]);

    }


    $('.slideme').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 64 //  -64 is for the fix for sticky nav
                }, 1000);

                return false;
            }
        }
    });

    //back to top

    $('.backtoTop').click(function (e) {
        e.preventDefault();
        console.log('clicked')
        $('html, body').animate({
            scrollTop: 0
        }, 1500)
    })


    //bootstrap Custom slider
    var handle_nav = function (e) {

        e.preventDefault();

        var target = $(this).data('target');

        if ($(this).hasClass('left')) {
            $(target).carousel("prev");
        }

        if ($(this).hasClass('right')) {

            $(target).carousel("next");
        }
    }

    var infinite_hack = function (e) {

        var $this = $(this);
        var getitems = $this.find('.item');
        console.log(getitems.last().hasClass('active'))

        if (getitems.last().hasClass('active')) {
            var right = $this.find('.right');
            right.bind('click', function () {

                //getitems.last().removeClass('active');
                //getitems.first().addClass('active');
                console.log($(this).parent())
                $(this).parent().carousel(0);


            });
            return false
        } else {
            var right = $this.find('.right');
            right.unbind('click')
        }
    }

    $('.carouselthis').carousel({
            interval: false,
            wrap: false
        })
        .on('click', '.carousel-control', handle_nav)
        .on('slid.bs.carousel', infinite_hack)

});
