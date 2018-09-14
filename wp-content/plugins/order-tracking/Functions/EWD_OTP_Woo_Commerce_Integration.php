<?php
$WooCommerce_Integration = get_option("EWD_OTP_WooCommerce_Integration");
if ($WooCommerce_Integration == "Yes") {
	add_action('woocommerce_checkout_order_processed', 'Add_WooCommerce_Order');
	add_action('woocommerce_order_status_changed', 'Update_WooCommerce_Order');
}

function Update_WooCommerce_Order($post_id, $old_status = "", $new_status = "") {
	global $wpdb, $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;

	$Order_Email = get_option("EWD_OTP_Order_Email");
	$Timezone = get_option("EWD_OTP_Timezone");
	date_default_timezone_set($Timezone);

	$Post_Type = get_post_type($post_id); 
	if ($Post_Type == "shop_order") {
		$Post_Status = get_post_status($post_id);
		$Order_Status = Return_WC_Order_Status($Post_Status);

		$Order = $wpdb->get_row($wpdb->prepare("SELECT Order_ID, Order_Status FROM $EWD_OTP_orders_table_name WHERE WooCommerce_ID='%d'", $post_id));
		$Order_ID = $Order->Order_ID;
		$Order_Status_Updated = date("Y-m-d H:i:s");

		if ($Order_Status != $Order->Order_Status and $Order_ID != "") {
			Update_EWD_OTP_Order_Status($Order_ID, $Order_Status, $Order_Status_Updated);
			if ($Order_Email == "Change" and $Order_Email[0]) {EWD_OTP_Send_Email($Order_Email[0], $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name);}
		}
	}

}

function Add_WooCommerce_Order($post_id) {
	global $wpdb, $EWD_OTP_customers, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $Order_ID;

	$Order_Email = get_option("EWD_OTP_Order_Email");
	$Timezone = get_option("EWD_OTP_Timezone");
	date_default_timezone_set($Timezone);

	$WooCommerce_Prefix = get_option("EWD_OTP_WooCommerce_Prefix");
	$WooCommerce_Random_Suffix = get_option("EWD_OTP_WooCommerce_Random_Suffix");

	$Post_Type = get_post_type($post_id); 
	if ($Post_Type == "shop_order") {
		$order = new WC_Order($post_id);
		$WP_ID = $order->get_customer_id();
		$Post_Status = get_post_status($post_id);
		$Order_Status = Return_WC_Order_Status($Post_Status);
		$Order_External_Status = $Order_Status;

		$Order_Key = get_post_meta($post_id, "_order_key", true);
		$Order_Email = get_post_meta($post_id, "_billing_email", true);

		$Customer_First_Name = get_post_meta($post_id, "_billing_first_name", true);
		$Customer_Last_Name = get_post_meta($post_id, "_billing_last_name", true);
		$Customer_Name = $Customer_First_Name . " " . $Customer_Last_Name;
		if ($WP_ID == 0) {$Customer_ID = $wpdb->get_var($wpdb->prepare("SELECT Customer_ID FROM $EWD_OTP_customers WHERE Customer_Name='%s'", $Customer_Name));}
		else {$Customer_ID = $wpdb->get_var($wpdb->prepare("SELECT Customer_ID FROM $EWD_OTP_customers WHERE Customer_WP_ID=%d", $WP_ID));}
		if ($Customer_ID == "") {$Customer_ID = 0;}

		$Order_Name = "WooCommerce Order #" . $post_id;
		$Order_Number = $WooCommerce_Prefix . $post_id . ($WooCommerce_Random_Suffix == "Yes" ? "_" . substr($Order_Key, -4) : '');

		$Order_Location = "";
		$Order_Notes_Public = "";
		$Order_Notes_Private = "";
		$Order_Display = "Yes";
		$Order_Status_Updated = date("Y-m-d H:i:s");
		$Sales_Rep_ID = 0;
		$Order_Payment_Price = 0;
		$Order_Payment_Completed = "Yes";
		$Order_PayPal_Receipt_Number = "";
		$Order_Internal_Status;

		$Message = Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email, $Order_Status, $Order_External_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID, $Order_Payment_Price, $Order_Payment_Completed, $Order_PayPal_Receipt_Number, $Order_Internal_Status, $post_id);
		if (($Order_Email == "Change" or $Order_Email == "Creation") and $Order_Email != "") {EWD_OTP_Send_Email($Order_Email, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name, "Yes");}

		$Fields = $wpdb->get_results("SELECT Field_ID, Field_Equivalent FROM $EWD_OTP_fields_table_name WHERE Field_Equivalent!='' AND Field_Equivalent!='None'");
		foreach ($Fields as $Field) {$wpdb->query($wpdb->prepare("INSERT INTO $EWD_OTP_fields_meta_table_name (Field_ID, Order_ID, Meta_Value) VALUES (%d, %d, %s)", $Field->Field_ID, $Order_ID, get_post_meta($post_id, $Field->Field_Equivalent, true)));}
	}
}


function Return_WC_Order_Status($WC_Status) {
	switch ($WC_Status) {
		case 'wc-pending':
			$OTP_Status = "Pending Payment";
			break;
		case 'wc-processing':
			$OTP_Status = "Processing";
			break;
		case 'wc-on-hold':
			$OTP_Status = "On Hold";
			break;
		case 'wc-completed':
			$OTP_Status = "Completed";
			break;
		case 'wc-cancelled':
			$OTP_Status = "Cancelled";
			break;
		case 'wc-refunded':
			$OTP_Status = "Refunded";
			break;
		case 'wc-failed':
			$OTP_Status = "Failed";
			break;
		default:
			$OTP_Status = "";
			break;
	}

	return $OTP_Status;
}

?>