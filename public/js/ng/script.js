function commaSeparateNumber(val){
    while (/(\d+)(\d{3})/.test(val.toString())){
      val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }
    return val;
  }


$(document).ready(function (){

	//Validate Password 
		var password = $("#Form_first_password") ; 
		var confirm_password = $("#Form_second_password");

		function validatePassword(){
		  if(password.val() != confirm_password.val()) {
		    confirm_password.get(0).setCustomValidity("Passwords Don't Match");
		    confirm_password.addClass('not-match');
		    password.addClass('not-match');
		  } else {
		    confirm_password.get(0).setCustomValidity('');
		    confirm_password.removeClass('not-match');
		    password.removeClass('not-match');
		  }
		}

		password.on('change', function () {
			return validatePassword()	;
		});

		confirm_password.on('change', function () {
			return validatePassword()	;
		});
	//Validate Password END
	//Register Page
		$('input[type=radio][name=user_type]').change(function() {
	        if (this.value == 'candidate') {
	            $('#Register .action').val('Sign up as a candidate');
	            $('#Register .action').removeClass('submitblue whitetext');
	            $('#Register .action').addClass('submityellow');
	            
	            $('form#Form').addClass('gtm-signup-candidate')
	            $('form#Form').removeClass('gtm-signup-employer')
	        }
	        else if (this.value == 'employer') {
	            $('#Register .action').val('Sign up as an employer');
	            $('#Register .action').addClass('submitblue whitetext');
	            $('#Register .action').removeClass('submityellow');

	            $('form#Form').addClass('gtm-signup-employer')
	            $('form#Form').removeClass('gtm-signup-candidate')
	        }
	    });
    //Register Page End

    //Header 

  //   	$(".notificationLink").on('click',function(){
		// 	$(".notificationContainer.notif").fadeToggle(300);

		// 	if ($(".notificationContainer.message").is(':visible')) {
		// 		$(".notificationContainer.message").hide();
		// 	}else if($(".notificationContainer.setting").is(':visible')){
		// 		$(".notificationContainer.setting").hide();
		// 	}

		// 	// $(".notification_count.notif").fadeOut("slow");
		// 	return false;
		// });


		// $(".messageLink").on('click',function(){
		// 	if ($(".notificationContainer.notif").is(':visible')) {
		// 		$(".notificationContainer.notif").hide();
		// 	}else if($(".notificationContainer.setting").is(':visible')){
		// 		$(".notificationContainer.setting").hide();
		// 	}
		// 	$(".notificationContainer.message").fadeToggle(300);


		// 	// $(".notification_count.message").fadeOut("slow");
		// 	return false;
		// });

		$("#pvmSettingsLink").unbind('click');
		$("#pvmSettingsLink").click(function(){
			if ($(".notificationContainer.notif").is(':visible')) {
				$(".notificationContainer.notif").hide();
			}else if ($(".notificationContainer.message").is(':visible')) {
				$(".notificationContainer.message").hide();
			}

			if($("#pvmNotificationSetting").hasClass('let-it-show')) {
				$("#pvmNotificationSetting").removeClass("let-it-show");
			}
			else {
				$("#pvmNotificationSetting").addClass("let-it-show");
			}
			return false;
		});


		//Document Click hiding the popup 
		$(document).click(function(ev){
            $("#pvmNotificationSetting").removeClass("let-it-show");
			// Add New Thread on Employer
			if($.trim(ev.target.text) != 'Add New Thread'){
				$(".addNewTheadContainer").hide();
			}
			
		});

		//Popup on click
		// $(".notificationContainer").click(function(){
		// 	return false;
		// });


		
		if( $('.datepicker').length ){
			$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
		}

		$('.carousel').carousel({
			interval: false,
			wrap: false
		})
    //Header End
	
	//Show Password Plugin
	if($('.showpassword').length){
		$('.showpassword').hideShowPassword({
		  show: false,
		  innerToggle: 'focus',
		  toggle: {
		    className: 'password-toggle'
		  }

		});
	}
	
	
			                


	//Dashboard animate sections
	if ($(".dashsection").length) {
			$(".dashsection").each( function( index ) {
				var getPosition = $(this).position();
				
				if ( getPosition.top  == 0 ) {
					
					//Fadein setion
					$(this).addClass('displaydashsection');

					//PieChart
					$(this).find(".displaychart").each( function( index ) {
						var test = $(this).find('p').text();
						
						 $(this).drawPieChart(
						 	$.parseJSON(test) 
						 	);
						 
					});

					// $('.animateSection').each( function () { //Select each animated sections
					// 	//Animate Numbers
					// 	var NumElem =  $( this ).find('.dash_inc');
					// 	var getValue = NumElem.text() ;
					// 	var parseVal = parseFloat(getValue.replace(',','').replace(' ',''))
					// 	//var StartVal = parseInt ( parseVal - 1000 );
					// 	var StartVal = 0;

					// 	$({someValue: StartVal}).animate({someValue: parseVal}, {
					// 	      duration: 1500,
					// 	      easing:'swing', // can be anything
					// 	      step: function() { // called on every step
					// 	          // Update the element's text with rounded-up value:
					// 	        var n = Math.round(this.someValue); 

					// 		    NumElem.text(commaSeparateNumber( (n < 10) ? ("0" + n) : n ) );
					// 	        return false;
					// 	      }
					// 	});

					// });	

				}
			});
		}


		//Homepage range finder
		if ($("#Homepage").length) {

			//Slider 1
			// $( "#slider-range" ).rangeslider({
			//   defaults: false,
			// });


			var min = $( "#min_salary" ).val( );
			var max = $( "#max_salary" ).val( );

			$('#slider-range .ui-slider-handle:first').addClass('min').html('<div class="valueslider">$'+min+'</div>');
		    $('#slider-range .ui-slider-handle:last').addClass('max').html('<div class="valueslider">$'+max.toString().substring(0, 3) +'K+'+'</div>');

		    $("#min_salary").on('change', function () {
		    	var minValNow =   $('#slider-range .ui-slider-handle:first').attr('aria-valuenow') ;
		    	var minstr = minValNow.toString() ;
		    	//console.log(minstr.length)
		    	switch(minstr.length) {
					    case 4:
					        var minval =  minstr.substring(0, 1)+'K'  ;	
					        break;
					    case 5:
					        var minval =  minstr.substring(0, 2)+'K'  ;	
					        break;
					    case 6:
					        var minval =  minstr.substring(0, 3)+'K'  ;	
					        break;    
					    default:
					    	var minval =  0  ;
					}

		    	$('#slider-range .ui-slider-handle:first').html('<div class="valueslider">$'+minval+'</div>');
		    	$( "#min_salary" ).val( minValNow );

		    });

		    $("#max_salary").on('change', function () {

		    	var maxValNow =   $('#slider-range .ui-slider-handle:last').attr('aria-valuenow') ;
		    	var maxstr = maxValNow.toString() ;
		    	switch(maxstr.length) {
					    case 4:
					        var maxval =  maxstr.substring(0, 1)+'K'  ;	
					        break;
					    case 5:
					        var maxval =  maxstr.substring(0, 2)+'K'  ;	
					        break;
					    case 6:
					        var maxval =  maxstr.substring(0, 3)+'K'  ;	
					        break;    
					    default:
					    	var maxval =  '500K'  ;	
					}  

				$('#slider-range .ui-slider-handle:last').html('<div class="valueslider">$'+maxval+'</div>');
				if(maxval == '200K'){
					$('#slider-range .ui-slider-handle:last').html('<div class="valueslider">$'+maxval+'+</div>');
				}
		    	
		    	$( "#max_salary" ).val( maxValNow );

		    });
		    //Slider 1 END

			//Slider 2
			var exp = $( "#employee_exp" ).val( );

		    $("#employee_exp").on('change', function () {
		    	
		    	var expValNow =   $('#slider-range-employer .ui-slider-handle').attr('aria-valuenow') ;
		    	var expstr = expValNow.toString() ;
		    	 $('#slider-range-employer .ui-slider-handle').html('<div class="valueslider">'+expstr+'</div>');
		    	 $( "#employee_exp" ).val( expValNow );

		    });

			//Open Filter search
		    $('.openFilter').click( function () {
		    	 $( ".FilterContent" ).slideToggle( "slow", function() {
				    // Animation complete.
				  });
		    });

		    // $('.openFilter').click();

		    if ( $('#FilterCandidate').is(':checked') ) {
		    		$('.slideEmployer').removeClass('showme');
		    		$('.slideEmployer').addClass('hideme');
		    		$('.slideCandidate').addClass('showme');
		    		$('.slideCandidate').removeClass('hideme');	
		    		$('#selectCandidate').addClass('activeme');
		    		$('#selectEmployer').removeClass('activeme');	
		    } 

		    $('#selectCandidate').click(function (argument) {
		    	$(this).addClass('activeme');
		    	$('#selectEmployer').removeClass('activeme');
		    	$('#FilterCandidate').prop('checked', true);
		    	$('#FilterEmployer').prop('checked', false);
		    	
		    	if ( $('#FilterCandidate').is(':checked') ) {
		    		$('.slideEmployer').removeClass('showme');
		    		$('.slideEmployer').addClass('hideme');
		    		$('.slideCandidate').addClass('showme');
		    		$('.slideCandidate').removeClass('hideme');		
		    	} 

		    	
		    });

		    $('#selectEmployer').click(function (argument) {
		    	$(this).addClass('activeme');
		    	$('#selectCandidate').removeClass('activeme');
		    	$('#FilterCandidate').prop('checked', false);
		    	$('#FilterEmployer').prop('checked', true);
		    	
		    	if ( $('#FilterEmployer').is(':checked') ) {
		    		$('.slideEmployer').addClass('showme');
		    		$('.slideEmployer').removeClass('hideme');
		    		$('.slideCandidate').removeClass('showme');	
		    		$('.slideCandidate').addClass('hideme');	
		    	} 
		    });



	    
	   }

	     
 
	
});

