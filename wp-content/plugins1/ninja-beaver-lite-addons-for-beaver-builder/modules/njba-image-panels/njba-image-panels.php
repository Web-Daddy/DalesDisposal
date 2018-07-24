<?php
/**
 * @class NJBAImagePanelsModule
 */
class NJBAImagePanelsModule extends FLBuilderModule {
    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Image Panels', 'bb-njba'),
            'description'   => __('Create beautiful images panels.', 'bb-njba'),
            'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Creative Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-image-panels/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-image-panels/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'partial_refresh'   => true
        ));
    }
}
/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('NJBAImagePanelsModule', array(
    'content'      => array( // Tab
		'title'         => __('Panel', 'bb-njba'), // Tab title
		'sections'      => array( // Tab Sections
            'separator'      => array(
                'title'     => '',
                'fields'    => array(
                    'image_panels'  => array(
                        'type'  => 'form',
                        'label' => __('Panel', 'bb-njba'),
                        'form'  => 'njba_image_panels_form',
                        'preview_text'  => 'title',
                        'multiple'  => true
                    ),
                ),
            ),
		)
	),
    'style'     => array(
        'title' => __('Style', 'bb-njba'),
        'sections'  => array(
            'panel_style'   => array(
                'title'     => __('Panel', 'bb-njba'),
                'fields'    => array(
                    'panel_height'  => array(
                        'type'      => 'text',
                        'label'     => __('Height', 'bb-njba'),
                        'size'      => 5,
                        'maxlength' => 3,
                        'default' => 400,
                        'description'   => 'px',
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.njba-image-panels-wrap .njba-panel-item',
                            'property'  => 'height',
                            'unit'      => 'px'
                        )
                    ),
                    'show_title'        => array(
                        'type'              => 'select',
                        'label'             => __('Show Title', 'bb-njba'),
                        'default'           => 'yes',
                        'options'           => array(
                            'yes'               => __('Yes', 'bb-njba'),
                            'no'                => __('No', 'bb-njba')
                        ),
                        'toggle'            => array(
                            'yes'               => array(
                                'sections'          => array('typography')
                            )
                        )
                    ),
                ),
            ),
            'typography'    => array(
                'title'         => __('Title', 'bb-njba'),
                'fields'        => array(
                    'title_height'  => array(
                        'type'      => 'text',
                        'label'     => __('Height', 'bb-njba'),
                        'size'      => 5,
                        'maxlength' => 3,
                        'default' => 15,
                        'description'   => '%',
                        'preview'   => array(
                            'type'  => 'css',
                            'selector'  => '.njba-image-panels-wrap .njba-panel-item .njba-panel-title',
                            'property'  => 'height',
                            'unit'      => '%'
                        )
                    ),
                    'title_font'    => array(
                        'type'  => 'font',
                        'default'		=> array(
                            'family'		=> 'Default',
                            'weight'		=> 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
							'type'            => 'font',
							'selector'        => '.njba-image-panels-wrap .njba-panel-item .njba-panel-title h3'
						)
                    ),
                    'title_font_size'    => array(
						'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop'   => '24',
                            'medium'   => '',
                            'small'   => '',
                        )
					)
                )
            ),
        ),
    ),
));
/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form('njba_image_panels_form', array(
	'title' => __('Add Panel', 'bb-njba'),
	'tabs'  => array(
		'general'      => array( // Tab
			'title'         => __('Panel', 'bb-njba'), // Tab title
			'sections'      => array( // Tab Sections
                'content'          => array(
                    'title'      => '',
                    'fields'     => array(
                        'title'     => array(
                            'type'          => 'text',
                            'label'         => __('Title', 'bb-njba')
                        ),
                        'photo'     => array(
                            'type'          => 'photo',
                            'label'         => __('Image', 'bb-njba')
                        ),
                        'position'  => array(
                            'type'      => 'select',
                            'label'     => __('Image Position', 'bb-njba'),
                            'default'   => 'center',
                            'options'   => array(
                                'center'    => __('Center', 'bb-njba'),
                                'custom'    => __('Custom', 'bb-njba')
                            ),
                            'toggle'    => array(
                                'custom'    => array(
                                    'fields'    => array('custom_position')
                                )
                            )
                        ),
                        'custom_position'   => array(
                            'type'              => 'text',
                            'label'             => __('Set Position', 'bb-njba'),
                            'default'           => 50,
                            'description'       => '%',
                            'maxlength'         => 3,
                            'placeholder'       => '',
                            'class'             => '',
                            'size'              => 5,
                            'preview'           => array(
                                'type'              => 'css',
                                'selector'          => '.njba-image-panels-wrap .njba-panel-item',
                                'property'          => 'background-position',
                                'unit'              => '%'
                            )
                        ),
                        'link_type'     => array(
                            'type'          => 'select',
                            'label'         => __('Link Type', 'bb-njba'),
                            'default'       => 'none',
                            'options'       => array(
                                'none'          => __('None', 'bb-njba'),
                                'title'         => __('Title', 'bb-njba'),
                                'panel'         => __('Panel', 'bb-njba'),
                            ),
                            'toggle'    => array(
                                'title' => array(
                                    'fields'    => array('link', 'link_target'),
                                ),
                                'panel' => array(
                                    'fields'    => array('link', 'link_target'),
                                ),
                            ),
                        ),
                        'link'  => array(
                            'type'      => 'link',
                            'label'     => __('Link', 'bb-njba'),
                        ),
                        'link_target'   => array(
                            'type'      => 'select',
                            'label'     => __('Link Target', 'bb-njba'),
                            'default'   => '_self',
                            'options'   => array(
                                '_self' => __('Same Window', 'bb-njba'),
                                '_blank' => __('New Window', 'bb-njba'),
                            ),
                        ),
                    ),
                ),
                'style'     => array(
                    'title' => __('Title Style', 'bb-njba'),
                    'fields'    => array(
                        'title_color'   => array(
                            'type'      => 'color',
                            'label'     => __('Color', 'bb-njba'),
                            'show_reset'    => true,
                            'default'   => 'ffffff'
                        ),
                        'title_background_color'   => array(
                            'type'      => 'color',
                            'label'     => __('Background Color', 'bb-njba'),
                            'show_reset'    => true,
                            'default'   => '000000'
                        ),
                        'title_opacity' => array(
                            'type'      => 'text',
                            'label'     => __('Background Opacity', 'bb-njba'),
                            'description'   => __('Between 0 & 1', 'bb-njba'),
                            'default'   => '0.5',
                            'size'      => 5,
                            'maxlength' => 3
                        ),
                    ),
                ),
			)
		),
	)
));
