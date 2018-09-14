<?php 
/* The function that creates the HTML on the front-end, based on the parameters
* supplied in the product-catalog shortcode */
function Insert_Customer_Form($atts) {
	global $user_message;
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_customers;
		
	$Custom_CSS = get_option('EWD_OTP_Custom_CSS');
	$New_Window = get_option("EWD_OTP_New_Window");
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
	$Order_Instructions = get_option("EWD_OTP_Form_Instructions");
	$Order_Form_Title = get_option("EWD_OTP_Tracking_Title_Label");
	$Order_Field_Text = get_option("EWD_OTP_Tracking_Ordernumber_Label");
	$Email_Field_Text = get_option("EWD_OTP_Tracking_Email_Label");
	$Submit_Text = get_option("EWD_OTP_Tracking_Button_Label");
	
	$ReturnString = "";
		
	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
		 		'order_form_title' => __('Track your Orders', 'order-tracking'),
				'order_field_text' => __('Customer Number', 'order-tracking'),
				'email_field_text' => __('Customer E-mail', 'order-tracking'),
				'email_field_shortcode' => '',
				'email_field_shortcode_attribute' => '',
				'email_field_attribute_value' => '',
				'order_instructions' => __('Enter your customer ID in the form below to track your orders.', 'order-tracking'),
				'field_names' => '',
				'submit_text' => __('Track', 'order-tracking')),
		$atts
		)
	);
		
	if ($order_instructions != __('Enter the order number you would like to track in the form below.', 'order-tracking') or $Order_Instructions == "") {$Order_Instructions = $order_instructions;}
	if ($order_form_title != __('Track an Order', 'order-tracking') or $Order_Form_Title == "") {$Order_Form_Title = $order_form_title;}
	if ($order_field_text != __('Customer Number', 'order-tracking') or $Order_Field_Text == "") {$Order_Field_Text = $order_field_text;}
	if ($email_field_text != __('Customer E-mail', 'order-tracking') or $Email_Field_Text == "") {$Email_Field_Text = $email_field_text;}
	if ($submit_text != __('Track', 'order-tracking') or $Submit_Text == "") {$Submit_Text = $submit_text;}

	$ReturnString .= "<style type='text/css'>";
	$ReturnString .= EWD_OTP_Add_Modified_Styles();
	$ReturnString .= $Custom_CSS;
	$ReturnString .= "</style>";
		
	$Fields = array();
	$Field_Names_Array = explode(",", $field_names);
	foreach ($Field_Names_Array as $Field_Name) {
		$Field_Name_Key = trim(substr($Field_Name, 0, strpos($Field_Name, "=>")));
		$Field_Name_Value = trim(substr($Field_Name, strpos($Field_Name, "=>")+2));
		$Fields[$Field_Name_Key] = $Field_Name_Value;
	}
		
	//If there's a tracking number that's already been submitted, display the results
	$FEUP_Installed = "";

	$WP_User = wp_get_current_user();
	if (function_exists('EWD_FEUP_Get_All_Users')) {
		$FEUP_Installed = true;
		$FEUP_User = new FEUP_User();
	}

	$Customer_ID = '';
	$Customer_Email = '';
	if (isset($_POST['Customer_ID'])) {
		$Customer_ID = $_POST['Customer_ID'];
		$Customer_Email = (isset($_POST['Customer_Email'])) ? $_POST['Customer_Email']: '';
	}
	elseif ($FEUP_Installed and $FEUP_User->Is_Logged_In()) {
		$Customer = $wpdb->get_row($wpdb->prepare("SELECT Customer_ID, Customer_Email FROM $EWD_OTP_customers WHERE Customer_FEUP_ID=%d", $FEUP_User->Get_User_ID()));
		if (is_object($Customer)) {$Customer_ID = $Customer->Customer_ID;}
		if (is_object($Customer)) {$Customer_Email = $Customer->Customer_Email;}
	}
	elseif ($WP_User->ID != 0) {
		$Customer = $wpdb->get_row($wpdb->prepare("SELECT Customer_ID, Customer_Email FROM $EWD_OTP_customers WHERE Customer_WP_ID=%d", $WP_User->ID));
		if (is_object($Customer)) {$Customer_ID = $Customer->Customer_ID;}
		if (is_object($Customer)) {$Customer_Email = $Customer->Customer_Email; }
	}

	if ($Customer_ID != '') {
		$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
		$ReturnString .= "<div class='pure-u-1'><h3>" . __("Order Information", 'order-tracking') . "</h3></div>";
		$ReturnString .= EWD_OTP_Return_Customer_Results($Customer_ID, $Fields, $Customer_Email);
		$ReturnString .= "</div>";
	}
		
	//Put in the tracking form
	$ReturnString .= "<div id='ewd-otp-tracking-form-div' class='mt-12'>";
	$ReturnString .= "<h3>" . $order_form_title . "</h3>";
	$ReturnString .= "<div class='ewd-otp-message mb-6'>";
	$ReturnString .= $user_message;
	$ReturnString .= $Order_Instructions;
	$ReturnString .= "</div>";
	if ($New_Window == "Yes") {$ReturnString .= "<form action='#' method='post' target='_blank' id='ewd-otp-tracking-form' class='pure-form pure-form-aligned'>";}
	else {$ReturnString .= "<form action='#' method='post' id='ewd-otp-tracking-form' class='pure-form pure-form-aligned'>";}
	$ReturnString .= "<input type='hidden' name='ewd-otp-action' value='customer-track'>";
	$ReturnString .= "<div class='pure-control-group'>";
	$ReturnString .= "<label for='Order_Number' id='ewd-otp-order-number-div' class='ewd-otp-field-label ewd-otp-bold'>" . $order_field_text . ": </label>";
	$ReturnString .= "<input type='text' class='ewd-otp-text-input' name='Customer_ID' placeholder='" . $order_field_text . "...'>";
	$ReturnString .= "</div>";
	if ($Email_Confirmation == "Order_Email") {
		$ReturnString .= "<div class='pure-control-group'>";
		$ReturnString .= "<label for='Order_Email' id='ewd-otp-order-number-div' class='ewd-otp-field-label ewd-otp-bold'>" . $email_field_text . ": </label>";
		$ReturnString .= "<input type='email' class='ewd-otp-text-input' name='Customer_Email' placeholder='" . $email_field_text . "...'>";
		$ReturnString .= "</div>";
	}
	if ($Email_Confirmation == "Auto_Entered") {
		$ReturnString .= "<input type='hidden' class='ewd-otp-text-input' name='Customer_Email' value='[" . $email_field_shortcode . " " . $email_field_shortcode_attribute . "=" . $email_field_attribute_value . "]'>";
	}
	$ReturnString .= "<div class='pure-control-group'>";
	$ReturnString .= "<label for='Submit'></label><input type='submit' class='ewd-otp-submit pure-button pure-button-primary' name='Login_Submit' value='" . $submit_text . "'>";
	$ReturnString .= "</div>";
	$ReturnString .= "</form>";
	$ReturnString .= "</div>";
		
	return $ReturnString;
}
add_shortcode("customer-form", "Insert_Customer_Form");
