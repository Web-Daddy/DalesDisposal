<?php
if(!class_exists('njba_row_sep')){
	class njba_row_sep{
		public function __construct(){
			require_once NJBA_MODULE_DIR . 'includes/row-settings.php';
			add_action( 'wp_enqueue_scripts', array($this, 'njba_rowstyles_scripts_styles') );
			add_action( 'fl_builder_before_render_row', array($this, 'do_before_render_row'), 10 , 2 );
            add_filter( 'fl_builder_render_css', array($this, 'add_row_style_css'), 10, 3 );
			$global_settings = FLBuilderModel::get_global_settings();
            
            // get the default settings
            $row_settings = FLBuilderModel::$settings_forms[ 'row' ];
            $new_tab = array( 
            	'row_separator' => array(
	                'title' => __( 'NJBA Effects', 'bb-njba' ),
	                'sections'  => array(
	                    'style' => array(
	                        'title' =>  __('Row Separator', 'bb-njba'),
	                        'fields'=> array(
	                            'row_position'     => array(
	                                'type'          => 'select',
	                                'label'         => __( 'Row Position', 'bb-njba' ),
	                                'default'       => 'none',
	                                'options'       => array(
	                                    'none'                  => __( 'None' , 'bb-njba' ),
	                                    'top'      => __( 'Top', 'bb-njba' ),
	                                    'bottom'      => __( 'Bottom', 'bb-njba' ),
	                                ),
	                                'toggle'	=> array(
										'none'				=> array(
											'fields'		=> array( )
										),
										'top'		=> array(
											'sections'		=> array( 'njba_row_option' )
										),
										'bottom'		=> array(
											'sections'		=> array( 'njba_row_option' )
										)
									)
	                            ),
	                        )
	                    ),
	                    'njba_row_option' => array(
	                    	'title'		=> __('Row Separator Option', 'bb-njba'),
	                    	'fields'	=> array(
								'separator_shape' => array(
									'type'          => 'select',
									'label'         => __('Type', 'bb-njba'),
									'default'       => 'triangle_svg',
									'options'       => array(
										'triangle_svg'				=>	__( 'Triangle', 'bb-njba' ),
										'xlarge_triangle'			=>	__( 'Big Triangle', 'bb-njba' ),
										'xlarge_triangle_left'		=>	__( 'Big Triangle Left', 'bb-njba' ),
										'xlarge_triangle_right'		=>	__( 'Big Triangle Right', 'bb-njba' ),
										'circle_svg'				=>	__( 'Half Circle', 'bb-njba' ),
										'xlarge_circle'				=>	__( 'Curve Center', 'bb-njba' ),
										'curve_up'					=>	__( 'Curve Left', 'bb-njba' ),
										'curve_down'				=>	__( 'Curve Right', 'bb-njba' ),
										'tilt_left'					=>	__( 'Tilt Left', 'bb-njba' ),
										'tilt_right'				=>	__( 'Tilt Right', 'bb-njba' ),
										'round_split'				=>	__( 'Round Split', 'bb-njba' ),
										'waves'						=>	__( 'Waves', 'bb-njba' ),
										'clouds'					=>	__( 'Clouds', 'bb-njba' ),
										'multi_triangle'			=>	__( 'Multi Triangle', 'bb-njba' ),
										'simple'					=> __('Simple','bb-njba'),
									),
									'toggle'	=> array(
										'triangle_svg'				=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'xlarge_triangle'			=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'xlarge_triangle_left'		=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'xlarge_triangle_right'		=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'circle_svg'				=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'xlarge_circle'				=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'curve_up'					=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'curve_down'				=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'tilt_left'					=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'tilt_right'				=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'round_split'				=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'waves'						=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'clouds'					=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color_opc' )
										),
										'multi_triangle'			=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color' )
										),
										'simple'			=> array(
											'fields'		=> array( 'separator_shape_height', 'separator_shape_height_medium', 'separator_shape_height_small', 'njba_row_separator_color', 'njba_row_separator_color' )
										),
									)
								),
								'separator_shape_height'   => array(
									'type'          => 'text',
									'label'         => __('Size', 'bb-njba'),
									'default'       => '60',
									'description'   => 'px',
									'maxlength'     => '3',
									'size'          => '6',
									'placeholder'   => '60'
								),
								'separator_shape_height_medium'   => array(
									'type'          => 'text',
									'label'         => __('Medium Device Size', 'bb-njba'),
									'default'       => '',
									'description'   => 'px',
									'maxlength'     => '3',
									'size'          => '6',
								),
								'separator_shape_height_small'   => array(
									'type'          => 'text',
									'label'         => __('Small Device Size', 'bb-njba'),
									'default'       => '',
									'description'   => 'px',
									'maxlength'     => '3',
									'size'          => '6',
								),
								'njba_row_separator_color' => array( 
									'type'       => 'color',
									'label'      => __('Background', 'bb-njba'),
									'default'    => 'ffffff',
									'show_reset' => true,
									'help'       => __('Mostly, this should be background color of your adjacent row section. (Default - White)', 'bb-njba'),
								),
			                	'njba_row_separator_color_opc' => array( 
									'type'        => 'text',
									'label'       => __('Opacity', 'bb-njba'),
									'default'     => '100',
									'placeholder'	=> '100',
									'description' => '%',
									'maxlength'   => '3',
									'size'        => '5',
								),
	                        )
	                    )
	                )
	            ) 
	        );
            // insert the tab to the set position
            array_insert( $row_settings['tabs'] , $new_tab, 1 );
            FLBuilder::register_settings_form( 'row' , $row_settings );
		}
		function njba_rowstyles_scripts_styles(){
            //wp_enqueue_style( 'njba-row-styles-css', NJBA_MODULE_URL . 'includes/row-settings.css', null , 'screen' );
		}
		function add_row_style_css( $css, $nodes, $global_settings ){
			ob_start();
			include NJBA_MODULE_DIR . 'includes/row-settings-css.php';
			$css .= ob_get_clean();
			return $css;
		}
		function do_before_render_row( $row, $groups ) {
            // only run when row style top OR bottom is set
            if( isset( $row->settings->row_position ) ) {
                // add rowstyle before adding the bg
                add_action( 'fl_builder_before_render_row_bg', array($this, 'add_row_style') );
            }
        }
        function add_row_style( $row_setting ) {
        	$row = $row_setting->settings;
        	if( $row->row_position != 'none'){
				$row->separator_flag = $row->row_position;
				include NJBA_MODULE_DIR . 'includes/row-settings-html.php';
			}
        }
	}
	new njba_row_sep();
}
?>