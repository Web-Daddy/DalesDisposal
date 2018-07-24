<div class="njba-admin-settings-section">
    <div class="njba-upgrade-section">
         <img src="https://www.ninjabeaveraddon.com/wp-content/plugins/ninja-beaver-pro/img/upgrade-banner.jpg">
    </div>
     <h1 class="njba-admin-settings-heading"> 
         <span><?php echo  _x( 'License For Ninja Beaver Addons', 'bb-njba' ); ?></span>
    </h1>
<?php 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}
global $wpdb;
?>
    <div class="njba-extensions-list-settings">
        <?php 
            $get_njba_extensions_lists = get_option('njba_extensions_lists');
            $module_list = unserialize($get_njba_extensions_lists);
           
            $pro_module_name = array( array ( 'module_name' => 'Advanced Accordion', 'module_slug' => 'njba-accordion','module_license_key' => 'njba_accordion_license_key', 'module_license_status' => 'njba_accordion_license_status' ) , 
                                     array ( 'module_name' => 'Advanced Tabs', 'module_slug' => 'njba-advanced-tabs', 'module_license_key' => 'njba_advanced_tabs_license_key', 'module_license_status' => 'njba_advanced_tabs_license_status' ) ,
                                     array ( 'module_name' => 'Audio', 'module_slug' => 'njba-audio' ,'module_license_key' => 'njba_audio_license_key', 'module_license_status' => 'njba_audio_license_status' ) ,
                                     array ( 'module_name' => 'Before After Slider', 'module_slug' => 'njba-after-before-slider' ,'module_license_key' => 'njba_after_before_slider_license_key' ,'module_license_status' => 'njba_after_before_slider_license_status' ),
                                    
                                     array ( 'module_name' => 'Forms', 'module_slug' => 'njba-forms-options', 'module_license_key' => 'njba_forms_options_license_key' ,'module_license_status' => 'njba_forms_options_license_status' ) ,
                                     array ( 'module_name' => 'Blog Post Content', 'module_slug' => 'njba-blog-post','module_license_key' => 'njba_blog_post_license_key', 'module_license_status' => 'njba_blog_post_license_status' ) ,
                                    
                                     array ( 'module_name' => 'Countdown','module_slug' => 'njba-countdown' ,'module_license_key' => 'njba_countdown_license_key', 'module_license_status' => 'njba_countdown_license_status' ) ,
                                     array ( 'module_name' => 'Counter', 'module_slug' => 'njba-counter', 'module_license_key' => 'njba_counter_license_key' ,'module_license_status' => 'njba_counter_license_status' ) ,
                                     array ( 'module_name' => 'Dual Button', 'module_slug' => 'njba-dual-button', 'module_license_key' => 'njba_dual_button_license_key', 'module_license_status' => 'njba_dual_button_license_status' ),
                                     
                                     array ( 'module_name' => 'Image Carousel', 'module_slug' => 'njba-image-carousel' , 'module_license_key' => 'njba_image_carousel_license_key' ,'module_license_status' => 'njba_image_carousel_license_status' ) ,
                                     array ( 'module_name' => 'Logo Grid & Carousel', 'module_slug' => 'njba-logo-grid-carousel' , 'module_license_key' => 'njba_logo_grid_carousel_license_key' ,'module_license_status' => 'njba_logo_grid_carousel_license_status' ) ,
                                     array ( 'module_name' => 'Modal Box', 'module_slug' => 'njba-modal-box', 'module_license_key' => 'njba_modal_box_license_key', 'module_license_status' => 'njba_modal_box_license_status' ),
                                     array ( 'module_name' => 'Polaroid', 'module_slug' => 'njba-polaroid-options', 'module_license_key' => 'njba_polaroid_options_license_key', 'module_license_status' => 'njba_polaroid_options_license_status' ) ,
                                     
                                     array ( 'module_name' => 'Price Box', 'module_slug' => 'njba-price-box' ,'module_license_key' => 'njba_price_box_license_key', 'module_license_status' => 'njba_price_box_license_status' ) ,
                                     array ( 'module_name' => 'Quote Box Pro', 'module_slug' => 'njba-quote-box', 'module_license_key' => 'njba_quote_box_license_key' ,'module_license_status' => 'njba_quote_box_license_status' ) ,
                                     array ( 'module_name' => 'Teams Pro', 'module_slug' => 'njba-teams' ,'module_license_key' => 'njba_teams_license_key', 'module_license_status' => 'njba_teams_license_status' ),
                                     array ( 'module_name' => 'Testimonials Pro', 'module_slug' => 'njba-testimonials', 'module_license_key' => 'njba_testimonials_license_key', 'module_license_status' => 'njba_testimonials_license_status' ),
                                     array ( 'module_name' => 'Timeline', 'module_slug' => 'njba-timeline' ,'module_license_key' => 'njba_timeline_license_key' ,'module_license_status' => 'njba_timeline_license_status' ) );
                
           // $arr = array_intersect($pro_module_name,$module_list);
           
             foreach ($pro_module_name as $value) {
                if($module_list != ''){
                    foreach ( $module_list as $modules ) { 
                        if($value['module_slug'] == $modules['module_slug']){
                              $module_slug = $modules['module_slug'];
                              $module_slug_chnage = str_replace('-','_',$module_slug);
                              $versions = $module_slug_chnage.'_versions';
                              $license_value = get_option( $versions ); 
                              if($license_value)
                              {
                                 
                                ?>
                                <div class="njba-columan-box">
                                    <div class="njba-columan-box-sub">
                                       
                                        <div class="wrap">
                                          <?php
                                              $license_key = $modules['module_license_key'];
                                              $status_key = $modules['module_license_status'];
                                              $license = get_option( $license_key );
                                              $status = get_option( $status_key );
                                            
                                              $nonce = $module_slug_chnage.'_pro_nonce';
                                              $deactivate = $module_slug_chnage.'_license_deactivate';
                                              $activate = $module_slug_chnage.'_license_activate';
                              
                                              ?>
                                                <form name="<?php echo $license_key;?>_frm" method="post">
                                                        
                                                         <h3><?php  echo $modules['module_name']; ?></h3>
                                                        <?php settings_fields('ninja_beaver_license'); ?>
                                                        
                                                            <?php if( false !== $license ) { 
                                                                    
                                                                    if( $status !== false && $status == 'valid' ) {
                                                                        ?>
                                                                            <h3 class="njba-license-not-active"><span style="color: #00FF00;">Active!</span></h3>
                                                                            <?php wp_nonce_field( $nonce, $nonce ); ?>
                                                                            <input type="submit" class="button-secondary" name="<?php echo $deactivate;?>" value="<?php _e('Deactivate License','bb-njba'); ?>"/>
                                                                        <?php
                                                                    }
                                                                    else{
                                                                    ?>
                                                                       
                                                                        <h3 class="njba-license-not-active"><span style="color: #FF0000;">Not Active!</span></h3>
                                                                        <?php wp_nonce_field( $nonce, $nonce ); ?>
                                                                        <input type="submit" class="button-secondary" name="<?php echo $activate;?>" value="<?php _e('Activate License','bb-njba'); ?>"/>
                                                                    <?php
                                                                    }
                                                                }
                                                                ?>
                                                            <p>Enter your <a href="https://www.ninjabeaveraddon.com/downloads/" target="_blank">license key</a> to enable updates.</p>
                                                            <input type="text" placeholder="Enter your license key.." class="regular-text" id="<?php echo $license_key;?>" name="<?php echo $license_key;?>" value="<?php esc_attr_e( $license ); ?>">
                                                        
                                                </form>
                                        </div>
                                    </div>
                                </div>
                              <?php 
                             }  
                        }
                    }
                }
            } 
               
      ?>
      </div>
</div>
<?php 