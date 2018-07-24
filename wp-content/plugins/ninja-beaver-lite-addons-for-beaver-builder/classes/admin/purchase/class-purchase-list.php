<div class="njba-admin-settings-section">
    <div class="njba-upgrade-section">
         <img src="https://www.ninjabeaveraddon.com/wp-content/plugins/ninja-beaver-pro/img/upgrade-banner.jpg">
    </div>
     <h1 class="njba-admin-settings-heading"> 
         <span><?php echo  _x( 'Purchase More Addons', 'bb-njba' ); ?></span>
    </h1>
<?php 
  add_filter( 'njba_extensions_lists_filter_hook', 'njba_extensions_lists_filter');
        function njba_extensions_lists_filter( $value ) {
            $get_option =get_option('njba_extensions_lists');
            $unserialize  = unserialize ( $get_option );
            if (!$unserialize == ''){
                 $serialize = serialize($value);
                 update_option('njba_extensions_lists', $serialize );
            }
            else{
                 $serialize = serialize($value);
                 update_option('njba_extensions_lists', $serialize );
            }
            return;
        }
  $pro_module =  array(array ( 'module_name' => 'Advanced Accordion', 'module_slug' => 'njba-accordion','module_license_key' => 'njba_accordion_license_key', 'module_license_status' => 'njba_accordion_license_status' ) , 
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
            $get_option =get_option('njba_extensions_lists');
            $unserialize  = unserialize ( $get_option );
             if (!$unserialize == ''){
                  $diff_key = array_diff_key($pro_module,$unserialize);
                  if(!empty($diff_key)){
                      apply_filters( 'njba_extensions_lists_filter_hook',  $diff_key );
                  }
             }
             else{
                apply_filters( 'njba_extensions_lists_filter_hook',  $pro_module );
             }
?>
<?php 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}
global $wpdb;
?>
    <div class="njba-addons-list-sections">
        <?php 
