<?php
/**
 * GeneratePress.
 *
 * Please do not make any edits to this file. All edits should be done in a child theme.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Set our theme version.
define( 'GENERATE_VERSION', '2.1.3' );

if ( ! function_exists( 'generate_setup' ) ) {
	add_action( 'after_setup_theme', 'generate_setup' );
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 0.1
	 */
	function generate_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'generatepress' );

		// Add theme support for various features.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'status' ) );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'custom-logo', array(
			'height' => 70,
			'width' => 350,
			'flex-height' => true,
			'flex-width' => true,
		) );

		// Register primary menu.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'generatepress' ),
		) );

		/**
		 * Set the content width to something large
		 * We set a more accurate width in generate_smart_content_width()
		 */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 1200; /* pixels */
		}

		// This theme styles the visual editor to resemble the theme style.
		add_editor_style( 'css/admin/editor-style.css' );
	}
}



add_action( 'wp_enqueue_scripts', 'dales_register_scripts' );

function dales_register_scripts() {
	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/custom-style.css' );
	wp_enqueue_style( 'jquery-formstyler', get_template_directory_uri() . '/css/jquery.formstyler.css');
	wp_enqueue_style( 'jquery-themeformstyler', get_template_directory_uri() . '/css/jquery.formstyler.theme.css');
	wp_enqueue_style( 'datepicker-style', get_template_directory_uri() . '/css/datepicker.min.css');
	wp_enqueue_script( 'mask_script', get_template_directory_uri() . '/js/jquery_mask.js' );
	wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/js/custom_dales.js' );
	wp_localize_script( 'custom-script', 'wp_links', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	wp_enqueue_script( 'jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.js' , array('jquery') );
	wp_enqueue_script( 'jquery-formstyler', get_template_directory_uri() . '/js/jquery.formstyler.min.js' , array('jquery') );
	wp_enqueue_script( 'datepicker-script', get_template_directory_uri() . '/js/datepicker.js' );
	wp_enqueue_script( 'datepicker-script-eng', get_template_directory_uri() . '/js/datepicker.en.js' );
	
}

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'dales_active ';
    }
    return $classes;
}

/**
 * Get all necessary theme files
 */
require get_template_directory() . '/inc/theme-functions.php';
require get_template_directory() . '/inc/defaults.php';
require get_template_directory() . '/inc/class-css.php';
require get_template_directory() . '/inc/css-output.php';
require get_template_directory() . '/inc/general.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/markup.php';
require get_template_directory() . '/inc/element-classes.php';
require get_template_directory() . '/inc/typography.php';
require get_template_directory() . '/inc/plugin-compat.php';
require get_template_directory() . '/inc/migrate.php';
require get_template_directory() . '/inc/deprecated.php';

if ( is_admin() ) {
	require get_template_directory() . '/inc/meta-box.php';
	require get_template_directory() . '/inc/dashboard.php';
}

/**
 * Load our theme structure
 */
require get_template_directory() . '/inc/structure/archives.php';
require get_template_directory() . '/inc/structure/comments.php';
require get_template_directory() . '/inc/structure/featured-images.php';
require get_template_directory() . '/inc/structure/footer.php';
require get_template_directory() . '/inc/structure/header.php';
require get_template_directory() . '/inc/structure/navigation.php';
require get_template_directory() . '/inc/structure/post-meta.php';
require get_template_directory() . '/inc/structure/sidebars.php';


function find_product_from_coockie ($prod_id) {
	if (isset($_COOKIE['form_data']) && !empty($_COOKIE['form_data'])) {
		parse_str(stripslashes($_COOKIE['form_data']), $form_prod_data);
		if (!isset($form_prod_data['product']) || empty($form_prod_data['product'])) {
			return;
		}
		$form_prod_data = $form_prod_data['product'];
		foreach ($form_prod_data  as $prod_row => $prod_data) {
			if ($prod_data['id'] == $prod_id) {
				return $form_prod_data[$prod_row];
			}
		}
	}
	return false;
}