$(".dashsection").eq(1).css('opacity',1);
$(".dashsection").eq(2).css('opacity',1);


//Dashboard Employer
	$(window).scroll(function() {
		if ($("body.Employer .dashsection").length) {

			$(".dashsection").each( function() {
	
		        if( $(window).scrollTop() > $(this).offset().top - 300 ) {
		            
		            var getPosition = $(this).position();
					if (   $(this).hasClass('displaydashsection') == false ) {
			            
			            //display section
			            $(this).addClass('displaydashsection');
			            
			            //PieChart
						$(this).find(".displaychart").each( function( index ) {
						 	var test = $(this).find('p').text();
						 	
						 	 $(this).drawPieChart(
						 	 	$.parseJSON(test) 
						 	 	);
							 
						 });

						$('.animateSection').each( function () { //Select each animated sections

							//Int Counter
				            var NumElem =  $( this ).find('.dash_inc');
							var getValue = NumElem.text() ;
							var parseVal = parseFloat(getValue.replace(',','').replace(' ',''))
							var StartVal = 0;

							
							$({someValue: StartVal}).animate({someValue: parseVal}, {
							      duration: 1500,
							      easing:'swing', // can be anything
							      step: function() { // called on every step
							          // Update the element's text with rounded-up value:
							         
							         var n = Math.round(this.someValue); 

							         NumElem.text(commaSeparateNumber( (n < 10) ? ("0" + n) : n ) );
							         return false;
							      }
							});

						});	
					}
		        }
		    }); 
		}

		$('#thread_list').TrackpadScrollEmulator();
		var myDiv = $("#thread_list");
		// var myDiv = $(".tse-content");
	    	
		myDiv.animate({ scrollTop: myDiv.prop("scrollHeight") - myDiv.height() }, 1000); 
		
	   
	});


	