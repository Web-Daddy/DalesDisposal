<?php
/**
 * @class NJBAGalleryModule
 */
class NJBAGalleryModule extends FLBuilderModule {
    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Gallery', 'bb-njba'),
            'description'   => __('Addon to display Image Carousel.', 'bb-njba'),
            'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Creative Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-gallery/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-gallery/',
            'icon'              => 'format-gallery.svg',
        ));
        /**
         * Use these methods to enqueue css and js already
         * registered or to register and enqueue your own.
         */
        // Already registered
       
         
        $this->add_js('jquery-magnificpopup');
        $this->add_css('jquery-magnificpopup');
        $this->add_js('njba-gallery-masonary', NJBA_MODULE_URL . 'modules/njba-gallery/js/gallery-masonary.js');
        $this->add_js('jquery-imagesloaded');
        
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
    public function delete()
    {
    }
   
}
/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('NJBAGalleryModule', array(
    'general'      => array( // Tab
        'title'         => __('General', 'bb-njba'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array(
                'title'         => '',
                'fields'        => array(
                    'layout'        => array(
                        'type'          => 'select',
                        'label'         => __('Layout', 'bb-njba'),
                        'default'       => 'collage',
                        'options'       => array(
                            'grid'     => __('Grid', 'bb-njba'),
                            'masonary' => __( 'Masonry', 'bb-njba' )
                        ),
                    ),
                    
                    'photos'        => array(
                        'type'          => 'multiple-photos',
                        'label'         => __('Photos', 'bb-njba')
                    ),
                    'image_size'    => array(
                        'type'          => 'select',
                        'label'         => __('Photo Size', 'bb-njba'),
                        'default'       => 'medium',
                        'options'       =>  array(
                                'thumbnail'  => __( 'Thumbnail', 'bb-njba' ),
                                'medium'     => __( 'Medium', 'bb-njba' ),
                                'full'       => __( 'Full', 'bb-njba')
                            
                        )
                    ),
                    'show_col'         => array(
                        'type'          => 'njba-simplify',
                        'label'         => __('Show Column'),
                        'default'       => array(
                                    'desktop' => '3',
                                    'medium'  => '2',
                                    'small'   => '1',
                        ),
                        'size'          => '5', 
                    ),
                    'photo_spacing' => array(
                        'type'          => 'text',
                        'label'         => __('Photo Spacing', 'bb-njba'),
                        'mode'          => 'padding',
                        'placeholder'   => '5',
                        'size'          => '5',
                        'description'   => 'px',
                    ),
                    
                )
            ),
            'image_setting' => array(
                'title'         => __('Photo Settings', 'bb-njba'),
                'fields'        => array(
                    'hover_effects' => array(
                        'type'          => 'select',
                        'label'         => __('Image Hover Effect', 'bb-njba'),
                        'default'       => 'zoom-in',
                        'options'       => array(
                            'none'          => __('None', 'bb-njba'),
                            'rotate-left' => __('Rotate Left', 'bb-njba'),
                            'rotate-right'=> __('Rotate Right', 'bb-njba'),
                            'zoom-in'       => __('Zoom In', 'bb-njba'),
                            'zoom-out'      => __('Zoom Out', 'bb-njba'),
                        )
                    ),
                    'click_action'  => array(
                        'type'          => 'select',
                        'label'         => __('Click Action', 'bb-njba'),
                        'default'       => 'lightbox',
                        'options'       => array(
                            'none'          => __( 'None', 'bb-njba' ),
                            'lightbox'      => __('Lightbox', 'bb-njba')
                        )
                        
                    ),
                    'overly_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Hover Background', 'bb-njba'),
                        'show_reset'    => true,
                                
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-image-box-overlay',
                            'property'      => 'background-color',
                        )
                    ),
                    'overly_color_opacity'    => array(
                        'type'          => 'text',
                        'label'         => __('Opacity', 'bb-njba'),
                        'default'       => '50',
                        'maxlength'     => '3',
                        'size'          => '5', 
                        'description'       => '%', 
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-image-box-overlay',
                            'property'      => 'background-color',
                        )
                    ),
                )
            ),
          
        )
    ),
));
