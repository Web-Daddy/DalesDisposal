
jQuery(document).ready(function($) {
	$('.owl-carousel').owlCarousel({
	    loop:true,
	    items:1,
	    dots:true,
	    autoplay:true,
	    autoplayTimeout:5000
	})
	if (jQuery(window).width() < 768) {
		jQuery("#dales_top_menu").hide();
		jQuery(".dales_mobile_menu_class").click(function() { 
			jQuery("#dales_top_menu").slideToggle("normal");
			jQuery("#dales_main_menu_container").toggleClass('dales_mobile_menu_opened');
		 	return false;
		});
	};

	jQuery("#dales_button_scroll_to_bottom a").click(function(){jQuery([document.documentElement, document.body]).animate({scrollTop: jQuery('#dales_homepage_section2').offset().top }, 1000);
		return false;})


	if (jQuery(window).width() < 900) {
		jQuery("#dales_bottom_menus h2").click(function() { 
			if (jQuery(this).parent().hasClass('dales_footer_mobile_menu_opened')) {
				jQuery('#dales_bottom_menus .widget_nav_menu').removeClass('dales_footer_mobile_menu_opened');
			} else {
				jQuery("#dales_bottom_menus").find('h2').parent().removeClass('dales_footer_mobile_menu_opened');
				jQuery(this).parent().addClass('dales_footer_mobile_menu_opened');
			};
		 	return false;
		});
	};
	jQuery('.label_description_block.first_block').on('click',function(){
		jQuery('.category_block_order').removeClass('active');
		jQuery('.category_block_order .select').html('Select');
		var id = jQuery(this).attr('data-id');
		jQuery('#'+id).addClass('active');
		jQuery('#'+id+' .select').html('Selected');
	})

	jQuery('.btn_submit_order_go.first_step').on('click',function(event){
		event.preventDefault();
		var slug = jQuery('.category_block_order.active').attr('data-slug');
		jQuery.cookie('slug', slug, { expires: 2, path: '/' });
		window.location = window.location.origin+'/order-2';
	})

	jQuery('.select_count_order').styler();

	jQuery('.label_description_block.product_order input[type="checkbox"]').on('change',function(){
		var is_checked = $(this).is(':checked'),
			$parent = $(this).closest('label'),
			$productBlock = $(this).closest('.block_product_order'),
			$qtySelect = $productBlock.find('.select_count_order');
		if (is_checked) {
			$parent.addClass('active');
			$parent.find('span.select').html('Selected');
			$qtySelect.removeAttr('disabled').trigger('refresh');
		} else {
			$parent.removeClass('active');
			$parent.find('span.select').html('Select');
			$qtySelect.attr('disabled', 'disabled').trigger('refresh');
		}
	});
	$('.btn_submit_order_go.step_2').on('click',function(e){
		e.preventDefault();
		var form_checked = $('#product_form .product_order input[type="checkbox"]:checked');
		if(form_checked.length != 0){
			$('#product_form').submit();
			window.location = window.location.origin+'/delivery-date';
		}else{
			alert('Please select at least one container');
		}
	})
	$('#product_form').on('submit', function (e) {
		e.preventDefault();
		var formData = $(this).serialize();
		$.cookie('form_data', formData, {path: '/' });
	})

/*** DATEPICKER *****/
	var dales_two_weeks_once = 1;
	jQuery(document).on("click", ".datepicker--cell-day", function (e) {
		if (dales_two_weeks_once == 1) {
			var datepicker = jQuery('.datepicker-here').datepicker().data('datepicker');
			if (datepicker.selectedDates[1])  {
				return;
			}

			var currentDay = datepicker.selectedDates[0];
			var secondDay = new Date();
			secondDay.setTime(currentDay.getTime());
			secondDay.setDate(secondDay.getDate() + 14);
			var dateArr = [currentDay, secondDay];

			setTimeout(function(){
				datepicker.clear();
			},10);

			setTimeout(function(){
				if(datepicker){
					datepicker.selectDate(dateArr);
					dales_two_weeks_once++;
				}
			},30);
		}

	});


	var data_range = {};
	var date_range = [];
	var monthArr = ['January','February','March','April','May','June','July','August','September','October','November','December'];
	var weekArr = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];	
	var rent_time_range = '';
	var disabledDays = [0, 6];
	var date_tomorrow = new Date;
	date_tomorrow.setDate(date_tomorrow.getDate()+1);
	var number_of_day = 0;


	$('.datepicker-here').datepicker({
		range: true,
		minDate: date_tomorrow,
		language: 'en',
		toggleSelected: false,
		onSelect: function (formattedDate, date, instance) {
			if (date[1]) {
				var lastDateVal = date[1].getTime();
				var firstDateVal = date[0].getTime();
				rent_time_range = ( lastDateVal - firstDateVal) / 86400000;
				if(rent_time_range < 14){ rent_time_range = 14}
				if (lastDateVal - firstDateVal < 60) {
					instance.clear();
					$('.error_message_order_step_three').css('opacity','1');
					$('.error_message_order_step_three').css('display','flex');
					data_range = {};
				} else {
					console.log('data', date);
					data_range.current_date = date[0];
					data_range.last_date = date[1];
					date_range[0] = (date[0]);
					date_range[1] = (date[1]);
					var count_day_current = date[0].getDate();
					var count_day_last = date[1].getDate();
					var number_name_day_current = date[0].getDay();
					var number_name_day_last = date[1].getDay();
					var number_name_month_current = date[0].getMonth();
					var number_name_month_last = date[1].getMonth();
					$('.count_date_deliver_title_datepicker.current_day').html(count_day_current);
					$('.count_date_deliver_title_datepicker.last_day').html(count_day_last);
					$('.hidden_text_date.current_day').html(weekArr[number_name_day_current]);
					$('.hidden_text_date.last_day').html(weekArr[number_name_day_last]);
					$('.year_text_date.current_day').html(monthArr[number_name_month_current]+' 2018');
					$('.year_text_date.last_day').html(monthArr[number_name_month_last]+' 2018');
					$('.error_message_order_step_three').css('opacity','0');
					$('.error_message_order_step_three').css('display','none');
				}
			}
		},
		onShow: function (inst, animationCompleted) {
		},
	    onRenderCell: function (date, cellType) {
            var currentDate = date.getDate(),
            	month = date.getMonth(),
            	year = date.getFullYear(),
            	day = date.getDay();

            month++;
            if (month.toString().length == 1) {
            	month = '0'+month;
            }
            if (currentDate.toString().length == 1) {
            	currentDate = '0'+currentDate;
            }

            var staticDate = currentDate+'/'+month;
            var dynamicDate = currentDate+'/'+month+'/'+year;
            

	        if (cellType == 'day') {
	        	if (staticHolidays && staticHolidays.length && staticHolidays.indexOf(staticDate) != -1) {
	    			return {
		                disabled: true
		            };
	            }
	        	if (dynamicHolidays && dynamicHolidays.length && dynamicHolidays.indexOf(dynamicDate) != -1) {
	    			return {
		                disabled: true
		            };
	            }
	        	var isDisabled = disabledDays.indexOf(day) != -1;

	            return {
	                disabled: isDisabled
	            };

	        }
	    }
	});
	var datepicker = $('.datepicker-here').datepicker().data('datepicker');
	var	date_range_cookie = $.cookie('date_range');
	var currentDay = '';
	var secondDay = '';
	if(date_range_cookie){
		date_range_cookie = JSON.parse(date_range_cookie);
		currentDay = new Date(date_range_cookie.current_date);
		secondDay = new Date(date_range_cookie.last_date);
		if(datepicker){
			datepicker.selectDate([currentDay,secondDay]);
		}
	}else{
		currentDay = new Date();
		currentDay.setDate(currentDay.getDate()+1);
		// console.log(currentDay);
		secondDay = new Date();
		secondDay.setDate(secondDay.getDate() + 15);
	}
	// if(datepicker){
	// 	datepicker.selectDate([currentDay,secondDay]);
	// }

/*** END DATEPICKER ***/
	$('.error_message_order_step_three i.fas.fa-times').on('click',function(){
		$('.error_message_order_step_three').css('opacity','0');
		$('.error_message_order_step_three').css('display','none');
	});
	$('.error_message_order_step_three_success i.fas.fa-times').on('click',function(){
		$('.error_message_order_step_three_success').css('opacity','0');
		$('.error_message_order_step_three_success').css('display','none');
	});
	$('.btn_submit_order_go.step_3').on('click',function(e){
		e.preventDefault();
		if (!$.isEmptyObject(data_range)){
			data_range_orig = data_range;
			data_range = JSON.stringify(data_range);
			$.cookie('date_range', data_range, {path: '/' });

			data_range_orig.current_date = data_range_orig.current_date.toLocaleDateString();
			data_range_orig.last_date = data_range_orig.last_date.toLocaleDateString();
			data_range_orig = JSON.stringify(data_range_orig);
			$.cookie('dales_date_range', data_range_orig, {path: '/' });

			$.cookie('rent_time_range', rent_time_range, {path: '/' });
			window.location = window.location.origin+'/checkout-dales';
			// console.log(date_range);
		}else{
			$('.error_message_order_step_three').css('opacity','1');
			$('.error_message_order_step_three').css('display','flex');
			$('html, body').animate({ scrollTop: $(".error_message_order_step_three").offset().top}, 1000);
		}		
	})
	$('.go_back_btn.three').on('click',function(){
		window.location = window.location.origin+'/order-2';
	});
	$('.go_back_btn.two').on('click',function(){
		window.location = window.location.origin+'/order';
	});

	$('label.optimization_btn .btn').on('click',function(){
		$('#file_for_upload_email').click();
	});

	var dales_form_resume = document.querySelector('.email_fails');
	if (dales_form_resume) {
		dales_form_resume.addEventListener('submit', function (e) {
			var fileInput = document.getElementById("file_for_upload_email");
	    	if(fileInput && fileInput.files.length == 0){
				alert('Please choose a file');
				e.preventDefault();
			}

		});
	};



	$("#file_for_upload_email").on('change',function(e){
		e.preventDefault();
	    var dales_upload_file_type = this.files[0].type,
	    	dales_correct_file_type = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'application/pdf', 'image/jpeg'],
	    	dales_upload_boolen = dales_correct_file_type.includes(dales_upload_file_type);
	    if (!dales_upload_boolen) {
	    	alert('The uploaded file is not supported file type. The correct type files are : pdf, jpg, doc, docx');
	    	$('.email_fails input[type="submit"]').attr('disabled', 'disabled');
	    	$('.email_fails input[type="submit"]').addClass('dales_form_disabled_submit');
	    	$('.dales_upload_file_name').html('');
	    } else {
	    	$('.email_fails input[type="submit"]').removeAttr("disabled");
	    	$('.email_fails input[type="submit"]').removeClass('dales_form_disabled_submit');
		    if (this.files[0].size > 1000000) {
		    	alert('Not a valid file weight. The maximum weight is 1000 KB.');
		    	$('.email_fails input[type="submit"]').attr('disabled', 'disabled');
		    	$('.email_fails input[type="submit"]').addClass('dales_form_disabled_submit');
		    	$('.dales_upload_file_name').html('');
		    } else {
		    	$('.email_fails input[type="submit"]').removeAttr("disabled");
		    	$('.email_fails input[type="submit"]').removeClass('dales_form_disabled_submit');
		    	$('.dales_upload_file_name').html(this.files[0].name);
		    }
	    };
	});


	$('#dales_order_cancel_button_link').on('click', clearCart);
      function clearCart(d) {
      	d.preventDefault();
            jQuery.post(
                wp_links.ajaxurl, 
                {
                    "action": "clearcart",
                }, 
                function(data){
                	if (data.status && data.status == 'done') {
	                    window.location = data.home_url;
	            	}
                }
            );
        }

	jQuery('.woocommerce-billing-fields__field-wrapper').prepend('<div class="dales_checkout_first_row"></div>');
	jQuery('.dales_checkout_first_row').append('<div class="dales_checkout_first_row_col1"></div>');
	jQuery('.dales_checkout_first_row').append('<div class="dales_checkout_first_row_col2"></div>');
	jQuery('.dales_checkout_first_row_col1').append(jQuery('#billing_myfield1_field'));
	jQuery('.dales_checkout_first_row_col1').append(jQuery('#billing_myfield2_field'));
	jQuery('.dales_checkout_first_row_col2').append(jQuery('#billing_myfield3_field'));
	jQuery('.dales_checkout_first_row_col2').append(jQuery('#billing_myfield4_field'));
	jQuery('.dales_checkout_first_row_col2').append(jQuery('#billing_myfield5_field'));
	jQuery('.woocommerce-billing-fields h3').not('.form-row').addClass('dales_billing_label').insertAfter(jQuery('#billing_myfield6_field'));
	jQuery('#ship-to-different-address-checkbox').prop( "checked", false );

	jQuery('#createaccount, #ship-to-different-address-checkbox, #billing_myfield6_checkbox, #billing_myfield2_checkbox').click(function(){
		jQuery(this).parent().toggleClass('dales_checked_checkbox');
	});
	jQuery('#billing_myfield4_checkbox').click(function(){
		jQuery(this).parent().toggleClass('dales_checked_checkbox');
		jQuery('.dales_checkout_first_row_col2').removeClass('dales_checkout_error_confirmation');
		if (jQuery('#billing_myfield5_checkbox').parent().hasClass('dales_checked_checkbox')) {
			jQuery('#billing_myfield5_checkbox').parent().removeClass('dales_checked_checkbox');
			jQuery('#billing_myfield5_checkbox').prop('checked', false);
		}
	});
	jQuery('#billing_myfield5_checkbox').click(function(){
		jQuery(this).parent().toggleClass('dales_checked_checkbox');
		jQuery('.dales_checkout_first_row_col2').removeClass('dales_checkout_error_confirmation');
		if (jQuery('#billing_myfield4_checkbox').parent().hasClass('dales_checked_checkbox')) {
			jQuery('#billing_myfield4_checkbox').parent().removeClass('dales_checked_checkbox');
			jQuery('#billing_myfield4_checkbox').prop('checked', false);
		}
	});
    function scrollToEmptyCard(){
    	if ( jQuery('.securesubmit_new_card ul').hasClass('woocommerce-error')){
	    	jQuery([document.documentElement, document.body]).animate({
		       			scrollTop: jQuery(".securesubmit_new_card ul.woocommerce-error").offset().top - 100
		   			}, 1000);
	    }
    };
	jQuery(document).on("click", "#place_order", function (e) {
    	if ( jQuery('#billing_myfield4_field label').hasClass('dales_checked_checkbox') || jQuery('#billing_myfield5_field label').hasClass('dales_checked_checkbox')) {
			setTimeout(scrollToEmptyCard, 500);
   		} else {
   			jQuery('.dales_checkout_first_row_col2').addClass('dales_checkout_error_confirmation');
   			jQuery([document.documentElement, document.body]).animate({
       			scrollTop: jQuery(".dales_checkout_first_row_col2").offset().top - 100
   			}, 1000);
   			e.preventDefault();
   		};

	});
	jQuery('#billing_phone').mask('000-000-0000').attr('placeholder', 'xxx-xxx-xxxx');

});


function getDate(date) {
	date = date.getDate().toString();
	return date.length == 1 ? '0'+date : date;
}

function getMonth(date) {
	var month = date.getMonth() + 1;
	date = month.toString();
	return date.length == 1 ? '0'+date : date;
}

function clone(obj) {
    var copy;

    // Handle the 3 simple types, and null or undefined
    if (null == obj || "object" != typeof obj) return obj;

    // Handle Date
    if (obj instanceof Date) {
        copy = new Date();
        copy.setTime(obj.getTime());
        return copy;
    }

    // Handle Array
    if (obj instanceof Array) {
        copy = [];
        for (var i = 0, len = obj.length; i < len; i++) {
            copy[i] = clone(obj[i]);
        }
        return copy;
    }

    // Handle Object
    if (obj instanceof Object) {
        copy = {};
        for (var attr in obj) {
            if (obj.hasOwnProperty(attr)) copy[attr] = clone(obj[attr]);
        }
        return copy;
    }

    throw new Error("Unable to copy obj! Its type isn't supported.");
}