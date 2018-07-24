<?php
/**
 * @class NJBATabsModule
 */
class NJBAAlertboxModule extends FLBuilderModule {
    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Alert Box', 'bb-njba'),
            'description'   => __('Addon to display notifications.', 'bb-njba'),
            'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Content Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-alert-box/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-alert-box/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
        /**
         * Use these methods to enqueue css and js already
         * registered or to register and enqueue your own.
         */
        // Already registered
       // $this->add_css('jquery-bxslider');
        $this->add_css('font-awesome');
        $this->add_css('njba-alertbox-frontend', NJBA_MODULE_URL . 'modules/njba-alert-box/css/frontend.css');
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
/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('NJBAAlertboxModule', array(
    'general'      => array( // Tab
        'title'         => __('General', 'bb-njba'), // Tab title
        'sections'      => array( // Tab Sections
            'notifications'      => array(
                'title'     => '',
                'fields'    => array(
                    'alertbox_icon' => array(
                            'type'          => 'icon',
                            'label'         => __('Icon', 'bb-njba'),
                            'default'       => 'ua-icon ua-icon-check',
                            'show_remove'   => true
                    ),
                    'main_title'         => array(
                            'type'          => 'text',
                            'label'         => __('Title', 'bb-njba'),
                            'default'         => 'Success!',
                            'preview'         => array(
                                'type'            => 'text',
                                'selector'        => ''
                            )
                    ),
                    'sub_title'  => array(
                        'type'  => 'textarea',
                        'label' => __('Sub Title', 'bb-njba'),
                        'default'         => 'well done! You successfully read this important alert message.',
                        'preview'   => array(
                            'type'  => 'textarea',
                            'selector'  => ''
                        ),
                    ),
                ),
            ),
        )
    ),
     'styles'    => array(
        'title' => __('Style', 'bb-njba'),
        'sections'  => array(
            'box_styling'   => array(
                'title'     => __('Box Styling', 'bb-njba'),
                'fields'    => array(
                    'box_background'    => array(
                        'type'      => 'color',
                        'label'     => __('Background Color', 'bb-njba'),
                        'default'   => '74c274',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.alert-box-main',
                            'property'  => 'background'
                        ),
                    ),
                
                    'box_border_style'      => array(
                        'type'      => 'select',
                        'label'     => __('Border Style', 'bb-njba'),
                        'default'   => 'Solid',
                        'options'   => array(
                            'none'  => __('None', 'bb-njba'),
                            'solid'  => __('Solid', 'bb-njba'),
                            'dotted'  => __('Dotted', 'bb-njba'),
                            'dashed'  => __('Dashed', 'bb-njba'),
                            'double'  => __('Double', 'bb-njba'),
                        ),
                    ),
                    'box_border_width'  => array(
                        'type'      => 'text',
                        'label'     => __('Border Width', 'bb-njba'),
                        'size'      => 5,
                        'maxlength' => 3,
                        'default'   => 1,
                        'description'   => 'px',
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.alert-box-main',
                            'property'  => 'border-width',
                            'unit'  => 'px'
                        ),
                    ),
                    'box_border_color'  => array(
                        'type'  => 'color',
                        'label' => __('Border Color', 'bb-njba'),
                        'show_reset'    => true,
                        'default'   => '11c111',
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.alert-box-main',
                            'property'  => 'border-color'
                        ),
                    ),
                    'border_radius'    => array(
                        'type'          => 'text',
                        'default'       => '4',
                        'maxlength'     => '3',
                        'size'          => '5',
                        'label'         => __('Round Corners', 'bb-njba'),
                        'description'   => _x( 'px', 'Value unit for border radius. Such as: "5 px"', 'bb-njba' ),
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.alert-box-main',
                                    'property'      => 'border-radius',
                                    'unit'          => 'px'
                                ),                
                            ),
                        )
                    ),
                     'box_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'default'   => array(
                            'top'   => 10,
                            'bottom'   => 10,
                            'left'   => 15,
                            'right'   => 15,
                        ),                   
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'default'           => '',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main',
                                    'property'          => 'padding-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'default'           => '',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main',
                                    'property'          => 'padding-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'default'           => '',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main',
                                    'property'          => 'padding-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'default'           => '',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main',
                                    'property'          => 'padding-right',
                                ),
                            )
                        )
                    ),
                     'box_margin'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Margin', 'bb-njba'),
                        'default'   => array(
                            'top'       => '',
                            'bottom'    => '',
                            'left'      => '',
                            'right'     => '',
                        ),                   
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'default'           => '',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main',
                                    'property'          => 'margin-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'default'           => '',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main',
                                    'property'          => 'margin-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'default'           => '',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main',
                                    'property'          => 'margin-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'default'           => '',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main',
                                    'property'          => 'margin-right',
                                ),
                            )
                        )
                    ),
                ),
            ),
              'icon_styling'  => array(
                'title' => __('Icon Styling', 'bb-njba'),
                'fields'    => array(
                    'show_icon'        => array(
                        'type'          => 'select',
                        'label'         => __('Show Icon', 'bb-njba'),
                        'default'       => 'yes',
                        'options'       => array(
                            'no'    => __('Disable', 'bb-njba'),
                            'yes'      => __('Enable', 'bb-njba'),
                        ),
                        'toggle' => array(
                            'no' => array(
                                'fields' => array('')
                            ),
                            'yes' => array(                                    
                                'fields' => array('icon_size','icon_color')
                            ),
                        )
                    ),
                    'icon_size'    => array(
                        'type'          => 'text',
                        'label'         => __( 'Icon Size', 'bb-njba' ),
                        'placeholder'   => __( 'Inherit', 'bb-njba'),
                        'size'          => '25',
                        'default'       => 25,
                        'description'   => 'px',
                        'help'   => __( 'If icon size is kept bank then title font size would be applied', 'bb-njba' ),
                    ),
                    'icon_color' => array( 
                        'type'       => 'color',
                        'label'      => __('Icon Color', 'bb-njba'),
                        'default'    => 'ffffff',
                        'show_reset' => true,
                    ),
                    'icon_margin'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Margin', 'bb-njba'),
                        'default'   => array(
                            'top'   => '',
                            'bottom'   => '',
                            'left'   => '',
                            'right'   => 15,
                        ),  
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main .njba-alertbox-icon',
                                    'property'          => 'margin-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main .njba-alertbox-icon',
                                    'property'          => 'margin-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main .njba-alertbox-icon',
                                    'property'          => 'margin-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',                               
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.alert-box-main .njba-alertbox-icon',
                                    'property'          => 'margin-right',
                                ),
                            )
                        )
                    ),
                ),
            ),
            
            'title_styling'  => array(
                'title' => __('Title Styling', 'bb-njba'),
                'fields'    => array(                   
                    'title_color'    => array(
                        'type'      => 'color',
                        'label'     => __('Title Color', 'bb-njba'),
                        'show_reset'    => true,
                        'default'   => 'ffffff',
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.njba-alert-content .alert-title',
                            'property'  => 'color'
                        ),
                    ),
                     'title_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'default'   => array(
                            'top'       => '',
                            'bottom'    => '',
                            'left'      => '',
                            'right'     => '',
                        ),                   
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-title',
                                    'property'          => 'padding-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-title',
                                    'property'          => 'padding-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                               
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-title',
                                    'property'          => 'padding-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-title',
                                    'property'          => 'padding-right',
                                ),
                            )
                        )
                    ),
                     'title_margin'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Margin', 'bb-njba'),
                        'default'   => array(
                            'top'       => '',
                            'bottom'    => '',
                            'left'      => '',
                            'right'     => '',
                        ),                   
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-title',
                                    'property'          => 'margin-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-title',
                                    'property'          => 'margin-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-title',
                                    'property'          => 'margin-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-title',
                                    'property'          => 'margin-right',
                                ),
                            )
                        )
                    ),
                ),
            ),
            'subtitle_styling'  => array(
                'title' => __('Subtitle Styling', 'bb-njba'),
                'fields'    => array(                   
                    'subtitle_color'    => array(
                        'type'      => 'color',
                        'label'     => __('Subtitle Color', 'bb-njba'),
                        'show_reset'    => true,
                        'default'   => 'ffffff',
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.njba-alert-content .alert-subtitle',
                            'property'  => 'color'
                        ),
                    ),
                     'subtitle_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'default'   => array(
                            'top'       => '',
                            'bottom'    => '',
                            'left'      => '',
                            'right'     => '',
                        ),    
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-subtitle',
                                    'property'          => 'padding-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-subtitle',
                                    'property'          => 'padding-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-subtitle',
                                    'property'          => 'padding-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-subtitle',
                                    'property'          => 'padding-right',
                                ),
                            )
                        )
                    ),
                     'subtitle_margin'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Margin', 'bb-njba'),
                        'default'   => array(
                            'top'       => '',
                            'bottom'    => '',
                            'left'      => '',
                            'right'     => '',
                        ),                   
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-subtitle',
                                    'property'          => 'margin-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-subtitle',
                                    'property'          => 'margin-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-subtitle',
                                    'property'          => 'margin-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-alert-content .alert-subtitle',
                                    'property'          => 'margin-right',
                                ),
                            )
                        )
                    ),
                ),
            ),
        ),
    ),
     'typography'        => array(
        'title'         => __('Typography', 'bb-njba'),
        'sections'      => array(
            'label_typography'  => array(
                'title' => __('Title', 'bb-njba'),
                'fields'    => array(
                    'title_font' => array(
                        'type'          => 'font',
                        'default'       => array(
                            'family'        => 'Open Sans',
                            'weight'        => 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => ''
                        )
                    ),
                    'title_font_size'   => array(
                        'type'          => 'njba-simplify',
	                    'size'          => '18',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '18',
                            'medium' => '',
                            'small' => ''
                        )
                    ),
                                      
                )
            ),
            'subtitle_typography'   => array(
                'title' => __('Sub Title', 'bb-njba'),
                'fields'    => array(
                    'subtitle_font' => array(
                        'type'          => 'font',
                        'default'       => array(
                            'family'        => 'Lato',
                            'weight'        => 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => ''
                        )
                    ),
                     'subtitle_font_size'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '18',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '18',
                            'medium' => '',
                            'small' => ''
                        )
                    ),      
                )
            ),
        )
    )
));