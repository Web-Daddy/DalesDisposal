<?php

/**
 * @class NjbaAccordionModule
 */
class NjbaAccordionModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          	=> __('Accordion', 'bb-njba'),
			'description'   	=> __('Display a collapsible accordion of items.', 'bb-njba'),
			'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Content Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-accordion/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-accordion/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
			'partial_refresh'	=> true,
			'icon'				=> 'layout.svg',
		));

	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('NjbaAccordionModule', array(
	'items'         => array(
		'title'         => __('Items', 'bb-njba'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'items'         => array(
						'type'          => 'form',
						'label'         => __('Item', 'bb-njba'),
						'form'          => 'njba_accordion_items_form', // ID from registered form below
						'preview_text'  => 'label', // Name of a field to use for the preview text
						'multiple'      => true
					)
				)
			)
		)
	),
	'icon_style'	=> array(
		'title'	=> __('Icon', 'bb-njba'),
		'sections'	=> array(
			'accordion_icon_style'	=> array(
				'title'	=> '',
				'fields'	=> array(
                    'accordion_icon_size'   => array(
                       'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'description'   => 'px',
                        'default'       => array(
                            'desktop' => '24',
                            'medium' => '20',
                            'small' => '16'
                        )
                    ),
                    'icon_title_alignment'        => array(
						'type'          => 'select',
						'label'         => __('Icon / Title Alignment', 'bb-njba'),
						'default'       => 'left',
						'options'       => array(
							'left'    => __('Left', 'bb-njba'),
							'center'    => __('Center', 'bb-njba'),
							'right'    => __('Right', 'bb-njba')
						)
					),

				)
			),
			'responsive_toggle_icons'	=> array(
				'title'	=> __('Toggle Icons', 'bb-njba'),
				'fields'	=> array(
					'accordion_open_icon' => array(
						'type'          => 'icon',
						'label'         => __('Open Icon', 'bb-njba'),
						'show_remove'   => true
					),
					'accordion_close_icon' => array(
						'type'          => 'icon',
						'label'         => __('Close Icon', 'bb-njba'),
						'show_remove'   => true
					),
                    'accordion_toggle_icon_size'   => array(
                       'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'description'   => 'px',
                        'default'       => array(
                            'desktop' => '24',
                            'medium' => '20',
                            'small' => '16'
                        )
                    ),
					'accordion_toggle_icon_color'  => array(
						'type'          => 'color',
						'label'         => __('Color', 'bb-njba'),
						'default'       => 'ffffff',
						'show_reset' => true,
						'preview'	=> array(
							'type'	=> 'css',
							'selector'	=> '.njba-accordion-item .njba-accordion-button-icon',
							'property'	=> 'color'
						)
					),
					'accordion_toggle_hover_icon_color'  => array(
						'type'          => 'color',
						'label'         => __('Icon Active/Hover Color', 'bb-njba'),
						'default'       => 'ffffff',
						'show_reset' => true,
						'preview'	=> array(
							'type'	=> 'css',
							'selector'	=> '.njba-accordion-item .njba-accordion-button-icon',
							'property'	=> 'color'
						)
					)
				)
			)
		)
	),
	'style'        => array(
		'title'         => __('Style', 'bb-njba'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'item_spacing'     => array(
						'type'          => 'text',
						'label'         => __('Item Spacing', 'bb-njba'),
						'default'       => '10',
						'maxlength'     => '2',
						'size'          => '5',
						'description'   => 'px',
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.njba-accordion-item',
							'property'      => 'margin-bottom',
							'unit'			=> 'px'
						)
					),
					'collapse'   => array(
						'type'          => 'select',
						'label'         => __('Collapse Inactive', 'bb-njba'),
						'default'       => '1',
						'options'       => array(
							'1'             => __('Yes', 'bb-njba'),
							'0'             => __('No', 'bb-njba')
						),
						'help'          => __('Select yes option will keep only one item open at a time. Select no option will allow multiple items to be open at the same time.', 'bb-njba'),
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'open_first'       => array(
						'type'          => 'select',
						'label'         => __('Expand First Item', 'bb-njba'),
						'default'       => '0',
						'options'       => array(
							'1'             => __('Yes', 'bb-njba'),
							'0'             => __('No', 'bb-njba'),
						),
						'help' 			=> __('Select yes option will expand the first item by default.', 'bb-njba'),
						'toggle'		=> array(
							'0'				=> array(
								'fields'		=> array('open_custom')
							)
						)
					),
					'open_custom'	=> array(
						'type'			=> 'text',
						'label'			=> __('Expand Custom', 'bb-njba'),
						'default'		=> '',
						'size'			=> 5,
						'help'			=> __('Add item number to expand by default.', 'bb-njba')
					)
				)
			),
			'label_style'       => array(
				'title'         => __('Label', 'bb-njba'),
				'fields'        => array(
					'label_background_color'      => array(
						'type'      => 'color',
                        'label'     => __('Background Color', 'bb-njba'),
						'show_reset' => true,
                        'default'   => '50cdf1'						
                    ),
					'label_bg_active_color'  => array(
						'type'          => 'color',
						'label'         => __('Background Active/Hover Color', 'bb-njba'),
						'default'       => '474747',
						'show_reset'	=> true
					),
					'label_text_color'      => array(
						'type'      => 'color',
                        'label'     => __('Text Color', 'bb-njba'),
						'show_reset' => true,
                        'default'   => 'ffffff'
                    ),
					'label_text_active_color'  => array(
						'type'          => 'color',
						'label'         => __('Text Active/Hover Color', 'bb-njba'),
						'default'       => 'ffffff',
						'show_reset'	=> true
					),
					'label_border_style'   => array(
						'type'          => 'select',
						'label'         => __('Border Style', 'bb-njba'),
						'default'       => 'none',
						'options'       => array(
							'none'         => __( 'None', 'bb-njba' ),
							'solid'        => __( 'Solid', 'bb-njba' ),
							'dashed'         => __( 'Dashed', 'bb-njba' ),
							'dotted'         => __( 'Dotted', 'bb-njba' ),
							'double'         => __( 'Double', 'bb-njba' )
						),
						'toggle'	=> array(
							'solid'	=> array(
								'fields'	=> array('label_border_width', 'label_border_color')
							),
							'dashed'	=> array(
								'fields'	=> array('label_border_width', 'label_border_color')
							),
							'dotted'	=> array(
								'fields'	=> array('label_border_width', 'label_border_color')
							),
							'double'	=> array(
								'fields'	=> array('label_border_width', 'label_border_color')
							)
						),
						'preview'       => array(
							'type'          => 'css',
							'selector'		=> '.njba-accordion-item .njba-accordion-button',
							'property'		=> 'border-style'
						)
					),
					'label_border_width'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Border Width', 'bb-njba'),
                        'description'       => 'px',
                        'default'       => array(
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
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
					'label_border_color'  => array(
						'type'          => 'color',
						'label'         => __('Border Color', 'bb-njba'),
						'default'       => 'cccccc',
						'show_reset' => true,
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.njba-accordion-item .njba-accordion-button',
							'property'      => 'border-color'
						)
					),
					'label_border_radius'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Border Radius', 'bb-njba'),
                        'description'       => 'px',
                        'size'              => '10',
                        'default'           => array(
                            'top_left'          => 0,
                            'top_right'         => 0,
                            'bottom_left'       => 0,
                            'bottom_right'      => 0
                        ),
                        'options'           => array(
                            'top_left'               => array(
                                'placeholder'       => __('Top-Left', 'bb-njba')
                            ),
                            'top_right'            => array(
                                'placeholder'       => __('Top-Right', 'bb-njba')
                            ),
                            'bottom_left'            => array(
                                'placeholder'       => __('Bottom-left', 'bb-njba')
                            ),
                            'bottom_right'            => array(
                                'placeholder'       => __('Bottom-Right', 'bb-njba')
                            )
                        )
                    ),
					'label_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 10,
                            'right'         => 20,
                            'bottom'       => 10,
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
			'content_style'       => array(
				'title'         => __('Content', 'bb-njba'),
				'fields'        => array(
					'content_bg_color'  => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'bb-njba'),
						'default'       => 'F9F9F9',
						'show_reset'	=> true,
						'preview'	=> array(
							'type'	=> 'css',
							'selector'	=> '.njba-accordion-item .njba-accordion-content',
							'property'	=> 'background-color'
						)
					),
					'content_text_color'  => array(
						'type'          => 'color',
						'label'         => __('Text Color', 'bb-njba'),
						'default'       => '333333',
						'show_reset' => true,
						'preview'	=> array(
							'type'	=> 'css',
							'selector'	=> '.njba-accordion-item .njba-accordion-content',
							'property'	=> 'color'
						)
					),
					'content_border_style'   => array(
						'type'          => 'select',
						'label'         => __('Border Style', 'bb-njba'),
						'default'       => 'none',
						'options'       => array(
							'none'         	=> __( 'None', 'bb-njba' ),
							'solid'        	=> __( 'Solid', 'bb-njba' ),
							'dashed'        => __( 'Dashed', 'bb-njba' ),
							'dotted'        => __( 'Dotted', 'bb-njba' ),
							'double'        => __( 'Double', 'bb-njba' )
						),
						'toggle'	=> array(
							'solid'	=> array(
								'fields'	=> array('content_border_width', 'content_border_color')
							),
							'dashed'	=> array(
								'fields'	=> array('content_border_width', 'content_border_color')
							),
							'dotted'	=> array(
								'fields'	=> array('content_border_width', 'content_border_color')
							),
							'double'	=> array(
								'fields'	=> array('content_border_width', 'content_border_color')
							)
						),
						'preview'       => array(
							'type'          => 'css',
							'selector'		=> '.njba-accordion-item .njba-accordion-content',
							'property'		=> 'border-style'
						)
					),
					'content_border_width'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Border Width', 'bb-njba'),
                        'description'       => 'px',
                        'default'       => array(
                            'top' => 0,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
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
					'content_border_color'  => array(
						'type'          => 'color',
						'label'         => __('Border Color', 'bb-njba'),
						'default'       => 'cccccc',
						'show_reset' => true,
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.njba-accordion-item .njba-accordion-content',
							'property'      => 'border-color'
						)
					),
					'content_border_radius'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Border Radius', 'bb-njba'),
                        'description'       => 'px',
                        'size'              => '10',
                        'default'           => array(
                            'top_left'          => 0,
                            'top_right'         => 0,
                            'bottom_left'       => 0,
                            'bottom_right'      => 0
                        ),
                        'options'           => array(
                            'top_left'               => array(
                                'placeholder'       => __('Top-Left', 'bb-njba')
                            ),
                            'top_right'            => array(
                                'placeholder'       => __('Top-Right', 'bb-njba')
                            ),
                            'bottom_left'            => array(
                                'placeholder'       => __('Bottom-left', 'bb-njba')
                            ),
                            'bottom_right'            => array(
                                'placeholder'       => __('Bottom-Right', 'bb-njba')
                            )
                        )
                    ),
					'content_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 15,
                            'right'         => 15,
                            'bottom'       => 15,
                            'left'      => 15
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
					'content_alignment'        => array(
						'type'          => 'select',
						'label'         => __('Alignment', 'bb-njba'),
						'default'       => 'left',
						'options'       => array(
							'left'    => __('Left', 'bb-njba'),
							'center'    => __('Center', 'bb-njba'),
							'right'    => __('Right', 'bb-njba'),
						),
						'preview'	=> array(
							'type'	=>	'css',
							'selector'	=> '.njba-accordion-item .njba-accordion-content',
							'property'	=> 'text-align'
						)
					),
				)
			)
		)
	),
	'typography'        => array(
		'title'         => __('Typography', 'bb-njba'),
		'sections'      => array(
			'label_typography'	=> array(
				'title'	=> __('Label', 'bb-njba'),
				'fields'	=> array(
					'label_font' => array(
                        'type'          => 'font',
                        'default'		=> array(
                            'family'		=> 'Default',
                            'weight'		=> 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-accordion-item .njba-accordion-button .njba-accordion-button-label'
                        )
                    ),
                    'label_custom_font_size'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '24',
                            'medium' => '20',
                            'small' => '16'
                        )
                    ),
                    'label_line_height'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Line Height', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '24',
                            'medium' => '20',
                            'small' => '16'
                        )
                    )
				)
			),
			'content_typography'	=> array(
				'title'	=> __('Content', 'bb-njba'),
				'fields'	=> array(
					'content_font' => array(
                        'type'          => 'font',
                        'default'		=> array(
                            'family'		=> 'Default',
                            'weight'		=> 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-accordion-item .njba-accordion-content'
                        )
                    ),
					'content_custom_font_size'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '20',
                            'medium' => '16',
                            'small' => '14'
                        )
                    ),
					'content_line_height'   => array(
                       'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Line Height', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '24',
                            'medium' => '20',
                            'small' => '18'
                        )
                    ),
				)
			),
		)
	),
));

/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form('njba_accordion_items_form', array(
	'title' => __('Add Item', 'bb-njba'),
	'tabs'  => array(
		'general'      => array(
			'title'         => __('General', 'bb-njba'),
			'sections'      => array(
				'general'       => array(
					'title'         => '',
					'fields'        => array(
						'accordion_font_icon' => array(
							'type'          => 'icon',
							'label'         => __('Icon', 'bb-njba'),
							'show_remove'   => true
						),
						'label'         => array(
							'type'          => 'text',
							'default'		=> 'Item',
							'label'         => __('Label', 'bb-njba')
						)
					)
				),
				'content'       => array(
					'title'         => __('Content', 'bb-njba'),
					'fields'        => array(
						'content'       => array(
							'type'          => 'editor',
							'label'         => '',
							'default'	=>	'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'
						)
					)
				)
			)
		)
	)
));
