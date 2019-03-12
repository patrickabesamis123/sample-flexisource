import Vue from 'vue';

const Form_forgot = new Vue({
	el: '#Form_forgot',
    data: {
      email: ''
    },
    methods:{
      checkForm: function (e) {
        e.preventDefault();
        if (this.email === '') {
              alert('Email required!');
        } else {
        	axios({method: 'post', data: {email: this.email}, url: '/api/forgot'})
        	.then(res => {
	            if (res.data.success == false) {
	              alert(res.data.error);
	            } else {
	              window.location.href = "/login"
	            }
	        })
        	.catch(function (error) {
		    if (error.response) {
		      alert(error.response.data.error);
		    }});
        }
      }
    }
  });