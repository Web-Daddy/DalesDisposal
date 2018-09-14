<?php
/* Processes the ajax requests being put out in the admin area and the front-end
*  of the OTP plugin */

// AJAX update of the tracking-form shortcode
function EWD_OTP_Update_Orders() {
	$Path = ABSPATH . 'wp-load.php';
	include_once($Path);

	$Fields = array();
	$Field_Names_Array = explode(",", $_POST['Field_Labels']);
	foreach ($Field_Names_Array as $Field_Name) {
		$Field_Name_Key = trim(substr($Field_Name, 0, strpos($Field_Name, "=")));
		$Field_Name_Value = trim(substr($Field_Name, strpos($Field_Name, "=")+5));
		$Fields[$Field_Name_Key] = $Field_Name_Value;
	}
		
	echo EWD_OTP_Return_Results($_POST['Tracking_Number'], $Fields, $_POST['Order_Email']);
}
add_action('wp_ajax_ewd_otp_update_orders', 'EWD_OTP_Update_Orders');
add_action( 'wp_ajax_nopriv_ewd_otp_update_orders', 'EWD_OTP_Update_Orders');

function EWD_OTP_Mobile_Order_Status() {
	$Path = ABSPATH . 'wp-load.php';
	include_once($Path);

	global $wpdb;
	global $EWD_OTP_orders_table_name;
		
	echo $wpdb->get_var($wpdb->prepare("SELECT Order_Status FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $_POST['Tracking_Number']));
}
add_action('wp_ajax_ewd_otp_order_status_mobile', 'EWD_OTP_Mobile_Order_Status');
add_action( 'wp_ajax_nopriv_ewd_otp_order_status_mobile', 'EWD_OTP_Mobile_Order_Status');

// Update the order of custom fields
function EWD_OTP_Custom_Fields_Save_Order(){
	global $wpdb;
	global $EWD_OTP_fields_table_name;
	
	foreach ($_POST['custom-field-item'] as $Key=>$ID) {
		$Result = $wpdb->query("UPDATE $EWD_OTP_fields_table_name SET Field_Order='" . $Key . "' WHERE Field_ID=" . $ID);
	}
}
add_action('wp_ajax_ewd_otp_custom_fields_update_order','EWD_OTP_Custom_Fields_Save_Order');


//REVIEW ASK POP-UP
function EWD_OTP_Hide_Review_Ask(){   
    $Ask_Review_Date = sanitize_text_field($_POST['Ask_Review_Date']);

    update_option('EWD_OTP_Ask_Review_Date', time()+3600*24*$Ask_Review_Date);

    die();
}
add_action('wp_ajax_ewd_otp_hide_review_ask','EWD_OTP_Hide_Review_Ask');