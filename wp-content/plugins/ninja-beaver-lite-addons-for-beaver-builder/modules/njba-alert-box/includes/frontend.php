<?php
	$alertbox_class = 'njba-alertbox-wrapper';
?>
<div class="<?php echo $alertbox_class ?>">
  <div class="alert-box-main">
    <?php if( $settings->show_icon == 'yes' ) { ?>
    <div class="njba-alertbox-icon"> <span class="njba-icon <?php echo $settings->alertbox_icon; ?>"></span> </div>
    <?php } ?>
    <div class="njba-alert-content">
      <?php if( $settings->main_title != '' ) { ?>
      <span class="alert-title"><strong><?php echo $settings->main_title; ?></strong></span>
      <?php } ?>
      <span class="alert-subtitle"> <?php echo $settings->sub_title; ?> </span> </div>
  </div>
</div>
