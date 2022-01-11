/* ------------------------------------------------------------------------------
*
*  # Stepy wizard
*
*  Specific JS code additions for wizard_stepy.html page
*
*  Version: 1.1
*  Latest update: Dec 25, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {


    // Override defaults
    $.fn.stepy.defaults.legend = false;
    $.fn.stepy.defaults.transition = 'fade';
    $.fn.stepy.defaults.duration = 150;
    $.fn.stepy.defaults.backLabel = '<i class="icon-arrow-left13 position-left"></i> Back';
    $.fn.stepy.defaults.nextLabel = 'Next <i class="icon-arrow-right14 position-right"></i>';



    // Wizard examples
    // ------------------------------

    // Basic wizard setup
    //$(".stepy-basic").stepy();


    // Hide step description
    /*$(".stepy-no-description").stepy({
        description: false
    });*/


    // Clickable titles
    /*$(".stepy-clickable").stepy({
        titleClick: true
    });*/


    // Stepy callbacks
    /*$(".stepy-callbacks").stepy({
        next: function(index) {
            alert('Going to step: ' + index);
        },
        back: function(index) {
            alert('Returning to step: ' + index);
        },
        finish: function() {
            alert('Submit canceled.');
            return false;
        }
    });*/


    //
    // Validation
    //

    // Initialize wizard
    $(".stepy-validation").stepy({
        validate: true,
        block: true,
        next: function(index) {
            if (!$(".stepy-validation").validate(validate)) {
                return false
            }
        }
    });


    // Initialize validation
    var validate = {
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        }, rules: {  
			'name': {
				required: true,  
			},
			'email':{
				required: true,
				email: true,
				remote: {
					url: $("#email_check_url").val(),
					type: "post",
					data: {
						email: function() {
							return $( "#email" ).val();
						}
					}
				}
			},
			'password': {
				required: true,
				minlength: 5
			}, 
			'conf_password': {
				required: true,
				equalTo : '[name="password"]',
			},
			'phone_no': {
				required: true,  
			},
			'mobile_no': {
				required: true,  
			},
			'company_name': {
				required: true,  
			},
			'no_of_employees': {
				required: true, 
			},
			'payment_gateway': {
				required: true,
			},
		}, messages: {
			'name': {
				required: "This is required field",
			},
			'email':{
				required: "This is required field",
				email: "Please enter a valid Email address!",
				remote: "This Email address is already in use, please enter another Email address!",
			},
			'password': {
				required: "This is required field",
				minlength: "Enter at-least 5 characters password!",
			}, 
			'conf_password': {
				required: "This is required field",
				equalTo : "Password & Confirm Password doesn't matched!",
			},
			'phone_no': {
				required: "This is required field",
			},
			'mobile_no': {
				required: "This is required field",
			},
			'company_name': {
				required: "This is required field",
			},
			'no_of_employees': {
				required: "This is required field",
			},
			'payment_gateway': {
				required: "This is required field",
			},
		}
        /*rules: {
            email: {
                email: true
            }
        }*/
    }
    // Initialize plugins
    // ------------------------------

    // Apply "Back" and "Next" button styling
    $('.stepy-step').find('.button-next').addClass('btn bg-teal-400');
    $('.stepy-step').find('.button-back').addClass('btn btn-default');


    // Select2 selects
    $('.select').select2();


    // Simple select without search
    /*$('.select-simple').select2({
        minimumResultsForSearch: Infinity
    });*/


    // Styled checkboxes and radios
    /*$('.styled').uniform({
        radioClass: 'choice'
    });


    // Styled file input
    $('.file-styled').uniform({
        fileButtonClass: 'action btn bg-blue'
    });*/
    
});