function file_upload_email_function(){
	global $form_error;
	$success = false;
	$form_error = new WP_Error;
	$data = $_POST;
	$email = get_option('admin_email');
	if (empty($data)) {
        return $form_error;
    }
	$name_of_uploaded_file = basename($_FILES['uploaded_file']['name']);
	// f(!isset($name_of_uploaded_file) || trim($name_of_uploaded_file) == ''){
	// 	$form_error->add('no_current_first_name', "Missing current first name");
	// }i
	$type_of_uploaded_file = substr($name_of_uploaded_file, strrpos($name_of_uploaded_file, '.') + 1);
	$size_of_uploaded_file = $_FILES["uploaded_file"]["size"]/1024;
	//Settings
	$max_allowed_file_size = 1000; // size in KB
	$allowed_extensions = array("pdf", "jpg", "jpeg", "doc", "docx");
	// Allowed types also are configured in custom-dales.js
	//Validations
	if($size_of_uploaded_file > $max_allowed_file_size )
	{
	  $form_error->add('not_valid_weight_file', "Not a valid file weight. The maximum weight is 1000 KB.");
	}

	//------ Validate the file extension -----
	$allowed_ext = false;
	for($i=0; $i<sizeof($allowed_extensions); $i++)
	{
	  if(strcasecmp($allowed_extensions[$i],$type_of_uploaded_file) == 0)
	  {
	    $allowed_ext = true;
	  }
	}

	if(!$allowed_ext)
	{
		$form_error->add('not_valid_type_file', "The uploaded file is not supported file type. The correct type files are : pdf, jpg, doc, docx");
	}

	if ($form_error->get_error_code()) {
        return $form_error; // stop scrip if we alredy have some error
    }

	$upload_folder = WP_CONTENT_DIR . "/uploads/email_files";
	if(!is_dir($upload_folder)) {
		$is_folder_exist = mkdir($upload_folder);
	} else {
		$is_folder_exist = true;
	}

	if ($is_folder_exist) {
		$file_path = $upload_folder . "/" . $_FILES['uploaded_file']['name'];
		$is_file_uploaded = move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path);
		if ($is_file_uploaded) {
			$headers = 'From: Dales <noreply@dales.wemes.com.ua>' . "\r\n";
			$is_mail_sended = wp_mail( $email, 'Submitted resume', 'Here is uploaded resume from website ' . $_FILES['uploaded_file']['name'], $headers, $file_path);
			@unlink($file_path);
			if ($is_mail_sended) {
				echo "<div class='alert alert-success'><p><strong>Success!</strong> File was successfully sent.</p></div>";
			} else {
				$form_error->add('email_fail_upload', "Error happend. Please contact us.");
				return $form_error;
			}
		}
	}
}

function debug_data ($data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}


add_action( 'init', 'custom_taxonomy_zip_code' );

function custom_taxonomy_zip_code()  {

$labels = array(

    'name'                       => 'Zip Codes',

    'singular_name'              => 'Zip Code',

    'menu_name'                  => 'Zip Code',

    'all_items'                  => 'All Zip Codes',

    'parent_item'                => 'Parent Zip Code',

    'parent_item_colon'          => 'Parent Zip Code:',

    'new_item_name'              => 'New Zip Code Name',

    'add_new_item'               => 'Add New Zip Code',

    'edit_item'                  => 'Edit Zip Code',

    'update_item'                => 'Update Zip Code',

    'separate_items_with_commas' => 'Separate Zip Code with commas',

    'search_items'               => 'Search Zip Codes',

    'add_or_remove_items'        => 'Add or remove Zip Codes',

    'choose_from_most_used'      => 'Choose from the most used Zip Codes',

);

$args = array(

    'labels'                     => $labels,

    'hierarchical'               => true,

    'public'                     => true,

    'show_ui'                    => true,

    'show_admin_column'          => false,

    'show_in_nav_menus'          => true,

    'show_tagcloud'              => true,

);

register_taxonomy( 'zip_code', 'product', $args );

register_taxonomy_for_object_type( 'zip_code', 'product' );

}



// Add Variation Settings

