import Vue from 'vue';

const Form = new Vue({
	el: '#Form',
    data: {
      first_name: '',
      last_name: '',
      email: '',
      first_password: '',
      second_password: '',
      user_type: ''
    },
    methods:{
      checkForm: function (e) {
        e.preventDefault();
        if (this.first_name === '') {
              alert('First name required!');
        } else if (this.last_name === '') {
              alert('Last name required!');
        } else if (this.email === '') {
              alert('Email required!');
        } else if (this.first_password === '') {
              alert('Password required!');
        } else if (this.second_password === '') {
              alert('Password confirmation required!');
        } else if (this.second_password != this.first_password) {
              alert('Passwords do not match!');
        } else {
        	axios({method: 'post', data: {first_name: this.first_name, last_name: this.last_name, email: this.email, password: this.first_password, user_type: this.user_type}, url: '/api/register'})
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