<?php

class NJBASubscribeFormModule extends FLBuilderModule {

	public function __construct()
	{
		parent::__construct( array(
			'name'          	=> __( 'Subscribe Form', 'bb-njba' ),
			'description'   	=> __( 'Adds a simple subscribe form to your layout.', 'bb-njba' ),
			'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Form Style Modules - NJBA', 'bb-njba'),
            'dir'           	=> NJBA_MODULE_DIR . 'modules/njba-subscribe-form/',
            'url'           	=> NJBA_MODULE_URL . 'modules/njba-subscribe-form/',
			'editor_export' 	=> false,
			'partial_refresh'	=> true,
			'icon'              => 'editor-table.svg',
		));

		add_action( 'wp_ajax_fl_builder_subscribe_form_submit', array( $this, 'submit' ) );
		add_action( 'wp_ajax_nopriv_fl_builder_subscribe_form_submit', array( $this, 'submit' ) );

		$this->add_js( 'jquery-cookie', $this->url . 'js/jquery.cookie.min.js', array('jquery') );
		$this->add_js('njba-subscribe-form', NJBA_MODULE_URL . 'modules/njba-subscribe-form/js/frontend.js');
	}

	/**
	 * Called via AJAX to submit the subscribe form.
	 *
	 * @since 1.5.2
	 * @return string The JSON encoded response.
	 */
	public function submit()
	{
		$name       		= isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : false;
		$email      		= isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : false;
		$node_id    		= isset( $_POST['node_id'] ) ? sanitize_text_field( $_POST['node_id'] ) : false;
		$template_id    	= isset( $_POST['template_id'] ) ? sanitize_text_field( $_POST['template_id'] ) : false;
		$template_node_id   = isset( $_POST['template_node_id'] ) ? sanitize_text_field( $_POST['template_node_id'] ) : false;
		$result    			= array(
			'action'    		=> false,
			'error'     		=> false,
			'message'   		=> false,
			'url'       		=> false
		);

		if ( $email && $node_id ) {

			// Get the module settings.
			if ( $template_id ) {
				$post_id  = FLBuilderModel::get_node_template_post_id( $template_id );
				$data	  = FLBuilderModel::get_layout_data( 'published', $post_id );
				$settings = $data[ $template_node_id ]->settings;
			}
			else {
				$module   = FLBuilderModel::get_module( $node_id );
				$settings = $module->settings;
			}

			// Subscribe.
			$instance = FLBuilderServices::get_service_instance( $settings->service );
			$response = $instance->subscribe( $settings, $email, $name );

			// Check for an error from the service.
			if ( $response['error'] ) {
				$result['error'] = $response['error'];
			}
			// Setup the success data.
			else {

				$result['action'] = $settings->success_action;

				if ( 'message' == $settings->success_action ) {
					$result['message']  = $settings->success_message;
				}
				else {
					$result['url']  = $settings->success_url;
				}
			}
		}
		else {
			$result['error'] = __( 'There was an error subscribing. Please try again.', 'bb-njba' );
		}

		echo json_encode( $result );

		die();
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module( 'NJBASubscribeFormModule', array(
	'general'       => array(
		'title'         => __( 'General', 'bb-njba' ),
		'sections'      => array(
			'service'       => array(
				'title'         => '',
				'file'          => FL_BUILDER_DIR . 'includes/service-settings.php',
				'services'      => 'autoresponder'
			),
			'display_type'	=> array(
				'title'			=> '',
				'fields'		=> array(
					'form_custom_title_desc'   => array(
						'type'          => 'select',
						'label'         => __('Custom Title & Description', 'bb-njba'),
						'default'       => 'no',
						'options'       => array(
							'yes'      => __('Yes', 'bb-njba'),
							'no'     => __('No', 'bb-njba'),
                        ),
						'toggle' => array(
							'yes'      => array(
								'tabs'	  => array('had_sub_style'),
								'sections'=> array('custom_title', 'custom_description'),
								'fields'  => array('custom_title', 'custom_description'),
							),
						)
					),
					'custom_title'      => array(
						'type'          => 'text',
						'label'         => __('Custom Title', 'bb-njba'),
						'default'       => 'SEND US A MESSAGE',
						'description'   => '',
						'preview'       => array(
							'type'      => 'text',
							'selector'  => ''
						)
					),
					'custom_description'    => array(
						'type'              => 'textarea',
						'label'             => __('Custom Description', 'bb-njba'),
						'default'           => 'Create a stylish Subscribe form that people would love to fill.',
						'placeholder'       => '',
						'rows'              => '6',
						'preview'           => array(
							'type'          => 'text',
							'selector'      => ''
						)
					)
				)
			),
			'structure'        => array(
				'title'         => __( 'Form Structure', 'bb-njba' ),
				'fields'        => array(
					'layout'        => array(
						'type'          => 'select',
						'label'         => __( 'Layout', 'bb-njba' ),
						'default'       => 'stacked',
						'options'       => array(
							'stacked'       => __( 'Stacked', 'bb-njba' ),
							'inline'        => __( 'Inline', 'bb-njba' ),
							'compact'		=> __( 'Compact', 'bb-njba' ),
						),
						'toggle'	=> array(
							'stacked'	=> array(
								'fields'	=> array('alignment', 'input_custom_width', 'inputs_space', 'button_margin')
							),
							'inline'	=> array(
								'fields'	=> array('input_custom_width', 'inputs_space')
							),
							'compact'	=> array(
								'fields'	=> array('button_margin', 'input_custom_width', 'alignment')
							)
						),
						'hide'	=> array(
							'compact'	=> array(
								'fields'	=> array('input_name_width', 'input_email_width')
							)
						)
					),
					'input_custom_width'     => array(
						'type'          => 'select',
						'label'         => __( 'Inputs Width', 'bb-njba' ),
						'default'       => 'default',
						'options'       => array(
							'default'          => __( 'Default', 'bb-njba' ),
							'custom'          => __( 'Custom', 'bb-njba' ),
						),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('input_name_width', 'input_email_width')
							)
						)
					),
					'input_name_width' 	=> array(
                        'type'          	=> 'text',
                        'label'         	=> __('Name Field Width', 'bb-njba'),
                        'description'   	=> '%',
                        'size'         		=> 5,
                        'default'       	=> '',
                    ),
					'input_email_width'      => array(
                        'type'          => 'text',
                        'label'         => __('Email Field Width', 'bb-njba'),
                        'description'   => '%',
                        'size'         => 5,
                        'default'       => '',
                    ),
					'inputs_space'      => array(
                        'type'          => 'text',
                        'label'         => __('Spacing Between Inputs', 'bb-njba'),
                        'description'   => '%',
                        'size'         => 5,
                        'default'       => 1,
                    ),
					'show_name'     => array(
						'type'          => 'select',
						'label'         => __( 'Name Field', 'bb-njba' ),
						'default'       => 'show',
						'options'       => array(
							'show'          => __( 'Show', 'bb-njba' ),
							'hide'          => __( 'Hide', 'bb-njba' ),
						),
						'toggle'		=> array(
							'show'			=> array(
								'fields'		=> array('input_name_placeholder')
							)
						)
					),
					'input_name_placeholder' 	=> array(
                        'type'          	=> 'text',
                        'label'         	=> __('Name Field Placeholder Text', 'bb-njba'),
                        'description'   	=> '',
                        'default'       	=> __('Name', 'bb-njba'),
                    ),
					'input_email_placeholder' 	=> array(
                        'type'          	=> 'text',
                        'label'         	=> __('Email Field Placeholder Text', 'bb-njba'),
                        'description'   	=> '',
                        'default'       	=> __('Email Address', 'bb-njba'),
                    ),
				)
			),
		)
	),
	'had_sub_style'	=> array(
		'title'	=> __('Heading & Description', 'bb-njba'),
		'sections'	=> array(
			'title_style' => array( // Section
				'title' => __('Title', 'bb-njba'),
				'fields'    => array(
					'title_alignment'    => array(
						'type'                      => 'select',
						'label'                     => __('Alignment', 'bb-njba'),
						'default'                   => 'center',
						'options'                   => array(
							'left'                  => __('Left', 'bb-njba'),
							'center'                => __('Center', 'bb-njba'),
							'right'                 => __('Right', 'bb-njba'),
						),
						'preview'       => array(
							'type'      => 'css',
							'selector'  => '',
							'property'  => 'text-align'
						)
					),
					'title_color'       => array(
						'type'          => 'color',
						'label'         => __('Color', ''),
						'default'       => '333333',
						'show_reset'    => true,
						'preview'       => array(
							'type'      => 'css',
							'selector'  => '.njba-form-title .njba-heading-title',
							'property'  => 'color'
						)
					),
					 'title_margin'      => array(
					 	'type'              => 'njba-multinumber',
					 	'label'             => __('Margin', 'bb-njba'),
					 	'options'           => array(
					 		'top'               => array(
					 			'placeholder'       => __('Top', 'bb-njba'),
					 			'icon'              => 'fa-long-arrow-up',
					 			'description'       => 'px',
					 			'preview'           => array(
					 				'selector'          => '.njba-form-title .njba-heading-title',
					 				'property'          => 'margin-top',
					 			),
					 		),
					 		'bottom'            => array(
					 			'placeholder'       => __('Bottom', 'bb-njba'),
					 			'icon'              => 'fa-long-arrow-down',
					 			'description'       => 'px',
					 			'preview'           => array(
					 				'selector'          => '.njba-form-title .njba-heading-title',
					 				'property'          => 'margin-bottom',
					 			),
					 		),
					 		'left'            => array(
					 			'placeholder'       => __('Left', 'bb-njba'),
					 			'icon'              => 'fa-long-arrow-left',
					 			'description'       => 'px',
					 			'preview'           => array(
					 				'selector'          => '.njba-form-title .njba-heading-title',
					 				'property'          => 'margin-left',
					 			),
					 		),
					 		'right'            => array(
					 			'placeholder'       => __('Right', 'bb-njba'),
					 			'icon'              => 'fa-long-arrow-right',
					 			'description'       => 'px',
					 			'preview'           => array(
					 				'selector'          => '.njba-form-title .njba-heading-title',
					 				'property'          => 'margin-right',
					 			),
					 		)
					 	)
					),
					'title_font_family' => array(
						'type'          => 'font',
						'default'       => array(
							'family'        => 'Default',
							'weight'        => 300
						),
						'label'         => __('Font', 'bb-njba'),
						'preview'         => array(
							'type'            => 'font',
							'selector'        => '.njba-form-title .njba-heading-title'
						)
					),
					'title_font_size'   => array(
						'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '',
                            'medium' => '',
                            'small' => ''
                        )
                    ),
					'title_line_height'   => array(

                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Line Height', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '',
                            'medium' => '',
                            'small' => ''
                        )
                    ),                                             
				)
			),
			'description_style' => array( // Section
				'title' => __('Description', 'bb-njba'),
				'fields'    => array(
					'description_alignment'    => array(
						'type'                      => 'select',
						'label'                     => __('Alignment', 'bb-njba'),
						'default'                   => 'center',
						'options'                   => array(
							'left'                  => __('Left', 'bb-njba'),
							'center'                => __('Center', 'bb-njba'),
							'right'                 => __('Right', 'bb-njba'),
						),
						'preview'       => array(
							'type'      => 'css',
							'selector'  => '',
							'property'  => 'text-align'
						)
					),
					'description_color' => array(
						'type'          => 'color',
						'label'         => __('Color', 'bb-njba'),
						'default'       => '333333',
						'show_reset'    => true,
						'preview'       => array(
							'type'      => 'css',
							'selector'  => '.njba-form-title .njba-heading-sub-title',
							'property'  => 'color'
						)
					),
					 'description_margin'      => array(
					 	'type'              => 'njba-multinumber',
					 	'label'             => __('Margin', 'bb-njba'),
					 	 'default'           => array(
					 	 	'top'          => '',
					 	 	'bottom'       => 40,
					 	 	'left'         => '',
							'right'        => '',
						),
					 	 'options'           => array(
					 	 	'top'               => array(
					 	 		'placeholder'       => __('Top', 'bb-njba'),
					 	 		'icon'              => 'fa-long-arrow-up',
					 	 		'description'       => 'px',
					 	 		'preview'           => array(
					 	 			'selector'          => '.njba-form-title .njba-heading-sub-title',
					 	 			'property'          => 'margin-top',
					 	 		),
					 	 	),
					 	 	'bottom'            => array(
					 	 		'placeholder'       => __('Bottom', 'bb-njba'),
					 	 		'icon'              => 'fa-long-arrow-down',
					 	 		'description'       => 'px',
					 	 		'preview'           => array(
					 	 			'selector'          => '.njba-form-title .njba-heading-sub-title',
					 	 			'property'          => 'margin-bottom',
					 	 		),
					 	 	),
					 	 	'left'            => array(
					 	 		'placeholder'       => __('Left', 'bb-njba'),
					 	 		'icon'              => 'fa-long-arrow-left',
					 	 		'description'       => 'px',
					 	 		'preview'           => array(
					 	 			'selector'          => '.njba-form-title .njba-heading-sub-title',
					 	 			'property'          => 'margin-left',
					 	 		),
					 	 	),
					 	 	'right'            => array(
					 	 		'placeholder'       => __('Right', 'bb-njba'),
					 	 		'icon'              => 'fa-long-arrow-right',
					 	 		'description'       => 'px',
					 	 		'preview'           => array(
					 	 			'selector'          => '.njba-form-title .njba-heading-sub-title',
					 	 			'property'          => 'margin-right',
					 	 		),
					 	 	)
					 	 )
					),
					'description_font_family' => array(
						'type'          => 'font',
						'default'       => array(
							'family'        => 'Default',
							'weight'        => 300
						),
						'label'         => __('Font', 'bb-njba'),
						'preview'         => array(
							'type'            => 'font',
							'selector'        => '.njba-form-title .njba-heading-sub-title'
						)
					),
					'description_font_size'   => array(
						'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '',
                            'medium' => '',
                            'small' => ''
                        )
                    ),
					'description_line_height'   => array(
						'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Line Height', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '',
                            'medium' => '',
                            'small' => ''
                        )
                    ),  
				)
			),
		)
	),
	'subscribe_form_style'	=> array(
		'title'	=> __('Style', 'bb-njba'),
		'sections'	=> array(
			'form_bg_setting'	=> array(
				'title'	=> __('Form Background', 'bb-njba'),
				'fields'	=> array(
					'form_bg_type'      => array(
	                    'type'          => 'select',
	                    'label'         => __('Background Type', 'bb-njba'),
	                    'default'       => 'color',
	                    'options'       => array(
	                        'color'   => __('Color', 'bb-njba'),
	                        'image'     => __('Image', 'bb-njba'),
	                    ),
	                    'toggle'    => array(
	                        'color' => array(
	                            'fields'    => array('form_bg_color','form_background_opacity')
	                        ),
	                        'image' => array(
	                            'fields'    => array('form_bg_image','form_bg_size','form_bg_repeat')
	                        )
	                    )
	                ),
	                'form_bg_color'     => array(
	                    'type'          => 'color',
	                    'label'         => __('Background Color', 'bb-njba'),
	                    'default'       => 'ffffff',
	                    'show_reset'    => true,
	                    'preview'       => array(
	                        'type'      => 'css',
	                        'selector'  => '.njba-subscribe-form',
	                        'property'  => 'background-color'
	                    )
	                ),
	                'form_background_opacity'    => array(
	                    'type'                 => 'text',
	                    'label'                => __('Background Opacity', 'bb-njba'),
	                    'size'          		=> '5',
						'maxlength'				=> 3,
	                    'description'          => '%',
	                    'default'              => '100',
	                    'preview'              => array(
	                        'type'             => 'css',
	                        'selector'         => '.njba-subscribe-form',
	                        'property'         => 'opacity',
	                    )
	                ),
	                'form_bg_image'     => array(
	                	'type'              => 'photo',
	                    'label'         	=> __('Background Image', 'bb-njba'),
	                    'default'       	=> '',
	                    'preview'       	=> array(
	                        'type'      		=> 'css',
	                        'selector'  		=> '.njba-subscribe-form',
	                        'property'  		=> 'background-image'
	                    )
	                ),
	                'form_bg_size'      => array(
	                    'type'         		=> 'select',
	                    'label'         	=> __('Background Size', 'bb-njba'),
	                    'default'       	=> 'cover',
	                    'options'       	=> array(
	                        'contain'   		=> __('Contain', 'bb-njba'),
	                        'cover'     		=> __('Cover', 'bb-njba'),
	                    )
	                ),
	                'form_bg_repeat'    => array(
	                    'type'          	=> 'select',
	                    'label'         	=> __('Background Repeat', 'bb-njba'),
	                    'default'       	=> 'no-repeat',
	                    'options'       	=> array(
	                        'repeat-x'      	=> __('Repeat X', 'bb-njba'),
	                        'repeat-y'      	=> __('Repeat Y', 'bb-njba'),
	                        'no-repeat'     	=> __('No Repeat', 'bb-njba'),
	                    )
	                ),
				)
			),
			'form_border_setting'	=> array( // Section
                'title'         		=> __('Border', 'bb-njba'), // Section Title
                'fields'        		=> array( // Section Fields
                    'form_border_style'	=> array(
                        'type'          	=> 'select',
                        'label'         	=> __('Border Style', 'bb-njba'),
                        'default'       	=> 'none',
                        'options'			=> array(
                            'none'				=> __('None', 'bb-njba'),
                            'solid'				=> __('Solid', 'bb-njba'),
                       		'dashed'			=> __('Dashed', 'bb-njba'),
                       		'dotted'			=> __('Dotted', 'bb-njba'),
                        ),
                        'preview'	=> array(
                            'type'      => 'css',
                            'selector'  => '.njba-subscribe-form',
                            'property'  => 'border-style'
                        ),
                        'toggle'    => array(
                            'solid' 	=> array(
                                'fields'    => array('form_border_width', 'form_border_color')
                            ),
                            'dashed'	=> array(
                                'fields'	=> array('form_border_width', 'form_border_color')
                            ),
                            'dotted'	=> array(
                                'fields'    => array('form_border_width', 'form_border_color')
                            )
                        )
                    ),
                    'form_border_width'	=> array(
                        'type'          	=> 'text',
                        'label'         	=> __('Border Width', 'bb-njba'),
                        'description'   	=> 'px',
                        'size'         		=> 5,
                        'default'       	=> 2,
                        'preview'       	=> array(
                            'type'      		=> 'css',
                            'selector'  		=> '.njba-subscribe-form',
                            'property'  		=> 'border-width',
                            'unit'      		=> 'px'
                        )
                    ),
                    'form_border_color'	=> array(
                        'type'          	=> 'color',
                        'label'         	=> __('Border Color', 'bb-njba'),
                        'default'       	=> 'ffffff',
                        'show_reset'    	=> true,
                        'preview'       	=> array(
                            'type'      		=> 'css',
                            'selector'  		=> '.njba-subscribe-form',
                            'property'  		=> 'border-color'
                        )
                    ),
                )
            ),
			'form_box_shadow'	=> array( // Section
                'title'         	=> __('Shadow', 'bb-njba'), // Section Title
                'fields'        	=> array( // Section Fields
                    'form_shadow_display'	=> array(
                        'type'                 	=> 'select',
                        'label'                	=> __('Enable Shadow', 'bb-njba'),
                        'default'              	=> 'no',
                        'options'              	=> array(
                            'yes'          			=> __('Yes', 'bb-njba'),
                            'no'             		=> __('No', 'bb-njba'),
                        ),
                        'toggle'	=>  array(
                            'yes'   	=> array(
                                'fields'	=> array('form_shadow', 'form_shadow_color')
                            )
                        )
                    ),
                    'form_shadow'	=> array(
						'type'          => 'njba-multinumber',
						'label'         => __('Box Shadow', 'bb-njba'),
						'default'       => array(
							'vertical'		=> 0,
							'horizontal'	=> 0,
							'blur'			=> 10,
							'spread'		=> 5
						),
						'options'	=> array(
							'vertical'			=> array(
								'placeholder'		=> __('Vertical', 'bb-njba'),
								'tooltip'			=> __('Vertical', 'bb-njba'),
								'icon'				=> 'fa-arrows-v'
							),
							'horizontal'		=> array(
								'placeholder'		=> __('Horizontal', 'bb-njba'),
								'tooltip'			=> __('Horizontal', 'bb-njba'),
								'icon'				=> 'fa-arrows-h'
							),
							'blur'				=> array(
								'placeholder'		=> __('Blur', 'bb-njba'),
								'tooltip'			=> __('Blur', 'bb-njba'),
								'icon'				=> 'fa-circle-o'
							),
							'spread'			=> array(
								'placeholder'		=> __('Spread', 'bb-njba'),
								'tooltip'			=> __('Spread', 'bb-njba'),
								'icon'				=> 'fa-paint-brush'
							),
						)
					),
                    'form_shadow_color' => array(
                        'type'              => 'color',
                        'label'             => __('Shadow Color', 'bb-njba'),
                        'default'           => '000000',
                    )
                )
            ),
			'form_corners_padding'      => array( // Section
                'title'         => __('Form Structure', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'form_border_radius' 	=> array(
                        'type'          => 'text',
                        'label'         => __('Round Corners', 'bb-njba'),
                        'description'   => 'px',
                        'default'       => 2,
                        'size'         => 5,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.njba-subscribe-form',
                            'property'  => 'border-radius',
                            'unit'      => 'px'
                        )
                    ),
                    'form_padding' 	=> array(
                        'type' 			=> 'njba-multinumber',
                        'label' 		=> __('Padding', 'bb-njba'),
                        'description'   => 'px',
                        'default'       => array(
                            'top' => 15,
                            'right' => 15,
                            'bottom' => 15,
                            'left' => 15,
                        ),
                        'options' 		=> array(
                            'top' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Top', 'bb-njba'),
                                'tooltip'       => __('Top', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-up',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form',
                                    'property'  => 'padding-top',
                                    'unit'      => 'px'
                                )
                            ),
                            'bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Bottom', 'bb-njba'),
                                'tooltip'       => __('Bottom', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-down',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form',
                                    'property'  => 'padding-bottom',
                                    'unit'      => 'px'
                                )
                            ),
                            'left' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Left', 'bb-njba'),
                                'tooltip'       => __('Left', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-left',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form',
                                    'property'  => 'padding-left',
                                    'unit'      => 'px'
                                )
                            ),
                            'right' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Right', 'bb-njba'),
                                'tooltip'       => __('Right', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-right',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form',
                                    'property'  => 'padding-right',
                                    'unit'      => 'px'
                                )
                            ),
                        ),
                    )
                )
            ),
		)
	),
	'input_style'   => array(
        'title' => __('Inputs', 'bb-njba'),
        'sections'  => array(
            'input_colors_setting'      => array( // Section
                'title'         => __('Colors', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'input_field_text_color'    => array(
                        'type'                  => 'color',
                        'label'                 => __('Text Color', 'bb-njba'),
                        'default'               => '333333',
                        'preview'               => array(
                            'type'                  => 'css',
                            'selector'              => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                            'property'              => 'color'
                        )
                    ),
                    'input_field_bg_color'      => array(
                        'type'                  => 'color',
                        'label'                 => __('Background Color', 'bb-njba'),
                        'default'               => 'ffffff',
                        'show_reset'            => true,
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                            'property'          => 'background-color'
                        )
                    ),
                    'input_field_background_opacity'    => array(
                        'type'                 => 'text',
                        'label'                => __('Background Opacity', 'bb-njba'),
						'size'          		=> '5',
						'maxlength'				=> 3,
                        'description'          => '%',
                        'default'              => '100',
                        'preview'              => array(
                            'type'             => 'css',
                            'selector'         => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                            'property'         => 'opacity',
                        )
                    ),
                )
            ),
            'input_border_setting'      => array( // Section
                'title'         => __('Border', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'input_field_border_color'  => array(
                        'type'                  => 'color',
                        'label'                 => __('Border Color', 'bb-njba'),
                        'default'               => 'eeeeee',
                        'show_reset'            => true,
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                            'property'          => 'border-color'
                        )
                    ),
					'input_border_width'   => array(
                        'type'          => 'njba-multinumber',
						'description'	=> 'px',
						'label'         => __('Border Width', 'bb-njba'),
                        'default'       => array(
                            'top'   => 1,
                            'bottom'   => 1,
                            'left'   => 1,
							'right'	=> 1
                        ),
						'options' 		=> array(
                            'top' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Top', 'bb-njba'),
                                'tooltip'       => __('Top', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-up',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form input[type=text], .njba-subscribe-form input[type=email]',
                                    'property'  => 'border-top-width',
                                    'unit'      => 'px'
                                )
                            ),
                            'bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Bottom', 'bb-njba'),
                                'tooltip'       => __('Bottom', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-down',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form input[type=text], .njba-subscribe-form input[type=email]',
                                    'property'  => 'border-bottom-width',
                                    'unit'      => 'px'
                                )
                            ),
                            'left' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Left', 'bb-njba'),
                                'tooltip'       => __('Left', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-left',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form input[type=text], .njba-subscribe-form input[type=email]',
                                    'property'  => 'border-left-width',
                                    'unit'      => 'px'
                                )
                            ),
                            'right' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Right', 'bb-njba'),
                                'tooltip'       => __('Right', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-right',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form input[type=text], .njba-subscribe-form input[type=email]',
                                    'property'  => 'border-right-width',
                                    'unit'      => 'px'
                                )
                            ),
                        ),
                    ),
                    'input_field_focus_color'      => array(
                        'type'                  => 'color',
                        'label'                 => __('Focus Border Color', 'bb-njba'),
                        'default'               => '719ece',
                        'show_reset'            => true,
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.njba-subscribe-form textarea:focus, .njba-subscribe-form input[type=text]:focus, .njba-subscribe-form input[type=tel]:focus, .njba-subscribe-form input[type=email]:focus',
                            'property'          => 'border-color'
                        )
                    ),
                )
            ),
            'input_general_style'      => array( // Section
                'title'         => __('Structure', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
					'input_field_text_alignment'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Text Alignment', 'bb-njba'),
                        'default'                   => 'left',
                        'options'                   => array(
                            'left'                  => __('Left', 'bb-njba'),
                            'center'                => __('Center', 'bb-njba'),
                            'right'                 => __('Right', 'bb-njba'),
                        )
                    ),
                    'input_field_border_radius'    => array(
                        'type'                     => 'text',
                        'label'                    => __('Round Corners', 'bb-njba'),
                        'description'              => 'px',
                        'default'                  => '2',
						'size'          		=> '5',
						'maxlength'				=> 3,
                        'preview'                  => array(
                            'type'                 => 'css',
                            'selector'             => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                            'property'             => 'border-radius',
                            'unit'                 => 'px'
                        )
                    ),
                    'input_field_box_shadow'   => array(
                        'type'                 => 'select',
                        'label'                => __('Box Shadow', 'bb-njba'),
                        'default'              => 'no',
                        'options'              => array(
                            'yes'          => __('Show', 'bb-njba'),
                            'no'             => __('Hide', 'bb-njba'),
                        ),
                        'toggle'    => array(
                            'yes'   => array(
                                'fields'    => array('input_shadow_color', 'input_shadow_direction')
                            )
                        )
                    ),
                    'input_shadow_color'      => array(
                        'type'          => 'color',
                        'label'         => __('Shadow Color', 'bb-njba'),
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                            'property'  => 'box-shadow'
                        ),
                    ),
                    'input_shadow_direction'  => array(
                        'type'      => 'select',
                        'label'     => __('Shadow Direction', 'bb-njba'),
                        'default'   => 'out',
                        'options'   => array(
                            'out'   => __('Outside', 'bb-njba'),
                            'inset'   => __('Inside', 'bb-njba'),
                        ),
                    ),
                    'input_field_padding' 	=> array(
                        'type' 			=> 'njba-multinumber',
                        'label' 		=> __('Padding', 'bb-njba'),
                        'description'   => 'px',
                        'default'       => array(
                            'top' => 10,
                            'right' => 10,
                            'bottom' => 10,
                            'left' => 10,
                        ),
                        'options' 		=> array(
                            'top' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Top', 'bb-njba'),
                                'tooltip'       => __('Top', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-up',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                                    'property'  => 'padding-top',
                                    'unit'      => 'px'
                                )
                            ),
                            'bottom' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Bottom', 'bb-njba'),
                                'tooltip'       => __('Bottom', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-down',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                                    'property'  => 'padding-bottom',
                                    'unit'      => 'px'
                                )
                            ),
                            'left' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Left', 'bb-njba'),
                                'tooltip'       => __('Left', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-left',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                                    'property'  => 'padding-left',
                                    'unit'      => 'px'
                                )
                            ),
                            'right' => array(
                                'maxlength' => 3,
                                'placeholder'   => __('Right', 'bb-njba'),
                                'tooltip'       => __('Right', 'bb-njba'),
                                'icon'		=> 'fa-long-arrow-right',
                                'preview'       => array(
                                    'selector'  => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                                    'property'  => 'padding-right',
                                    'unit'      => 'px'
                                )
                            ),
                        ),
                    ),
					'input_height' => array(
						'type'          => 'text',
						'label'         => __( 'Height', 'bb-njba' ),
						'default'       => '38',
						'description'   => 'px',
						'maxlength'     => '3',
						'size'          => '5',
					),
                )
            ),
            'placeholder_style'      => array( // Section
                'title'         => __('Placeholder', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'input_placeholder_display' 	=> array(
                        'type'          => 'select',
                        'label'         => __('Show Placeholder', 'bb-njba'),
                        'default'       => 'block',
                        'options'		=> array(
                       		'block'	=> __('Yes', 'bb-njba'),
                       		'none'	=> __('No', 'bb-njba'),
                        ),
                        'toggle' => array(
                            'block' => array(
                                'fields' => array('input_placeholder_color')
                            )
                        )
                    ),
                    'input_placeholder_color'  => array(
                        'type'                  => 'color',
                        'label'                 => __('Color', 'bb-njba'),
                        'default'               => 'dddddd',
                        'show_reset'            => true,
                        'preview'               => array(
                            'type'              => 'css',
                            'selector'          => '.njba-subscribe-form input[type=text]::-webkit-input-placeholder, .njba-subscribe-form input[type=tel]::-webkit-input-placeholder, .njba-subscribe-form input[type=email]::-webkit-input-placeholder, .njba-subscribe-form textarea::-webkit-input-placeholder',
                            'property'          => 'color'
                        )
                    ),
                )
            ),
        )
    ),
	'button'        => array(
		'title'         => __( 'Button', 'bb-njba' ),
		'sections'      => array(
			'btn_general'   => array(
				'title'         => '',
				'fields'        => array(
					'button_text'     => array(
                        'type'      => 'text',
                        'label'     => 'Text',
                        'default'   => __('Subscribe', 'bb-njba'),
                        'preview'       => array(
							'type'          => 'text',
							'selector'      => ''
						)
					),
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
	                            'sections' => array('icon_section'),
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
			),
			'btn_colors'     => array(
				'title'         => __( 'Colors', 'bb-njba' ),
				'fields'        => array(
					'button_background_color'  => array(
						'type'          => 'color',
						'label'         => __( 'Background Color', 'bb-njba' ),
						'default'       => '3074b0',
						'show_reset'    => true
					),
					'button_background_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Background Hover Color', 'bb-njba' ),
						'default'       => '428bca',
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'button_text_color' => array(
						'type'          => 'color',
						'label'         => __( 'Text Color', 'bb-njba' ),
						'default'       => 'ffffff',
						'show_reset'    => true
					),
					'button_text_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Text Hover Color', 'bb-njba' ),
						'default'       => 'ffffff',
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'button_border_color' => array(
						'type'          => 'color',
						'label'         => __( 'Border Color', 'bb-njba' ),
						'default'       => '',
						'show_reset'    => true
					),
					'button_border_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Border Hover Color', 'bb-njba' ),
						'default'       => '',
						'show_reset'    => true
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
            'btn_style'     => array(
				'title'         => __( 'Style', 'bb-njba' ),
				'fields'        => array(
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
                                'fields'        => array('button_background_color','hover_button_style','button_box_shadow','button_box_shadow_color', 'transition'),
                            ),
                            'gradient'          => array(
                                'fields'        => array('button_background_color')
                            ),
                            'threed'          => array(
                                'fields'        => array('button_background_color','hover_button_style', 'transition'),
                            ),
                            'transparent' => array(
                                'fields' => array('hover_button_style','button_box_shadow','button_box_shadow_color', 'transition'),
                            )
                        )
                    ),
                    'transition' => array(
                        'type' => 'text',
                        'label' => __('Transition delay','bb-njba'),
                        'default' => 0.3,
                        'size' => '5',
                        'description' => 's'
                    )
				)
			),
			'btn_border_setting'	=> array(
				'title'	=>	__('Border', 'bb-njba'),
				'fields'	=> array(
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
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up'
                            ),
                            'top-right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right'
                            ),
                            'bottom-left'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down'
                            ),
                            'bottom-right'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left'
                            )
                            
                        )
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
			'btn_structure' => array(
				'title'         => __( 'Structure', 'bb-njba' ),
				'fields'        => array(
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
			),
			'button_typography' => array(
                'title' => __('Button Typography','bb-njba'),
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
                    ),
                    'icon_font_size'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Icon Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '18',
                            'medium' => '16',
                            'small' => ''
                        )
                    )
                )
            )
            
		)
		
	),
	'form_messages_setting' => array(
        'title' => __('Messages', 'bb-njba'),
        'sections'  => array(
			'form_error_styling'    => array( // Section
                'title'             => __('Error Message', 'bb-njba'), // Section Title
                'fields'            => array( // Section Fields
                    'validation_message_color'    => array(
                        'type'                    => 'color',
                        'label'                   => __('Color', 'bb-njba'),
                        'default'                 => 'dd4420',
                        'preview'                 => array(
                            'type'                => 'css',
                            'selector'            => '.njba-subscribe-form .njba-form-error-message',
                            'property'            => 'color'
                        )
                    ),
                    'validation_message_border_color'    => array(
                        'type'                    => 'color',
                        'label'                   => __('Color', 'bb-njba'),
                        'default'                 => 'dd4420',
                        'preview'                 => array(
                            'type'                => 'css',
                            'selector'            => '.njba-subscribe-form input.njba-form-error',
                            'property'            => 'color'
                        )
                    )
                )
            ),
			'form_success_styling'    => array( // Section
                'title'             => __('Success Message', 'bb-njba'), // Section Title
                'fields'            => array( // Section Fields
                    'success_message_color'    => array(
                        'type'                         => 'color',
                        'label'                        => __('Color', 'bb-njba'),
                        'default'                      => '29bb41',
                        'preview'                      => array(
                            'type'                     => 'css',
                            'selector'                 => '.njba-subscribe-form .njba-form-success-message',
                            'property'                 => 'color'
                        )
                    ),
					'success_action' => array(
						'type'          => 'select',
						'label'         => __( 'Success Action', 'bb-njba' ),
						'default'		=> 'message',
						'options'       => array(
							'message'       => __( 'Message', 'bb-njba' ),
							'redirect'      => __( 'Redirect', 'bb-njba' )
						),
						'toggle'        => array(
							'message'       => array(
								'sections'		=> array('form_success_typography'),
								'fields'        => array( 'success_message', 'success_message_color' )
							),
							'redirect'      => array(
								'fields'        => array( 'success_url' )
							)
						),
						'preview'       => array(
							'type'             => 'none'
						)
					),
					'success_message' => array(
						'type'          => 'editor',
						'label'         => '',
						'media_buttons' => false,
						'rows'          => 8,
						'default'       => __( 'Thanks for subscribing! Please check your email for further instructions.', 'bb-njba' ),
						'preview'       => array(
							'type'             => 'none'
						)
					),
					'success_url'  => array(
						'type'          => 'link',
						'label'         => __( 'Success URL', 'bb-njba' ),
						'preview'       => array(
							'type'             => 'none'
						)
					)
                )
            ),
		)
	),
	'form_typography'       => array( // Tab
        'title'         => __('Typography', 'bb-njba'), // Tab title
        'sections'      => array( // Tab Sections
			'input_typography'       => array( // Section
                'title'         => __('Input', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'input_font_family' => array(
                        'type'          => 'font',
                        'default'		=> array(
                            'family'		=> 'Default',
                            'weight'		=> 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                        )
                    ),
					'input_size'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Font Size', 'bb-njba'),
                        'default'                   => 'default',
                        'options'                   => array(
                            'default'                  => __('Default', 'bb-njba'),
                            'custom'                => __('Custom', 'bb-njba'),
                        ),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('input_font_size')
							)
						)
                    ),
                    'input_font_size'   => array(
                        'type'          => 'njba-simplify',
						'label'         => __('Custom Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop'   => 16,
                            'tablet'   => '',
                            'mobile'   => '',
                        ),
                        'options'       => array(
                            'desktop'   => array(
                                'placeholder'   => __('Desktop', 'bb-njba'),
                                'icon'          => 'fa-desktop',
                                'maxlength'     => 3,
                                'tooltip'       => __('Desktop', 'bb-njba'),
                                'preview'           => array(
                                    'selector'      => '.njba-subscribe-form textarea, .njba-subscribe-form input[type=text], .njba-subscribe-form input[type=tel], .njba-subscribe-form input[type=email]',
                                    'property'      => 'font-size',
                                    'unit'          => 'px'
                                ),
                            ),
                            'tablet'   => array(
                                'placeholder'   => __('Tablet', 'bb-njba'),
                                'icon'          => 'fa-tablet',
                                'maxlength'     => 3,
                                'tooltip'       => __('Tablet', 'bb-njba')
                            ),
                            'mobile'   => array(
                                'placeholder'   => __('Mobile', 'bb-njba'),
                                'icon'          => 'fa-mobile',
                                'maxlength'     => 3,
                                'tooltip'       => __('Mobile', 'bb-njba')
                            ),
                        ),
                    ),
                    'input_text_transform'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Text Transform', 'bb-njba'),
                        'default'                   => 'none',
                        'options'                   => array(
                            'none'                  => __('Default', 'bb-njba'),
                            'lowercase'                => __('lowercase', 'bb-njba'),
                            'uppercase'                 => __('UPPERCASE', 'bb-njba'),
                        )
                    ),
                )
            ),
			'placeholder_typography'	=> array(
				'title'	=> __( 'Placeholder', 'bb-njba' ),
				'fields'	=> array(
					'placeholder_size'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Font Size', 'bb-njba'),
                        'default'                   => 'default',
                        'options'                   => array(
                            'default'                  => __('Default', 'bb-njba'),
                            'custom'                => __('Custom', 'bb-njba'),
                        ),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('placeholder_font_size')
							)
						)
                    ),
                    'placeholder_font_size'   => array(
                        'type'          => 'njba-simplify',
						'label'         => __('Custom Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop'   => 16,
                            'tablet'   => '',
                            'mobile'   => '',
                        ),
                        'options'       => array(
                            'desktop'   => array(
                                'placeholder'   => __('Desktop', 'bb-njba'),
                                'icon'          => 'fa-desktop',
                                'maxlength'     => 3,
                                'tooltip'       => __('Desktop', 'bb-njba'),
                                'preview'           => array(
                                    'selector'      => '.njba-subscribe-form input[type=text]::-webkit-input-placeholder, .njba-subscribe-form input[type=email]::-webkit-input-placeholder',
                                    'property'      => 'font-size',
                                    'unit'          => 'px'
                                ),
                            ),
                            'tablet'   => array(
                                'placeholder'   => __('Tablet', 'bb-njba'),
                                'icon'          => 'fa-tablet',
                                'maxlength'     => 3,
                                'tooltip'       => __('Tablet', 'bb-njba')
                            ),
                            'mobile'   => array(
                                'placeholder'   => __('Mobile', 'bb-njba'),
                                'icon'          => 'fa-mobile',
                                'maxlength'     => 3,
                                'tooltip'       => __('Mobile', 'bb-njba')
                            ),
                        ),
                    ),
					'placeholder_text_transform'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Text Transform', 'bb-njba'),
                        'default'                   => 'none',
                        'options'                   => array(
                            'none'                  => __('Default', 'bb-njba'),
                            'lowercase'                => __('lowercase', 'bb-njba'),
                            'uppercase'                 => __('UPPERCASE', 'bb-njba'),
                        )
                    ),
				)
			),
			'errors_typography'       => array( // Section
                'title'         => __('Error Message', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
					'validation_error_size'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Font Size', 'bb-njba'),
                        'default'                   => 'default',
                        'options'                   => array(
                            'default'                  => __('Default', 'bb-njba'),
                            'custom'                => __('Custom', 'bb-njba'),
                        ),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('validation_error_font_size')
							)
						)
                    ),
                    'validation_error_font_size'    => array(
                        'type'          => 'njba-simplify',
						'label'         => __('Custom Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop'   => 14,
                            'tablet'   => '',
                            'mobile'   => '',
                        ),
                        'options'       => array(
                            'desktop'   => array(
                                'placeholder'   => __('Desktop', 'bb-njba'),
                                'icon'          => 'fa-desktop',
                                'maxlength'     => 3,
                                'tooltip'       => __('Desktop', 'bb-njba'),
                                'preview'           => array(
                                    'selector'      => '.njba-subscribe-form .njba-form-error-message',
                                    'property'      => 'font-size',
                                    'unit'          => 'px'
                                ),
                            ),
                            'tablet'   => array(
                                'placeholder'   => __('Tablet', 'bb-njba'),
                                'icon'          => 'fa-tablet',
                                'maxlength'     => 3,
                                'tooltip'       => __('Tablet', 'bb-njba')
                            ),
                            'mobile'   => array(
                                'placeholder'   => __('Mobile', 'bb-njba'),
                                'icon'          => 'fa-mobile',
                                'maxlength'     => 3,
                                'tooltip'       => __('Mobile', 'bb-njba')
                            ),
                        ),
                    ),
					'error_text_transform'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Text Transform', 'bb-njba'),
                        'default'                   => 'none',
                        'options'                   => array(
                            'none'                  => __('Default', 'bb-njba'),
                            'lowercase'                => __('lowercase', 'bb-njba'),
                            'uppercase'                 => __('UPPERCASE', 'bb-njba'),
                        )
                    ),
                )
            ),
			'form_success_typography'    => array( // Section
                'title'             => __('Success Message', 'bb-njba'), // Section Title
                'fields'            => array( // Section Fields
					'success_message_size'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Font Size', 'bb-njba'),
                        'default'                   => 'default',
                        'options'                   => array(
                            'default'                  => __('Default', 'bb-njba'),
                            'custom'                => __('Custom', 'bb-njba'),
                        ),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array('success_message_font_size')
							)
						)
                    ),
                    'success_message_font_size'    => array(
                        'type'          => 'njba-simplify',
						'label'         => __('Custom Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop'   => 14,
                            'tablet'   => '',
                            'mobile'   => '',
                        ),
                        'options'       => array(
                            'desktop'   => array(
                                'placeholder'   => __('Desktop', 'bb-njba'),
                                'icon'          => 'fa-desktop',
                                'maxlength'     => 3,
                                'tooltip'       => __('Desktop', 'bb-njba'),
                                'preview'           => array(
                                    'selector'      => '.njba-subscribe-form .njba-form-success-message',
                                    'property'      => 'font-size',
                                    'unit'          => 'px'
                                ),
                            ),
                            'tablet'   => array(
                                'placeholder'   => __('Tablet', 'bb-njba'),
                                'icon'          => 'fa-tablet',
                                'maxlength'     => 3,
                                'tooltip'       => __('Tablet', 'bb-njba')
                            ),
                            'mobile'   => array(
                                'placeholder'   => __('Mobile', 'bb-njba'),
                                'icon'          => 'fa-mobile',
                                'maxlength'     => 3,
                                'tooltip'       => __('Mobile', 'bb-njba')
                            ),
                        ),
                    ),
					'success_message_text_transform'    => array(
                        'type'                      => 'select',
                        'label'                     => __('Text Transform', 'bb-njba'),
                        'default'                   => 'none',
                        'options'                   => array(
                            'none'                  => __('Default', 'bb-njba'),
                            'lowercase'                => __('lowercase', 'bb-njba'),
                            'uppercase'                 => __('UPPERCASE', 'bb-njba'),
                        )
                    ),
                )
            ),
		),
	),
));
