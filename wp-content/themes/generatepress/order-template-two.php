<?php /* Template Name: Order Template Two */ ?>
<?php

if (!isset($_COOKIE['dales_order_zip_code'])) {
    header('Location:'.  home_url() );
    exit;
};
if (!isset($_COOKIE['slug'])) {
    header('Location:'.  home_url() .'/order' );
    exit;
};


$category_slug = '';
if(isset($_COOKIE['slug'])){
	$category_slug = $_COOKIE['slug'];
}
$dales_cat_id = get_term_by( 'slug', $category_slug, 'product_cat' );
get_header();
$args = array(
	'post_type'      => 'product',
	'posts_per_page' => -1,
	'order'          => 'DESC',
	'tax_query' => array(
                                array(
                                'taxonomy' => 'product_cat',
                                'field' => 'term_id',
                                'terms' => $dales_cat_id
                                )
                            )

);

$posts = get_posts( $args );
?>

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
							<a href="#" class="open_zip_code_search"><img src="/wp-content/uploads/2018/07/hint.png"><span>You can change ZIP code right now by clicking here</span></a>
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
					<div class="delivery_date">
						<img class="good_icon_image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/wait_icon.png" alt="">
						<p class="material_text">Delivery Date</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="template_order_content">
	<div class="container">
		<div class="go_back_btn two">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/go_back_icon.png" alt="">
			<span>Go Back</span>
		</div>
		<div class="header_template_order_content two">
			<h5 class="title_header_template_order_content">Step 2</h5>
			<h3 class="title_select_header_template_order_content">Select Container</h3>
			<a href="/contact-us/" class="need_help_header_order_content">Need Help? Click here</a>
			<p class="text_header_order_content">Select a container size</p>
		</div>
		<div class="btn_submit_order btn_submit_order_top">
			<a href="#" class="btn_submit_order_go step_2">Step 3: Delivery Date</a>
		</div>
		<form action="#" id="product_form">
			<div class="products_blocks_order">
				<?php 
				$i= 0;
				$term_by_coockie = get_term_by( 'slug', $_COOKIE['dales_order_zip_code'], 'zip_code');
				$zone = get_field('zone', $term_by_coockie);
				if(!$zone){
					$zone = 'zone1';
				}
				foreach( $posts as $post ){
					$product = wc_get_product( $post->ID );

					if( $product->has_child() ) {
						$variations = $product->get_available_variations();
						foreach ($variations as $variation) {
							if ($zone === $variation['attributes']['attribute_zip-code-group']) {
								$product_price = $variation['display_price'];
								$id_product = $variation['variation_id'];
							}
						}
					} else {
						$id_product = $product->get_id();
						$product_price = $product->get_regular_price();
					}
					$id_atachment = get_post_thumbnail_id($product->get_id() );
					$product_content = $post->post_content;
					$product_selected = find_product_from_coockie($id_product);
					$dales_product_info = get_field( 'product_type', $post->ID);
					$qty = '';
					$checked = '';
					if ($product_selected && $product_selected['id']) {
						$checked = 'checked';
						$qty =$product_selected['count'];
					}
					// debug_data($id_product);
					// // debug_data($product);
					// debug_data($product_selected);
					// debug_data($product_selected['id']);
					?>
						<div class="col-12 col-xl-10 col-lg-10 col-md-12 col-sm-12 block_product_order">
							<div class="row">
								<div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 block_left_product_order">
									<img class="img_product_atachment" src="<?php echo wp_get_attachment_url($id_atachment); ?>" width="100%" height="auto" alt="">
									<div class="delivery_block_product_order"></div>
									<?php if(get_field('product_size')){ ?>
										<div class="size_product_order">
											<p><?php echo get_field('product_size'); ?></p>
										</div>
									<?php } ?>
									<?php if(get_field('product_info')){ ?>
										<div class="info_product_order">
											<p><?php echo get_field('product_info'); ?></p>
										</div>
									<?php } ?>
								</div>
								<div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 block_right_product_order" id="<?php echo $id_product; ?>">
									<div class="title_price_top_block_order">
										<p class="title_product_order"><?php the_title(); ?></p>
										<p class="price_order_product">$<?php echo $product_price; ?> <span>/  14 days</span></p>
									</div>
									<div class="content_product_order">
										<p><?php echo $product_content; ?></p>
									</div>
									<div class="footer_content_product_order">
										<label class="label_description_block product_order <?php echo $checked != '' ? 'active' : ''; ?>" data-id="<?php echo $id_product; ?>">
											<?php if($checked === ''){ 
												echo '<span class="select">Select</span>';
											} else {
												echo '<span class="select">Selected</span>';
											} ?>
											<input type="checkbox" name="product[<?php echo $i; ?>][id]" value="<?php echo $id_product ?>" <?php echo $checked; ?>>
											<span class="checkmark"></span>
										</label>
										<select class="select_count_order" name="product[<?php echo $i; ?>][count]" <?php echo $checked != '' ? '' : 'disabled'; ?>>
											<option <?php echo $qty == '1' ? 'selected' : '' ?> class="option_count_order" value="1">1</option>
											<option <?php echo $qty == '2' ? 'selected' : '' ?> class="option_count_order" value="2">2</option>
											<option <?php echo $qty == '3' ? 'selected' : '' ?> class="option_count_order" value="3">3</option>
											<option <?php echo $qty == '4' ? 'selected' : '' ?> class="option_count_order" value="4">4</option>
											<option <?php echo $qty == '5' ? 'selected' : '' ?> class="option_count_order" value="5">5</option>
										</select>
										<p class="rolloff_product_order"><?php echo $dales_product_info; ?></p>
									</div>
								</div>
							</div>
						</div>
					<?php 
					$i++;
				}
				wp_reset_postdata();?>
			</div>
		</form>
		<div class="btn_submit_order">
			<a href="#" class="btn_submit_order_go step_2">Step 3: Delivery Date</a>
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
				window.location.reload();
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
