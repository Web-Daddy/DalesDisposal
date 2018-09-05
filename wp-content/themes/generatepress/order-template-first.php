<?php /* Template Name: Order Template */ ?>
<?php
if (!isset($_COOKIE['dales_order_zip_code'])) {
    header('Location:'.  home_url() );
    exit;
}
get_header(); ?>

<div class="template_order">
	<div class="dales_order_cancel_button_container">
		<div class="dales_order_cancel_button">
			<a href="#" id="dales_order_cancel_button_link"><span>&#10006;</span> CANCEL</a>
		</div>
	</div>
	<div class="container">
		<div class="col-12 col-xl-8 col-lg-8 col-md-8 col-sm-12 header_order">
			<div class="row">
				<div class="col-12 col-xl-4 col-lg-4 col-md-4 col-sm-12 line_wrap">
					<div class="delivery">
						<img class="good_icon_image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/good_icon.png" alt="">
						<div class="delivery_zip_code_container">
							<p class="delivery_text">Delivery to <span><?php echo $_COOKIE['dales_order_zip_code'] ?></span></p>
							<a href="#" class="open_zip_code_search"><img src="/wp-content/uploads/2018/07/hint.png"><span>You can change ZIP code right now by clicking here</span></a>
						</div>
					</div>					
				</div>
				<div class="col-12 col-xl-4 col-lg-4 col-md-4 col-sm-12">
					<div class="material_container">
						<img class="good_icon_image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/wait_icon.png" alt="">
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
		<div class="header_template_order_content">
			<h5 class="title_header_template_order_content">Step 1</h3>
			<h3 class="title_select_header_template_order_content">Select A Material</h3>
			<a href="/contact-us/" class="need_help_header_order_content">Need Help? Click here</a>
			<p class="text_header_order_content">What material will you be depositing into the container? </p>
		</div>
		<div class="btn_submit_order btn_submit_order_top">
			<a href="#" class="btn_submit_order_go first_step">Go to step 2: Select Container</a>
		</div>
		<div class="category_order_content">
			<div class="row">
			<?php
				$terms = get_terms( 'product_cat' );
				$i = 0;
				if( $terms && ! is_wp_error($terms) ){ ?>
					<?php foreach( $terms as $term ){ ?>
						<div class="col-12 col-xl-4 col-lg-4 col-md-8 col-sm-12 for_tablet_order_blocks">
							<?php if($i == 0){ ?>
							<div class="category_block_order active" id="<?php echo $term->term_id; ?>" data-slug="<?php echo $term->slug; ?>">
							<?php }else{ ?>
							<div class="category_block_order" data-slug="<?php echo $term->slug; ?>" id="<?php echo $term->term_id; ?>">
							<?php } ?>
								<?php if($term->term_id == 22){ ?>
									<h3 class="title_block_category_order"><span>*</span> <?php echo $term->name; ?></h3>
								<?php }else{ ?>
									<h3 class="title_block_category_order"><?php echo $term->name; ?></h3>
								<?php } ?>
								<p class="description_block_category_order"><?php echo $term->description; ?></p>
								<label class="label_description_block first_block" data-id="<?php echo $term->term_id; ?>">
									<?php if($i == 0){ ?>
										<span class="select">Selected</span>
									<?php }else{ ?>
										<span class="select">Select</span>
									<?php } ?>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
								<?php if($term->term_id == 22){ ?>
									<p class="no_weight">No weight limit</p>
								<?php } ?>
							</div>
						</div>

					<?php $i++; } ?>
			<?php } ?>
			</div>
		</div>
		<div class="btn_submit_order">
			<a href="#" class="btn_submit_order_go first_step">Go to step 2: Select Container</a>
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
