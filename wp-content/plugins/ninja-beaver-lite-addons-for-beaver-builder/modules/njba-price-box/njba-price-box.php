<?php

/**
 * @class NJBATeamsModule
 */
class NJBAPriceBoxModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Price Box', 'bb-njba'),
            'description'   => __('Addon to display Price Box.', 'bb-njba'),
            'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Creative Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-price-box/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-price-box/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'icon'              => 'editor-table.svg',
        ));

        /**
         * Use these methods to enqueue css and js already
         * registered or to register and enqueue your own.
         */
        // Already registered
        $this->add_css('font-awesome');
		$this->add_css('njba-price-box-fields', NJBA_MODULE_URL . 'modules/njba-price-box/css/fields.css');
		
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

    public function icon_module($box_content){
        $html = '';
        if($box_content->featured_item == 'feau_icon') :
                $html .= '<i class="'.$box_content->select_feau_icon.'" aria-hidden="true"></i>';
        endif;
        if($box_content->featured_item == 'feau_image') :
            if(!empty($box_content->select_feau_image_src)){
                $src = $box_content->select_feau_image_src;
            } else {
                $url = FL_BUILDER_URL . 'img/pixel.png';
            }
            $html .= '<div>';
                $html .= '<img src="'.$src.'">';
            $html .= '</div>';
        endif;
        if($box_content->featured_item == 'feau_text') :
            $html .= '<div class="njba-text">';
                $html .= '<span>'.$box_content->select_feau_text.'</span>';
            $html .= '</div>';
        endif;
        return $html;
    }

    public function price_box_body_btn($box_content){

        $btn_settings = array(
            //Button text         
            'button_text'   => $box_content->button_text,
            //Button Link
            'link'      => $box_content->link,
            'link_target'       => $box_content->link_target,
        );

        return FLBuilder::render_module_html('njba-button', $btn_settings);


        /*$html = '';
        $html .= '<a href="'.$box_content->btn_link.'" class="njba-purchase" target="'.$box_content->btn_link_target.'">';           
            $html .= '<span class="mkdf-btn-text">'.$box_content->btn_text.'</span>';
        $html .= '</a>';

        return $html;*/
    }

    public function space_bw_btn_pro(){
        return FLBuilder::render_module_html('njba-spacer', '');
    }

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('NJBAPriceBoxModule', array(
    'price_box'      => array( // Tab
        'title'         => __('Price Box', 'bb-njba'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => '', // Section Title
                'fields'        => array( // Section Fields
                    'price_box_content'     => array(
                        'type'          => 'form',
                        'label'         => __('Price Box', 'bb-njba'),
                        'form'          => 'njba_pricebox_form', // ID from registered form below
                        'preview_text'  => 'title', // Name of a field to use for the preview text
                        'multiple'      => true
                    )
                )
            )
        )
    ),
    'layouts'       => array(
        'title'     => __('Layout', 'bb-njba'),
        'sections'  => array(
            'layout'       => array( // Section
                'title'         => '', // Section Title
                'fields'        => array( // Section Fields
                    'price_box_layout'     => array(
                        'type'          => 'njba-radio',
                        'label'         => __('Layout', 'bb-njba'),
                        'default'       => 1,
                        'options'        => array(
                            '1'      => 'layout_1',
                            '2'      => 'layout_2',
                            '3'      => 'layout_3',
                            '4'      => 'layout_4',
                            '5'      => 'layout_5',
                        ),
                        'toggle'        => array(
                            '1'        => array(
                                'fields'        => array('heading_margintb','price_margintb','duration_margintb','properties_margintb')
                            ),
                            '2'        => array(
                                'fields'        => array('heading_margintb','price_margintb','duration_margintb','properties_margintb')
                            ),
                            '3'        => array(
                                'fields'        => array('heading_margintb','price_margintb','duration_margintb','properties_margintb')
                            ),
                            '4'        => array(
                                'fields'        => array('heading_paddingtb','price_paddingtb','duration_paddingtb','properties_paddingtb')
                            ),
                            '5'        => array(
                                'fields'        => array('heading_paddingtb','price_paddingtb','properties_paddingtb')
                            )
                        )
                    ),
                )
            ),
        ),
    ),
    'typography'                => array(
        'title'                     => __('Typography', 'bb-njba'),
        'sections'                  => array(
            'heading_fonts'             => array(
                'title'                     => __('Heading Style', 'bb-njba'),
                'fields'                    => array( // Section Fields
                    'heading_font_size'    => array(
                        'type'          => 'text',
                        'size'          => '5',
                        'maxlength'     => '2',
                        'default'       => '18',
                        'label'         => __('Font Size', 'bb-njba'),
                        'description'   => _x( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-njba' ),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-pricing-inner-heading .price-heading',
                            'property'      => 'font-size',
                            'unit'          => 'px'
                        )
                    ),
                    'heading_font'          => array(
                        'type'          => 'font',
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-pricing-inner-heading .price-heading'
                        )
                    ),
                    'heading_margintb'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Margin', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 20,
                            'bottom'      => 20
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading .price-heading',
                                    'property'          => 'margin-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading .price-heading',
                                    'property'          => 'margin-bottom',
                                ),
                            )
                        )
                    ),
                    'heading_paddingtb'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 0,
                            'bottom'      => 0
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading span',
                                    'property'          => 'padding-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading span',
                                    'property'          => 'padding-bottom',
                                ),
                            )
                        )
                    )
                )
            ),
            'price_fonts'             => array(
                'title'                     => __('Price Style', 'bb-njba'),
                'fields'                    => array( // Section Fields
                    'price_font_size'    => array(
                        'type'          => 'text', 
                        'size'          => '5',
                        'maxlength'     => '2',
                        'default'       => '18',
                        'label'         => __('Font Size', 'bb-njba'),
                        'description'   => _x( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-njba' ),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-pricing-inner-heading h2',
                            'property'      => 'font-size',
                            'unit'          => 'px'
                        )
                    ),
                    'price_font'          => array(
                        'type'          => 'font',
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-pricing-inner-heading h2'
                        )
                    ),
                    'price_margintb'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Margin', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 0,
                            'bottom'      => 10
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading h2',
                                    'property'          => 'margin-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading h2',
                                    'property'          => 'margin-bottom',
                                ),
                            )
                        )
                    ),
                    'price_paddingtb'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 0,
                            'bottom'      => 10
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading h2',
                                    'property'          => 'padding-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading h2',
                                    'property'          => 'padding-bottom',
                                ),
                            )
                        )
                    )
                )
            ),
            'duration_fonts'             => array(
                'title'                     => __('Duration Style', 'bb-njba'),
                'fields'                    => array( // Section Fields
                    'duration_font_size'    => array(
                        'type'          => 'text',
                        'size'          => '5',
                        'maxlength'     => '2',
                        'default'       => '18',
                        'label'         => __('Font Size', 'bb-njba'),
                        'description'   => _x( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-njba' ),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-pricing-inner-heading span',
                            'property'      => 'font-size',
                            'unit'          => 'px'
                        )
                    ),
                    'duration_font'          => array(
                        'type'          => 'font',
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-pricing-inner-heading span'
                        )
                    ),
                    'duration_margintb'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Margin', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 0,
                            'bottom'      => 0
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading span',
                                    'property'          => 'margin-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading span',
                                    'property'          => 'margin-bottom',
                                ),
                            )
                        )
                    ),
                    'duration_paddingtb'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 0,
                            'bottom'      => 0
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading span',
                                    'property'          => 'padding-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading span',
                                    'property'          => 'padding-bottom',
                                ),
                            )
                        )
                    )
                )
            ),
            'properties_fonts'             => array(
                'title'                     => __('Properties Style', 'bb-njba'),
                'fields'                    => array( // Section Fields
                    'properties_font_size'    => array(
                        'type'          => 'text',
                        'size'          => '5',
                        'maxlength'     => '2',
                        'default'       => '18',
                        'label'         => __('Font Size', 'bb-njba'),
                        'description'   => _x( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-njba' ),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-pricing-inner-body ul li',
                            'property'      => 'font-size',
                            'unit'          => 'px'
                        )
                    ),
                    'properties_font'          => array(
                        'type'          => 'font',
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-pricing-inner-body ul li'
                        )
                    ),
                    'properties_margintb'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Margin', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 10,
                            'bottom'      => 10
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-body ul li',
                                    'property'          => 'margin-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-body ul li',
                                    'property'          => 'margin-bottom',
                                ),
                            )
                        )
                    ),
                    'properties_paddingtb'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'description'       => 'px',
                        'default'           => array(
                            'top'          => 0,
                            'bottom'      => 0
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading span',
                                    'property'          => 'padding-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'preview'           => array(
                                    'selector'          => '.njba-pricing-inner-heading span',
                                    'property'          => 'padding-bottom',
                                ),
                            )
                        )
                    )
                )
            ),
            'seperator'             => array(
                'title'                     => __('Seperator Style', 'bb-njba'),
                'fields'                    => array( // Section Fields
                    'properties_border_style'      => array(
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
                        'toggle'        => array(
                            'none'        => array(
                                'fields'        => array('')
                            ),
                            'solid'        => array(
                                'fields'        => array('properties_border_width','properties_border_color')
                            ),
                            'dotted'        => array(
                                'fields'        => array('properties_border_width','properties_border_color')
                            ),
                            'dashed'        => array(
                                'fields'        => array('properties_border_width','properties_border_color')
                            ),
                            'double'        => array(
                                'fields'        => array('properties_border_width','properties_border_color')
                            )
                        ),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-pricing-inner-body',
                            'property'      => 'border-top-style',
                            'unit'          => 'px'
                        )
                    ),
                    'properties_border_width'    => array(
                        'type'          => 'text',
                        'default'       => '1',
                        'maxlength'     => '2',
                        'size'          => '5',
                        'label'         => __('Border Width', 'bb-njba'),
                        'description'   => 'px',
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-pricing-inner-body',
                            'property'      => 'border-top',
                            'unit'          => 'px'
                        )
                    ),
                    'properties_border_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Border Color', 'bb-njba'),
                        'default'       => '000000',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-pricing-inner-body',
                            'property'      => 'border-color',
                        )
                    )
                )
            ),
            'button_common_style'   => array(
                'title'                     => __('Button Common Style', 'bb-njba'),
                'fields'                    => array( // Section Fields
                    'space_bw_btn_pro'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Space Between Button & Properties', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '10',
                            'medium' => '10',
                            'small' => '10'
                        )
                    )
                )
            )
        )
    )
));


