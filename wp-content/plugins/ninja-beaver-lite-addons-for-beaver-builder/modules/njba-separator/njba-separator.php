<?php
class NJBASeparatorModule extends FLBuilderModule {
    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Separator', 'bb-njba'),
            'description'   => __('Addon to display Separator.', 'bb-njba'),
            'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Separator Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-separator/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-separator/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'icon'              => 'minus.svg',
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
    public function njba_icon_module($sep_type){
        $html = '';
        if($sep_type == 'separator_icon') :
            $html .= '<div class="njba-divider-content njba-divider">';
                $html .= '<h5><i class="'.$this->settings->separator_icon_text.'" aria-hidden="true"></i></h5>';
            $html .= '</div>';
        endif;
        if($sep_type == 'separator_image') :
            $src = $this->get_image_src();
            $html .= '<div class="njba-divider-content njba-divider">';
                $html .= '<h5><img src="'.$src.'"></h5>';
            $html .= '</div>';
        endif;
        if($sep_type == 'separator_text') :
            $src = $this->get_image_src();
            $html .= '<div class="njba-divider-content njba-divider">';
                $html .= '<h5>'.$this->settings->separator_text_select.'</h5>';
            $html .= '</div>';
        endif;
        return $html;
    }
    public function get_image_src()
    {
        $src = $this->_get_image_url();
        return $src;
    }
    /**
     * @method _get_image_url
     * @protected
     */
    protected function _get_image_url()
    {
        if(!empty($this->settings->separator_image_select_src)) {
            $url = $this->settings->separator_image_select_src;
        }
        else {
            $url = FL_BUILDER_URL . 'img/pixel.png';
        }
        return $url;
    }
}
FLBuilder::register_module('NJBASeparatorModule', array(
    'general'       => array(
        'title'         => __('General', 'bb-njba'),
        'sections'      => array(
            'separator_style'       => array( // Section
                'title'         => __('Separator Style', 'bb-njba'), // Section Title,
                'fields'        => array( // Section Fields
                    'separator_type'    => array(
                        'type'          => 'select',
                        'default'       => 'separator_normal',
                        'label'         => __('Choose Type', 'bb-njba'),
                        'options'                   => array(
                            'separator_normal'                      => __('Normal', 'bb-njba'),
                            'separator_icon'                      => __('Icon', 'bb-njba'),
                            'separator_image'                     => __('Image', 'bb-njba'),
                            'separator_text'                     => __('Text', 'bb-njba'),
                        ),
                        'toggle'        => array(
                            'separator_normal'        => array(
                                'fields'        => array('separator_normal_width')
                            ),
                            'separator_icon'        => array(
                                'fields'        => array('separator_icon_text', 'separator_icon_font_size', 'separator_icon_font_color')
                            ),
                            'separator_image'        => array(
                                'fields'        => array('separator_image_select')
                            ),
                            'separator_text'        => array(
                                'fields'        => array('separator_text_select','separator_text_font_size','separator_text_font_color')
                            )
                        )
                    ),
                    'icon_position'    => array(
                        'type'          => 'select',
                        'default'       => 'center',
                        'label'         => __('Choose Position', 'bb-njba'),
                        'options'                   => array(
                            'left'                      => __('Left', 'bb-njba'),
                            'center'                      => __('Center', 'bb-njba'),
                            'right'                     => __('Right', 'bb-njba')
                        )
                    ),
                    'separator_normal_width'          => array(
                        'type'          => 'text',
                        'size'          => '5',
                        'maxlength'     => '3',
                        'default'       => '50',
                        'label'         => __('Separator Width', 'bb-njba'),
                        'description'   => _x( '%', 'Value unit for Separator Width. Such as: "50%"', 'bb-njba' ),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-heading-icon',
                            'property'      => 'width',
                            'unit'          => '%'
                        )
                    ),
                    'separator_icon_text'          => array(
                        'type'          => 'icon',
                        'label'         => __('Icon', 'bb-njba')
                    ),
                    'separator_icon_font_size'    => array(
                        'type'          => 'text',
                        'size'          => '5',
                        'maxlength'     => '2',
                        'default'       => '18',
                        'label'         => __('Font Size', 'bb-njba'),
                        'description'   => _x( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-njba' ),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-divider-content',
                            'property'      => 'font-size',
                            'unit'          => 'px'
                        )
                    ),
                    'separator_icon_font_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-njba'),
                        'default'       => '000000',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-divider-content',
                            'property'      => 'color'
                        )
                    ),
                    'separator_image_select'         => array(
                        'type'          => 'photo',
                        'label'         => __('Separator Image', 'bb-njba'),
                        'show_remove'   => true
                    ),
                    'separator_text_select'         => array(
                        'type'            => 'text',
                        'label'           => __('Separator Text', 'bb-njba'),
                        'default'         => 'Example',
                        'help'            => __('Use a unique small word to highlight this Heading.','bb-njba')
                    ),
                    'separator_text_font_size'    => array(
                        'type'          => 'text',
                        'size'          => '5',
                        'maxlength'     => '2',
                        'default'       => '16',
                        'label'         => __('Font Size', 'bb-njba'),
                        'description'   => _x( 'px', 'Value unit for font size. Such as: "14 px"', 'bb-njba' ),
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-divider-content',
                            'property'      => 'font-size',
                            'unit'          => 'px'
                        )
                    ),
                    'separator_text_font_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-njba'),
                        'default'       => '000000',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-divider-content',
                            'property'      => 'color'
                        )
                    ),
                    'separator_border_width'    => array(
                        'type'          => 'text',
                        'default'       => '1',
                        'maxlength'     => '2',
                        'size'          => '5',
                        'label'         => __('Border Width', 'bb-njba'),
                        'description'   => 'px',
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-heading-separator-line',
                            'property'      => 'border-top',
                            'unit'          => 'px'
                        )
                    ),
                    'separator_border_style'      => array(
                        'type'      => 'select',
                        'label'     => __('Border Style', 'bb-njba'),
                        'default'   => 'solid',
                        'options'   => array(
                            'none'  => __('None', 'bb-njba'),
                            'solid'  => __('Solid', 'bb-njba'),
                            'dotted'  => __('Dotted', 'bb-njba'),
                            'dashed'  => __('Dashed', 'bb-njba'),
                            'double'  => __('Double', 'bb-njba'),
                        ),
                    ),
                    'separator_border_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Border Color', 'bb-njba'),
                        'default'       => '000000',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'          => 'css',
                            'selector'      => '.njba-heading-separator-line',
                            'property'      => 'border-color',
                        )
                    )
                )
            )
        )
    )
));