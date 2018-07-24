<?php
class NJBAInfoListModule extends FLBuilderModule {
    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Info List', 'bb-njba'),
            'description'   => __('Addon for display information as list.', 'bb-njba'),
            'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Creative Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-infolist/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-infolist/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh' => false, // Defaults to false and can be omitted.
        ));
        //$this->add_css('njba-infolist-frontend', NJBA_MODULE_URL . 'modules/njba-infolist/css/frontend.css');
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
FLBuilder::register_module('NJBAInfoListModule', array(
    'info_list_tab'      => array( // Tab
        'title'         => __('Info-List Items', 'bb-njba'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => '', // Section Title
                'fields'        => array( // Section Fields
                    'info_list_content'     => array(
                        'type'          => 'form',
                        'label'         => __('List Items', 'bb-njba'),
                        'form'          => 'njba_info_list_form', // ID from registered form below
                        'preview_text'  => 'title', // Name of a field to use for the preview text
                        'multiple'      => true
                    )
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
                        'label'         => __('Image / Icon Position', 'bb-njba'),
                        'default'       => 'above-title',
                        'help'  => __( 'Image Icon position', 'bb-njba' ),
                        'options'       => array(
                            'center'   => __('Above Heading', 'bb-njba'),
                            'left'          => __('Left of Text and Heading', 'bb-njba'),
                            'right'         => __('Right of Text and Heading', 'bb-njba')
                        ),
                        'toggle'    => array(
                            'center' => array(
                                'fields' => array( 'heading_margin' ),
                            ),
                            'left' => array(
                                'fields' => array( 'heading_padding', 'heading_subhead_padding' ),
                            ),
                            'right' => array(
                                'fields' => array( 'heading_padding', 'heading_subhead_padding' ),
                            )
                        )
                    ),
                    'icon_image_size'          => array(
                        'type'          => 'text',
                        'label'         => __('Icon / Image size','bb-njba'),
                        'default'       => '30',
                        'description'       => 'px',
                        'size'      => '5'
                    ),
                    'space_btw_elements'          => array(
                        'type'          => 'text',
                        'label'         => __('Space Between Elements','bb-njba'),
                        'default'       => '10',
                        'description'       => 'px',
                        'size'      => '5'
                    ),
                    'border_radius'          => array(
                        'type'          => 'text',
                        'label'         => __('Border Radius','bb-njba'),
                        'default'       => '0',
                        'description'       => 'px',
                        'size'      => '5'
                    ),
                )
            ),
            'list_connector' => array(
                'title'         => __('List Connector', 'bb-njba'),
                'fields'        => array(
                    'show_connector' => array(
                        'type'          => 'select',
                        'label'         => __('Show Connector', 'bb-njba'),
                        'default'       => 'no',
                        'options'       => array(
                            'yes'   => __('Yes', 'bb-njba'),
                            'no'          => __('No', 'bb-njba')
                        ),
                        'toggle'    => array(
                            'yes' => array(
                                'fields' => array( 'connector_width', 'connector_color', 'connector_style'),
                            ),
                            'no' => array(
                                'fields' => array(),
                            )
                        )
                    ),
                    'connector_width'          => array(
                        'type'          => 'text',
                        'label'         => __('Connector Width','bb-njba'),
                        'default'       => '1',
                        'description'       => 'px',
                        'size'      => '5'
                    ),
                    'connector_color' => array( 
                        'type'       => 'color',
                        'label'         => __('Connector Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'connector_style'          => array(
                        'type'          => 'select',
                        'label'         => __('Connector Style','bb-njba'),
                        'default'       => 'solid',
                        'options'       => array(
                            'solid'   => __('Solid', 'bb-njba'),
                            'dotted'          => __('Dotted', 'bb-njba'),
                            'Dashed'          => __('Dashed', 'bb-njba')
                        )
                    )
                )
            )
        )
    ),
    'typography'         => array(
        'title'         => __('Typography', 'bb-njba'),
        'sections'      => array(
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
                    'heading_margin'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('margin', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 10,
                            'bottom'       => 10
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('10', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up'
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('10', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down'
                            )
                            
                        )
                    ),
                    'heading_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 0,
                            'right'         => 0,
                            'bottom'       => 0,
                            'left'      => 20
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('0', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up'
                            ),
                            'right'            => array(
                                'placeholder'       => __('0', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right'
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('0', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down'
                            ),
                            'left'            => array(
                                'placeholder'       => __('20', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left'
                            )
                            
                        )
                    )
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
                    'heading_subhead_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 0,
                            'right'         => 0,
                            'bottom'       => 0,
                            'left'      => 20
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('0', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up'
                            ),
                            'right'            => array(
                                'placeholder'       => __('0', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right'
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('0', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down'
                            ),
                            'left'            => array(
                                'placeholder'       => __('20', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left'
                            )
                            
                        )
                    )
                )
            )
        )
    )
));
FLBuilder::register_settings_form('njba_info_list_form', array(
    'title' => __('Add List Items.', 'bb-njba'),
    'tabs'  => array(
        'general'       => array(
            'title'         => __('General', 'bb-njba'),
            'sections'      => array(
                'title'         => array(
                    'title'         => __('Title', 'bb-njba'),
                    'fields'        => array(
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
                                    'sections'   => array( 'icon_basic', ),
                                ),
                                'photo'         => array(
                                    'sections'   => array( 'img_basic' ),
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
                        'icon_color' => array( 
                            'type'       => 'color',
                            'label'      => __('Icon Color', 'bb-njba'),
                            'default'    => '',
                            'show_reset' => true,
                        )
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
                        )
                    )
                ),
                'background_sec'     => array( // Section
                    'title'         => __('Icon / Image Background','bb-njba'), // Section Title
                    'fields'        => array( // Section Fields
                        'icon_bg_color' => array( 
                            'type'       => 'color',
                            'label'         => __('Background Color', 'bb-njba'),
                            'default'    => '',
                            'show_reset' => true,
                        ),
                        'icon_bg_color_opc' => array( 
                            'type'        => 'text',
                            'label'       => __('Opacity', 'bb-njba'),
                            'default'     => '100',
                            'description' => '%',
                            'maxlength'   => '3',
                            'size'        => '5',
                        )
                    )
                )
            )
        )
    )
));