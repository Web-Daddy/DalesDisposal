<?php
			for($i=0; $i < $number_testimonials; $i++) :
				$testimonials = $settings->testimonials[$i];
?>
				<div class="njba-testimonial-body layout_<?php echo $settings->testimonial_layout; ?>">
					<?php $module->profile_image_render($i);?>
					<?php $module->profile_content($i); ?>
		            <?php $module->profile_name($i);?>
		            <?php $module->profile_designation($i);?>
		            <?php $module->profile_ratings($i);?>
		        </div>
<?php 		endfor;	?>