	<?php $width = 100 / $settings->show_col['desktop'];?>
	
	.fl-node-<?php echo $id; ?> .njba-gallery-box {
			width: <?php echo $width ?>%;
			padding: <?php echo $settings->photo_spacing/2; ?>px;
			float: left;
		}
	<?php if ( $settings->show_col['desktop'] > 1 ) { ?>
		.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['desktop']; ?>n+1){
			clear: left;
		}
		.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['desktop']; ?>n+0){
			clear: right;
		}
	<?php } ?>
.fl-node-<?php echo $id; ?> .njba-gallery-main .njba-image-box-overlay {
	<?php if( $settings->overly_color ) { ?>background-color: rgba(<?php echo implode(',', FLBuilderColor::hex_to_rgb($settings->overly_color)) ?>, <?php echo $settings->overly_color_opacity/100; ?>); <?php } ?>
}
<?php if($global_settings->responsive_enabled) { // Global Setting If started ?>
	@media ( max-width: <?php echo $global_settings->medium_breakpoint .'px'; ?> ) {
		
		
		
			.fl-node-<?php echo $id; ?> .njba-gallery-box {
				width: <?php echo 100/$settings->show_col['medium']; ?>%;
			}
			<?php if ( $settings->show_col['desktop'] > 1 ) { ?>
				.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['desktop']; ?>n+1),
				.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['desktop']; ?>n+0) {
					clear: none;
				}
			<?php } ?>
			
			.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['medium']; ?>n+1){
				clear: left;
			}
			.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['medium']; ?>n+0){
				clear: right;
			}
		
	}
	@media ( max-width: <?php echo $global_settings->responsive_breakpoint .'px'; ?> ) {
		
		
		
			.fl-node-<?php echo $id; ?> .njba-gallery-box {
				width: <?php echo 100/$settings->show_col['small']; ?>%;
			}
			<?php if ( $settings->show_col['desktop'] > 1 ) { ?>
				.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['desktop']; ?>n+1),
				.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['desktop']; ?>n+0) <?php if ( $settings->show_col['medium'] > 1 ) { ?>,
				.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['medium']; ?>n+1),
				.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['medium']; ?>n+0) <?php } ?>{
					clear: none;
				}
			<?php } ?>
			
			.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['small']; ?>n+1){
				clear: left;
			}
			.fl-node-<?php echo $id; ?> .njba-gallery-box:nth-child(<?php echo $settings->show_col['small']; ?>n+0){
				clear: right;
			}
		
	}
<?php } ?>