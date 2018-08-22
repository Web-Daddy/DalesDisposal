<?php /* Template Name: Dales Checkout Template */ ?>
<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
};


if (!isset($_COOKIE['dales_order_complete'])) {
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
	if (!isset($_COOKIE['date_range'])) {
	    header('Location:'.  home_url() .'/delivery-date' );
	    exit;
	};
}
$date = $_COOKIE['date_range'];
$date = stripcslashes($date);
$date = json_decode($date);
$dales_current_date = date("F d", strtotime($date->current_date));
if (isset($_COOKIE['rent_time_range'])) {
    $rent_time = $_COOKIE['rent_time_range'];
    $dales_cart_count_rent = WC()->cart->get_cart_contents_count();
	$additional_rent_price = ceil(($rent_time - 14) / 7) * 25 * $dales_cart_count_rent;
	$dales_cart_total = $woocommerce->cart->get_cart_contents_total();
	$dales_total_amount_rent = $dales_cart_total + $additional_rent_price;
};

get_header(); ?>
	<div id="primary" <?php generate_content_class();?>>
		<main id="main" <?php generate_main_class(); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			while ( have_posts() ) : the_post(); ?>

				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_article_schema( 'CreativeWork' ); ?>>
					<div class="inside-article">
						<?php
						/**
						 * generate_before_content hook.
						 *
						 * @since 0.1
						 *
						 * @hooked generate_featured_page_header_inside_single - 10
						 */
						do_action( 'generate_before_content' );
						?>
						<?php if(isset($_COOKIE['date_range'])) { ?>
							<div class="dales_checkout_header_info_conteiner">
								<div class="dales_order_cancel_button_container">
									<div class="dales_order_cancel_button">
										<a href="#" id="dales_order_cancel_button_link"><span>&#10006;</span> CANCEL</a>
									</div>
								</div>
								<div class="dales_checkout_header_info">
									<div class="dales_checkout_header_info_col">
										<div>
											<img src="<?php echo get_template_directory_uri(); ?>/images/dales_checkout_car.jpg">
										</div>
										<div>
										<div class="delivery_zip_code_container">
											<p class="delivery_text">Delivery to <span><?php echo $_COOKIE['dales_order_zip_code'] ?></span></p>
											<!-- <a href="#" class="open_zip_code_search"><img src="/wp-content/uploads/2018/07/hint.png"><span>You can change ZIP code right now by clicking here</span></a> -->
										</div>
										</div>
									</div>
									<div class="dales_checkout_header_info_col">
										<div class="dales_checkout_products owl-carousel">
											<?php 
											parse_str(stripslashes($_COOKIE['form_data']), $form_data);
											foreach ($form_data['product'] as $form_data_post) {
												$dales_parent_id_product = get_post($form_data_post['id']);
												$form_data_post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $dales_parent_id_product->post_parent ), 'medium' );
												$form_data_post_title = get_the_title( $dales_parent_id_product->post_parent );
												?>
												<div>
													<img src="<?php  echo $form_data_post_image[0]; ?>" data-id="<?php echo $form_data_post['id']; ?>">
													<p><?php echo $form_data_post_title ; ?></p>
												</div>
												<?php

											} ?>
										</div>
									</div>
									<div class="dales_checkout_header_info_col">
										<div>
											<img src="<?php echo get_template_directory_uri(); ?>/images/dales_checkout_calc.jpg">
										</div>
										<div>
											<p>Deliver on <span id="dales_deliver_date"><?php echo $dales_current_date ;?></span></p>
										</div>
									</div>
									<div class="dales_checkout_header_info_col">
										<div>
											<p class="dales_checkout_header_info_col_total">$<?php echo $dales_total_amount_rent ; ?></p>
										</div>
										<div>
											<p>Delivered!</p>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<div class="dales_checkout_content">
									<div class="go_back_btn checkout_button_back">
										<a href="/delivery-date/">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/go_back_icon.png" alt="">
											<span>Go Back</span>
										</a>
									</div>
							<?php

							if ( generate_show_title() ) : ?>

								<header class="entry-header">
									<?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
								</header><!-- .entry-header -->

							<?php endif;

							/**
							 * generate_after_entry_header hook.
							 *
							 * @since 0.1
							 *
							 * @hooked generate_post_image - 10
							 */
							do_action( 'generate_after_entry_header' );
							?>

							<div class="entry-content" itemprop="text">
								<?php
								the_content();

								wp_link_pages( array(
									'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
									'after'  => '</div>',
								) );
								?>
							</div><!-- .entry-content -->
						</div>

						<?php
						/**
						 * generate_after_content hook.
						 *
						 * @since 0.1
						 */
						do_action( 'generate_after_content' );
						?>
					</div><!-- .inside-article -->
				</article><!-- #post-## -->

			<?php	
			endwhile;

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();


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
				jQuery('#dales_zip_code').val(input_value);
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

<?php
get_footer();

?>
