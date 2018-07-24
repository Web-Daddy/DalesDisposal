<?php
class NJBAIconImgModule extends FLBuilderModule {
    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Icon / Image', 'bb-njba'),
            'description'   => __('Addon for icon and image.', 'bb-njba'),
            'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Content Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-icon-img/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-icon-img/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh' => false, // Defaults to false and can be omitted.
            'icon'              => 'star-filled.svg',
        ));
        $this->add_css('font-awesome');
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
}
FLBuilder::register_module('NJBAIconImgModule', array(
    'general'       => array(
        'title'         => __('General', 'bb-njba'),
        'sections'      => array(
            'type_general'      => array( // Section
                'title'         => __('Image / Icon','bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'image_type'    => array(
                        'type'          => 'select',
                        'label'         => __('Image Type', 'bb-njba'),
                        'default'       => 'none',
                        'options'       => array(
                            'none'          => __( 'None', 'Image type.', 'bb-njba' ),
                            'icon'          => __('Icon', 'bb-njba'),
                            'photo'         => __('Photo', 'bb-njba'),
                        ),
                        'class'         => 'class_image_type',
                        'toggle'        => array(
                            'icon'          => array(
                                'fields'    => array( 'overall_alignment_img_icon' ),
                                'sections'   => array( 'icon_basic',  'icon_style', 'icon_colors', 'common_style', 'image_icon_link' )
                            ),
                            'photo'         => array(
                                'fields'    => array( 'overall_alignment_img_icon' ),
                                'sections'   => array( 'img_basic', 'img_style', 'common_style', 'image_icon_link' )
                            )
                        ),
                    ),
                    'overall_alignment_img_icon'    => array(
                        'type'          => 'select',
                        'label'         => __('Overall Alignment', 'bb-njba'),
                        'default'       => 'left',
                        'options'       => array(
                            'left'          => __( 'Left', 'bb-njba' ),
                            'center'          => __('Center', 'bb-njba'),
                            'right'          => __('Right', 'bb-njba'),
                        )
                    )
                ),
            ),
            'icon_basic'        => array( // Section
                'title'         => __('Icon Basics','bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'icon'          => array(
                        'type'          => 'icon',
                        'label'         => __('Icon', 'bb-njba'),
                        'show_remove' => true
                    ),
                    'icon_size'     => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '18',
                            'medium' => '16',
                            'small' => ''
                        ),
                        'preview'   => array(
                            'type'      => 'refresh',
                        )
                    ),
                    'icon_line_height'     => array(
                        'type'          => 'text',
                        'label'         => __('Width / Height', 'bb-njba'),
                        'placeholder'   => '30',
                        'maxlength'     => '5',
                        'size'          => '6',
                        'description'   => 'px',
                        'preview'   => array(
                            'type'      => 'refresh',
                        ),
                    ),
                )
            ),
            /* Image Basic Setting */
            'img_basic'     => array( // Section
                'title'         => __('Image Basics','bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'photo'         => array(
                        'type'          => 'photo',
                        'label'         => __('Photo', 'bb-njba'),
                        'show_remove'   => true,
                    ),
                    'img_size'     => array(
                        'type'          => 'text',
                        'label'         => __('Size', 'bb-njba'),
                        'placeholder'   => 'auto',
                        'help'      => __('This size is adjust your photo and it\'s Background.', 'bb-njba'),
                        'maxlength'     => '5',
                        'size'          => '6',
                        'description'   => 'px',
                    )
                )
            ),
            /* Link Setting */
            'image_icon_link'     => array( // Section
                'title'         => __('Link','bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'show_image_icon_link'       => array(
                        'type'          => 'select',
                        'label'         => __('Image / Icon Link', 'bb-njba'),
                        'default'       => 'no',
                        'options'       => array(
                            'no'             => __('No', 'bb-njba'),
                            'yes'            => __('Yes', 'bb-njba')
                        ),
                        'toggle'        => array(
                            'yes'      => array(
                                'fields'      => array( 'url', 'link_target' ),
                            ),
                        ),
                    ),
                    'url'     => array(
                        'type'          => 'link',
                        'label'         => __('Link', 'fl-builder'),
                        'placeholder'   => 'http://www.example.com',
                        
                    ),
                    'link_target'   => array(
                        'type'          => 'select',
                        'label'         =>  __('Link Target', 'bb-njba'),
                        'default'       =>  __('_self', 'bb-njba'),
                        'placeholder'   => 'www.example.com',
                        'options'   => array(
                            '_self'     =>  __('Same Window', 'bb-njba'),   
                            '_blank'    =>  __('New Window', 'bb-njba'),   
                        ),
                        'preview'   => array(
                            'type'      => 'none'
                        )
                    )
                )
            ),
            'img_icon_style'     =>  array(
                'title'         => 'Border of Image / Icon',
                'fields'        => array(
                    'img_icon_show_border'    => array(
                        'type'          => 'select',
                        'label'         => __('Show Border', 'bb-njba'),
                        'default'       => 'no',
                        'options'       => array(
                            'yes'          => __( 'Yes', 'bb-njba' ),
                            'no'          => __('No', 'bb-njba')
                        ),
                        'toggle'        => array(
                            'yes'          => array(
                                'fields'     => array( 'img_icon_border_width', 'icon_img_border_radius_njba', 'img_icon_border_style', 'img_icon_border_color', 'img_icon_border_hover_color' )
                            )
                        )
                    ),
                    'img_icon_border_width' => array(
                        'type'        => 'text',
                        'label'       => __('Border Width', 'bb-njba'),
                        'default'     => '1',
                        'description' => 'px',
                        'maxlength'   => '3',
                        'size'        => '5',
                    ),
                    'icon_img_border_radius_njba'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Border Radius', 'bb-njba'),
                        'description'       => 'px',
                        'help'              => 'Enter Padding for.',
                        'default'           => array(
                            'topleft'          => 0,
                            'topright'         => 0,
                            'bottomleft'       => 0,
                            'bottomright'      => 0
                        ),
                        'options'           => array(
                            'topleft'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up'
                            ),
                            'topright'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right'
                            ),
                            'bottomleft'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down'
                            ),
                            'bottomright'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left'
                            )
                            
                        )
                    ),
                    'img_icon_border_style'      => array(
                        'type'      => 'select',
                        'label'     => __('Border Style', 'bb-njba'),
                        'default'   => 'solid',
                        'options'   => array(
                            'none'  => __('None', 'bb-njba'),
                            'solid'  => __('Solid', 'bb-njba'),
                            'dotted'  => __('Dotted', 'bb-njba'),
                            'dashed'  => __('Dashed', 'bb-njba'),
                            'double'  => __('Double', 'bb-njba'),
                        )
                    ),
                    'img_icon_border_color' => array( 
                        'type'       => 'color',
                        'label'      => __('Border Color', 'bb-njba'),
                        'default'    => 'ffffff',
                        'show_reset' => true,
                    ),
                    'img_icon_border_hover_color' => array( 
                        'type'       => 'color',
                        'label'      => __('Border Hover Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                )
            ),
            'icon_colors'   => array( // Section
                'title'         => __('Colors', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    /* Icon Color */
                    'icon_color' => array( 
                        'type'       => 'color',
                        'label'      => __('Icon Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'icon_hover_color' => array( 
                        'type'       => 'color',
                        'label'      => __('Icon Hover Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                        'preview'       => array(
                               'type'      => 'none',
                        )
                    ),
                    'icon_transition' => array(
                        'type'        => 'text',
                        'label'       => __('Transition', 'bb-njba'),
                        'default'     => '0.3',
                        'description' => 's',
                        'maxlength'   => '3',
                        'size'        => '5',
                    )
                )
            ),
            'common_style'   => array( // Section
                'title'         => __('', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'img_icon_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 0,
                            'right'         => 0,
                            'bottom'       => 0,
                            'left'      => 0
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up'
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right'
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down'
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left'
                            )
                            
                        )
                    ),
                    'img_icon_margin'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Margin', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 0,
                            'right'         => 0,
                            'bottom'       => 0,
                            'left'      => 0
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up'
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right'
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down'
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left'
                            )
                            
                        )
                    ),
                    /* Background Color Dependent on Icon Style **/
                    'img_icon_bg_color' => array( 
                        'type'       => 'color',
                        'label'         => __('Background Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'img_icon_bg_color_opc' => array( 
                        'type'        => 'text',
                        'label'       => __('Opacity', 'bb-njba'),
                        'default'     => '',
                        'description' => '%',
                        'maxlength'   => '3',
                        'size'        => '5',
                    ),
                    'img_icon_bg_hover_color' => array( 
                        'type'       => 'color',
                        'label'      => __('Background Hover Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                        'preview'       => array(
                                'type'      => 'none',
                        )
                    ),
                    'img_icon_bg_hover_color_opc' => array( 
                        'type'        => 'text',
                        'label'       => __('Opacity', 'bb-njba'),
                        'default'     => '',
                        'description' => '%',
                        'maxlength'   => '3',
                        'size'        => '5',
                    ),
                )
            )
        )
    )
));
?>