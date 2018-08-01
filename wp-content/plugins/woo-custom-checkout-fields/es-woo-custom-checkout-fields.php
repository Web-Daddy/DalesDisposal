<?php
/*
	Plugin Name: Woocommerce Custom Checkout Fields Editor With Drag & Drop
	Plugin URI: http://www.easysoftonic.com
	Description: Woocommerce Custom Checkout Fields Editor With Drag & Drop is a most helpful plugin that help you to add edit and delete custom field. 
    Version: 0.1
	Author: Umair Saleem
	
	
	
	Requires at least: 3.3
    Tested up to: 4.7.3
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


 if( !defined( 'wcfew_PLUGIN_URL' ) )
define( 'wcfew_PLUGIN_URL', plugin_dir_url( __FILE__ ) );



load_plugin_textdomain( 'wcfew', false, basename( dirname(__FILE__) ).'/languages' );

//include the classes
include dirname( __FILE__ ) . '/include/eswcfew_core_functions.php';
include dirname( __FILE__ ) . '/include/update_checkout_fields_class.php';
include dirname( __FILE__ ) . '/include/add_order_meta_fields_class.php';
include dirname( __FILE__ ) . '/include/manage_extrafield_class.php';

include dirname( __FILE__ ) . '/include/admin/wcfew_admin_settings.php';



?>