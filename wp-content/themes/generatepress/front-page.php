<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package GeneratePress
 */
// $zip_codes_front_page = get_field('zip_codes');
// echo $zip_codes_front_page;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

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

			while ( have_posts() ) : the_post();

				get_template_part( 'content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || '0' != get_comments_number() ) : ?>

					<div class="comments-area">
						<?php comments_template(); ?>
					</div>

				<?php endif;

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

	$zip_codes_array = array();
	if( have_rows('zip_codes') ):
    while ( have_rows('zip_codes') ) : the_row();
        $zip_codes_array[] = get_sub_field('zip_code');

	    endwhile;
	endif;
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
			console.log(input_index);
			if(input_index >= 0 ){
				setCookieDales("dales_order_zip_code", input_value, {"path":"/"});
				window.location.replace("/order/");
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

