<?php /* Template Name: Order Template Three */ ?>
<?php 
get_header();
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
			<a href="#" class="need_help_header_order_content">Need Help? Click here</a>
			<p class="text_header_order_content">All containers rentals have a 14-day rental term</p>
		</div>
		<div class="error_message_order_step_three">
			<i class="fas fa-exclamation-triangle"></i>
			<p class="text_error_message">Prepare your location for dumpsters arrival on selected date. Make sure area is clear of vehicles and any other obstructions.</p>
			<i class="fas fa-times"></i>
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
								<p class="year_text_date current_day">July 2018</p>
								<p class="hidden_text_date current_day">Tuesday</p>
							</div>
						</div>
					</div>
					<div class="center_section_title_datepicker">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/delivery_date_icon.png" width="auto" height="auto" alt="">
					</div>
					<div class="right_section_title_datepicker">
						<p class="label_deliver_title_datepicker">Pickup</p>
						<div class="date_deliver_title_datepicker">
							<div class="count_date_deliver_title_datepicker last_day">20</div>
							<div class="text_date_deliver_title_datepicker">
								<p class="year_text_date last_day">July 2018</p>
								<p class="hidden_text_date last_day">Tuesday</p>
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



<?php get_footer(); ?>