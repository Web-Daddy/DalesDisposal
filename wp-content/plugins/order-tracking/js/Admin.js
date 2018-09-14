/* Used to show and hide the admin tabs for otp */
function ShowTab(TabName) {
		jQuery(".OptionTab").each(function() {
				jQuery(this).addClass("HiddenTab");
				jQuery(this).removeClass("ActiveTab");
		});
		jQuery("#"+TabName).removeClass("HiddenTab");
		jQuery("#"+TabName).addClass("ActiveTab");
		
		jQuery(".nav-tab").each(function() {
				jQuery(this).removeClass("nav-tab-active");
		});
		jQuery("#"+TabName+"_Menu").addClass("nav-tab-active");
}

jQuery(document).ready(function() {
	jQuery('.custom-fields-list').sortable({
		items: '.custom-field-list-item',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			var order = jQuery(this).sortable('serialize') + '&action=ewd_otp_custom_fields_update_order';
			jQuery.post(ajaxurl, order, function(response) {});
		}
	});
});

function ShowOptionTab(TabName) {
	jQuery(".otp-option-set").each(function() {
		jQuery(this).addClass("otp-hidden");
	});
	jQuery("#"+TabName).removeClass("otp-hidden");
	
	// var activeContentHeight = jQuery("#"+TabName).innerHeight();
	// jQuery(".otp-options-page-tabbed-content").animate({
	// 	'height':activeContentHeight
	// 	}, 500);
	// jQuery(".otp-options-page-tabbed-content").height(activeContentHeight);

	jQuery(".options-subnav-tab").each(function() {
		jQuery(this).removeClass("options-subnav-tab-active");
	});
	jQuery("#"+TabName+"_Menu").addClass("options-subnav-tab-active");
	jQuery('input[name="Display_Tab"]').val(TabName);
}

jQuery(document).ready(function() {
	SetMessageDeleteHandlers();

	jQuery('.ewd-otp-add-email').on('click', function(event) {
		var ID = jQuery(this).data('nextid');

		var HTML = "<tr id='ewd-otp-email-message-" + ID + "'>";
		HTML += "<td><a class='ewd-otp-delete-message' data-messagenumber='" + ID + "'>Delete</a></td>";
		HTML += "<td><input type='text' name='Email_Message_" + ID + "_Name'></td>";
		HTML += "<td><textarea name='Email_Message_" + ID + "_Body'></textarea></td>";
		HTML += "</tr>";

		//jQuery('table > tr#ewd-uasp-add-reminder').before(HTML);
		jQuery('#ewd-otp-email-messages-table tr:last').before(HTML);

		ID++;
		jQuery(this).data('nextid', ID); //updates but doesn't show in DOM

		SetMessageDeleteHandlers();

		event.preventDefault();
	});
});

function SetMessageDeleteHandlers() {
	jQuery('.ewd-otp-delete-message').on('click', function(event) {
		var ID = jQuery(this).data('messagenumber');
		var tr = jQuery('#ewd-otp-email-message-'+ID);

		tr.fadeOut(400, function(){
            tr.remove();
        });

		event.preventDefault();
	});
}

jQuery(document).ready(function() {
	jQuery('input#Field_Name').on('focusout', function() {
		if (jQuery('input#Field_Slug').val() == "") {
			var Name = jQuery(this).val();
			var Name2 = Name.replace(/ /g, '-');
			var Name3 = Name2.toLowerCase();
			var Slug = Name3.replace(/[\/\\\[\]|&;$%@"<>()+,^#*{}'!=:?]/g, "");
			jQuery('input#Field_Slug').val(Slug);
		}
	})
});

jQuery(document).ready(function() {
	jQuery('.ewd-otp-spectrum').spectrum({
		showInput: true,
		showInitial: true,
		preferredFormat: "hex",
		allowEmpty: true
	});

	jQuery('.ewd-otp-spectrum').css('display', 'inline');

	jQuery('.ewd-otp-spectrum').on('change', function() {
		if (jQuery(this).val() != "") {
			jQuery(this).css('background', jQuery(this).val());
			var rgb = EWD_OTP_hexToRgb(jQuery(this).val());
			var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
			if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
			else {jQuery(this).css('color', '#000000');}
		}
		else {
			jQuery(this).css('background', 'none');
		}
	});

	jQuery('.ewd-otp-spectrum').each(function() {
		if (jQuery(this).val() != "") {
			jQuery(this).css('background', jQuery(this).val());
			var rgb = EWD_OTP_hexToRgb(jQuery(this).val());
			var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
			if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
			else {jQuery(this).css('color', '#000000');}
		}
	});
});

function EWD_OTP_hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}


//NEW DASHBOARD MOBILE MENU AND WIDGET TOGGLING
jQuery(document).ready(function($){
	$('#ewd-otp-dash-mobile-menu-open').click(function(){
		$('.EWD_OTP_Menu .nav-tab:nth-of-type(1n+2)').toggle();
		$('#ewd-otp-dash-mobile-menu-up-caret').toggle();
		$('#ewd-otp-dash-mobile-menu-down-caret').toggle();
		return false;
	});
	$(function(){
		$(window).resize(function(){
			if($(window).width() > 785){
				$('.EWD_OTP_Menu .nav-tab:nth-of-type(1n+2)').show();
			}
			else{
				$('.EWD_OTP_Menu .nav-tab:nth-of-type(1n+2)').hide();
				$('#ewd-otp-dash-mobile-menu-up-caret').hide();
				$('#ewd-otp-dash-mobile-menu-down-caret').show();
			}
		}).resize();
	});	
	$('#ewd-otp-dashboard-support-widget-box .ewd-otp-dashboard-new-widget-box-top').click(function(){
		$('#ewd-otp-dashboard-support-widget-box .ewd-otp-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-otp-dash-mobile-support-up-caret').toggle();
		$('#ewd-otp-dash-mobile-support-down-caret').toggle();
	});
	$('#ewd-otp-dashboard-optional-table .ewd-otp-dashboard-new-widget-box-top').click(function(){
		$('#ewd-otp-dashboard-optional-table .ewd-otp-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-otp-dash-optional-table-up-caret').toggle();
		$('#ewd-otp-dash-optional-table-down-caret').toggle();
	});
});


//REVIEW ASK POP-UP
jQuery(document).ready(function() {
    jQuery('.ewd-otp-hide-review-ask').on('click', function() {
        var Ask_Review_Date = jQuery(this).data('askreviewdelay');

        jQuery('.ewd-otp-review-ask-popup, #ewd-otp-review-ask-overlay').addClass('otp-hidden');

        var data = 'Ask_Review_Date=' + Ask_Review_Date + '&action=ewd_otp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
    });
    jQuery('#ewd-otp-review-ask-overlay').on('click', function() {
    	jQuery('.ewd-otp-review-ask-popup, #ewd-otp-review-ask-overlay').addClass('otp-hidden');
    })
});
