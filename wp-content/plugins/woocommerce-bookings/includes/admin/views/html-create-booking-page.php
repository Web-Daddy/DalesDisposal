<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="wrap woocommerce">
	<h2><?php _e( 'Create Booking', 'woocommerce-bookings' ); ?></h2>

	<p><?php _e( 'You can create a new booking for a customer here. This form will create a booking for the user, and optionally an associated order. Created orders will be marked as pending payment.', 'woocommerce-bookings' ); ?></p>

	<?php $this->show_errors(); ?>

	<form method="POST">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="customer_id"><?php _e( 'Customer', 'woocommerce-bookings' ); ?></label>
					</th>
					<td>
						<?php if ( version_compare( WOOCOMMERCE_VERSION, '2.3', '<' ) ) : ?>
							<select id="customer_id" name="customer_id" style="width:300px">
								<option value=""><?php _e( 'Guest', 'woocommerce-bookings' ) ?></option>
							</select>
						<?php else : ?>
							<input type="hidden" class="wc-customer-search" id="customer_id" name="customer_id" data-placeholder="<?php _e( 'Guest', 'woocommerce-bookings' ); ?>" data-allow_clear="true" style="width: 300px" />
						<?php endif; ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="bookable_product_id"><?php _e( 'Bookable Product', 'woocommerce-bookings' ); ?></label>
					</th>
					<td>
						<select id="bookable_product_id" name="bookable_product_id" class="chosen_select" style="width: 300px">
							<option value=""><?php _e( 'Select a bookable product...', 'woocommerce-bookings' ); ?></option>
							<?php foreach ( WC_Bookings_Admin::get_booking_products() as $product ) : ?>
								<option value="<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="create_order"><?php _e( 'Create Order', 'woocommerce-bookings' ); ?></label>
					</th>
					<td>
						<p>
							<label>
								<input type="radio" name="booking_order" value="new" class="checkbox" />
								<?php _e( 'Create a new corresponding order for this new booking. Please note - the booking will not be active until the order is processed/completed.', 'woocommerce-bookings' ); ?>
							</label>
						</p>
						<p>
							<label>
								<input type="radio" name="booking_order" value="existing" class="checkbox" />
								<?php _e( 'Assign this booking to an existing order with this ID:', 'woocommerce-bookings' ); ?>
								<input type="number" name="booking_order_id" value="" class="text" size="3" style="width: 80px;" />
							</label>
						</p>
						<p>
							<label>
								<input type="radio" name="booking_order" value="" class="checkbox" checked="checked" />
								<?php _e( 'Don\'t create an order for this booking.', 'woocommerce-bookings' ); ?>
							</label>
						</p>
					</td>
				</tr>
                                <?php do_action( 'woocommerce_bookings_after_create_booking_page' ); ?>
				<tr valign="top">
					<th scope="row">&nbsp;</th>
					<td>
						<input type="submit" name="create_booking" class="button-primary" value="<?php _e( 'Next', 'woocommerce-bookings' ); ?>" />
						<?php wp_nonce_field( 'create_booking_notification' ); ?>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<?php

if ( version_compare( WOOCOMMERCE_VERSION, '2.3', '<' ) ) {
	// Ajax Chosen Customer Selectors JS
	wc_enqueue_js( "
		jQuery('select#customer_id').ajaxChosen({
		    method: 		'GET',
		    url: 			'" . admin_url('admin-ajax.php') . "',
		    dataType: 		'json',
		    afterTypeDelay: 100,
		    minTermLength: 	1,
		    data:		{
		    	action: 	'woocommerce_json_search_customers',
				security: 	'" . wp_create_nonce("search-customers") . "'
		    }
		}, function (data) {

			var terms = {};

		    $.each(data, function (i, val) {
		        terms[i] = val;
		    });

		    return terms;
		});

		jQuery('select.chosen_select').chosen();
	" );
}
