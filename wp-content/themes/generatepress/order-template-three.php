<?php /* Template Name: Order Template Three */ ?>
<?php 

if (!isset($_COOKIE['dales_order_zip_code'])) {
    header('Location:'.  home_url() );
    exit;
};
if (!isset($_COOKIE['slug'])) {
    header('Location:'.  home_url() .'/order' );
    exit;
};
if (!isset($_COOKIE['form_data'])) {
    header('Location:'.  home_url() .'/order-2' );
    exit;
};

parse_str(stripslashes($_COOKIE['form_data']), $form_data);

global $woocommerce;
$woocommerce->cart->empty_cart(); 
foreach ($form_data['product'] as $form_data_post) {
	$woocommerce->cart->add_to_cart($form_data_post['id'], $form_data_post['count'] );
} 
?>
<script>
	<?php 
	$static_holidays = array();

	if( have_rows('static_holidays_repeater') ):
	    while ( have_rows('static_holidays_repeater') ) : the_row();
	        $static_holidays[] = get_sub_field('static_holidays');
	    endwhile;
	endif;
	?>
	var staticHolidays = <?php echo json_encode($static_holidays); ?>;
	<?php 
		$dynamic_holidays = array();
		if( have_rows('dynamic_holidays_repeater') ):
		    while ( have_rows('dynamic_holidays_repeater') ) : the_row();
		        $dynamic_holidays[] = get_sub_field('dynamic_holidays');
		    endwhile;
		endif;
	?>

	var dynamicHolidays = <?php echo json_encode($dynamic_holidays); ?>;
</script>
<?php get_header(); ?>

<div class="template_order">
	<div class="dales_order_cancel_button_container">
		<div class="dales_order_cancel_button">
			<a href="#" id="dales_order_cancel_button_link"><span>&#10006;</span> CANCEL</a>
		</div>
	</div>
	<div class="container">
		<div class="col-12 col-xl-8 col-lg-8 col-md-8 col-sm-12 header_order">
			<div class="row">
				<div class="col-12 col-xl-4 col-lg-4 col-md-4 col-sm-12 line_wrap line_wrap_active">
					<div class="delivery">
						<img class="good_icon_image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/good_icon.png" alt="">
						<div class="delivery_zip_code_container">
							<p class="delivery_text">Delivery to <span><?php echo $_COOKIE['dales_order_zip_code'] ?></span></p>
							<!-- <a href="#" class="open_zip_code_search"><img src="/wp-content/uploads/2018/07/hint.png"><span>You can change ZIP code right now by clicking here</span></a> -->
						</div>
					</div>					
				</div>
				<div class="col-12 col-xl-4 col-lg-4 col-md-4 col-sm-12 line_wrap">
					<div class="material_container active">
						<img class="good_icon_image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/good_icon.png" alt="">
						<p class="material_text">Material/Container</p>
					</div>
				</div>
				<div class="col-12 col-xl-4 col-lg-4 col-md-4 col-sm-12">
					<div class="delivery_date active">
						<img class="good_icon_image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/good_icon.png" alt="">
						<p class="material_text">Delivery Date</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="template_order_content">
	<div class="container">
		<div class="go_back_btn three">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/go_back_icon.png" alt="">
			<span>Go Back</span>
		</div>
		<div class="header_template_order_content three">
			<h5 class="title_header_template_order_content">Step 3</h5>
			<h3 class="title_select_header_template_order_content">Delivery Date</h3>
			<a href="/contact-us/" class="need_help_header_order_content">Need Help? Click here</a>
			<p class="text_header_order_content">All containers rentals have a 14-day rental term</p>
		</div>
		<div class="error_message_order_step_three_success">
			<i class="fas fa-exclamation-triangle"></i>
			<p class="text_error_message">Please indicate the type of location we'll be delivering to.</p>
			<i class="fas fa-times dales_delivery_date_info_close"></i>
		</div>
		<div class="error_message_order_step_three">
			<i class="fas fa-exclamation-triangle"></i>
			<p class="text_error_message">The term of rent must be 2 days or more.</p>
			<i class="fas fa-times dales_delivery_date_info_close"></i>
		</div>
		<div class="row">
			<div class="col-12 col-xl-6 col-lg-4 col-md-12 col-sm-12 date_left_block">
				<div class="block_left_inner">		
				<?php if(get_field('title_early') || get_field('text_early')){ ?>		
					<div class="delivery_black"></div>
					<div class="title_left_block_date">
						<h3><?php echo get_field('title_early'); ?></h3>
					</div>
					<div class="text_left_block_date">
						<p><?php echo get_field('text_early'); ?></p>
					</div>
				<?php } ?>
				<?php if(get_field('title_rental') || get_field('text_rental')){ ?>
					<div class="delivery_black"></div>
					<div class="title_left_block_date">
						<h3><?php echo get_field('title_rental'); ?></h3>
					</div>
					<div class="text_left_block_date">
						<p><?php echo get_field('text_rental'); ?></p>
					</div>
				<?php } ?>
				<?php if(get_field('title_holidays') || get_field('text_holidays')){ ?>
					<div class="delivery_black"></div>
					<div class="title_left_block_date">
						<h3><?php echo get_field('title_holidays'); ?></h3>
					</div>
					<div class="text_left_block_date">
						<p><?php echo get_field('text_holidays'); ?></p>
					</div>
				<?php } ?>
				</div>
			</div>
			<div class="col-12 col-xl-6 col-lg-8 col-md-12 col-sm-12 date_right_block">
				<div class="title_datepicker">
					<div class="left_section_title_datepicker">
						<p class="label_deliver_title_datepicker">Deliver</p>
						<div class="date_deliver_title_datepicker">
							<div class="count_date_deliver_title_datepicker current_day"></div>
							<div class="text_date_deliver_title_datepicker">
								<p class="year_text_date current_day"></p>
								<p class="hidden_text_date current_day"></p>
							</div>
						</div>
					</div>
					<div class="center_section_title_datepicker">
						<!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/delivery_date_icon.png" width="auto" height="auto" alt=""> -->
					</div>
					<div class="right_section_title_datepicker">
						<p class="label_deliver_title_datepicker">Pickup</p>
						<div class="date_deliver_title_datepicker">
							<div class="count_date_deliver_title_datepicker last_day"></div>
							<div class="text_date_deliver_title_datepicker">
								<p class="year_text_date last_day"></p>
								<p class="hidden_text_date last_day"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="datepicker-here"></div>
				<div class="text_need_more">
					<p>Need more time? $25.00 for each additional week</p>
				</div>
				<div class="btn_submit_order">
					<a href="#" class="btn_submit_order_go step_3">Go to checkout</a>
				</div>
			</div>
		</div>
	</div>
