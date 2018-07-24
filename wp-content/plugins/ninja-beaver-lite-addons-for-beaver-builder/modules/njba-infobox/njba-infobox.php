<?php
class NJBAInfoBoxModule extends FLBuilderModule {
    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Infobox', 'bb-njba'),
            'description'   => __('Addon to display Infobox.', 'bb-njba'),
            'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Content Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-infobox/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-infobox/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
        /**
         * Use these methods to enqueue css and js already
         * registered or to register and enqueue your own.
         */
        // Already registered
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
FLBuilder::register_module('NJBAInfoBoxModule', array(
    'general'       => array(
        'title'         => __('General', 'bb-njba'),
        'sections'      => array(
            'title'         => array(
                'title'         => __('Title', 'bb-njba'),
                'fields'        => array(
                    'heading_prefix'          => array(
                        'type'          => 'text',
                        'label'         => __('Title Prefix','bb-njba'),
                        'help'          => __('The small text appear above the title. You can leave it empty if not required.','bb-njba')
                    ),
                    'title'         => array(
                        'type'          => 'text',
                        'label'         => __('Title', 'bb-njba'),
                        'default'       => __('Info Box','bb-njba'),
                        'preview'       => array(
                            'type'          => 'text',
                            'selector'      => '.bb-njba-infobox-title'
                        )
                    ),
                )
            ),
            'text'          => array(
                'title'         => __('Description', 'bb-njba'),
                'fields'        => array(
                    'text'          => array(
                        'type'          => 'editor',
                        'label'         => '',
                        'media_buttons' => false,
                        'rows'          => 6,
                        'default'       => __('Enter description text here.','bb-njba'),
                    ),
                )
            )
        )
    ),
    'image_icon' => array(
        'title'         => __('Image / Icon', 'bb-njba'),
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
                                'sections'   => array( 'icon_basic',  'icon_style', 'icon_colors' ),
                            ),
                            'photo'         => array(
                                'sections'   => array( 'img_basic', 'img_style' ),
                            )
                        ),
                    ),
                )
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
                    'info_photo'         => array(
                        'type'          => 'photo',
                        'label'         => __('Photo', 'bb-njba'),
                        'show_remove'   => true,
                    ),
                    'img_size'     => array(
                        'type'          => 'text',
                        'label'         => __('Size', 'bb-njba'),
                        'placeholder'   => 'auto',
                        'maxlength'     => '5',
                        'size'          => '6',
                        'description'   => 'px',
                    )
                )
            ),
            'img_icon_style'     =>  array(
                'title'         => __('Border of Image / Icon & Background', 'bb-njba'),
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
                                'sections'   => array( ),
                                'fields'     => array( 'img_icon_border_width', 'img_icon_border_radius', 'img_icon_border_style', 'img_icon_border_color', 'img_icon_border_hover_color')
                            ),
                            'no'         => array(
                                'sections'   => array( ),
                                'fields'     => array( )
                            )
                        ),
                    ),
                    'img_icon_border_width' => array(
                        'type'        => 'text',
                        'label'       => __('Border Width', 'bb-njba'),
                        'default'     => '1',
                        'description' => 'px',
                        'maxlength'   => '3',
                        'size'        => '5',
                    ),
                    'img_icon_border_radius' => array(
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
                        'label'      => __('Color', 'bb-njba'),
                        'default'    => 'ffffff',
                        'show_reset' => true,
                    ),
                    'img_icon_border_hover_color' => array( 
                        'type'       => 'color',
                        'label'      => __('Hover Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
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
                )
            )
        )
    ),
    'style'         => array(
        'title'         => __('Style', 'bb-njba'),
        'sections'      => array(
            'overall_structure' => array(
                'title'         => __('Structure', 'bb-njba'),
                'fields'        => array(
                    'img_icon_position' => array(
                        'type'          => 'select',
                        'label'         => __('Position', 'bb-njba'),
                        'default'       => 'center',
                        'help'  => __( 'Image Icon position', 'bb-njba' ),
                        'options'       => array(
                            'center'   => __('Above Heading', 'bb-njba'),
                            'left'          => __('Left of Text and Heading', 'bb-njba'),
                            'right'         => __('Right of Text and Heading', 'bb-njba')
                        ),
                        'toggle'        => array(
                            'center' =>  array(
                                'fields'    => array( '' )
                            ),
                            'left' =>  array(
                                'sections'  => array( 'img_icon_margins' ),
                                'fields'    => array( )
                            ),
                            'right' =>  array(
                                'sections'  => array( 'img_icon_margins' ),
                                'fields'    => array( )
                            )
                        )
                    ),
                    'overall_alignment' => array(
                        'type'          => 'select',
                        'label'         => __('Overall Alignment', 'bb-njba'),
                        'default'       => 'left',
                        'help'  => __( 'Image Icon position', 'bb-njba' ),
                        'options'       => array(
                            'center'   => __('Center', 'bb-njba'),
                            'left'          => __('Left', 'bb-njba'),
                            'right'         => __('Right', 'bb-njba')
                        )
                    ),
                    'bg_type' => array(
                        'type'          => 'select',
                        'label'         => __('Select Background', 'bb-njba'),
                        'default'       => 'color',
                        'options'       => array(
                            ''              => __('None', 'bb-njba'),
                            'color'         => __('Color', 'bb-njba')
                        ),
                        'toggle'        => array(
                            'color' =>  array(
                                'fields'    => array( 'bg_color')
                            )
                        )
                    ),
                    'bg_color' => array( 
                        'type'       => 'color',
                        'label'         => __('Background Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'infobox_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Infobox Padding', 'bb-njba'),
                        'description'       => 'px',
                        'help'              => 'Enter Padding for Full Infobox.',
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
                    'content_box_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Content Padding', 'bb-njba'),
                        'description'       => 'px',
                        'help'              => 'Enter padding for Prefix Title, Title, Description and Button.',
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
                    )
                )
            ),
            'heading_margins' => array(
                'title'         => __( 'Title Margins', 'bb-njba' ),
                'fields'        => array(
                    'heading_margin_top' => array(
                        'type'              => 'text',
                        'label'             => __('Top', 'bb-njba'),
                        'default'           => '',
                        'placeholder'       => '0',
                        'maxlength'         => '3',
                        'size'              => '4',
                        'description'       => 'px',
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.bb-njba-infobox-title',
                            'property'      => 'margin-top',
                            'unit'          => 'px'
                        ),
                    ),
                    'heading_margin_bottom' => array(
                        'type'              => 'text',
                        'label'             => __('Bottom', 'bb-njba'),
                        'placeholder'       => '10',
                        'maxlength'         => '3',
                        'size'              => '4',
                        'description'       => 'px',
                    ),
                    'prefix_margin_top' => array(
                        'type'              => 'text',
                        'label'             => __('Prefix Top', 'bb-njba'),
                        'placeholder'       => '0',
                        'maxlength'         => '3',
                        'size'              => '4',
                        'description'       => 'px',
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.bb-njba-infobox-title-prefix',
                            'property'      => 'margin-top',
                            'unit'          => 'px'
                        ),
                    )
                )
            ),
            'img_icon_margins' => array(
                'title'         => __( 'Image / Icon Margins', 'bb-njba' ),
                'fields'        => array(
                    'icon_margin'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Icon Margins', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 0,
                            'right'         => 20,
                            'bottom'       => 0,
                            'left'      => 20
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
                    )
                )
            ),
            'content_margins' => array(
                'title'         => __( 'Description Margins', 'bb-njba' ),
                'fields'        => array(
                    'content_margin_top' => array(
                        'type'              => 'text',
                        'label'             => __('Top', 'bb-njba'),
                        'placeholder'       => '0',
                        'maxlength'         => '3',
                        'size'              => '4',
                        'description'       => 'px',
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.bb-njba-infobox-text',
                            'property'      => 'margin-top',
                            'unit'          => 'px'
                        ),
                    ),
                    'content_margin_bottom' => array(
                        'type'              => 'text',
                        'label'             => __('Bottom', 'bb-njba'),
                        'placeholder'       => '0',
                        'maxlength'         => '3',
                        'size'              => '4',
                        'description'       => 'px',
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.bb-njba-infobox-text',
                            'property'      => 'margin-bottom',
                            'unit'          => 'px'
                        ),
                    )
                )
            ),
        )
    ),
    'button'           => array(
        'title'         => __('Button / Link', 'bb-njba'),
        'sections'      => array(
            'button'           => array(
                'title'         => __('General', 'bb-njba'),
                'fields'        => array(
                    'cta_type'      => array(
                        'type'          => 'select',
                        'label'         => __('Type', 'bb-njba'),
                        'default'       => 'none',
                        'options'       => array(
                            'none'          => _x( 'None', 'Call to action.', 'bb-njba' ),
                            'link'          => __('Text', 'bb-njba'),
                            'button'        => __('Button', 'bb-njba'),
                            'complete_box'  => __('Complete Box', 'bb-njba')
                        ),
                        'toggle'        => array(
                            'none'          => array(),
                            'link'          => array(
                                'fields'        => array('button_text'),
                                'sections'      => array('button_link_section','btn_link_typography')
                            ),
                            'button'        => array(
                                'fields'        => array('button_text'),
                                'sections'      => array('button_link_section','button_style_section','transition_section','structure_section','button_typography')
                            ),
                            'complete_box'  => array(
                                'fields'        => array(''),
                                'sections'      => array( 'button_link_section' )
                            )
                        )
                    ),
                    'button_text'      => array(
                        'type'          => 'text',
                        'label'         => __('Text', 'bb-njba'),
                        'default'       => __('Read More', 'bb-njba'),
                    ),
                )
            ),
            'button_link_section'  => array(
                'title'     =>  __('Link', 'bb-njba'), // Tab title',
                'fields'    => array(
                    'link'     => array(
                        'type'          => 'link',
                        'label'         =>  __('Link', 'bb-njba'),
                        'default'       =>  __('#', 'bb-njba'),
                        'placeholder'   => 'www.example.com',
                        'preview'       => array(
                            'type'          => 'none'
                        )
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
            'button_style_section' => array(
                'title' => __('Button Style','bb-njba'),
                'fields' => array(
                    'button_style'         => array(
                        'type'          => 'select',
                        'label'         => __('Style', 'bb-njba'),
                        'default'       => 'flat',
                        'class'         => 'creative_button_styles',
                        'options'       => array(
                            'flat'          => __('Flat', 'bb-njba'),
                            'gradient'      => __('Gradient', 'bb-njba'),
                            'transparent'   => __('Transparent', 'bb-njba'),
                            'threed'          => __('3D', 'bb-njba'),
                        ),
                        'toggle'        => array(
                            'flat'          => array(
                                'fields'        => array('button_background_color','hover_button_style','button_box_shadow','button_box_shadow_color'),
                                'sections' => array('transition_section')
                            ),
                            'gradient'          => array(
                                'fields'        => array('button_background_color')
                            ),
                            'threed'          => array(
                                'fields'        => array('button_background_color','hover_button_style'),
                                'sections' => array('transition_section')
                            ),
                            'transparent' => array(
                                'fields' => array('hover_button_style','button_box_shadow','button_box_shadow_color'),
                                'sections' => array('transition_section')
                            )
                        )
                    ),
                    'button_background_color' => array(
                        'type' => 'color',
                        'label' => __('Background Color','bb-njba'),
                        'show_reset' => true,
                        'default' => 'dfdfdf'
                    ),
                    'button_background_hover_color' => array(
                        'type' => 'color',
                        'label' => __('Background Hover Color','bb-njba'),
                        'show_reset' => true,
                        'default' => '000000'
                    ),
                    'button_text_color' => array(
                        'type' => 'color',
                        'label' => __('Text Color','bb-njba'),
                        'show_reset' => true,
                        'default' => '404040'
                    ),
                    'button_text_hover_color' => array(
                        'type' => 'color',
                        'label' => __('Text Hover Color','bb-njba'),
                        'show_reset' => true,
                        'default' => 'ffffff'
                    ),
                    'button_border_style'      => array(
                        'type'      => 'select',
                        'label'     => __('Border Style', 'bb-njba'),
                        'default'   => 'none',
                        'options'   => array(
                            'none'  => __('None', 'bb-njba'),
                            'solid'  => __('Solid', 'bb-njba'),
                            'dotted'  => __('Dotted', 'bb-njba'),
                            'dashed'  => __('Dashed', 'bb-njba'),
                            'double'  => __('Double', 'bb-njba'),
                        ),
                        'toggle' => array(
                            'solid' => array(
                                'fields' => array('button_border_width','button_border_radius','button_border_color','button_border_hover_color')
                            ),
                            'solid' => array(
                                'fields' => array('button_border_width','button_border_radius','button_border_color','button_border_hover_color')
                            ),
                            'solid' => array(
                                'fields' => array('button_border_width','button_border_radius','button_border_color','button_border_hover_color')
                            ),
                            'solid' => array(
                                'fields' => array('button_border_width','button_border_radius','button_border_color','button_border_hover_color')
                            ),
                        )
                    ),
                    'button_border_width' => array(
                        'type' => 'text',
                        'label' => __('Border Width','bb-njba'),
                        'default' => '1',
                        'size' => '5',
                        'description'       => _x( 'px', 'Value unit for spacer width. Such as: "10 px"', 'bb-njba' )
                    ),
                    'button_border_radius'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Border Radius', 'bb-njba'),
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
                    'button_border_color' => array(
                        'type' => 'color',
                        'label' => __('Border Color','bb-njba'),
                        'show_reset' => true,
                        'default' => '000000'
                    ),
                    'button_border_hover_color' => array(
                        'type' => 'color',
                        'label' => __('Border Hover Color','bb-njba'),
                        'show_reset' => true,
                        'default' => '000000'
                    ),
                    'button_box_shadow'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Box Shadow', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'left_right'          => 0,
                            'top_bottom'         => 0,
                            'blur'       => 0,
                            'spread'      => 0
                        ),
                        'options'           => array(
                            'left_right'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa fa-arrows-h'
                            ),
                            'top_bottom'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa fa-arrows-v'
                            ),
                            'blur'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa fa-circle-thin'
                            ),
                            'spread'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa fa-circle'
                            )
                            
                        )
                    ),
                    'button_box_shadow_color' => array(
                        'type' => 'color',
                        'label' => __('Box Shadow Color','bb-njba'),
                        'show_reset' => true,
                        'default' => 'ffffff'
                    ),
                    'button_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 20,
                            'right'         => 40,
                            'bottom'       => 20,
                            'left'      => 40
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
                    )
                )
            ),
            'transition_section' =>array(
                'title' => __('Transition','bb-njba'),
                'fields' => array(
                    'transition' => array(
                        'type' => 'text',
                        'label' => __('Transition delay','bb-njba'),
                        'default' => 0.3,
                        'size' => '5',
                        'description' => 's'
                    ),
                ) 
            ),      
            'structure_section' =>array(
                'title' => __('Structure','bb-njba'),
                'fields' => array(
                    'width' => array(
                        'type' => 'select',
                        'label' => __('Width','bb-njba'),
                        'default' => 'auto',
                        'options' => array(
                            'auto' => __('Auto','bb-njba'),
                            'full_width' => __('Full Width','bb-njba'),
                            'custom' => __('Custom','bb-njba')
                        ),
                        'toggle' => array(
                            'auto' => array(
                                'fields' => array('alignment')
                            ),
                            'full_width' => array(
                                'fields' => array('')
                            ),
                            'custom' => array(
                                'fields' => array('custom_width','custom_height','alignment')
                            )
                        )
                    ),
                    'custom_width' => array(
                        'type' => 'text',
                        'label' => __('Custom Width','bb-njba'),
                        'default' => 200,
                        'size' => 10
                    ),
                    'custom_height' => array(
                        'type' => 'text',
                        'label' => __('Custom Height','bb-njba'),
                        'default' => 45,
                        'size' => 10
                    ),
                ) 
            )
        )
    ),
    'typography'         => array(
        'title'         => __('Typography', 'bb-njba'),
        'sections'      => array(
            'prefix_typography'    =>  array(
                'title' => __('Title Prefix', 'bb-njba' ),
                'fields'    => array(
                    'prefix_tag_selection'   => array(
                        'type'          => 'select',
                        'label'         => __('Tag', 'bb-njba'),
                        'default'       => 'h5',
                        'options'       => array(
                            'h1'      => __('H1', 'bb-njba'),
                            'h2'      => __('H2', 'bb-njba'),
                            'h3'      => __('H3', 'bb-njba'),
                            'h4'      => __('H4', 'bb-njba'),
                            'h5'      => __('H5', 'bb-njba'),
                            'h6'      => __('H6', 'bb-njba')
                        )
                    ),
                    'prefix_font_family'       => array(
                        'type'          => 'font',
                        'label'         => __('Font Family', 'bb-njba'),
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 'Default'
                        ),
                        'preview'   => array(
                            'type'      => 'font',
                            'selector'  => '.bb-njba-infobox-title-prefix'
                        ),
                    ),
                    'prefix_font_size'     => array(
                        'type'          => 'njba-simplify',
                        'label'         => __( 'Font Size', 'bb-njba' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'prefix_line_height'    => array(
                        'type'          => 'njba-simplify',
                        'label'         => __( 'Line Height', 'bb-njba' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'prefix_color'        => array( 
                        'type'       => 'color',
                        'label'      => __('Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    )
                )
            ),
            'title_typography'    =>  array(
                'title' => __('Title', 'bb-njba' ),
                'fields'    => array(
                    'title_tag_selection'   => array(
                        'type'          => 'select',
                        'label'         => __('Tag', 'bb-njba'),
                        'default'       => 'h3',
                        'options'       => array(
                            'h1'      => __('H1', 'bb-njba'),
                            'h2'      => __('H2', 'bb-njba'),
                            'h3'      => __('H3', 'bb-njba'),
                            'h4'      => __('H4', 'bb-njba'),
                            'h5'      => __('H5', 'bb-njba'),
                            'h6'      => __('H6', 'bb-njba')
                        )
                    ),
                    'title_font_family'       => array(
                        'type'          => 'font',
                        'label'         => __('Font Family', 'bb-njba'),
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 'Default'
                        ),
                        'preview'   => array(
                            'type'      => 'font',
                            'selector'  => '.bb-njba-infobox-title'
                        ),
                    ),
                    'title_font_size'     => array(
                        'type'          => 'njba-simplify',
                        'label'         => __( 'Font Size', 'bb-njba' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'title_line_height'    => array(
                        'type'          => 'njba-simplify',
                        'label'         => __( 'Line Height', 'bb-njba' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'title_color'        => array( 
                        'type'       => 'color',
                        'label'      => __('Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                )
            ),
            'subhead_typography'    =>  array(
                'title' => __('Description', 'bb-njba' ),
                'fields'    => array(
                    'subhead_font_family'       => array(
                        'type'          => 'font',
                        'label'         => __('Font Family', 'bb-njba'),
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 'Default'
                        ),
                        'preview'   => array(
                            'type'      => 'font',
                            'selector'  => '.bb-njba-infobox-text, .bb-njba-infobox-text * '
                        ),
                    ),
                    'subhead_font_size'     => array(
                        'type'          => 'njba-simplify',
                        'label'         => __( 'Font Size', 'bb-njba' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'subhead_line_height'    => array(
                        'type'          => 'njba-simplify',
                        'label'         => __( 'Line Height', 'bb-njba' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'subhead_color'        => array( 
                        'type'       => 'color',
                        'label'         => __('Description Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                )
            ),
            'btn_link_typography'    =>  array(
                'title' => __( 'Link Text', 'bb-njba' ),
                'fields'    => array(
                    'btn_link_font_family'       => array(
                        'type'          => 'font',
                        'label'         => __('Font Family', 'bb-njba'),
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 'Default'
                        ),
                        'preview'   => array(
                            'type'      => 'font',
                            'selector'  => 'a.bb-njba-button'
                        ),
                    ),
                    'btn_link_font_size'     => array(
                        'type'          => 'njba-simplify',
                        'label'         => __( 'Font Size', 'bb-njba' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'btn_link_line_height'    => array(
                        'type'          => 'njba-simplify',
                        'label'         => __( 'Line Height', 'bb-njba' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'btn_link_color'        => array( 
                        'type'       => 'color',
                        'label'      => __('Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'btn_link_hover_color'        => array( 
                        'type'       => 'color',
                        'label'      => __('Hover Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                )
            ),
            'button_typography' => array(
                'title' => __('Button','bb-njba'),
                'fields' => array(
                    'button_font_family' => array(
                        'type' => 'font',
                        'label' => __('Font Family','bb-njba'),
                        'default' => array(
                            'family' => 'Default',
                            'weight' => 'Default'
                        ),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-btn-main a.njba-btn'
                        )
                    ),
                    'button_font_size'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '18',
                            'medium' => '16',
                            'small' => ''
                        )
                    )
                )
            )
        )
    )
));