<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/**
 * 	Contributors: mooveagency, gaspar.nemes
 *  Plugin Name: Change Taxonomy Buttons
 *  Plugin URI: http://www.mooveagency.com
 *  Description: Allows to change taxonomy metabox buttons type to Radio, Checkbox, Checkbox with Select All button.
 *  Version: 1.0.1
 *  Author: Moove Agency
 *  Author URI: http://www.mooveagency.com
 *  License: GPLv2
 *  Text Domain: moove
 */

register_activation_hook( __FILE__ , 'moove_radioselect_activate' );
register_deactivation_hook( __FILE__ , 'moove_radioselect_deactivate' );

/**
 * Functions on plugin activation, create relevant pages and defaults for settings page.
 */

function moove_radioselect_activate() {

}

/**
 * Function on plugin deactivation. It removes the pages created before.
 */
function moove_radioselect_deactivate() {

}

include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'moove-view.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'moove-options.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'moove-controller.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'moove-actions.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'moove-functions.php' );