add_action( 'woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3 );

// Save Variation Settings

add_action( 'woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2 );

/**

 * Create new fields for variations

 *

*/

function variation_settings_fields( $loop, $variation_data, $variation ) {

	// Text Field

	woocommerce_wp_text_input( 

		array( 

			'id'          => 'variation_size[' . $variation->ID . ']', 

			'label'       => __( 'Size', 'woocommerce' ),

			'placeholder' => "18' long x 8' wide x 3' high", 

			'desc_tip'    => 'true',

			'description' => __( 'Enter Container Dimension Here.', 'woocommerce' ),

			'value'       => get_post_meta( $variation->ID, 'variation_size', true )

		)

	);

	// Number Field

	woocommerce_wp_text_input( 

		array( 

			'id'          => 'variation_weight[' . $variation->ID . ']', 

			'label'       => __( 'Weight', 'woocommerce' ),

			'placeholder' => "3 TON WEIGHT LIMIT (6,000 LBS) $47.50 PER TON OVERWEIGHT", 			

			'desc_tip'    => 'Enter Container Weight Here.',

			'description' => __( 'Enter Container Weight Here.', 'woocommerce' ),

			'value'       => get_post_meta( $variation->ID, 'variation_weight', true )

		)

	);

	

}

/**

 * Save new fields for variations

 *

*/

function save_variation_settings_fields( $post_id ) {

	// Text Field

	$variation_size = $_POST['variation_size'][ $post_id ];

	if( ! empty( $variation_size ) ) {

		update_post_meta( $post_id, 'variation_size', esc_attr( $variation_size ) );

	}

	

	// Number Field

	$variation_weight = $_POST['variation_weight'][ $post_id ];

	if( ! empty( $variation_weight ) ) {

		update_post_meta( $post_id, 'variation_weight', esc_attr( $variation_weight ) );

	}

	

}

add_filter( 'woocommerce_checkout_fields' , 'bbloomer_remove_billing_postcode_checkout' );
 
function bbloomer_remove_billing_postcode_checkout( $fields ) {
  unset($fields['billing']['billing_postcode']);
  return $fields;
}

function woo_add_cart_fee() {
 
  global $woocommerce;

$additional_rent_price = 0;
if (isset($_COOKIE['rent_time_range'])) {
    $rent_time = $_COOKIE['rent_time_range'];
    $dales_cart_count_rent = WC()->cart->get_cart_contents_count();
	$additional_rent_price = ceil(($rent_time - 14) / 7) * 25 * $dales_cart_count_rent;
};


  $woocommerce->cart->add_fee( __('Price of additional rent', 'woocommerce'), $additional_rent_price );
	
}
add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );

function dales_cart_shortcode_func( $atts ){
	$dales_cart_count = WC()->cart->get_cart_contents_count();
	if ( $dales_cart_count == 0 ){ 
		$dales_cart_count_link = '<a href="#" class="dales_cart_count_link">'.$dales_cart_count.'</a>';
	} else {
		$dales_cart_count_link = '<a href="/checkout-dales/" class="dales_cart_count_link">'.$dales_cart_count.'</a>';
	}
	
	return $dales_cart_count_link;
}
add_shortcode('dales_cart_shortcode', 'dales_cart_shortcode_func');

add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );



//remove Order Notes Field
add_filter( 'woocommerce_checkout_fields' , 'remove_order_notes' );

function remove_order_notes( $fields ) {
     unset($fields['order']['order_comments']);
     return $fields;
}

/**
 * Disable the emoji's
 */
function disable_emojis() {
 remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
 remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
 remove_action( 'wp_print_styles', 'print_emoji_styles' );
 remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
 remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
 remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
 remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
 add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
 add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
 if ( is_array( $plugins ) ) {
 return array_diff( $plugins, array( 'wpemoji' ) );
 } else {
 return array();
 }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
 if ( 'dns-prefetch' == $relation_type ) {
 /** This filter is documented in wp-includes/formatting.php */
 $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

$urls = array_diff( $urls, array( $emoji_svg_url ) );
 }

return $urls;
}


add_action( 'woocommerce_payment_complete', 'so_payment_complete' );
function so_payment_complete( $order_id ){
	setcookie( "dales_order_complete", "order status is complete", time() + (86400 * 30), "/");
	if (isset($_COOKIE['dales_order_zip_code'])) {
	    unset($_COOKIE['dales_order_zip_code']);
	    setcookie('dales_order_zip_code', '', time() - 3600, '/'); 
	};
	if (isset($_COOKIE['slug'])) {
	    unset($_COOKIE['slug']);
	    setcookie('slug', '', time() - 3600, '/'); 
	};
	if (isset($_COOKIE['form_data'])) {
	    unset($_COOKIE['form_data']);
	   	setcookie('form_data', '', time() - 3600, '/'); 
	};
	if (isset($_COOKIE['date_range'])) {
	    unset($_COOKIE['date_range']);
	    setcookie('date_range', '', time() - 3600, '/'); 
	};
	return false;
}

add_action('wp_ajax_clearcart', 'clearcart');
add_action('wp_ajax_nopriv_clearcart', 'clearcart');

