<?php
/**
 * @class NjbaButtonModule
 */
class NjbaButtonModule extends FLBuilderModule {
    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Button', 'bb-njba'),
            'description'   => __('A module for Button.', 'bb-njba'),
            'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Content Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-button/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-button/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'icon'              => 'button.svg',
        ));
    }
    public function njba_button_icon_image(){
        if($this->settings->button_font_icon && $this->settings->buttton_icon_select == 'font_icon' ) {?>
            <span><i class="<?php echo $this->settings->button_font_icon;?>"></i></span>
        <?php } ?>
        <?php if($this->settings->button_custom_icon && $this->settings->buttton_icon_select == 'custom_icon' ) {?>
            <span><img src="<?php echo $this->settings->button_custom_icon_src;?>" /></span>
        <?php }
    }
}
/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('NjbaButtonModule', array(
    'button_tab'       => array( // Tab
        'title'         => __('Button', 'bb-njba'), // Tab title
        'sections'      => array( // Tab Sections
            'button_section'     => array(
                'title'     => '',
                'fields'    => array(
                    'button_text'     => array(
                        'type'      => 'text',
                        'label'     => 'Text',
                        'default'   => __('SUBMIT', 'bb-njba'),
                        'preview'       => array(
							'type'          => 'text',
							'selector'      => ''
						)
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
            'button_icon_section'  => array(
                'title'     =>  __('Icon', 'bb-njba'), // Tab title',
                'fields'    => array(
                    'buttton_icon_select'       => array(
                    'type'          => 'select',
                    'label'         => __('Icon Type', 'bb-njba'),
                    'default'       => 'none',
                    'options'       => array(
                        'none'              => __('None', 'bb-njba'),
                        'font_icon'         => __('Icon', 'bb-njba'),
                        'custom_icon'       => __('Image', 'bb-njba')
                    ),
                    'toggle' => array(
                        'font_icon'    => array(
                            'fields'   => array('button_font_icon','button_icon_aligment'),
                            'sections' => array('icon_section','icon_typography'),
                        ),
                        'custom_icon'   => array(
                            'fields'  => array('button_custom_icon','button_icon_aligment'),
                            'sections' => array(''),
                        ),
                    )
                    ),
                    'button_font_icon'          => array(
                        'type'          => 'icon',
                        'label'         => __('Icon', 'bb-njba')
                    ),
                    'button_custom_icon'     => array(
                        'type'              => 'photo',
                        'label'         => __('Custom Image', 'bb-njba'),
                    ),
                    'button_icon_aligment'       => array(
                        'type'          => 'select',
                        'label'         => __('Icon Position', 'bb-njba'),
                        'default'       => 'left',
                        'options'       => array(
                            'left'      => __('Before Text', 'bb-njba'),
                            'right'     => __('After Text', 'bb-njba')
                        ),
                    )
                )
            )
        )
    ),
    'style_tab' => array(
        'title' => __('Style','bb-njba'),
        'sections' => array(
            'button_style_section' => array(
                'title' => __('Button','bb-njba'),
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
                                'fields' => array('button_border_width','button_border_color','button_border_hover_color')
                            ),
                            'dotted' => array(
                                'fields' => array('button_border_width','button_border_color','button_border_hover_color')
                            ),
                            'dashed' => array(
                                'fields' => array('button_border_width','button_border_color','button_border_hover_color')
                            ),
                            'double' => array(
                                'fields' => array('button_border_width','button_border_color','button_border_hover_color')
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
                            'top-left'          => 0,
                            'top-right'         => 0,
                            'bottom-left'       => 0,
                            'bottom-right'      => 0
                        ),
                        'options'           => array(
                            'top-left'               => array(
                                'placeholder'       => __('Top Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up'
                            ),
                            'top-right'            => array(
                                'placeholder'       => __('Top Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right'
                            ),
                            'bottom-left'            => array(
                                'placeholder'       => __('Bottom Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down'
                            ),
                            'bottom-right'            => array(
                                'placeholder'       => __('Bottom Right', 'bb-njba'),
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
                    ),
                    'button_margin'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Button Margin', 'bb-njba'),
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
                    )
                )
            ),
            'icon_section' => array(
                'title' => __('Icon', 'bb-njba'),
                'fields' => array(
                    'icon_color' => array(
                        'type' => 'color',
                        'label' => __('Icon Color','bb-njba'),
                        'show_reset' => true,
                        'default' => '000000'
                    ),
                    'icon_hover_color' => array(
                        'type' => 'color',
                        'label' => __('Icon Hover Color','bb-njba'),
                        'show_reset' => true,
                        'default' => '000000'
                    ),
                    'icon_padding'      => array(
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
                    'icon_margin'      => array(
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
                    'alignment' => array(
                        'type' => 'select',
                        'label' => __('Alignment','bb-njba'),
                        'default' => 'left',
                        'options' => array(
                            'left' => __('Left','bb-njba'),
                            'center' => __('Center','bb-njba'),
                            'right' => __('Right','bb-njba')
                        )   
                    )
                ) 
            )
        )
    ),
    'typography_tab' => array(
        'title' => __('Typography','bb-njba'),
        'sections' => array(
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
            ),
            'icon_typography' => array(
                'title' => __('Icon','bb-njba'),
                'fields' => array(
                    'icon_font_size'   => array(
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