$get_njba_extensions_lists = get_option('njba_extensions_lists');
$module_list = unserialize($get_njba_extensions_lists);
$pro_module_name = array(
                   array ( 'module_name' => 'Advanced Accordion', 'module_slug' => 'njba-accordion','module_license_key' => 'njba_accordion_license_key', 'module_license_status' => 'njba_accordion_license_status' ,'description' => 'Simplify navigation and avoid endless scrolling with attractive advanced accordions for WordPress websites.') , 
                   array ( 'module_name' => 'Advanced Tabs', 'module_slug' => 'njba-advanced-tabs', 'module_license_key' => 'njba_advanced_tabs_license_key', 'module_license_status' => 'njba_advanced_tabs_license_status','description' => 'Tabs with creative presets & styling options.' ) ,
                   array ( 'module_name' => 'Audio', 'module_slug' => 'njba-audio' ,'module_license_key' => 'njba_audio_license_key', 'module_license_status' => 'njba_audio_license_status' ,'description' => 'Implements the functionality of the Audio Shortcode for displaying audio-files in a post.') ,
                   array ( 'module_name' => 'Before After Slider', 'module_slug' => 'njba-after-before-slider' ,'module_license_key' => 'njba_after_before_slider_license_key' ,'module_license_status' => 'njba_after_before_slider_license_status','description' => 'its not just a Slider. But a new way to deliver ideas' ),
                   array ( 'module_name' => 'Forms', 'module_slug' => 'njba-forms-options', 'module_license_key' => 'njba_forms_options_license_key' ,'module_license_status' => 'njba_forms_options_license_status','description' => 'Create beautiful lead generation contact forms and connect them with popular contact form services.' ) ,
                   array ( 'module_name' => 'Blog Post Content', 'module_slug' => 'njba-blog-post','module_license_key' => 'njba_blog_post_license_key', 'module_license_status' => 'njba_blog_post_license_status' ,'description' => 'Display a beautiful posts index that appeals the user with images and text.') ,
                  
                   array ( 'module_name' => 'Countdown','module_slug' => 'njba-countdown' ,'module_license_key' => 'njba_countdown_license_key', 'module_license_status' => 'njba_countdown_license_status','description' => 'Display opening hours and if you are presently open/closed, with counting to next opening.' ) ,
                   array ( 'module_name' => 'Counter', 'module_slug' => 'njba-counter', 'module_license_key' => 'njba_counter_license_key' ,'module_license_status' => 'njba_counter_license_status','description' => 'Create beautiful Counter.' ) ,
                   array ( 'module_name' => 'Dual Button', 'module_slug' => 'njba-dual-button', 'module_license_key' => 'njba_dual_button_license_key', 'module_license_status' => 'njba_dual_button_license_status','description' => 'Add a pair of fancy buttons connected to each other, making it a Dual Button.' ),
                   array ( 'module_name' => 'Image Carousel', 'module_slug' => 'njba-image-carousel' , 'module_license_key' => 'njba_image_carousel_license_key' ,'module_license_status' => 'njba_image_carousel_license_status' ,'description' => 'Display an Image Carousel with a set of beautiful images and videos.') ,
                   array ( 'module_name' => 'Logo Grid & Carousel', 'module_slug' => 'njba-logo-grid-carousel' , 'module_license_key' => 'njba_logo_grid_carousel_license_key' ,'module_license_status' => 'njba_logo_grid_carousel_license_status','description' => 'Display logos in grid & carousel with styling options.' ) ,
                   array ( 'module_name' => 'Modal Box', 'module_slug' => 'njba-modal-box', 'module_license_key' => 'njba_modal_box_license_key', 'module_license_status' => 'njba_modal_box_license_status','description' => 'A modal could be a dialog box/popup window thats displayed on of the present page' ),
                   array ( 'module_name' => 'Polaroid', 'module_slug' => 'njba-polaroid-options', 'module_license_key' => 'njba_polaroid_options_license_key', 'module_license_status' => 'njba_polaroid_options_license_status','description' => 'Display a beautiful polaroid image  that appeals the user with polaroid images.' ) ,
                   array ( 'module_name' => 'Price Box', 'module_slug' => 'njba-price-box' ,'module_license_key' => 'njba_price_box_license_key', 'module_license_status' => 'njba_price_box_license_status','description' => 'Listing your package with Different styles.' ) ,
                   array ( 'module_name' => 'Quote Box Pro', 'module_slug' => 'njba-quote-box', 'module_license_key' => 'njba_quote_box_license_key' ,'module_license_status' => 'njba_quote_box_license_status' ,'description' => 'Grab user attention with stylish Quote Box.') ,
                   
                   array ( 'module_name' => 'Teams Pro', 'module_slug' => 'njba-teams' ,'module_license_key' => 'njba_teams_license_key', 'module_license_status' => 'njba_teams_license_status','description' => 'Grab user attention with stylish your team layout.' ),
                   array ( 'module_name' => 'Testimonials Pro', 'module_slug' => 'njba-testimonials', 'module_license_key' => 'njba_testimonials_license_key', 'module_license_status' => 'njba_testimonials_license_status','description' => 'Grab user attention with stylish testimonials.' ),
                   array ( 'module_name' => 'Timeline', 'module_slug' => 'njba-timeline' ,'module_license_key' => 'njba_timeline_license_key' ,'module_license_status' => 'njba_timeline_license_status','description' => 'Grab user attention with stylish timeline.' )
              );
            //$arr = array_intersect($pro_module_name,$module_list);
              /*if($module_list != ''){
                $arr = array_intersect($pro_module_name,$module_list);
              }else{
                $arr = $pro_module_name;
              }*/
            
             foreach ($pro_module_name as $value) 
             {
                if($module_list != ''){
                    foreach ( $module_list as $modules ) 
                    { 
                        if($value['module_slug'] == $modules['module_slug'])
                        {
                           
                            $module_slug = $modules['module_slug'];
                            $module_slug_chnage = str_replace('-','_',$module_slug);
                            $versions = $module_slug_chnage.'_versions';
                            $license_value = get_option( $versions ); 
                            if($license_value)
                            {
                               
                              ?>
                              <div class="njba-columan-box">
                                  <div class="njba-columan-box-sub">
                                      <div class="addons-purchase-list">
                                        <div class="njba-info">
                                          <div class="njba-info-image">
                                              <img class="njba-image-responsive" src="<?php echo NJBA_MODULE_URL;?>classes/admin/purchase/icons/<?php  echo $module_slug; ?>-icon.png">
                                              
                                              <h3><?php  echo $modules['module_name']; ?></h3>
                                          </div>
                                          <div class="njba-info-dis">
                                              <p><?php  echo $value['description']; ?></p>
                                              <h4 class="njba-already-purchase-btn" >Install</h4>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                            <?php 
                           }  
                           else{
                             ?>
                              <div class="njba-columan-box">
                                  <div class="njba-columan-box-sub">
                                      <div class="addons-purchase-list">
                                        <div class="njba-info">
                                          <div class="njba-info-image">
                                              <img class="njba-image-responsive" src="<?php echo NJBA_MODULE_URL;?>classes/admin/purchase/icons/<?php  echo $module_slug; ?>-icon.png">
                                              
                                              <h3><?php  echo $modules['module_name']; ?></h3>
                                          </div>
                                          <div class="njba-info-dis">
                                              <p><?php  echo $value['description']; ?></p>
                                              <a href="https://www.ninjabeaveraddon.com/downloads/" class="njba-purchase-btn" target="_blank">Purchase</a>
                                          </div>
                                        </div>
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