//Reference: 
//http://www.onextrapixel.com/2012/12/10/how-to-create-a-custom-file-input-with-jquery-css3-and-php/
;(function($) {

		  // Browser supports HTML5 multiple file?
		  var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
		      isIE = /msie/i.test( navigator.userAgent );

		    var mobile_agent = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
            var mobile_agent_name = false;
            
            if (mobile_agent) {
                if ((/iphone|ipad|ipod/i.test(navigator.userAgent.toLowerCase()))) {
                    mobile_agent_name = 'ios';
                } else {
                    mobile_agent_name = 'android';
                }
            }

		 	$.fn.customFile = function(options) {
		  	$.fn.customFile.defaults={
		  		buttonText: 'Browse',
		  		showFilePath: true,
		  		placeHolder: 'Upload a file'
		  	};
		  	var opts = $.extend({},$.fn.customFile.defaults,options);

		    return this.each(function() {

		      var $file = $(this).addClass('custom-file-upload-hidden'), // the original file input
		          $wrap = $('<div class="file-upload-wrapper">'),
		          $input = $('<input type="text" class="file-upload-input" ng-show="'+opts.showFilePath+'" placeholder="'+opts.placeHolder+'" />'),
		          // Button that will be used in non-IE browsers
		          $button = $('<button type="button" ng-click="open_file_modal($event)" data-docFileType="image" class="file-upload-button">'+opts.buttonText+'</button>'),
		          // Hack for IE
		          $label = $('<label class="file-upload-button" for="'+ $file[0].id +'">Select a File</label>');

		          if(mobile_agent){
		          		
		          		 var str = '<label type="button" style="display:inline-block" data-docFileType="image" class="file-upload-button">'+opts.buttonText;
		          		 	str += '<input type="file" accept="image/*;capture=camera" class="file inputfile inputfile-6 hide" id="mobile_'+$file[0].id+'">';
		          		 	str += '</label>';
		          		 	 $button = $(str);
		          }

		      // Hide by shifting to the left so we
		      // can still trigger events
		      $file.css({
		        position: 'absolute',
		        left: '-9999px'
		      });

		      $wrap.insertAfter( $file )
		        .append( $file, $input, ( isIE ? $label : $button ) );
		       

		      // Prevent focus
		      $file.attr('tabIndex', -1);
		      $button.attr('tabIndex', -1);

		      // $button.click(function () {
		      //   $file.focus().click(); // Open dialog
		      // });

		      $file.change(function() {

		        var files = [], fileArr, filename;

		        // If multiple is supported then extract
		        // all filenames from the file array
		        if ( multipleSupport ) {
		          fileArr = $file[0].files;
		          for ( var i = 0, len = fileArr.length; i < len; i++ ) {
		            files.push( fileArr[i].name );
		          }
		          filename = files.join(', ');

		        // If not supported then just take the value
		        // and remove the path to just show the filename
		        } else {
		          filename = $file.val().split('\\').pop();
		        }

		        $input.val( filename ) // Set the value
		          .attr('title', filename) // Show filename in title tootlip
		          .focus(); // Regain focus

		      });

		      $input.on({
		        blur: function() { $file.trigger('blur'); },
		        keydown: function( e ) {
		          if ( e.which === 13 ) { // Enter
		            if ( !isIE ) { $file.trigger('click'); }
		          } else if ( e.which === 8 || e.which === 46 ) { // Backspace & Del
		            // On some browsers the value is read-only
		            // with this trick we remove the old input and add
		            // a clean clone with all the original events attached
		            $file.replaceWith( $file = $file.clone( true ) );
		            $file.trigger('change');
		            $input.val('');
		          } else if ( e.which === 9 ){ // TAB
		            return;
		          } else { // All other keys
		            return false;
		          }
		        }
		      });

		    });

		  };

		  // Old browser fallback
		  if ( !multipleSupport ) {
		    $( document ).on('change', 'input.customfile', function() {

		      var $this = $(this),
		          // Create a unique ID so we
		          // can attach the label to the input
		          uniqId = 'customfile_'+ (new Date()).getTime(),
		          $wrap = $this.parent(),

		          // Filter empty input
		          $inputs = $wrap.siblings().find('.file-upload-input')
		            .filter(function(){ return !this.value }),

		          $file = $('<input type="file" id="'+ uniqId +'" name="'+ $this.attr('name') +'"/>');

		      // 1ms timeout so it runs after all other events
		      // that modify the value have triggered
		      setTimeout(function() {
		        // Add a new input
		        if ( $this.val() ) {
		          // Check for empty fields to prevent
		          // creating new inputs when changing files
		          if ( !$inputs.length ) {
		            $wrap.after( $file );
		            $file.customFile();
		          }
		        // Remove and reorganize inputs
		        } else {
		          $inputs.parent().remove();
		          // Move the input so it's always last on the list
		          $wrap.appendTo( $wrap.parent() );
		          $wrap.find('input').focus();
		        }
		      }, 1);

		    });
		  }

}(jQuery));



$('#EmployerVideoUpload').customFile({
	buttonText:'Upload a video',
	showFilePath: false
});

// $('#Register_employer input[type=file]').customFile();
//$('#Register_employer .formStepsHolder input[type=file]').customFile();
// $('#Register_employer .formStepsHolder input[type=file]').not(".globalUpload").customFile();

//
$('#Register_employer .formStepsHolder input[type=file]#profileImage, #Register_employer .formStepsHolder input[type=file]#Form_my_file2').customFile({
	placeHolder:'Upload profile image',
});


$('#Register_employer .formStepsHolder input[type=file]#Form_my_file').customFile({
	placeHolder:'Upload company logo',
});
/*
$('#EmployerVideoUpload').customFile({
	buttonText:'Upload a video',
});*/