function clearcart (){
	if (isset($_COOKIE['dales_order_zip_code'])) {
	    unset($_COOKIE['dales_order_zip_code']);
	    setcookie('dales_order_zip_code', '', time() - 3600, '/'); 
	};
	if (isset($_COOKIE['slug'])) {
	    unset($_COOKIE['slug']);
	    setcookie('slug', '', time() - 3600, '/'); 
	};
	if (isset($_COOKIE['form_data'])) {
	    unset($_COOKIE['form_data']);
	   	setcookie('form_data', '', time() - 3600, '/'); 
	};
	if (isset($_COOKIE['date_range'])) {
	    unset($_COOKIE['date_range']);
	    setcookie('date_range', '', time() - 3600, '/'); 
	};
    global $woocommerce;
    $woocommerce->cart->empty_cart();
    wp_send_json(['status'=> 'done', 'home_url'=> home_url('/')], 200);
}


function cloudways_custom_checkout_fields($fields){
	if (isset($_COOKIE['date_range'])) {
		$date = $_COOKIE['date_range'];
		$date = stripcslashes($date);
		$date = json_decode($date);
		$dales_current_date = date("m/d/Y", strtotime($date->current_date));
		$dales_last_date = date("m/d/Y", strtotime($date->last_date));
	};
	if (isset($_COOKIE['dales_order_zip_code'])) {
	    $dales_zip_code = $_COOKIE['dales_order_zip_code'];
	};
$fields['cloudways_extra_fields'] = array(
            'dales_zip_code' => array(
		        'label'     => __('ZIP code', 'woocommerce'),
		        'placeholder'   => _x('ZIP code', 'placeholder', 'woocommerce'),
		        'required'  => false,
		        'class'     => array('form-row-wide dales_zip_code_checkout_filed'),
		        'clear'       => true,
		        'type'        => 'text',
		        'default' 	=> $dales_zip_code,
		        'custom_attributes'	=> array('readonly'=>'readonly')
                ),
            'dales_current_date' => array(
		        'label'     => __('Deliver on', 'woocommerce'),
		        'placeholder'   => _x('First date', 'placeholder', 'woocommerce'),
		        'required'  => false,
		        'class'     => array('form-row-wide dales_current_date_checkout_filed'),
		        'clear'       => true,
		        'type'        => 'text',
		        'default' 	=> $dales_current_date,
		        'custom_attributes'	=> array('readonly'=>'readonly')
                ),
            'dales_last_date' => array(
		        'label'     => __('Return on', 'woocommerce'),
		        'placeholder'   => _x('Last date', 'placeholder', 'woocommerce'),
		        'required'  => false,
		        'class'     => array('form-row-wide dales_last_date_checkout_filed'),
		        'clear'       => true,
		        'type'        => 'text',
		        'default' 	=> $dales_last_date,
		        'custom_attributes'	=> array('readonly'=>'readonly')
                )
            );

     return $fields;
}

add_filter( 'woocommerce_checkout_fields', 'cloudways_custom_checkout_fields' );

function cloudways_extra_checkout_fields(){

   $checkout = WC()->checkout(); ?>

    <div class="extra-fields" style="display: none;">
    <h3><?php  _e( 'Rent Information' ); ?></h3> 

    <?php
        foreach ( $checkout->checkout_fields['cloudways_extra_fields'] as $key => $field ) : ?>

            <?php  woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

        <?php  endforeach; ?>
    </div>

<?php  }
add_action( 'woocommerce_checkout_after_customer_details' ,'cloudways_extra_checkout_fields' );



function cloudways_save_extra_checkout_fields( $order_id, $posted ){
    // don't forget appropriate sanitization if you are using a different field type
    if( isset( $posted['dales_zip_code'] ) ) {
        update_post_meta( $order_id, '_dales_zip_code', sanitize_text_field( $posted['dales_zip_code'] ) );
    }
    if( isset( $posted['dales_current_date'] ) ) {
        update_post_meta( $order_id, '_dales_current_date', sanitize_text_field( $posted['dales_current_date'] ) );
    }
    if( isset( $posted['dales_last_date'] ) ) {
        update_post_meta( $order_id, '_dales_last_date', sanitize_text_field( $posted['dales_last_date'] ) );
    }

}
add_action( 'woocommerce_checkout_update_order_meta', 'cloudways_save_extra_checkout_fields', 10, 2 );


