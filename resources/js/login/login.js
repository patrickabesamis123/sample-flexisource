import Vue from 'vue';

const Form_LoginForm = new Vue({
	el: '#Form_LoginForm',
    data: {
      email: '',
      password: ''
    },
    methods:{
      checkForm: function (e) {
        e.preventDefault();
        if (this.email === '') {
              alert('email required!');
        } else if (this.password === '') {
              alert('password required!');
        } else {
        	axios({method: 'post', data: {email: this.email, password: this.password}, url: '/api/login'})
        	.then(res => {
	            if (res.data.success == false) {
	              alert(res.data.error);
	            } else {
	            	var now = new Date();
	            	now.setTime(now.getTime() + 1 * 3600 * 1000);
					document.cookie = "api_token=" + res.data.data.token;
					// Sets the Cookie Expiration Time to 1 Hour same as JWT Token on the Backend
					document.cookie = "expires=" + now.toUTCString() + ";"
	              // redirect to a new URL, or do something on success
	              window.location.href = "/dashboard"
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