</div>


<?php

	$tax_args = array(
		'taxonomy' => 'zip_code',
		'hide_empty' => false,
	);

	$zip_codes_tax = get_terms( $tax_args );

	$zip_codes_tax_array = array();
	foreach ($zip_codes_tax as $zip_code_name) {

		$zip_codes_tax_array[] = substr($zip_code_name->name, 0, 5);
	}

?>

<script type="text/javascript">
	
	jQuery(document).ready(function($) {
		

		$('#dales_search_form').on('submit', function(e) {
			e.preventDefault();
			var zip_codes = [<?php echo implode(',', $zip_codes_tax_array); ?>];
			var input_value = jQuery('.input_zip_code').val().substring(0, 5);
			var input_index = zip_codes.indexOf(+input_value);
			if(input_index >= 0 ){
				setCookieDales("dales_order_zip_code", input_value, {"path":"/"});
				jQuery('.pum-close.popmake-close').click();
				jQuery('.delivery_text span').html(input_value);
				// window.location.replace("/order-2/");
			} else {
				jQuery('.search_zip_code_error_container').css('display', 'block');
			}
		});
		jQuery(document).on("click", '.search_zip_code_error_close_button', function(){
			jQuery('.search_zip_code_error_container').css('display', 'none');
		});
		function setCookieDales(name, value, options) {
	  options = options || {};

	  var expires = options.expires;

	  if (typeof expires == "number" && expires) {
	    var d = new Date();
	    d.setTime(d.getTime() + expires * 1000);
	    expires = options.expires = d;
	  }
	  if (expires && expires.toUTCString) {
	    options.expires = expires.toUTCString();
	  }

	  value = encodeURIComponent(value);

	  var updatedCookie = name + "=" + value;

	  for (var propName in options) {
	    updatedCookie += "; " + propName;
	    var propValue = options[propName];
	    if (propValue !== true) {
	      updatedCookie += "=" + propValue;
	    }
	  }

	  document.cookie = updatedCookie;
	};
 
	});
</script>
<?php get_footer(); ?>
