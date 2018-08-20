<?php
/*
Plugin Name:  WooCommerce Order Pending To Cancelled Email
Plugin URI:   https://wordpress.org/plugins/woo-order-pending-to-cancelled-email/
Description:  Brings back the email notification when an order status changes from pending to cancelled.
Version:      1.0.0
Author:       Fresh-Media
Author URI:   https://fresh-media.nl/
License:      MIT
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
  function send_order_pending_to_cancelled_email( $order_id, $order = false ) {
    if ( version_compare( WC_VERSION, '3.0.8', '<' ) ) return;
  
    $email_notifications = WC()->mailer()->get_emails();
    $email_notifications['WC_Email_Cancelled_Order']->trigger( $order_id, $order );
  }
  add_action( 'woocommerce_order_status_pending_to_cancelled', 'send_order_pending_to_cancelled_email', 10, 2 );
}
