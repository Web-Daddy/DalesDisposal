<?php if ($EWD_OTP_Full_Version == "Yes") { 
	$Locations_Array = get_option("EWD_OTP_Locations_Array");
	if (!is_array($Locations_Array)) {$Locations_Array = array();}
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>Locations</h2>

	<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Locations&OTPAction=EWD_OTP_UpdateLocations">
	<?php wp_nonce_field('EWD_OTP_Admin_Nonce', 'EWD_OTP_Admin_Nonce'); ?>
	<table class="wp-list-table striped widefat tags sorttable location-list">
	<thead>
		<tr>
			<th><?php _e("Delete", 'order-tracking') ?></th>
			<th><?php _e("Location", 'order-tracking') ?></th>
			<th><?php _e("Latitude", 'order-tracking') ?></th>
			<th><?php _e("Longitude", 'order-tracking') ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?php _e("Delete", 'order-tracking') ?></th>
			<th><?php _e("Location", 'order-tracking') ?></th>
			<th><?php _e("Latitude", 'order-tracking') ?></th>
			<th><?php _e("Longitude", 'order-tracking') ?></th>
		</tr>
	</tfoot>
			
	<?php 
	foreach ($Locations_Array as $key => $Location_Array_Item) { ?>
		<tr id="list-item-<?php echo $key; ?>" class="list-item">
			<input type='hidden' name='location[]' value="<?php echo $Location_Array_Item['Name']; ?>" />
			<input type='hidden' name='location_latitude[]' value="<?php echo $Location_Array_Item['Latitude']; ?>" />
			<input type='hidden' name='location_longitude[]' value="<?php echo $Location_Array_Item['Longitude']; ?>" />
			<td class="location-delete"><a href="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_DeleteLocation&DisplayPage=Locations&Location=<?php echo $Location_Array_Item['Name']; ?>"><?php _e("Delete", 'order-tracking') ?></a></td>
			<td class="location"><?php echo $Location_Array_Item['Name']; ?></td>
			<td class="latitude"><?php echo $Location_Array_Item['Latitude']; ?></td>
			<td class="longitude"><?php echo $Location_Array_Item['Longitude']; ?></td>
		</tr>	
	<?php } ?>
	
	</table>	

	<h3>Add New Location:</h3>
		<div class="form-field form-required">
			<label for="Location"><?php _e("New Location", 'order-tracking') ?></label>
			<input name="location[]" id="Location" type="text" size="60" />
			<p><?php _e("The name of the location you'd like to add.", 'order-tracking') ?></p>
		</div>
		<div class="form-field form-required">
			<label for="Location_Latitude"><?php _e("Location Latitude", 'order-tracking') ?></label>
			<input name="location_latitude[]" id="Location_Latitude" type="text" size="60" />
			<p><?php _e("The latitude of the location, if you'd like it to display on the map.", 'order-tracking') ?></p>
		</div>
		<div class="form-field form-required">
			<label for="Location_Longitude"><?php _e("Location Longitude", 'order-tracking') ?></label>
			<input name="location_longitude[]" id="Location_Longitude" type="text" size="60" />
			<p><?php _e("The longitude of the location, if you'd like it to display on the map.", 'order-tracking') ?></p>
		</div>
	
		<p class="submit"><input type="submit" name="Locations_Submit" id="submit" class="button button-primary" value="Add Location"  /></p>
	</form>

</div>

<?php } else { ?>
<div class="Info-Div">
		<h2><?php _e("Full Version Required!", 'order-tracking') ?></h2>
		<div class="upcp-full-version-explanation">
				<?php _e("The full version of Order Tracking is required to use locations.", "UPCP");?><a href="http://www.etoilewebdesign.com/order-tracking/"><?php _e(" Please upgrade to unlock this page!", 'order-tracking'); ?></a>
		</div>
</div>
<?php } ?>