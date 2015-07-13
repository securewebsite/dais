<script>

setTimeout(function(){
	$('.alert-warning').fadeOut('slow', function() {
		$(this).remove();
	});
}, 8000);

<?php if ($affiliate_allowed): ?>
	$('.payment').hide();
	<?php if (!$affiliate['status']): ?>
	$('#affiliate-panel').hide();
	$('#affiliate-agree-panel').hide();
	<?php endif; ?>
<?php endif; ?>

var customer_group = [];
<?php foreach ($customer_groups as $customer_group): ?>
	customer_group[<?= $customer_group['customer_group_id']; ?>] = [];
	customer_group[<?= $customer_group['customer_group_id']; ?>]['company_id_display'] = <?= $customer_group['company_id_display']; ?>;
	customer_group[<?= $customer_group['customer_group_id']; ?>]['company_id_required'] = <?= $customer_group['company_id_required']; ?>;
	customer_group[<?= $customer_group['customer_group_id']; ?>]['tax_id_display'] = <?= $customer_group['tax_id_display']; ?>;
	customer_group[<?= $customer_group['customer_group_id']; ?>]['tax_id_required'] = <?= $customer_group['tax_id_required']; ?>;
<?php endforeach; ?>

$("#register-form").steps({
	headerTag: "h3",
    bodyTag: "fieldset",
    autoFocus: true,
    titleTemplate: "<span class=\"number\">#title#</span>",
    buttons: {
    	selector: '[role="menuitem"]',
    	disabled: 'disabled'
    },
    transitionEffect: 1,
    onInit: function (event, current) {
    	$('.actions > ul > li:first-child').attr('style', 'display:none');
    },
    onStepChanged: function (event, current, next) {
    	if (current > 0) {
    		$('.actions > ul > li:first-child').attr('style', '');
    	} else {
    		$('.actions > ul > li:first-child').attr('style', 'display:none');
    	}

    	<?php if ($affiliate_allowed): ?>
    		if (current == 2) {
	    		var radios = $('#tab-payment').find('input:radio');
				
	    		radios.each(function() {
					$(this).on('change', function() {
						$('.payment').hide();
						$('#payment-' + $(this).val()).show();
					});
				});

				$('input[name="affiliate[payment_method]"]:checked').change();
    		}
    	<?php endif; ?>
    },
    onStepChanging: function(e, currentIndex, newIndex) {
        var fv         = $('#register-form').data('formValidation'), // FormValidation instance
            // The current step container
            $container = $('#register-form').find('fieldset[aria-labelledby="register-form-h-' + currentIndex +'"]');

        // Validate the container
        fv.validateContainer($container);

        var isValidStep = fv.isValidContainer($container);
        if (isValidStep === false || isValidStep === null) {
            // Do not jump to the next step
            return false;
        }

        return true;
    },
    onFinishing: function(e, currentIndex) {
        var fv         = $('#register-form').data('formValidation'),
            $container = $('#register-form').find('fieldset[aria-labelledby="register-form-h-' + currentIndex +'"]');

        // Validate the last step container
        fv.validateContainer($container);

        var isValidStep = fv.isValidContainer($container);
        if (isValidStep === false || isValidStep === null) {
            return false;
        }

        return true;
    },
    onFinished: function(e, currentIndex) {
        // Uncomment the following line to submit the form using the defaultSubmit() method
        $('#register-form').formValidation('defaultSubmit');

        // For testing purpose
        //alert('Hot Damn! Everything is Valid!');
    },
    labels: {
    	finish: 'Sign Up <i class="fa fa-chevron-right"></i>',
    	next: 'Next <i class="fa fa-chevron-right"></i>',
    	previous: '<i class="fa fa-chevron-left"></i> Previous'
    }
}).formValidation({
	framework: 'bootstrap',
    icon: {
        valid: 'fa fa-check',
        invalid: 'fa fa-times',
        validating: 'fa fa-refresh'
    },
    exclude: ':disabled, :hidden, :not(:visible)',
    fields: {
    	username: {
            verbose: false,
            validators: {
                notEmpty: {
                    message: '<?= $lang_error_req_username; ?>'
                },
                stringLength: {
                    min: 3,
                    max: 16,
                    message: '<?= $lang_error_username; ?>'
                },
                regexp: {
                    regexp: /^[a-zA-Z]+$/,
                    message: '<?= $lang_error_alpha_username; ?>'
                },
                remote: {
                    url: 'account/register/username',
                    type: 'get'
                }
            }
        },
    	firstname: {
            validators: {
                notEmpty: {
                    message: '<?= $lang_error_req_firstname; ?>'
                },
                stringLength: {
                	min: 1,
                	max: 32,
                	message: '<?= $lang_error_firstname; ?>'
                },
                regexp: {
                    regexp: /^[a-zA-Z]+$/,
                    message: '<?= $lang_error_alpha_firstname; ?>'
                }
            }
        },
        lastname: {
            validators: {
                notEmpty: {
                    message: '<?= $lang_error_req_lastname; ?>'
                },
                stringLength: {
                	min: 3,
                	max: 32,
                	message: '<?= $lang_error_lastname; ?>'
                },
                regexp: {
                    regexp: /^[a-zA-Z]+$/,
                    message: '<?= $lang_error_alpha_lastname; ?>'
                }
            }
        },
        email: {
        	verbose: false,
        	validators: {
        		notEmpty: {
                    message: '<?= $lang_error_req_email; ?>'
                },
                emailAddress: {
                    message: '<?= $lang_error_email; ?>'
                },
                stringLength: {
                	max: 96,
                	message: '<?= $lang_error_email; ?>'
                },
                remote: {
                    url: 'account/register/email',
                    type: 'get'
                }
        	}
        },
        password: {
            validators: {
                notEmpty: {
                    message: '<?= $lang_error_req_password; ?>'
                },
                stringLength: {
                	min: 4,
                	max: 20,
                	message: '<?= $lang_error_password; ?>'
                }
            }
        },
        confirm: {
            validators: {
                notEmpty: {
                    message: '<?= $lang_error_req_confirm; ?>'
                },
                identical: {
                    field: 'password',
                    message: '<?= $lang_error_confirm; ?>'
                }
            }
        },
        telephone: {
        	validators: {
        		notEmpty: {
        			message: '<?= $lang_error_req_telephone; ?>'
        		},
        		stringLength: {
        			min: 3,
        			max: 32,
        			message: '<?= $lang_error_telephone; ?>'
        		}
        	}
        },
        address_1: {
        	validators: {
        		notEmpty: {
        			message: '<?= $lang_error_req_address; ?>'
        		},
        		stringLength: {
        			min: 3,
        			max: 128,
        			message: '<?= $lang_error_address; ?>'
        		}
        	}
        },
        city: {
        	validators: {
        		notEmpty: {
        			message: '<?= $lang_error_req_city; ?>'
        		},
        		stringLength: {
        			min: 2,
        			max: 128,
        			message: '<?= $lang_error_city; ?>'
        		}
        	}
        },
        postcode: {
        	validators: {
        		notEmpty: {
        			message: '<?= $lang_error_req_postcode; ?>'
        		}
        	}
        },
        country_id: {
        	validators: {
        		notEmpty: {
        			message: '<?= $lang_error_req_country; ?>'
        		}
        	}
        },
        zone_id: {
        	validators: {
        		notEmpty: {
        			message: '<?= $lang_error_req_zone; ?>'
        		}
        	}
        },
        <?php if ($affiliate_allowed): ?>
        'affiliate[status]': {
            validators: {
                notEmpty: {
                    message: "<?= $lang_error_status; ?>"
                }
            }
        },
        'affiliate[tax]': {
        	verbose: false,
        	validators: {
        		notEmpty: {
        			message: '<?= $lang_error_req_tax; ?>'
        		},
        		regexp: {
                    regexp: /^(?!(000|666|9))\d{3}(?!00)\d{2}(?!0000)\d{4}$/,
                    message: '<?= $lang_error_tax; ?>'
                },
                stringLength: {
                	min: 9,
                	max: 9,
                	message: '<?= $lang_error_tax_length; ?>'
                }
        	}
        },
        'affiliate[slug]': {
        	verbose: false,
        	validators: {
        		notEmpty: {
        			message: '<?= $lang_error_vanity; ?>'
        		},
        		stringLength: {
        			min: 5,
        			max: 32,
        			message: '<?= $lang_error_vanity_length; ?>'
        		},
        		remote: {
        			threshold: 5,
        			url: 'account/register/slug'
        		}
        	}
        },
        'affiliate[payment_method]': {
        	validators: {
        		notEmpty: {
        			message: '<?= $lang_error_payment_method; ?>'
        		}
        	}
        },
        'affiliate[cheque]': {
        	validators: {
        		callback: {
        			message: '<?= $lang_error_cheque; ?>',
        			callback: function (value, validator, $field) {
        				var method = $('[name="affiliate[payment_method]"]:checked').val();
        				return (method !== 'cheque') ? true : (value !== '');
        			}
        		}
        	}
        },
        'affiliate[paypal]': {
        	validators: {
        		emailAddress: {
        			message: '<?= $lang_error_paypal_invalid; ?>'
        		},
        		callback: {
        			message: '<?= $lang_error_paypal; ?>',
        			callback: function (value, validator, $field) {
        				var method = $('[name="affiliate[payment_method]"]:checked').val();
        				return (method !== 'paypal') ? true : (value !== '');
        			}
        		}
        	}
        },
        'affiliate[bank_name]': {
        	validators: {
        		callback: {
        			message: '<?= $lang_error_bank_name; ?>',
        			callback: function (value, validator, $field) {
        				var method = $('[name="affiliate[payment_method]"]:checked').val();
        				return (method !== 'bank') ? true : (value !== '');
        			}
        		}
        	}
        },
        'affiliate[bank_account_name]': {
        	validators: {
        		callback: {
        			message: '<?= $lang_error_bank_account_name; ?>',
        			callback: function (value, validator, $field) {
        				var method = $('[name="affiliate[payment_method]"]:checked').val();
        				return (method !== 'bank') ? true : (value !== '');
        			}
        		}
        	}
        },
        'affiliate[bank_account_number]': {
        	validators: {
        		callback: {
        			message: '<?= $lang_error_bank_account_number; ?>',
        			callback: function (value, validator, $field) {
        				var method = $('[name="affiliate[payment_method]"]:checked').val();
        				return (method !== 'bank') ? true : (value !== '');
        			}
        		}
        	}
        },
        affiliate_agree: {
        	validators: {
        		notEmpty: {
        			message: '<?= $lang_error_req_affiliate; ?>.'
        		}
        	}
        },
        <?php endif; ?>
        agree: {
        	validators: {
        		notEmpty: {
        			message: '<?= $lang_error_req_account; ?>.'
        		}
        	}
        }
    }
}).on('change', '[name="affiliate[status]"]', function(e) {
	$('#affiliate-panel').slideToggle();
	$('#affiliate-agree-panel').toggle();

}).on('change', '[name="affiliate[payment_method]"]', function(e) {
    var method = $('[name="affiliate[payment_method]"]:checked').val();
    if (method == 'cheque') {
    	$('#register-form').formValidation('revalidateField', 'affiliate[cheque]');
    } else if (method == 'paypal') {
    	$('#register-form').formValidation('revalidateField', 'affiliate[paypal]');
    } else if (method == 'bank') {
    	$('#register-form').formValidation('revalidateField', 'affiliate[bank_name]');
    	$('#register-form').formValidation('revalidateField', 'affiliate[bank_account_name]');
    	$('#register-form').formValidation('revalidateField', 'affiliate[bank_account_number]');
    }
}).on('keyup', '[name="affiliate[slug]"]', function(e){
	var value = $(this).val();
	$('#vanity').html(value); 
});


</script>