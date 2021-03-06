<?php
	$classes  = $module->njba_get_img_class();
	$src      = $module->njba_get_img_src();
	$alt      = $module->njba_get_img_alt();
?>
<div class="njba-module-content njba-image-seperator-main">
	<?php if( $settings->enable_link == 'yes' ) : ?>
	<a class="imgseparator-link" href="<?php echo $settings->link; ?>" target="<?php echo $settings->link_target; ?>"></a>
	<?php endif; ?>
	<div class="njba-image-separator njba-image<?php if ( ! empty( $settings->image_style ) ) echo ' njba-crop-image-' . $settings->image_style ; ?>" itemscope itemtype="http://schema.org/ImageObject">
		<img class="<?php echo $classes; ?> <?php echo ( $settings->img_animation_repeat == '0' ) ? 'infinite' : ''; ?>" src="<?php echo $src; ?>" alt="<?php echo $alt; ?>" itemprop="image"/>
	</div>
</div>