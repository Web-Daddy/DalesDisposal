<?php /* Template Name: Dales Checkout Template */ ?>
<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
};

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
$rent_time = $_COOKIE['rent_time_range'];
$additional_rent_price = ceil(($rent_time - 14) / 7) * 25;

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


						<div class="dales_checkout_header_info">
							<div class="dales_checkout_header_info_col">
								<div>
									<img src="<?php echo get_template_directory_uri(); ?>/images/dales_checkout_car.jpg">
								</div>
								<div>
									<p class="delivery_text">Delivery to <span><?php echo $_COOKIE['dales_order_zip_code'] ?></span></p>
								</div>
							</div>
							<div class="dales_checkout_header_info_col">
								<div class="dales_checkout_products">
									<?php 
									parse_str(stripslashes($_COOKIE['form_data']), $form_data);
									foreach ($form_data['product'] as $form_data_post) {
										$form_data_post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $form_data_post['id'] ), 'medium' );
										$form_data_post_title = get_the_title( $form_data_post['id'] );
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
									<p>Deliver on <span id="dales_deliver_date"></span></p>
								</div>
							</div>
							<div class="dales_checkout_header_info_col">
								<div>
									<p class="dales_checkout_header_info_col_total"><?php echo WC()->cart->get_cart_total(); ?></p>
								</div>
								<div>
									<p>Delivered!</p>
								</div>
							</div>
						</div>
						<div class="dales_checkout_content">
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

get_footer();

?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var	date_range_cookie = jQuery.cookie('date_range');
		var date_element = jQuery('#dales_deliver_date');

		if(date_range_cookie){
			date_range_cookie = JSON.parse(date_range_cookie);
			currentDay = new Date(date_range_cookie.current_date);
			secondDay = new Date(date_range_cookie.last_date);
			currentDay2 = currentDay.toString().substring(0, 10);
			date_element.html(currentDay2);



		};

		jQuery('.woocommerce-billing-fields__field-wrapper').prepend('<div class="dales_checkout_first_row"></div>');
		jQuery('.dales_checkout_first_row').append('<div class="dales_checkout_first_row_col1"></div>');
		jQuery('.dales_checkout_first_row').append('<div class="dales_checkout_first_row_col2"></div>');
		jQuery('.dales_checkout_first_row_col1').append(jQuery('#billing_myfield1_field'));
		jQuery('.dales_checkout_first_row_col1').append(jQuery('#billing_myfield2_field'));
		jQuery('.dales_checkout_first_row_col2').append(jQuery('#billing_myfield3_field'));
		jQuery('.dales_checkout_first_row_col2').append(jQuery('#billing_myfield4_field'));
		jQuery('.dales_checkout_first_row_col2').append(jQuery('#billing_myfield5_field'));
		jQuery('.woocommerce-billing-fields h3:first-child').not('.form-row').insertBefore(jQuery('#billing_myfield6_field'));
		jQuery('#billing_myfield2_checkbox').click(function(){
			jQuery(this).parent().toggleClass('dales_checked_checkbox');
		});
		jQuery('#billing_myfield4_checkbox').click(function(){
			jQuery(this).parent().toggleClass('dales_checked_checkbox');
			if (jQuery('#billing_myfield5_checkbox').parent().hasClass('dales_checked_checkbox')) {
				jQuery('#billing_myfield5_checkbox').parent().removeClass('dales_checked_checkbox');
				jQuery('#billing_myfield5_checkbox').prop('checked', false);
			}
		});
		jQuery('#billing_myfield5_checkbox').click(function(){
			jQuery(this).parent().toggleClass('dales_checked_checkbox');
			if (jQuery('#billing_myfield4_checkbox').parent().hasClass('dales_checked_checkbox')) {
				jQuery('#billing_myfield4_checkbox').parent().removeClass('dales_checked_checkbox');
				jQuery('#billing_myfield4_checkbox').prop('checked', false);
			}
		});



	})
</script>