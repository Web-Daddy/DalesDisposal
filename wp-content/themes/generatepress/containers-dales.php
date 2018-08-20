<?php
get_header();


$dales_cat_id = get_term_by( 'slug', 'household-waste', 'product_cat' );

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
	<div class="products_blocks_order">
		<div class="col-12 col-xl-10 col-lg-10 col-md-12 col-sm-12 dales_containers_page_title">
			<div class="row">
				<h2 class="dales_containers_page_h2">Each container rental has a standard 14 day term. Click <a href="/" class="dales_containers_page_link_here">here</a> to book</h2>
			</div>
		</div>
				<?php 
				$i= 0;
				foreach( $posts as $post ){
				$product = wc_get_product( $post->ID );
				$id_atachment = get_post_thumbnail_id($post->ID);
				$product_content = $post->post_content;
				$qty = '';
				$checked = '';
				$dales_product_size = get_field( 'product_size', $post->ID);
				$dales_product_info = get_field( 'product_info', $post->ID);
				$dales_product_type = get_field( 'product_type', $post->ID);
				?>
					<div class="col-12 col-xl-10 col-lg-10 col-md-12 col-sm-12 block_product_order">
						<div class="row">
							<div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 block_left_product_order">
								<img class="img_product_atachment" src="<?php echo wp_get_attachment_url($id_atachment); ?>" width="100%" height="auto" alt="">
								<div class="delivery_block_product_order"></div>
								<?php if($dales_product_size){ ?>
									<div class="size_product_order">
										<p><?php echo $dales_product_size; ?></p>
									</div>
								<?php } ?>
								<?php if($dales_product_info){ ?>
									<div class="info_product_order">
										<p><?php echo $dales_product_info; ?></p>
									</div>
								<?php } ?>
							</div>
							<div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 block_right_product_order">
								<div class="title_price_top_block_order">
									<p class="title_product_order"><?php echo $product->post->post_title; ?></p>
								</div>
								<div class="content_product_order">
									<p><?php echo $product_content; ?></p>
								</div>
							
		<p class="rolloff_product_order_1"><?php echo $dales_product_type; ?></p>
							</div>
						</div>
					</div>
				<?php 
				$i++;
				}
				wp_reset_postdata();?>
			</div>