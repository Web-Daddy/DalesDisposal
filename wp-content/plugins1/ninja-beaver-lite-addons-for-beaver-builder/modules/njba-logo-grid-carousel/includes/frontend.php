<?php
?>
	<div class="njba-logo-<?php echo $settings->logos_layout_view; ?>-main ">
		
	     <div class="njba-logo-<?php echo $settings->logos_layout_view; ?>-body">
		    	<div class="njba-logo-<?php echo $settings->logos_layout_view; ?>-wrapper">
				    <?php
						$number_logos = count($settings->logos);
							$j=1;
							for($i=0; $i < $number_logos; $i++)
				    		{
				    			$logos = $settings->logos[$i];
				    		?>
				    		<?php if($settings->logos_layout_view == 'grid'): ?>
				    				<div class="njba-column-<?php echo $settings->show_col;?> njba-out-side">
				    		<?php else: ?>
				    				<div class="njba-slide-<?php echo $i;?> njba-out-side">
				    		<?php endif; ?>
							            <div class="njba-logo-inner njba-logo-<?php echo $j; ?> <?php if($settings->logo_grid_grayscale){ echo 'njba-'.$settings->logo_grid_grayscale; }?> <?php if($settings->logo_grid_grayscale_hover){echo 'njba-'.$settings->logo_grid_grayscale_hover.'-hover'; }?> ">
							                <div class="njba-logo-inner-wrap">
							                	<?php if($logos->url != ''): ?>
								                    <a href="<?php echo $logos->url;?>" target="<?php echo $logos->link_target;?>">
								                <?php endif;?>
								                <?php if($logos->logo != ''){ ?>
								                       <img class="njba-image-responsive" src="<?php echo $logos->logo_src;?>" alt="<?php echo $logos->logo_title;?>">
								                <?php  } ?>
								                <?php if($settings->show_logo_title == 'yes'): ?>
								                        <div class="njba-title-wrapper">
								                    		<<?php  echo $settings->title_tag; ?> class="njba-logo-title"> 
								                    				<?php echo $logos->logo_title;?>
								                    		</<?php  echo $settings->title_tag; ?>>
								                       </div>
								                <?php endif;?>
								                <?php if($logos->url != ''): ?>
								                    </a>
								                 <?php endif;?>
							                </div>
							            </div>
									</div>
				    		<?php
				    			$j++;
				    		}
					?>
			</div><!--njba-logo-grid-carousel-wrapper-->
		</div><!--njba-logo-grid-carousel-body-->
	</div><!--njba-logo-grid-carousel-main-->