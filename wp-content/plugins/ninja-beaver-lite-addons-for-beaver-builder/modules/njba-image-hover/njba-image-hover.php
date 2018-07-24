<?php
/**
 * @class NJBATestimonialsModule
 */
class NJBAImageHoverModule extends FLBuilderModule {
    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Image Hover', 'bb-njba'),
            'description'   => __('Addon to display image hover.', 'bb-njba'),
            'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Creative Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-image-hover/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-image-hover/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
        /**
         * Use these methods to enqueue css and js already
         * registered or to register and enqueue your own.
         */
        // Already registered
        
        $this->add_css('font-awesome');
        
        $this->add_css('njba-image-hover-frontend', NJBA_MODULE_URL . 'modules/njba-image-hover/css/frontend.css');
        
    }
    /**
     * Use this method to work with settings data before
     * it is saved. You must return the settings object.
     *
     * @method update
     * @param $settings {object}
     */
    public function update($settings)
    {
        return $settings;
    }
    /**
     * This method will be called by the builder
     * right before the module is deleted.
     *
     * @method delete
     */
    public function delete()
    {
    }
    public function njba_image_hover_module($style_type){
            
            $html ='';
            $html .= '<div class="njba-col-md-1';
            if($style_type =='3') :
                $html .= ' njba-image-box-collum" >';
            endif;
            if($style_type =='4') :
                if($this->settings->hover_effect =='1') :
                $html .= ' hover-one" >';
                endif;
                if($this->settings->hover_effect =='2') :
                $html .= ' hover-two" >';
                endif;
                if($this->settings->hover_effect =='3') :
                $html .= ' hover-three" >';
                endif;
                if($this->settings->hover_effect =='4') :
                $html .= ' hover-four" >';
                endif;
            endif;
            if($style_type =='1' || $style_type =='2' || $style_type =='5') :
                $html .= '" >';
            endif;
            $html .= '<div class="njba-image-box njba-square-hover';
            if($style_type =='2') :
                $html .= '-three">';
            endif;
            if($style_type =='3') :
                $html .= '-two">';
            endif;
            if($style_type =='4') :
                $html .= '-four">';
            endif;
            if($style_type =='5') :
                $html .= '-five">';
            endif;
            if($style_type =='1') :
                $html .= '">';
            endif;
            $html .= '<a href="'; 
                                     if(!empty($this->settings->link_url)) :
                                        $html .= $this->settings->link_url;
                                    endif;
            $html .= '" target="'; 
                                    if(!empty($this->settings->link_target)) :
                                        $html .= $this->settings->link_target;
                                    endif; 
            $html .= '">';
            $html .= '<div class="njba-image-box-img">';
            if(!empty($this->settings->photo)) :
                $html .= '<img src="'.$this->settings->photo_src.'" class="njba-image-responsive" >';
            endif;
            $html .= '<div class="njba-box-border-line">';
            if($style_type =='1' || $style_type =='3') :
                $html .= '<div class="njba-box-line njba-box-line-top"></div>';
                $html .= '<div class="njba-box-line njba-box-line-right"></div>';
                $html .= '<div class="njba-box-line njba-box-line-bottom"></div>';
                $html .= '<div class="njba-box-line njba-box-line-left"></div>';
            endif;
            if($style_type =='2' || $style_type =='4' || $style_type =='5') :   
                $html .= '<div class="njba-box-border-line-double"></div>';
            endif;
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="njba-image-box-overlay">';
            $html .= '<div class="njba-image-box-content">';
            if($style_type =='1' && !empty($this->settings->caption)) :
                $caption = $this->settings->caption[0];
                $html .= '<h1><span>'.ucfirst($caption).'</span>'.substr($this->settings->caption,1).'</h1>';
            endif;
            if(($style_type =='2' || $style_type =='3' || $style_type =='4' || $style_type =='5') && ( !empty($this->settings->caption ))) :   
                $html .= '<h1>'.$this->settings->caption.'</h1>';
            endif;
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</a>';
            $html .= '</div>';
            $html .= '</div>';
            return $html;
    }
   
}
/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('NJBAImageHoverModule', array(
    'general'       => array( // Tab
        'title'         => __('General', 'bb-njba'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => '', // Section Title
                'fields'        => array( // Section Fields
                    'photo_source'  => array(
                        'type'          => 'select',
                        'label'         => __('Photo Source', 'bb-njba'),
                        'default'       => 'library',
                        'options'       => array(
                            'library'       => __('Media Library', 'bb-njba'),
                            'url'           => __('URL', 'bb-njba')
                        ),
                        'toggle'        => array(
                            'library'       => array(
                                'fields'        => array('photo')
                            ),
                            'url'           => array(
                                'fields'        => array('photo_url')
                            )
                        )
                    ),
                    'photo'         => array(
                        'type'          => 'photo',
                        'label'         => __('Photo', 'bb-njba'),
                        'show_remove'   => true,
                    ),
                    'photo_url'     => array(
                        'type'          => 'text',
                        'label'         => __('Photo URL', 'bb-njba'),
                        'placeholder'   => 'http://www.example.com/my-photo.jpg',
                    )
                )
            ),
            'caption'       => array(
                'title'         => __('Caption', 'bb-njba'),
                'fields'        => array(
                    'caption'       => array(
                        'type'          => 'text',
                        'label'         => __('Caption', 'bb-njba')
                    )
                )
            ),
            'link'          => array(
                'title'         => __('Link', 'bb-njba'),
                'fields'        => array(
                    'link_type'     => array(
                        'type'          => 'select',
                        'label'         => __('Link Type', 'bb-njba'),
                        'options'       => array(
                            ''              => _x( 'None', 'Link type.', 'bb-njba' ),
                            'url'           => __('URL', 'bb-njba'),
                        ),
                        'toggle'        => array(
                            ''              => array(),
                            'url'           => array(
                                'fields'        => array('link_url', 'link_target')
                            ),
                        ),
                        'help'          => __('Link type applies to how the image should be linked on click. You can choose a specific URL.', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'none'
                        )
                    ),
                    'link_url'     => array(
                        'type'          => 'link',
                        'label'         => __('Link URL', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'none'
                        )
                    ),
                    'link_target'   => array(
                        'type'          => 'select',
                        'label'         => __('Link Target', 'bb-njba'),
                        'default'       => '_self',
                        'options'       => array(
                            '_self'         => __('Same Window', 'bb-njba'),
                            '_blank'        => __('New Window', 'bb-njba')
                        ),
                        'preview'         => array(
                            'type'            => 'none'
                        )
                    )
                )
            )
        )
    ),
    'style'       => array( // Tab
        'title'         => __('Style', 'bb-njba'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => '', // Section Title
                'fields'        => array( // Section Fields
                    'style'         => array(
                        'type'          => 'select',
                        'label'         => __('Photo Style', 'bb-njba'),
                        'default'       => 'Style-1',
                        'options'       => array(
                            '1'        => __('Style-1', 'bb-njba'),
                            '2'          => __('Style-2', 'bb-njba'),
                            '3'         => __('Style-3', 'bb-njba'),
                            '4'     => __('Style-4', 'bb-njba'),
                            '5'      => __('Style-5', 'bb-njba'),
                            
                        ),
                        'toggle' => array(
                            '1' => array(
                                'fields' => array( 'heading_font', 'caption_padding', 'first_font_size', 'first_font_color', 'font_size', 'font_color',  'inside_primary_border_color', 'inside_secondary_border_color', 'hover_color', 'content_box_margin1', 'hover_opacity', 'transition' )
                            ),
                            '2' => array(
                                'fields' => array( 'heading_font', 'caption_padding', 'font_size', 'font_color', 'inside_primary_border', 'inside_primary_border_color', 'inside_secondary_border', 'inside_secondary_border_color', 'hover_color', 'content_box_margin1', 'hover_opacity', 'transition' )
                            ),
                            '3' => array(
                                'fields' => array( 'heading_font', 'caption_padding', 'font_size', 'font_color', 'hover_color', 'hover_opacity', 'transition', 'before_padding', 'after_padding' )
                            ),
                            '4' => array(
                                'fields' => array( 'hover_effect', 'heading_font', 'caption_padding', 'font_size', 'font_color', 'hover_color', 'hover_opacity', 'transition' )
                            ),
                            '5' => array(
                                'fields' => array( 'heading_font', 'caption_padding', 'font_size', 'font_color', 'hover_color', 'hover_opacity', 'transition', 'rotate', 'rotate_hover', 'scale' )
                            )
                        )
                    ),
                    'hover_effect'       => array(
                        'type'          => 'select',
                        'label'         => __('Effect', 'bb-njba'),
                        'options'       => array(
                            '1'       => __('Hover Bottom To Top', 'bb-njba'),
                            '2'       => __('Hover Top To Bottom', 'bb-njba'),
                            '3'         => __('Hover Left To Right', 'bb-njba'),
                            '4'         => __('Hover Right To Left', 'bb-njba')
                            
                        )
                    ),
                    'rotate' => array(
                        'type' => 'text',
                        'label' => __('Rotate','bb-njba'),
                        'default' => -45,
                        'size' => '3',
                        'description' => 'deg'
                    ),
                    'rotate_hover' => array(
                        'type' => 'text',
                        'label' => __('After Hover Rotate','bb-njba'),
                        'default' => 0,
                        'size' => '3',
                        'description' => 'deg'
                    ),
                    'scale' => array(
                        'type' => 'text',
                        'label' => __('Scale','bb-njba'),
                        'default' => 1.1,
                        'size' => '2',
                        'description' => ''
                    ),
                    'heading_font'          => array(
                        'type'          => 'font',
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-testimonials-heading'
                        )
                    ),
                   'first_font_size'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('First Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '22',
                            'medium' => '20',
                            'small' => '16'
                        )
                    ),
                    'first_font_color'    => array( 
                        'type'       => 'color',
                        'label'      => __('First Font Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'font_size'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '18',
                            'medium' => '16',
                            'small' => '12'
                        )
                    ),
                    'font_color'    => array( 
                        'type'       => 'color',
                        'label'      => __('Font Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    
                    'inside_primary_border_color'    => array( 
                        'type'       => 'color',
                        'label'      => __('Intside Primary Border Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'inside_secondary_border_color'    => array( 
                        'type'       => 'color',
                        'label'      => __('Intside Secondary Border Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'hover_color'    => array( 
                        'type'       => 'color',
                        'label'      => __('Hover Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'hover_opacity' => array(
                        'type'          => 'text',
                        'label'         => __('Image Hover Opacity', 'bb-njba'),
                        'default'       => '100',
                        'description'   => '%',
                        'maxlength'     => '3',
                        'size'          => '5',
                        'placeholder'   => '100'
                    ),
                    'content_box_margin1'      => array(
                        'type'              => 'text',
                        'label'             => __('Margin', 'bb-njba'),
                        'size'              =>'5'
                    ),
                    'caption_padding'      => array(
                        'type'              => 'text',
                        'label'             => __('Font Padding', 'bb-njba'),
                        'size'              =>'5'
                    ),
                    'before_padding'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Before Style Padding', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '18',
                            'medium' => '16',
                            'small' => '12'
                        )
                    ),
                    'after_padding'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('After Style Padding', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '18',
                            'medium' => '16',
                            'small' => '12'
                        )
                    ),
                    'inside_primary_border'      => array(
                        'type'      => 'select',
                        'label'     => __('Primary Border Style', 'bb-njba'),
                        'default'   => 'none',
                        'options'   => array(
                            'none'  => __('None', 'bb-njba'),
                            'solid'  => __('Solid', 'bb-njba'),
                            'dotted'  => __('Dotted', 'bb-njba'),
                            'dashed'  => __('Dashed', 'bb-njba'),
                            'double'  => __('Double', 'bb-njba'),
                        ),
                    ),
                    'inside_secondary_border'      => array(
                        'type'      => 'select',
                        'label'     => __('Secondary Border Style', 'bb-njba'),
                        'default'   => 'none',
                        'options'   => array(
                            'none'  => __('None', 'bb-njba'),
                            'solid'  => __('Solid', 'bb-njba'),
                            'dotted'  => __('Dotted', 'bb-njba'),
                            'dashed'  => __('Dashed', 'bb-njba'),
                            'double'  => __('Double', 'bb-njba'),
                        ),
                    ),
                    'transition'      => array(
                        'type'              => 'text',
                        'label'             => __('Transition', 'bb-njba'),
                        'size'              =>'5'
                    )
                )
            )
        )
    )
));
