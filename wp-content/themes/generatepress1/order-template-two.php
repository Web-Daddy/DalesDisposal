<?php /* Template Name: Order Template Two */ ?>
<?php
$category_slug = '';
if(isset($_COOKIE['slug'])){
	$category_slug = $_COOKIE['slug'];
}
get_header();
$args = array(
	'post_type'      => 'product',
	'posts_per_page' => -1,
	'order'          => 'ASC',
	'tax_query'      => array(
        array(
            'taxonomy' => 'product_cat',
            'terms'    => $category_slug,
        )
    )

);

$posts = get_posts( $args );
?>

<div class="template_order">
	<div class="container">
		<div class="col-12 col-xl-8 col-lg-8 col-md-8 col-sm-12 header_order">
			<div class="row">
				<div class="col-12 col-xl-4 col-lg-4 col-md-4 col-sm-12 line_wrap line_wrap_active">
					<div class="delivery">
						<img class="good_icon_image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/good_icon.png" alt="">
						<p class="delivery_text">Delivery to <span>48346</span></p>
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
			<a href="#" class="need_help_header_order_content">Need Help? Click here</a>
			<p class="text_header_order_content">Select a container size</p>
		</div>
		<form action="#" id="product_form">
			<div class="products_blocks_order">
				<?php 
				$i= 0;
				foreach( $posts as $post ){
				$product = wc_get_product( $post->ID );
				$id_product = $product->get_id();
				$id_atachment = get_post_thumbnail_id($id_product);
				$product_price = $product->get_regular_price();
				$product_content = $post->post_content;
				$product_selected = find_product_from_coockie($id_product);
				$qty = '';
				$checked = '';
				if ($product_selected && $product_selected['id']) {
					$checked = 'checked';
					$qty =$product_selected['count'];
				}
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
									<a href="<?php the_permalink(); ?>" class="title_product_order"><?php the_title(); ?></a>
									<p class="price_order_product">$<?php echo $product_price; ?> <span>/ 14days</span></p>
								</div>
								<div class="content_product_order">
									<p><?php echo $product_content; ?></p>
								</div>
								<div class="footer_content_product_order">
									<label class="label_description_block product_order <?php echo $checked != '' ? 'active' : ''; ?>" data-id="<?php echo $id_product; ?>">
										<span class="select">Select</span>
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
									<p class="rolloff_product_order">Rolloff</p>
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
<?php get_footer(); ?>
