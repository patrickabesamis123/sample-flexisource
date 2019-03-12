// require('../../bootstrap');
// window.Vue = require('vue');

import Vue from 'vue';

var app = new Vue({
    el: '#role-app',
    data: {
      hide: true,
      showEduc: false,
      editEduc: false,
      showWork: false,
      editWork: false,
      showRef: false,
      editRef: false,
      scrolled: false
    }, 
    
    mounted() {

      // $("#file-upload").change(function(){
      //   $("#file-name").text(this.files[0].name);
      // });

      

      window.onscroll = function() {stickyHeader()};

      var header = document.getElementById("scrolled");
      var sticky = header.offsetTop;

      function stickyHeader() {
        if (window.pageYOffset > sticky) {
          header.classList.add("sticky");
        } else {
          header.classList.remove("sticky");
        }
      }
      
      document.getElementById("file-upload").onchange = function() {
        document.getElementById("uploadFile").value = this.value;
      };

      $('.mydatepicker').datetimepicker({
          timepicker: false,
          format: 'd-m-Y'
      });
    },

    methods: {
      toggle () {
        this.isActive = !this.isActive;
      },
      handleScroll () {
        this.scrolled = window.scrollY > 400;      
      } 
    },

    created () {
      window.addEventListener('scroll', this.handleScroll);
    },
    destroyed () {
          window.removeEventListener('scroll', this.handleScroll);
    },
});
