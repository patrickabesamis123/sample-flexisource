
(function() {
  'use strict';
  var app = angular.module('app');
  var base_url = $('body').data('base_url');

  app.controller('CandidateSidebar', ['GlobalConstant', '$scope', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile',
  function (GlobalConstant, $scope, $window, $http, $cookies, $filter, $timeout, $compile) {


    $scope.stickHeader = function() {

    var candidateNav = document.getElementById('CandidateSidebar');
    var candidateNavSticky = candidateNav.offsetTop;
    var windowWidth = window.outerWidth;
/*
    console.log("pageYOffset ", window.pageYOffset)
    console.log("doc offsetHeight " + document.body.offsetHeight, document.body.offsetHeight - 1174)
    console.log("doc height, scroll pos +309", document.body.offsetHeight - (window.pageYOffset + 309))
    console.log("innerHeight", window.innerHeight)
    console.log("sticky position", candidateNavSticky)
    console.log("window height", window.outerWidth)*/


      if(window.pageYOffset > candidateNavSticky) {
        document.querySelector('#CandidateSidebar').classList.add('pvm-side-nav--fixed');

        if(windowWidth > 1680) {
          var newMainWidth = (windowWidth - 1680) / 2,
          element = document.getElementById('CandidateSidebar');
          element.style.left = ((newMainWidth+15)+100) + "px";
        }
      } else {
        document.querySelector('#CandidateSidebar').classList.remove('pvm-side-nav--fixed');
        document.querySelector('#CandidateSidebar').classList.remove('pvm-side-nav--fixed-btm');
        //console.log("yes")
      }

      if(window.innerHeight < (document.body.offsetHeight - (window.pageYOffset + 300))) {
        document.querySelector('#CandidateSidebar').classList.add('pvm-side-nav--fixed');
        document.querySelector('#CandidateSidebar').classList.remove('pvm-side-nav--fixed-btm');

        if(window.pageYOffset <= 102 && candidateNavSticky == 0) { //mobile
          document.querySelector('#CandidateSidebar').classList.remove('pvm-side-nav--fixed');
        }
        //console.log("no")

        if(window.pageYOffset < candidateNavSticky) {
          document.querySelector('#CandidateSidebar').classList.remove('pvm-side-nav--fixed');
        }

      } else {
        if(windowWidth > 768) {
          document.querySelector('#CandidateSidebar').classList.add('pvm-side-nav--fixed-btm');
        }
      }
    }

    window.onscroll = function() { $scope.stickHeader();  }

     //stickHeader();
   }]);
}());