function cloudways_display_order_data( $order_id ){  ?>
    <h2><?php _e( 'Additional Information' ); ?></h2>
    <table class="shop_table shop_table_responsive additional_info">
        <tbody>
            <tr>
                <th><?php _e( 'ZIP Code' ); ?></th>
                <td><?php echo get_post_meta( $order_id, '_dales_zip_code', true ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Deliver on' ); ?></th>
                <td><?php echo get_post_meta( $order_id, '_dales_current_date', true ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Return on' ); ?></th>
                <td><?php echo get_post_meta( $order_id, '_dales_last_date', true ); ?></td>
            </tr>
        </tbody>
    </table>
<?php }
// add_action( 'woocommerce_thankyou', 'cloudways_display_order_data', 20 );
add_action( 'woocommerce_view_order', 'cloudways_display_order_data', 20 );


function cloudways_display_order_data_in_admin( $order ){  ?>
    <div class="order_data_column">

        <h4><?php _e( 'Additional Information', 'woocommerce' ); ?><a href="#" class="edit_address"><?php _e( 'Edit', 'woocommerce' ); ?></a></h4>
        <div class="address">
        <?php
        	echo '<p><strong>' . __( 'ZIP Code' ) . ':</strong>' . get_post_meta( $order->id, '_dales_zip_code', true ) . '</p>';
            echo '<p><strong>' . __( 'Deliver on' ) . ':</strong>' . get_post_meta( $order->id, '_dales_current_date', true ) . '</p>';
            echo '<p><strong>' . __( 'Return on' ) . ':</strong>' . get_post_meta( $order->id, '_dales_last_date', true ) . '</p>'; ?>
        </div>
        <div class="edit_address">
        	<?php woocommerce_wp_text_input( array( 'id' => '_dales_zip_code', 'label' => __( 'ZIP Code' ), 'wrapper_class' => '_billing_company_field' ) ); ?>
            <?php woocommerce_wp_text_input( array( 'id' => '_dales_current_date', 'label' => __( 'Deliver on' ), 'wrapper_class' => '_billing_company_field' ) ); ?>
            <?php woocommerce_wp_text_input( array( 'id' => '_dales_last_date', 'label' => __( 'Return on' ), 'wrapper_class' => '_billing_company_field' ) ); ?>
        </div>
    </div>
<?php }
add_action( 'woocommerce_admin_order_data_after_order_details', 'cloudways_display_order_data_in_admin' );


function cloudways_save_extra_details( $post_id, $post ){
	update_post_meta( $post_id, '_dales_zip_code', wc_clean( $_POST[ '_dales_zip_code' ] ) );
    update_post_meta( $post_id, '_dales_current_date', wc_clean( $_POST[ '_dales_current_date' ] ) );
    update_post_meta( $post_id, '_dales_last_date', wc_clean( $_POST[ '_dales_last_date' ] ) );
}
add_action( 'woocommerce_process_shop_order_meta', 'cloudways_save_extra_details', 45, 2 );


function cloudways_email_order_meta_fields( $fields, $sent_to_admin, $order ) {
    $fields['dales_field1'] = array(
                'label' => __( 'ZIP Code' ),
                'value' => get_post_meta( $order->id, '_dales_zip_code', true ),
            );
    $fields['dales_field2'] = array(
                'label' => __( 'Deliver on' ),
                'value' => get_post_meta( $order->id, '_dales_current_date', true ),
            );
    $fields['dales_field3'] = array(
                'label' => __( 'Return on' ),
                'value' => get_post_meta( $order->id, '_dales_last_date', true ),
            );
    return $fields;
}
add_filter('woocommerce_email_order_meta_fields', 'cloudways_email_order_meta_fields', 10, 3 );

// function cloudways_show_email_order_meta( $order, $sent_to_admin, $plain_text ) {
// 	$dales_zip_code = get_post_meta( $order->id, '_dales_zip_code', true );
//     $dales_current_date = get_post_meta( $order->id, '_dales_current_date', true );
//     $dales_last_date = get_post_meta( $order->id, '_dales_last_date', true );
//     if( $plain_text ){
//         echo 'The value for some field is ' . $dales_current_date . ' while the value of another field is ' . $dales_last_date;
//     } else {
//         echo '<p>The value for <strong>input text field</strong> is ' . $dales_current_date. ' while the value of <strong>drop down</strong> is ' . $dales_last_date . '</p>';
//     }
// }
// add_action('woocommerce_email_customer_details', 'cloudways_show_email_order_meta', 30, 3 );


function CM_woocommerce_account_menu_items_callback($items) {
    unset( $items['downloads'] );
    unset( $items['bookings'] );
    return $items;
}
add_filter('woocommerce_account_menu_items', 'CM_woocommerce_account_menu_items_callback', 10, 1);


function auto_login_new_user( $user_id ) {
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
    wp_redirect( home_url() );
}


