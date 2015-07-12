<script>
$(window).load(function() {
	$.ajax({
		url: 'content/contact/captcha',
		type: 'html',
		success: function(response) {
			$('#cap-code').val(response);
		}
	});
});

$('#contact-form').formValidation({
	framework: 'bootstrap',
	live: 'submitted',
    icon: {
        valid: 'fa fa-check',
        invalid: 'fa fa-times',
        validating: 'fa fa-refresh'
    },
    exclude: ':disabled, :hidden, :not(:visible)',
    fields: {
    	name: {
    		validators: {
    			notEmpty: {
    				message: '<?= $lang_error_name; ?>'
    			},
    			stringLength: {
    				min: 3,
    				max: 32,
    				message: '<?= $lang_error_name; ?>'
    			}
    		}
    	},
    	email: {
        	verbose: false,
        	validators: {
        		notEmpty: {
                    message: '<?= $lang_error_email; ?>'
                },
                emailAddress: {
                    message: '<?= $lang_error_email; ?>'
                }
        	}
        },
        enquiry: {
        	validators: {
    			notEmpty: {
    				message: '<?= $lang_error_enquiry; ?>'
    			},
    			stringLength: {
    				min: 10,
    				max: 3000,
    				message: '<?= $lang_error_enquiry; ?>'
    			}
    		}
        },
        captcha: {
            validators: {
                identical: {
                    field: 'cap_code',
                    message: '<?= $lang_error_captcha; ?>'
                }
            }
        },
    }
}).on('success.field.fv', function(e, data) {
	var $parent = data.element.parents('.form-group');
	$parent.removeClass('has-success');
	data.element.data('fv.icon').hide();

}).on('success.form.fv', function(e) {
	e.preventDefault();

	$.ajax({
		url: 'content/contact/send',
		type: 'post',
		dataType: 'json',
		data: $('#contact-form').serialize(),
		success: function(json) {
			if (json['success']) {
				$('#contact-form').before('<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">&times;</a>'+ json['success'] + '</div>');
	            $('#contact-form').trigger("reset");
	            setTimeout(function() {
					$('.alert').fadeOut(function(){
						$(this).remove();
					});
				}, 5000);
			}
		}
	});
});
</script>