/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form('njba_pricebox_form', array(
	'title' => __('Add Price Box', 'bb-njba'),
	'tabs'  => array(
		'general'      => array( // Tab
			'title'         => __('General', 'bb-njba'), // Tab title
			'sections'      => array( // Tab Sections
                'featured_sec'          => array(
                    'title'      => '',
                    'fields'     => array(
                        'set_as_featured_box'     => array(
                            'type'          => 'select',
                            'label'         => __('Set as Featured Box', 'bb-njba'),
                            'default'       => 'no',
                            'options'       => array(
                                'no'       => __('No', 'bb-njba'),
                                'yes'        => __('Yes', 'bb-njba')
                            ),
                            'toggle'    => array(
                                'yes' => array(
                                    'sections'      => array('feature')
                                )
                            )
                        ),
                    )
                ),
                'feature'           => array(
                    'title'     => '',
                    'fields'    => array(
                        'featured_item'          => array(
                            'type'          => 'select',
                            'label'         => __('Featured Item', 'bb-njba'),
                            'options'   => array(
                                'feau_icon'  => __('Icon', 'bb-njba'),
                                'feau_image' => __('Image', 'bb-njba'),
                                'feau_text'  => __('Text', 'bb-njba')
                            ),
                            'toggle'    => array(
                                'feau_icon' => array(
                                    'fields' => array('select_feau_icon')
                                ),
                                'feau_image' => array(
                                    'fields' => array('select_feau_image')
                                ),
                                'feau_text' => array(
                                    'fields' => array('select_feau_text', 'feature_font')
                                )
                            )
                        ),
                        'select_feau_icon'          => array(
                            'type'          => 'icon',
                            'label'         => __('Featured Icon', 'bb-njba')
                        ),
                        'select_feau_image'         => array(
                            'type'          => 'photo',
                            'label'         => __('Featured Image', 'bb-njba'),
                            'show_remove'   => true
                        ),
                        'select_feau_text'         => array(
                            'type'            => 'text',
                            'label'           => __('Featured Text', 'bb-njba'),
                            'default'         => 'Popular',
                            'help'            => __('Use a unique small word to highlight this Box.','bb-njba')
                        ),
                    )
                ),
                'title'          => array(
                    'title'      => __('Title', 'bb-njba'),
                    'fields'        => array(
                        'title'          => array(
                            'type'          => 'text',
                            'label'         => __('Title Text', 'bb-njba'),
                            'default'   => __( 'Consultation Pack', 'bb-njba' )
                        ),
                        'price'          => array(
                            'type'          => 'text',
                            'label'         => __('Price Value', 'bb-njba'),
                            'default'       => __( '$99', 'bb-njba' )
                        ),
                        'duration'          => array(
                            'type'          => 'text',
                            'label'         => __('Duration', 'bb-njba'),
                            'default'       => __( '/ Hour', 'bb-njba' ),
                            'placeholder'   => __( '/ Hour', 'bb-njba' )
                        ),
                    ),
                ),
                'features'       => array(
                    'title'         => __( 'List of Properties', 'bb-njba' ),
                    'fields'        => array(
                        'features'          => array(
                            'type'          => 'text',
                            'label'         => '',
                            'default'       => __( 'Feature 1', 'bb-njba' ),
                            'placeholder'   => __( 'One feature per line.', 'bb-njba' ),
                            'multiple'      => true
                        )
                    )
                ),
                'general'       => array(
                    'title' => 'General',
                    'fields'    => array(
                        'show_button'   => array(
                            'type'          => 'select',
                            'label'         => __('Show Button', 'bb-njba'),
                            'default'       => 'yes',
                            'options'       => array(
                                'yes'       => __( 'Yes', 'bb-njba' ),
                                'no'        => __( 'No', 'bb-njba' ),
                            ),
                            'toggle'        => array(
                                'yes' => array(
                                    'sections' => array( 'btn-general', 'btn-style', 'button_typography' )
                                )
                            )
                        ),
                    )
                ),
                'btn-general'    => array( // Section
                    'title'         => __( 'General', 'bb-njba' ),
                    'fields'        => array(
                        'button_text'     => array(
                            'type'      => 'text',
                            'label'     => 'Text',
                            'default'   => __('GET STARTED', 'bb-njba'),
                            'preview'       => array(
                                'type'          => 'text',
                                'selector'      => 'a.njba-btn'
                            )
                        ),
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
                )
            )
		),
        'style'      => array(
            'title'         => __('Style', 'bb-njba'),
            'sections'      => array(
                'featured_item'       => array(
                    'title'         => __('Feature Area Style'),
                    'fields'        => array(
                        'feature_color' => array(
                            'type'       => 'color',
                            'label'      => __('Feature Text / Font Color', 'bb-njba'),
                            'default'    => 'ffffff',
                            'show_reset' => true,
                        ),
                        'feature_font'          => array(
                            'type'          => 'font',
                            'default'       => array(
                                'family'        => 'Default',
                                'weight'        => 300
                            ),
                            'label'         => __('Feature Text Font', 'bb-njba')
                        ),
                        'feature_font_size'    => array(
                            'type'          => 'text',
                            'size'          => '5',
                            'maxlength'     => '2',
                            'default'       => '16',
                            'label'         => __('Feature Text Font Size', 'bb-njba'),
                            'description'   => _x( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-njba' )
                        ),
                        'feature_background_color'        => array( 
                            'type'       => 'color',
                            'label'      => __('Feature area Background Color', 'bb-njba'),
                            'default'    => '000000',
                            'show_reset' => true,
                            'help'       => __( 'Choose background color for feature section', 'bb-njba' ),
                        ),
                    )
                ),
                'price-box'       => array(
                    'title'         => __( 'Price Box Style', 'bb-njba' ),
                    'fields'        => array(
                        'heading_color'    => array(
                            'type'          => 'color',
                            'label'         => __('Title Color', 'bb-njba'),
                            'default'       => '000000',
                            'show_reset'    => true
                        ),
                        'price_color'    => array(
                            'type'          => 'color',
                            'label'         => __('Price Color', 'bb-njba'),
                            'default'       => '000000',
                            'show_reset'    => true
                        ),
                        'duration_color'    => array(
                            'type'          => 'color',
                            'label'         => __('Duration Color', 'bb-njba'),
                            'default'       => '000000',
                            'show_reset'    => true
                        ),
                        'foreground_heading'        => array( 
                            'type'       => 'color',
                            'label'      => __('Title Area Background Color', 'bb-njba'),
                            'default'    => '4fbf70',
                            'show_reset' => true,
                            'help'       => __( 'Select the background for specific Price Box.', 'bb-njba'),
                        ),
                        'foreground_opc_heading' => array( 
                            'type'        => 'text',
                            'label'       => __('Opacity', 'bb-njba'),
                            'default'     => '100',
                            'description' => '%',
                            'maxlength'   => '3',
                            'size'        => '5',
                        ),
                    )
                ),
                'properties_style'       => array(
                    'title'         => __( 'Properties Style', 'bb-njba' ),
                    'fields'        => array(
                        'properties_color'    => array(
                            'type'          => 'color',
                            'label'         => __('Properties Color', 'bb-njba'),
                            'default'       => '000000',
                            'show_reset'    => true
                        ),
                        'foreground'        => array( 
                            'type'       => 'color',
                            'label'      => __('Properties Area Background Color', 'bb-njba'),
                            'default'    => 'ffffff',
                            'show_reset' => true,
                            'help'       => __( 'Select the background for specific Price Box.', 'bb-njba'),
                        ),
                        'foreground_opc' => array( 
                            'type'        => 'text',
                            'label'       => __('Opacity', 'bb-njba'),
                            'default'     => '100',
                            'description' => '%',
                            'maxlength'   => '3',
                            'size'        => '5',
                        )
                    )
                ),
                'btn-style'     => array( // Section
                    'title'         => __('Button Style', 'bb-njba'),
                    'fields'        => array(
                        'button_text_color' => array(
                            'type' => 'color',
                            'label' => __('Text Color','bb-njba'),
                            'show_reset' => true,
                            'default' => '404040'
                        ),
                        'button_background_color' => array(
                            'type' => 'color',
                            'label' => __('Background Color','bb-njba'),
                            'show_reset' => true,
                            'default' => 'dfdfdf'
                        ),
                        'button_text_hover_color' => array(
                            'type' => 'color',
                            'label' => __('Text Hover Color','bb-njba'),
                            'show_reset' => true,
                            'default' => 'ffffff'
                        ),
                        'button_background_hover_color' => array(
                            'type' => 'color',
                            'label' => __('Background Hover Color','bb-njba'),
                            'show_reset' => true,
                            'default' => '000000'
                        ),
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
                            'default' => 'center',
                            'options' => array(
                                'left' => __('Left','bb-njba'),
                                'center' => __('Center','bb-njba'),
                                'right' => __('Right','bb-njba')
                            )   
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
                        )
                    )
                ),
                'button_typography'    =>  array(
                    'title'     => __('Button Typography', 'bb-njba' ) ,
                    'fields'    => array(
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
                                'desktop' => '20',
                                'medium' => '16',
                                'small' => ''
                            )
                        )
                    )
                )
            ),
        )
	)
));