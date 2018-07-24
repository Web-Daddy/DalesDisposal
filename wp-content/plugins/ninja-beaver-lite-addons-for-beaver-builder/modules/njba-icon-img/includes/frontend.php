<?php if($settings->image_type != 'none') : ?>
<div class="njba-icon-img-main <?php echo "position_".$settings->overall_alignment_img_icon; ?>">
    <?php if($settings->show_image_icon_link != 'no') : ?>
        <?php if($settings->url != '') : ?>
            <a href="<?php echo $settings->url;?>" target="<?php echo $settings->link_target;?>" >
        <?php endif; ?>
    <?php endif; ?>
                <div class="njba-icon-img">
                    <?php if( $settings->image_type == 'photo' ) {
                        if(!empty($settings->photo_src)){
                            $src = $settings->photo_src;
                        } else {
                            $src = FL_BUILDER_URL . 'img/pixel.png';
                        }
                    ?>
                        <img src="<?php echo $src; ?>" class="njba-img-responsive">
                    <?php } ?>
                    <?php if( $settings->image_type == 'icon' ) {?>
                        <i class="<?php echo $settings->icon; ?>" aria-hidden="true"></i>
                    <?php } ?>
                </div>
    <?php if($settings->show_image_icon_link != 'no') : ?>
        <?php if($settings->url != '') : ?>
            </a>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>