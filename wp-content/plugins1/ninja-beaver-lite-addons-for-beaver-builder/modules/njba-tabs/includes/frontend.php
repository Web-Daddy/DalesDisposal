<?php
$activeTabIndex= '';
$activeTabIndex = $activeTabIndex > count($settings->items) ? 0 : $activeTabIndex;
$activeTabIndex = $activeTabIndex < 1 ? 0 : $activeTabIndex - 1;
$css_id='';
$layout = $settings->tab_style_layout;
$i='';
	?>
	<div class="njba-tabs njba-tabs-<?php echo $settings->tab_style_layout; ?> njba-tab-section-main ">
	<?php  if($layout == 'style-1') {  ?>
	<div class="njba-tabs-labels njba-tab-menu-main tab-align-<?php echo $settings->tab_alignment; ?>">
		<div id="" class="njba-tabs-nav njba-tabs-nav<?php echo $id; ?> nav" role="tablist" data-index="<?php echo $i; ?>"> 
  		
		<?php	$module->tab_title_loop(); ?>
		</div>
	</div>	
	<div class="njba-tabs-panels njba-clearfix">
		<?php  $module->tab_content();?>
	</div>
	<?php } ?>
   		<?php if($layout == 'style-2') {?>
   			 <div class="njba-col-xs-12 njba-col-sm-4">
					<div class="njba-tabs-labels njba-tab-menu-main tab-align-<?php echo $settings->tab_alignment; ?>">
						<div id="" class="njba-tabs-nav njba-tabs-nav<?php echo $id; ?> nav" role="tablist" data-index="<?php echo $i; ?>"> 
  						<?php	$module->tab_title_loop(); ?>
						</div>
					</div>
			</div>
			<div class="njba-col-xs-12 njba-col-sm-8">	
				<div class="njba-tabs-panels njba-clearfix">
					<?php  $module->tab_content();?>
				</div>
			</div>	
   			 
   	 <?php	} ?>
   	 <?php if($layout == 'style-3') {?>
   			<div class="njba-tabs-labels njba-tab-menu-main tab-align-<?php echo $settings->tab_alignment; ?>">
				<div id="" class="njba-tabs-nav njba-tabs-nav<?php echo $id; ?> nav" role="tablist" data-index="<?php echo $i; ?>"> 
		
					<?php	$module->tab_title_loop(); ?>
				</div>
			</div>	
			<div class="njba-tabs-panels njba-clearfix">
					<?php  $module->tab_content();?>
			</div>
   			 
   	 <?php	} ?>
   		
   		<?php if($layout == 'style-4') {?>
   			<div class="njba-col-xs-12 njba-col-sm-4 njba-pull-right">
				<div class="njba-tabs-labels njba-tab-menu-main tab-align-<?php echo $settings->tab_alignment; ?>">
					<div id="" class="njba-tabs-nav njba-tabs-nav<?php echo $id; ?> nav" role="tablist" data-index="<?php echo $i; ?>"> 
  						<?php	$module->tab_title_loop(); ?>
			
					</div>
				</div>
			</div>
			<div class="njba-col-xs-12 njba-col-sm-8">	
				<div class="njba-tabs-panels njba-clearfix">
						<?php  $module->tab_content();?>
				</div>
			</div>	
   			 
   	 <?php	} ?>
   	 <?php if($layout == 'style-5') {?>
   			 <div class="njba-tabs-labels njba-tab-menu-main tab-align-<?php echo $settings->tab_alignment; ?>">
					<div id="" class="njba-tabs-nav njba-tabs-nav<?php echo $id; ?> nav" role="tablist" data-index="<?php echo $i; ?>"> 
		
						<?php	$module->tab_title_loop(); ?>
					</div>
			</div>	
			<div class="njba-tabs-panels njba-clearfix">
				<?php  $module->tab_content();?>
			</div>
   			 
   	 <?php	} ?>
   	 <?php if($layout == 'style-6') {?>
   			 <div class="njba-tabs-labels njba-tab-menu-main tab-align-<?php echo $settings->tab_alignment; ?>">
				<div id="" class="njba-tabs-nav njba-tabs-nav<?php echo $id; ?> nav" role="tablist" data-index="<?php echo $i; ?>"> 
  					<?php	$module->tab_title_loop(); ?>
				</div>
			</div>	
			<div class="njba-tabs-panels njba-clearfix">
					<?php  $module->tab_content();?>
			</div>
   			 
   	 <?php	} ?>
   	  <?php if($layout == 'style-7') {?>
   			 <?php
				$i='';
			 ?>	
			<div class="njba-tabs-labels njba-tab-menu-main tab-align-<?php echo $settings->tab_alignment; ?>">
				<div id="" class="njba-tabs-nav njba-tabs-nav<?php echo $id; ?> nav" role="tablist" data-index="<?php echo $i; ?>"> 
  		
					<?php	$module->tab_title_loop(); ?>
				</div>
			</div>	
			<div class="njba-tabs-panels njba-clearfix">
				<?php  $module->tab_content();?>
			</div>
   			 
   	 <?php	} ?>
   	 <?php if($layout == 'style-8') {?>
   			<div class="njba-tabs-labels njba-tab-menu-main tab-align-<?php echo $settings->tab_alignment; ?>">
				<div id="" class="njba-tabs-nav njba-tabs-nav<?php echo $id; ?> nav" role="tablist" data-index="<?php echo $i; ?>"> 
  		
					<?php	$module->tab_title_loop(); ?>
				</div>
			</div>	
			<div class="njba-tabs-panels njba-clearfix">
				<?php  $module->tab_content();?>
			</div>
   			 
   	 <?php	} ?>
	
</div>