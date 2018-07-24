
jQuery(document).ready(function($) {
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

	jQuery('.btn_submit_order_go.first_step').on('click',function(){
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
	var data_range = {};
	var monthArr = ['December','January','February','March','April','May','June','July','August','September','October','November'];
	var weekArr = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];	
	$('.datepicker-here').datepicker({
		range: true,
		minDate: new Date,
		language: 'en',
		toggleSelected: false,
		onSelect: function (formattedDate, date, instance) {
			if (date[1]) {
				var lastDateVal = date[1].getTime();
				var firstDateVal = date[0].getTime();
				if (lastDateVal - firstDateVal < 1209600000) {
					instance.clear();
					$('.error_message_order_step_three').css('opacity','1');
					// alert('Date range must be more than 2 weeks.');
					data_range = {};
				} else {
					data_range.current_date = date[0];
					data_range.last_date = date[1];
					var count_day_current = date[0].getDate();
					var count_day_last = date[1].getDate();
					var number_name_day_current = date[0].getDay();
					var number_name_day_last = date[1].getDay();
					var number_name_month_current = date[0].getMonth();
					var number_name_month_last = date[0].getMonth();
					$('.count_date_deliver_title_datepicker.current_day').html(count_day_current);
					$('.count_date_deliver_title_datepicker.last_day').html(count_day_last);
					$('.hidden_text_date.current_day').html(weekArr[number_name_day_current]);
					$('.hidden_text_date.last_day').html(weekArr[number_name_day_last]);
					$('.year_text_date.current_day').html(monthArr[number_name_month_current]+' 2018');
					$('.year_text_date.last_day').html(monthArr[number_name_month_last]+' 2018');
					$('.error_message_order_step_three').css('opacity','0');
				}
			}
		},
		onShow: function (inst, animationCompleted) {
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
	}else{
		currentDay = new Date();
		secondDay = new Date();
		secondDay.setDate(secondDay.getDate() + 14);
	}
	if(datepicker){
		datepicker.selectDate([currentDay,secondDay]);
	}

/*** END DATEPICKER ***/
	$('.btn_submit_order_go.step_3').on('click',function(e){
		e.preventDefault();
		if (!$.isEmptyObject(data_range)){
			data_range = JSON.stringify(data_range);
			$.cookie('date_range', data_range, {path: '/' });
			window.location = window.location.origin+'/checkout';
		}else{
			$('.error_message_order_step_three').css('opacity','1');
		}		
	})
	$('.go_back_btn.three').on('click',function(){
		window.location = window.location.origin+'/order-2';
	});
	$('.go_back_btn.two').on('click',function(){
		window.location = window.location.origin+'/order';
	});

});
