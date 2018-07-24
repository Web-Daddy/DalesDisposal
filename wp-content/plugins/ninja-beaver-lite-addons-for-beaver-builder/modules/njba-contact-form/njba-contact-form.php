<?php
/**
 * @class NJBAFormModule
 */
class NJBAFormModule extends FLBuilderModule {
    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Contact Form', 'bb-njba'),
            'description'   => __('Addon to display form.', 'bb-njba'),
            'group'         => __('NJBA Module', 'bb-njba'),
            'category'      => __('Form Style Modules - NJBA', 'bb-njba'),
            'dir'           => NJBA_MODULE_DIR . 'modules/njba-contact-form/',
            'url'           => NJBA_MODULE_URL . 'modules/njba-contact-form/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
            'icon'              => 'editor-table.svg',
        ));
        add_action('wp_ajax_njba_builder_email', array($this, 'send_mail'));
        add_action('wp_ajax_nopriv_njba_builder_email', array($this, 'send_mail'));
        /**
         * Use these methods to enqueue css and js already
         * registered or to register and enqueue your own.
         */
        // Already registered
		$this->add_css('font-awesome');
		
		$this->add_css('njba-form-frontend', NJBA_MODULE_URL . 'modules/njba-contact-form/css/frontend.css');
		
    }
    static public function mailto_email()
    {
        return $this->settings->mailto_email;
    }
    static public function send_mail($params = array()) {
        global $njba_contact_from_name, $njba_contact_from_email, $from_name, $from_email;
        // Get the contact form post data
        $node_id            = isset( $_POST['node_id'] ) ? sanitize_text_field( $_POST['node_id'] ) : false;
        $template_id        = isset( $_POST['template_id'] ) ? sanitize_text_field( $_POST['template_id'] ) : false;
        $template_node_id   = isset( $_POST['template_node_id'] ) ? sanitize_text_field( $_POST['template_node_id'] ) : false;
        $mailto = get_option('admin_email');
        if ( $node_id ) {
            // Get the module settings.
            if ( $template_id ) {
                $post_id  = FLBuilderModel::get_node_template_post_id( $template_id );
                $data     = FLBuilderModel::get_layout_data( 'published', $post_id );
                $settings = $data[ $template_node_id ]->settings;
            }
            else {
                $module   = FLBuilderModel::get_module( $node_id );
                $settings = $module->settings;
            }
            if ( isset($settings->mailto_email) && !empty($settings->mailto_email) ) {
                $mailto   = $settings->mailto_email;
            }
        $subject =  $settings->email_subject;
        if ( $subject != '' ) {
            
            if ( isset( $_POST['name'] ) )  $subject = str_replace( '[NAME]', sanitize_text_field($_POST['name']), $subject );
            if ( isset( $_POST['last_name'] ) ) $subject = str_replace( '[LAST NAME]', sanitize_text_field($_POST['last_name']), $subject );
            if ( isset( $_POST['subject'] ) ) $subject = str_replace( '[SUBJECT]', sanitize_text_field($_POST['subject']), $subject );
            if ( isset( $_POST['email'] ) ) $subject = str_replace( '[EMAIL]', sanitize_text_field($_POST['email']), $subject );
            if ( isset( $_POST['phone'] ) ) $subject = str_replace( '[PHONE]', sanitize_text_field($_POST['phone']), $subject );
            if ( isset( $_POST['message'] ) ) $subject = str_replace( '[MESSAGE]', sanitize_text_field($_POST['message']), $subject );
            
        } 
        $njba_contact_from_email = (isset($_POST['email']) ? sanitize_text_field($_POST['email']) : null);
        $njba_contact_from_name = (isset($_POST['name']) ? sanitize_text_field($_POST['name']) : null);
       
       
        $from_name = $settings->from_name;
        $from_email = $settings->from_email;
        add_filter('wp_mail_from', 'NJBAFormModule::mail_from');
        add_filter('wp_mail_from_name', 'NJBAFormModule::from_name');
       
        $headers =  array(
                        'Reply-To: ' . $njba_contact_from_email . ' <' . $njba_contact_from_email . '>',
                        'Content-Type: text/html; charset=UTF-8',
                    );
        $template = $settings->email_template;
        if ( isset( $_POST['name'] ) )  $template = str_replace( '[NAME]', sanitize_text_field($_POST['name']), $template );
        if ( isset( $_POST['last_name'] ) ) $template = str_replace( '[LAST NAME]', sanitize_text_field($_POST['last_name']), $template );
        if ( isset( $_POST['email'] ) ) $template = str_replace( '[EMAIL]', sanitize_text_field($_POST['email']), $template );
        if ( isset( $_POST['subject'] ) ) $template = str_replace( '[SUBJECT]', sanitize_text_field($_POST['subject']), $template );
        if ( isset( $_POST['phone'] ) ) $template = str_replace( '[PHONE]', sanitize_text_field($_POST['phone']), $template );
        if ( isset( $_POST['message'] ) ) $template = str_replace( '[MESSAGE]', sanitize_text_field($_POST['message']), $template );
        $template = wpautop( $template );
        // Double check the mailto email is proper and send
        
        if ($mailto) {       
            wp_mail($mailto, stripslashes($subject), do_shortcode( stripslashes($template) ), $headers);
            die('1');
        } else {
            die($mailto);
        }
       } 
    }
    static public function mail_from($original_email_address) {
        global $from_email;
        $original_email_address ='info@ninjabeaveraddon.com';
       return ( $from_email != '') ? $from_email : $original_email_address;
      
    }
    static public function from_name($original_name) {
        global $from_name;
        $original_name= 'ninjabeaveraddon';
       return ( $from_name != '') ? $from_name : $original_name;
     
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
$host = 'localhost';
if ( isset( $_SERVER['HTTP_HOST'] ) ) {
    $host = $_SERVER['HTTP_HOST'];
}
$current_url = 'http://' . $host . strtok($_SERVER["REQUEST_URI"],'?');
//$default_subject = sprintf( __(' Request received from %s (%s)' , 'bb-njba' ), get_bloginfo( 'name' ), $current_url);
$default_subject = 'Request received from ' .get_bloginfo('name').'';
$default_template = sprintf( __( '<strong>Name:</strong> [NAME]
<strong>Email:</strong> [EMAIL]
<strong>Last Name:</strong> [LAST NAME]
<strong>Subject:</strong> [SUBJECT]
<strong>Message Body:</strong>
[MESSAGE]
----
You have received a new submission from %s
(%s)' , 'bb-njba' ), get_bloginfo( 'name' ), $current_url );
/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('NJBAFormModule', array(
    'general'         => array(
        'title'         => __('General', 'bb-njba'),
        'sections'      => array(
            'general'       => array(
                'title'         => '',
                'fields'        => array(
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
                        'default'           => 'Create a stylish contact form that people would love to fill.',
                        'placeholder'       => '',
                        'rows'              => '6',
                        'preview'           => array(
                            'type'          => 'text',
                            'selector'      => ''
                        )
                    ),
                )
            ),        
            
  
            'first_name'       => array(
                'title'         => __('First Name Field', 'bb-njba'),
                'fields'        => array(
                    'first_name_toggle'   => array(
                        'type'          => 'select',
                        'label'         => __('First Name', 'bb-njba'),
                        'default'       => 'show',
                        'options'       => array(
                            'show'      => __('Show', 'bb-njba'),
                            'hide'      => __('Hide', 'bb-njba'),
                        ),
                        'toggle'        => array(
                            'show'      => array(
                                'fields'    => array( 'first_name_width', 'name_label', 'first_name_placeholder', 'name_required', 'first_name_icon' ),
                            )
                        )
                    ),
                    'first_name_width'   => array(
                        'type'          => 'select',
                        'label'         => __('Width', 'bb-njba'),
                        'default'       => '100',
                        'options'       => array(
                            '100'       => __('100%', 'bb-njba'),
                            '50'        => __('50%', 'bb-njba'),
                        )
                    ),        
                    'first_name_label'          => array(
                        'type'          => 'text',
                        'label'         => __('Label', 'bb-njba'),
                        'default'       => __('Firstname', 'bb-njba'),
                    ),
                    'first_name_placeholder'          => array(
                        'type'          => 'text',
                        'label'         => __('Placeholder', 'bb-njba'),
                        'default'       => __('First Name', 'bb-njba'),
                    ),
                    'first_name_icon'          => array(
                        'type'          => 'icon',
                        'label'         => __('Icon', 'bb-njba'),
                        'show_remove'   => true
                    ),
                    'first_name_required'     => array(
                        'type'          => 'select',
                        'label'         => __( 'Required', 'bb-njba' ),
                        'help'          => __( 'Enable to make name field compulsary.', 'bb-njba' ),
                        'default'       => 'yes',
                        'options'       => array(
                            'yes'       => 'Yes',
                            'no'        => 'No',
                        ),
                    ),
                )
            ),
             'last_name'       => array(
                'title'         => __('Last Name Field', 'bb-njba'),
                'fields'        => array(
                    'last_name_toggle'   => array(
                        'type'          => 'select',
                        'label'         => __('Last Name', 'bb-njba'),
                        'default'       => 'show',
                        'options'       => array(
                            'show'      => __('Show', 'bb-njba'),
                            'hide'      => __('Hide', 'bb-njba'),
                        ),
                        'toggle'        => array(
                            'show'      => array(
                                'fields'    => array( 'last_name_width', 'last_name_label', 'last_name_placeholder', 'last_name_required', 'last_name_icon' ),
                            )
                        )
                    ),
                    'last_name_width'   => array(
                        'type'          => 'select',
                        'label'         => __('Width', 'bb-njba'),
                        'default'       => '100',
                        'options'       => array(
                            '100'       => __('100%', 'bb-njba'),
                            '50'        => __('50%', 'bb-njba'),
                        )
                    ),         
                    'last_name_label'          => array(
                        'type'          => 'text',
                        'label'         => __('Label', 'bb-njba'),
                        'default'       => __('Lastname', 'bb-njba'),
                    ),
                    'last_name_placeholder'          => array(
                        'type'          => 'text',
                        'label'         => __('Placeholder', 'bb-njba'),
                        'default'       => __('Last Name', 'bb-njba'),
                    ),
                    'last_name_icon'          => array(
                        'type'          => 'icon',
                        'label'         => __('Icon', 'bb-njba'),
                        'show_remove'   => true
                    ),
                    'last_name_required'     => array(
                        'type'          => 'select',
                        'label'         => __( 'Required', 'bb-njba' ),
                        'help'          => __( 'Enable to make name field compulsary.', 'bb-njba' ),
                        'default'       => 'yes',
                        'options'       => array(
                            'yes'       => 'Yes',
                            'no'        => 'No',
                        ),
                    ),
                )
            ),
            'email_section'       => array(
                'title'         => __('Email Field', 'bb-njba'),
                'fields'        => array(
                    'email_toggle'   => array(
                        'type'          => 'select',
                        'label'         => __('Email', 'bb-njba'),
                        'default'       => 'show',
                        'options'       => array(
                            'show'      => __('Show', 'bb-njba'),
                            'hide'      => __('Hide', 'bb-njba'),
                        ),
                        'toggle'        => array(
                            'show'      => array(
                                'fields'    => array( 'email_width', 'email_label', 'email_placeholder', 'email_required', 'email_icon' ),
                            )
                        )
                    ),
                    'email_width'   => array(
                        'type'          => 'select',
                        'label'         => __('Width', 'bb-njba'),
                        'default'       => '100',
                        'options'       => array(
                            '100'       => __('100%', 'bb-njba'),
                            '50'        => __('50%', 'bb-njba'),
                        )
                    ),
                    'email_label'          => array(
                        'type'          => 'text',
                        'label'         => __('Label', 'bb-njba'),
                        'default'       => __('Email', 'bb-njba'),
                    ),
                    'email_placeholder'          => array(
                        'type'          => 'text',
                        'label'         => __('Placeholder', 'bb-njba'),
                        'default'       => __('Email', 'bb-njba'),
                    ),
                    'email_icon'          => array(
                        'type'          => 'icon',
                        'label'         => __('Icon', 'bb-njba'),
                        'show_remove'   => true
                    ),
                    'email_required'     => array(
                        'type'          => 'select',
                        'label'         => __( 'Required', 'bb-njba' ),
                        'help'          => __( 'Enable to make email field compulsary.', 'bb-njba' ),
                        'default'       => 'yes',
                        'options'       => array(
                            'yes'       => 'Yes',
                            'no'        => 'No',
                        ),
                    ),
                )
            ),
            'subject_section'       => array(
                'title'         => __('Subject Field', 'bb-njba'),
                'fields'        => array(
                    'subject_toggle'   => array(
                        'type'          => 'select',
                        'label'         => __('Subject', 'bb-njba'),
                        'default'       => 'show',
                        'options'       => array(
                            'show'      => __('Show', 'bb-njba'),
                            'hide'      => __('Hide', 'bb-njba'),
                        ),
                        'toggle'        => array(
                            'show'      => array(
                                'fields'    => array( 'subject_width', 'subject_label', 'subject_placeholder', 'subject_required', 'subject_icon' ),
                            )
                        )
                    ),
                    'subject_width'   => array(
                        'type'          => 'select',
                        'label'         => __('Width', 'bb-njba'),
                        'default'       => '100',
                        'options'       => array(
                            '100'       => __('100%', 'bb-njba'),
                            '50'        => __('50%', 'bb-njba'),
                        )
                    ),
                    'subject_label'          => array(
                        'type'          => 'text',
                        'label'         => __('Label', 'bb-njba'),
                        'default'       => __('Subject', 'bb-njba'),
                    ),
                    'subject_placeholder'          => array(
                        'type'          => 'text',
                        'label'         => __('Placeholder', 'bb-njba'),
                        'default'       => __('Subject', 'bb-njba'),
                    ),
                    'subject_icon'          => array(
                        'type'          => 'icon',
                        'label'         => __('Icon', 'bb-njba'),
                        'show_remove'   => true
                    ),
                    'subject_required'     => array(
                        'type'          => 'select',
                        'label'         => __( 'Required', 'bb-njba' ),
                        'help'          => __( 'Enable to make subject field compulsary.', 'bb-njba' ),
                        'default'       => 'no',
                        'options'       => array(
                            'yes'       => 'Yes',
                            'no'        => 'No',
                        ),
                    ),
                )
            ),          
            'phone_section'       => array(
                'title'         => __('Phone Field', 'bb-njba'),
                'fields'        => array(
                    'phone_toggle'   => array(
                        'type'          => 'select',
                        'label'         => __('Phone', 'bb-njba'),
                        'default'       => 'hide',
                        'options'       => array(
                            'show'      => __('Show', 'bb-njba'),
                            'hide'      => __('Hide', 'bb-njba'),
                        ),
                        'toggle'        => array(
                            'show'      => array(
                                'fields'    => array( 'phone_width', 'phone_label', 'phone_placeholder', 'phone_required', 'phone_icon' ),
                            )
                        )
                    ),
                    'phone_width'   => array(
                        'type'          => 'select',
                        'label'         => __('Width', 'bb-njba'),
                        'default'       => '100',
                        'options'       => array(
                            '100'       => __('100%', 'bb-njba'),
                            '50'        => __('50%', 'bb-njba'),
                        )
                    ),
                    'phone_label'          => array(
                        'type'          => 'text',
                        'label'         => __('Label', 'bb-njba'),
                        'default'       => __('Phone', 'bb-njba'),
                    ),
                    'phone_placeholder'          => array(
                        'type'          => 'text',
                        'label'         => __('Placeholder', 'bb-njba'),
                        'default'       => __('Phone', 'bb-njba'),
                    ),
                    'phone_icon'          => array(
                        'type'          => 'icon',
                        'label'         => __('Icon', 'bb-njba'),
                        'show_remove'   => true
                    ),
                    'phone_required'     => array(
                        'type'          => 'select',
                        'label'         => __( 'Required', 'bb-njba' ),
                        'help'          => __( 'Enable to make phone field compulsary.', 'bb-njba' ),
                        'default'       => 'no',
                        'options'       => array(
                            'yes'       => 'Yes',
                            'no'        => 'No',
                        ),
                    ),
                )
            ),
            'msg_section'       => array(
                'title'         => __('Message Field', 'bb-njba'),
                'fields'        => array(
                    'msg_toggle'   => array(
                        'type'          => 'select',
                        'label'         => __('Message', 'bb-njba'),
                        'default'       => 'show',
                        'options'       => array(
                            'show'      => __('Show', 'bb-njba'),
                            'hide'      => __('Hide', 'bb-njba'),
                        ),
                        'toggle'        => array(
                            'show'      => array(
                                'fields'    => array( 'msg_width', 'msg_height', 'msg_label', 'msg_placeholder', 'msg_required', 'textarea_top_margin', 'textarea_bottom_margin', 'msg_icon' ),
                            )
                        )
                    ),
                    'msg_width'   => array(
                        'type'          => 'select',
                        'label'         => __('Width', 'bb-njba'),
                        'default'       => '100',
                        'options'       => array(
                            '100'       => __('100%', 'bb-njba'),
                            '50'        => __('50%', 'bb-njba'),
                        )
                    ),                    
                    'msg_label'          => array(
                        'type'          => 'text',
                        'label'         => __('Label', 'bb-njba'),
                        'default'       => __('Message', 'bb-njba'),
                    ),
                    'msg_placeholder'          => array(
                        'type'          => 'text',
                        'label'         => __('Placeholder', 'bb-njba'),
                        'default'       => __('Message', 'bb-njba'),
                    ),
                    'msg_icon'          => array(
                        'type'          => 'icon',
                        'label'         => __('Icon', 'bb-njba'),
                        'show_remove'   => true
                    ),
                    'msg_required'     => array(
                        'type'          => 'select',
                        'label'         => __( 'Required', 'bb-njba' ),
                        'help'          => __( 'Enable to make message field compulsary.', 'bb-njba' ),
                        'default'       => 'yes',
                        'options'       => array(
                            'yes'       => 'Yes',
                            'no'        => 'No',
                        ),
                    ),
                )
            ),
            'success'       => array(
                'title'         => __( 'Success', 'bb-njba' ),
                'fields'        => array(
                    'success_action' => array(
                        'type'          => 'select',
                        'label'         => __( 'Success Action', 'bb-njba' ),
                        'default'       => 'show_message',
                        'options'       => array(
                            'none'          => __( 'None', 'bb-njba' ),
                            'show_message'  => __( 'Show Message', 'bb-njba' ),
                            'redirect'      => __( 'Redirect', 'bb-njba' )
                        ),
                        'toggle'        => array(
                            'show_message'       => array(
                                'fields'        => array( 'success_message' )
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
                        'default'       => __( 'Thanks for your message! We’ll be in touch soon.', 'bb-njba' ),
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
     'template'       => array(
        'title'         => __('Email', 'bb-njba'),
        'sections'      => array(
            'email-subject' => array(
                'title' => __('', 'bb-njba'),
                'fields' => array(
                    'mailto_email'     => array(
                        'type'          => 'text',
                        'label'         => __('Send To Email', 'bb-njba'),
                        'default'       => '',
                        'placeholder'   => 'example@mail.com',
                        'help'          => __('The contact form will send to this e-mail. Defaults to the admin email.', 'bb-njba'),
                        'preview'       => array(
                            'type'          => 'none'
                        )
                    ),
                    'email_subject'    => array(
                        'type'          => 'text',
                        'label'         => __('Email Subject', 'bb-njba'),
                        'default'       => $default_subject,
                        'help'         => __('The subject of email received, by default if you have enabled subject it would be shown by shortcode or you can manually add yourself', 'bb-njba'),
                    ),
                    'from_name'    => array(
                        'type'          => 'text',
                        'label'         => __('From Name', 'bb-njba'),
                        'default'       => '',
                        'help'         => __('The contact form will send to this From name. Defaults to the admin name.', 'bb-njba'),
                    ),
                    'from_email'    => array(
                        'type'          => 'text',
                        'label'         => __('From Email', 'bb-njba'),
                        'default'       => '',
                        'placeholder'   => 'example@mail.com',
                        'help'         => __('The contact form will send to this From e-mail. Defaults to the admin email.', 'bb-njba'),
                    ),
                )
            ),
            'email-template' => array(
                'title' => __('Email Template', 'bb-njba'),
                'fields' => array(
                    'email_template'    => array(
                        'type'          => 'editor',
                        'label'         => '',
                        'rows'          => 8,
                        'default'       => $default_template,
                        'description'   => __('Here you can design the email you receive', 'bb-njba'),
                    ),                  
                    'email_sccess'    => array(
                        'type'          => 'text',
                        'label'         => __('Success Message', 'bb-njba'),
                        'default'       => __('Message Sent!','bb-njba'),
                    ),
                    'email_error'    => array(
                        'type'          => 'text',
                        'label'         => __('Error Message', 'bb-njba'),
                        'default'       => __('Message failed. Please try again.','bb-njba'),
                    ),
                )
            ),
        )
    ),
    'style'       => array(
        'title'         => __('Style', 'bb-njba'),
        'sections'      => array(
            'form-general'       => array(
                'title'         => '',
                'fields'        => array(
                    'form_style'   => array(
                        'type'          => 'select',
                        'label'         => __('Form Style', 'bb-njba'),
                        'default'       => 'style1',
                        'options'       => array(
                            'style1'      => __('Style 1', 'bb-njba'),
                            'style2'      => __('Style 2', 'bb-njba'),
                            'style3'      => __('Style 3', 'bb-njba'),
                        ),
                        'toggle'        => array(
                            'style1'      => array(
                                'fields'    => array( 'input_border_width', 'input_border_color', 'input_border_radius' )
                            ),
                             'style2'      => array(
                                'fields'    => array( 'border_style','input_border', 'border_color', 'border_radius' )
                            ),
                             'style3'      => array(
                                'fields'    => array( 'border_style','input_border', 'border_color', 'border_radius', 'textarea_border' )
                            )
                        ),
                        'help'         => __('Input fleld Apperance', 'bb-njba'),
                    ),
                    'enable_label'   => array(
                        'type'          => 'select',
                        'label'         => __('Enable Label', 'bb-njba'),
                        'default'       => 'no',
                        'options'       => array(
                            'yes'     => __('Yes', 'bb-njba'),
                            'no'      => __('No', 'bb-njba'),
                        )
                    ),
                    'enable_placeholder'   => array(
                        'type'          => 'select',
                        'label'         => __('Enable Placeholder', 'bb-njba'),
                        'default'       => 'yes',
                        'options'       => array(
                            'yes'     => __('Yes', 'bb-njba'),
                            'no'      => __('No', 'bb-njba'),
                        )
                    ),
                   'enable_icon'   => array(
                        'type'          => 'select',
                        'label'         => __('Enable Input Icon', 'bb-njba'),
                        'default'       => 'yes',
                        'options'       => array(
                            'yes'     => __('Yes', 'bb-njba'),
                            'no'      => __('No', 'bb-njba'),
                        )
                    ), 
                )
            ),
            'form-style'       => array(
                'title'         => 'Form Style',
                'fields'        => array(
                    'form_bg_type' => array(
                            'type'          => 'select',
                            'label'         => __( 'Background Type', 'bb-njba' ),
                            'default'       => 'none',
                            'options'       => array(
                                'none'          => __( 'None', 'bb-njba' ),
                                'color'         => __( 'Color', 'bb-njba' ),
                                'image'         => __( 'Image', 'bb-njba' ),
                            ),
                            'toggle'    => array(
                                'color'     => array(
                                    'fields'    => array( 'form_bg_color', 'form_bg_color_opc' )
                                ),
                                'image' => array(
                                    'fields'    => array( 'form_bg_img', 'form_bg_img_pos', 'form_bg_img_size', 'form_bg_img_repeat' )
                                ),
                            ),
                    ),
                    'form_bg_img'         => array(
                        'type'          => 'photo',
                        'label'         => __( 'Photo', 'bb-njba' ),
                        'show_remove'   => true,
                    ),
                    'form_bg_img_pos' => array(
                            'type'          => 'select',
                            'label'         => __( 'Background Position', 'bb-njba' ),
                            'default'       => 'center center',
                            'options'       => array(
                                'left top'          => __( 'Left Top', 'bb-njba' ),
                                'left center'       => __( 'Left Center', 'bb-njba' ),
                                'left bottom'       => __( 'Left Bottom', 'bb-njba' ),
                                'center top'        => __( 'Center Top', 'bb-njba' ),
                                'center center'     => __( 'Center Center', 'bb-njba' ),
                                'center bottom'     => __( 'Center Bottom', 'bb-njba' ),
                                'right top'         => __( 'Right Top', 'bb-njba' ),
                                'right center'      => __( 'Right Center', 'bb-njba' ),
                                'right bottom'      => __( 'Right Bottom', 'bb-njba' ),
                            ),
                    ),
                    'form_bg_img_repeat' => array(
                            'type'          => 'select',
                            'label'         => __( 'Background Repeat', 'bb-njba' ),
                            'default'       => 'repeat',
                            'options'       => array(
                                'no-repeat'     => __( 'No Repeat', 'bb-njba' ),
                                'repeat'        => __( 'Repeat All', 'bb-njba' ),
                                'repeat-x'      => __( 'Repeat Horizontally', 'bb-njba' ),
                                'repeat-y'      => __( 'Repeat Vertically', 'bb-njba' ),
                            ),
                    ),
                    'form_bg_img_size' => array(
                            'type'          => 'select',
                            'label'         => __( 'Background Size', 'bb-njba' ),
                            'default'       => 'cover',
                            'options'       => array(
                                'contain'   => __( 'Contain', 'bb-njba' ),
                                'cover'     => __( 'Cover', 'bb-njba' ),
                                'initial'   => __( 'Initial', 'bb-njba' ),
                                'inherit'   => __( 'Inherit', 'bb-njba' ),
                            ),
                    ),
                    'form_bg_color' => array( 
                        'type'       => 'color',
                        'label'     => __( 'Background Color', 'bb-njba' ),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'form_bg_color_opc' => array( 
                        'type'        => 'text',
                        'label'     => __( 'Background Color Opacity', 'bb-njba' ),
                        'default'     => '',
                        'description' => '%',
                        'maxlength'   => '3',
                        'size'        => '5',
                    ),
                   'form_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'default'           => array(
                            'top'          => 15,
                            'bottom'       => 15,
                            'left'         => 15,
                            'right'        => 15,
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => 'padding-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => 'padding-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => 'padding-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => 'padding-right',
                                ),
                            )
                        )
                    ),
                    'form_border_width'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Border', 'bb-njba'),
                         'default'   => array(
                            'top'   => '',
                            'bottom'   => 1,
                            'left'   => '',
                            'right'   => '',
                        ), 
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => '',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => '',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => '',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => '',
                                ),
                            )
                        )
                    ),
                    'form_border_style'      => array(
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
                    ),
                    'form_border_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Border Color', 'bb-njba'),
                        'default'       => 'F8F8F8',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.njba-contact-form',
                                    'property'      => 'border-color',
                                ),
           
                            ),
                        )
                    ),
                    'form_radius'   => array(
                        'type'          => 'text',
                        'label'         => __('Round Corner', 'bb-njba'),
                        'maxlength'     => '4',
                        'size'          => '6',
                        'description'   => 'px',
                        'placeholder'   => '0',
                    ),
                     'form_box_shadow'        => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Box Shadow', 'bb-njba'),
                        'options'           => array(
                            'vertical'          => array(
                                'placeholder'       => __('Vertical', 'bb-njba'),
                                'tooltip'           => __('Vertical', 'bb-njba'),
                                'icon'              => 'fa-arrows-v'
                            ),
                            'horizontal'        => array(
                                'placeholder'       => __('Horizontal', 'bb-njba'),
                                'tooltip'           => __('Horizontal', 'bb-njba'),
                                'icon'              => 'fa-arrows-h'
                            ),
                            'blur'              => array(
                                'placeholder'       => __('Blur', 'bb-njba'),
                                'tooltip'           => __('Blur', 'bb-njba'),
                                'icon'              => 'fa-circle-o'
                            ),
                            'spread'            => array(
                                'placeholder'       => __('Spread', 'bb-njba'),
                                'tooltip'           => __('Spread', 'bb-njba'),
                                'icon'              => 'fa-paint-brush'
                            ),
                        )
                    ),
                    'box_shadow_color' => array(
                        'type'              => 'color',
                        'label'             => __('Shadow Color', 'bb-njba'),
                        'default'           => '000000',
                    ),
                    'box_shadow_opacity' => array(
                        'type'              => 'text',
                        'label'             => __('Shadow Opacity', 'bb-njba'),
                        'description'       => '%',
                        'size'             => 5,
                        'default'           => 50,
                    ),
                    'input_custom_width'     => array(
                        'type'          => 'select',
                        'label'         => __( 'Inputs Width', 'bb-njba' ),
                        'default'       => 'default',
                        'options'       => array(
                            'default'          => __( 'Default', 'bb-njba' ),
                            'custom'          => __( 'Custom', 'bb-njba' ),
                        ),
                        'toggle'    => array(
                            'custom'    => array(
                                'fields'    => array('input_name_width', 'input_email_width', 'input_button_width')
                            )
                        )
                    ),
                    'input_name_width'  => array(
                        'type'              => 'text',
                        'label'             => __('Name Field Width', 'bb-njba'),
                        'description'       => '%',
                        'size'              => 5,
                        'default'           => '',
                    ),
                    'input_email_width'      => array(
                        'type'          => 'text',
                        'label'         => __('Email Field Width', 'bb-njba'),
                        'description'   => '%',
                        'size'         => 5,
                        'default'       => '',
                    ),
                     'input_textarea_width'      => array(
                        'type'          => 'text',
                        'label'         => __('Textarea Field Width', 'bb-njba'),
                        'description'   => '%',
                        'size'         => 5,
                        'default'       => '',
                    ),
                    'input_button_width'      => array(
                        'type'          => 'text',
                        'label'         => __('Button Width', 'bb-njba'),
                        'description'   => '%',
                        'size'         => 5,
                        'default'       => '',
                    ),
                    'inputs_space'      => array(
                        'type'          => 'text',
                        'label'         => __('Spacing Between Inputs Top/Bottom', 'bb-njba'),
                        'description'   => '%',
                        'size'         => 5,
                        'default'       => '1',
                    ),
                    'input_spacing'      => array(
                        'type'          => 'text',
                        'label'         => __('Spacing Between Inputs', 'bb-njba'),
                        'description'   => 'px',
                        'size'         => 5,
                        'default'       => '1',
                    ),
                )
            ),
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
                )
            ),
            'label_style' => array( // Section
                'title' => __('Label', 'bb-njba'),
                'fields'    => array(
                    'form_label_color'  => array(
                        'type'          => 'color',
                        'label'         => __('Color', 'bb-njba'),
                        'default'       => '333333',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'      => 'css',
                            'selector'  => '.njba-contact-form .njba-input-group label',
                            'property'  => 'color'
                        )
                    ),
                )
            ),
            'error-style'       => array(
                'title'         => __('Validation Style','bb-njba'),
                'fields'        => array(
                    'invalid_msg_color' => array( 
                        'type'       => 'color',
                        'label'     => __( 'Input Message Color', 'bb-njba' ),
                        'default'    => 'dd4420',
                        'show_reset' => true,
                        'help'      => __( 'This color would be applied to validation message and error icon in input field', 'bb-njba' ),
                        'preview'   => 'none'
                    ),
                    'invalid_border_color' => array( 
                        'type'       => 'color',
                        'label'     => __( 'Input border color', 'bb-njba' ),
                        'default'    => 'dd4420',
                        'show_reset' => true,
                        'help'      => __( 'If the validation is not right then this color would be applied to input border', 'bb-njba' ),
                        'preview'   => 'none'
                    ),
                    'success_msg_color' => array( 
                        'type'       => 'color',
                        'label'     => __( 'Success Message Color', 'bb-njba' ),
                        'default'    => '',
                        'show_reset' => true,
                        'preview'   => 'none'
                    ),
                    'error_msg_color' => array( 
                        'type'       => 'color',
                        'label'     => __( 'Error Message color', 'bb-njba' ),
                        'default'    => 'dd4420',
                        'show_reset' => true,
                        'preview'   => 'none'
                    ),
                )
            ),
        )
    ),
     'input'       => array(
        'title'         => __('Input', 'bb-njba'),
        'sections'      => array(
            'input-colors'       => array(
                'title'         => __('Input Color', 'bb-njba'),
                'fields'        => array(
                    'input_text_color'    => array( 
                        'type'       => 'color',
                        'label'         => __('Text Color', 'bb-njba'),
                        'default'         => '333333',
                        'show_reset' => true,
                    ),
                    'input_background_color'    => array( 
                        'type'       => 'color',
                        'label'         => __('Background Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'input_background_color_opc'    => array( 
                        'type'        => 'text',
                        'label'       => __('Opacity', 'bb-njba'),
                        'default'     => '',
                        'description' => '%',
                        'maxlength'   => '3',
                        'size'        => '5',
                    ),
                    'input_icon_color' => array( 
                        'type'       => 'color',
                        'label'      => __('Icon Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'input_icon_size'    => array(
                        'type'          => 'text',
                        'label'         => __( 'Icon Size', 'bb-njba' ),
                        'placeholder'   => __( 'Inherit', 'bb-njba'),
                        'size'          => '8',
                        'description'   => 'px',
                        'help'   => __( 'If icon size is kept bank then title font size would be applied', 'bb-njba' ),
                    ),
                    'position_top'    => array(
                        'type'          => 'text',
                        'label'         => __( 'Icon Position Top', 'bb-njba' ),
                        'placeholder'   => __( 'Inherit', 'bb-njba'),
                        'size'          => '8',
                        'description'   => 'px',
                    ),
                    'position_left'    => array(
                        'type'          => 'text',
                        'label'         => __( 'Icon Position Left', 'bb-njba' ),
                        'placeholder'   => __( 'Inherit', 'bb-njba'),
                        'size'          => '8',
                        'description'   => 'px',            
                    ),
                 
                )
            ),
            'input-border-style' => array(
                'title' => __('Input Border Style', 'bb-njba'),
                'fields' => array(
                    'input_border_width'    => array(
                        'type'          => 'text',
                        'label'         => __('Border Width', 'bb-njba'),
                        'placeholder'   => '1',
                        'default'       => '1',
                        'description'   => 'px',
                        'maxlength'     => '2',
                        'size'          => '6',
                    ),
                    
                    'input_border_color'    => array( 
                        'type'       => 'color',
                        'label'         => __('Border Color', 'bb-njba'),
                        'default'       => 'cccccc',
                        'show_reset' => true,
                    ),
            
                    'input_border_radius'    => array(
                        'type'          => 'text',
                        'default'       => '0',
                        'maxlength'     => '3',
                        'size'          => '5',
                        'label'         => __('Round Corners', 'bb-njba'),
                        'description'   => _x( 'px', 'Value unit for border radius. Such as: "5 px"', 'bb-njba' ),
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.njba-contact-form .njba-input-group-wrap input',
                                    'property'      => 'border-radius',
                                    'unit'          => 'px'
                                ),                              
                            ),
                        )
                    ),
                     'border_style'      => array(
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
                    'input_border'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Border', 'bb-njba'),
                         'default'   => array(
                            'top'   => '',
                            'bottom'   => 1,
                            'left'   => '',
                            'right'   => '',
                        ), 
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form.njba-form-style2 .njba-input-group-wrap input',
                                    'property'          => '',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form.njba-form-style2 .njba-input-group-wrap input',
                                    'property'          => '',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form.njba-form-style2 .njba-input-group-wrap input',
                                    'property'          => '',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form.njba-form-style2 .njba-input-group-wrap input',
                                    'property'          => '',
                                ),
                            )
                        )
                    ),
                    'textarea_border'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Textarea Border', 'bb-njba'),
                         'default'   => array(
                            'top'   => 1,
                            'bottom'   => 1,
                            'left'   => 1,
                            'right'   => 1,
                        ), 
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form.njba-form-style2 .njba-input-group-wrap input',
                                    'property'          => '',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form.njba-form-style2 .njba-input-group-wrap input',
                                    'property'          => '',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form.njba-form-style2 .njba-input-group-wrap input',
                                    'property'          => '',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form.njba-form-style2 .njba-input-group-wrap input',
                                    'property'          => '',
                                ),
                            )
                        )
                    ),
                     'border_color'    => array( 
                        'type'       => 'color',
                        'label'         => __('Border Color', 'bb-njba'),
                        'default'       => 'cccccc',
                        'show_reset' => true,
                    ),
            
                    'border_radius'    => array(
                        'type'          => 'text',
                        'default'       => '0',
                        'maxlength'     => '3',
                        'size'          => '5',
                        'label'         => __('Round Corners', 'bb-njba'),
                        'description'   => _x( 'px', 'Value unit for border radius. Such as: "5 px"', 'bb-njba' ),
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.njba-contact-form.njba-form-style2 .njba-input-group-wrap input',
                                    'property'      => 'border-radius',
                                    'unit'          => 'px'
                                ),                              
                            ),
                        )
                    ),
                )
            ),
            'input-fields'       => array(
                'title'         => __('Input Size and Aignment', 'bb-njba'),
                'fields'        => array(
                    'input_text_align'   => array(
                        'type'          => 'select',
                        'label'         => __('Text Alignment', 'bb-njba'),
                        'default'       => 'left',
                        'options'       => array(
                            'left'      => __('Left', 'bb-njba'),
                            'center'    => __('Center', 'bb-njba'),
                            'right'    => __('Right', 'bb-njba'),
                        )
                    ),
                    'msg_height' => array(
                        'type' => 'text',
                        'label' => __('Textarea Height', 'bb-njba'),
                        'placeholder' => '130',
                        'size' => '8',
                        'description' => __('px', 'bb-njba'),
                    ),
                     'input_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                        'default'           => array(
                            'top'          => 16,
                            'bottom'       => 16,
                            'left'         => 15,
                            'right'        => 15,
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form',
                                    'property'          => 'padding-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form',
                                    'property'          => 'padding-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form',
                                    'property'          => 'padding-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form',
                                    'property'          => 'padding-right',
                                ),
                            )
                        )
                    ),                                      
                )
            ),
           
        )
    ),
    'button' => array(
        'title'         => __('Button', 'bb-njba'),
        'sections'      => array(
            'button-style'       => array(
                'title'         => __('Submit Icon Button', 'bb-njba'),
                'fields'        => array(
                    'btn_text'  => array(
                        'type'          => 'text',
                        'label'         => __('Text', 'bb-njba'),
                        'default'       => 'SEND YOUR MESSAGE',
                    ),
                    'buttton_icon_select'       => array(
                        'type'          => 'select',
                        'label'         => __('Icon Type', 'bb-njba'),
                        'default'       => 'none',
                        'options'       => array(
                            'none'              => __('None', 'bb-njba'),
                            'font_icon'         => __('Icon', 'bb-njba'),
                        ),
                        'toggle' => array(
                            'font_icon'    => array(
                                'fields'   => array('button_font_icon','button_icon_aligment','icon_color','icon_margin'),
                                'sections' => array(''),
                            ),
                        
                        )
                    ),
                    'button_font_icon'          => array(
                        'type'          => 'icon',
                        'label'         => __('Icon', 'bb-njba')
                    ),
                    'button_icon_aligment'       => array(
                        'type'          => 'select',
                        'label'         => __('Icon Position', 'bb-njba'),
                        'default'       => 'left',
                        'options'       => array(
                            'left'      => __('Before Text', 'bb-njba'),
                            'right'     => __('After Text', 'bb-njba')
                        ),
                    ),
                    'icon_color' => array( 
                        'type'       => 'color',
                        'label'      => __('Icon Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                     'icon_margin'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Margin', 'bb-njba'),
                         'default'   => array(
                            'top'   => '',
                            'bottom'   => '',
                            'left'   => '',
                            'right'   => 8,
                        ),   
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form-submit i',
                                    'property'          => 'margin-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form-submit i',
                                    'property'          => 'margin-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form-submit i',
                                    'property'          => 'margin-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form-submit i',
                                    'property'          => 'margin-right',
                                ),
                            )
                        )
                    ),
                )
            ),
            'btn-colors'     => array(
                'title'         => __('Button Colors', 'bb-njba'),
                'fields' => array(
                    'btn_text_color'        => array( 
                        'type'       => 'color',
                        'label'      => __('Text Color', 'bb-njba'),
                        'default'    => '969696',
                        'show_reset' => true,
                    ),
                    'btn_text_hover_color'        => array( 
                        'type'       => 'color',
                        'label'      => __('Text Hover Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                        'preview'       => array(
                            'type'          => 'none'
                        )
                    ),
                    'btn_background_color'    => array( 
                        'type'       => 'color',
                        'label'      => __('Background Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'btn_background_hover_color'    => array( 
                        'type'       => 'color',
                        'label'         => __('Background Hover Color', 'bb-njba'),
                        'default'    => '',
                        'show_reset' => true,
                        'preview'       => array(
                            'type'          => 'none'
                        )
                    ),                
                )
            ),
            'btn-structure'  => array(
                'title'         => __('Button Structure', 'bb-njba'),
                'fields'        => array(
                    'btn_align'   => array(
                        'type'          => 'select',
                        'label'         => __('Button Width/Alignment', 'bb-njba'),
                        'default'       => 'left',
                        'options'       => array(
                            'left'      => __('Left', 'bb-njba'),
                            'center'    => __('Center', 'bb-njba'),
                            'right'    => __('Right', 'bb-njba'),
                        )
                    ),
                     'btn_border_width'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Border', 'bb-njba'),
                         'default'   => array(
                            'top'   => 1,
                            'bottom'   => 1,
                            'left'   => 1,
                            'right'   => 1,
                        ), 
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => '',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => '',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => '',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '',
                                    'property'          => '',
                                ),
                            )
                        )
                    ),
                    'btn_border_style'      => array(
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
                    'btn_border_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Border Color', 'bb-njba'),
                        'default'       => 'bababa',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.njba-contact-form .njba-contact-form-submit',
                                    'property'      => 'border-color',
                                ),
           
                            ),
                        )
                    ),
                    'btn_hover_border_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Hover Border Color', 'bb-njba'),
                        'default'       => 'F8F8F8',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'          => 'css',
                            'rules'     => array(
                                array(
                                    'selector'      => '.njba-contact-form .njba-contact-form-submit',
                                    'property'      => 'border-color',
                                ),
           
                            ),
                        )
                    ),                   
                    'btn_radius'      => array(
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
                    'btn_box_shadow'        => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Box Shadow', 'bb-njba'),
                        'options'           => array(
                            'vertical'          => array(
                                'placeholder'       => __('Vertical', 'bb-njba'),
                                'tooltip'           => __('Vertical', 'bb-njba'),
                                'icon'              => 'fa-arrows-v'
                            ),
                            'horizontal'        => array(
                                'placeholder'       => __('Horizontal', 'bb-njba'),
                                'tooltip'           => __('Horizontal', 'bb-njba'),
                                'icon'              => 'fa-arrows-h'
                            ),
                            'blur'              => array(
                                'placeholder'       => __('Blur', 'bb-njba'),
                                'tooltip'           => __('Blur', 'bb-njba'),
                                'icon'              => 'fa-circle-o'
                            ),
                            'spread'            => array(
                                'placeholder'       => __('Spread', 'bb-njba'),
                                'tooltip'           => __('Spread', 'bb-njba'),
                                'icon'              => 'fa-paint-brush'
                            ),
                        )
                    ),
                    'btn_shadow_color' => array(
                        'type'              => 'color',
                        'label'             => __('Shadow Color', 'bb-njba'),
                        'default'           => '000000',
                    ),
                    'btn_padding'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Padding', 'bb-njba'),
                         'default'           => array(
                            'top'          => 12,
                            'bottom'       => 12,
                            'left'         => 24,
                            'right'         => 24,
                        ),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form .njba-contact-form-submit',
                                    'property'          => 'padding-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form .njba-contact-form-submit',
                                    'property'          => 'padding-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form .njba-contact-form-submit',
                                    'property'          => 'padding-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'default'           => '40',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form .njba-contact-form-submit',
                                    'property'          => 'padding-right',
                                ),
                            )
                        )
                    ),
                    'btn_margin'      => array(
                        'type'              => 'njba-multinumber',
                        'label'             => __('Margin', 'bb-njba'),
                        'options'           => array(
                            'top'               => array(
                                'placeholder'       => __('Top', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-up',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form .njba-contact-submit-btn',
                                    'property'          => 'margin-top',
                                ),
                            ),
                            'bottom'            => array(
                                'placeholder'       => __('Bottom', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-down',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form .njba-contact-submit-btn',
                                    'property'          => 'margin-bottom',
                                ),
                            ),
                            'left'            => array(
                                'placeholder'       => __('Left', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-left',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form .njba-contact-submit-btn',
                                    'property'          => 'margin-left',
                                ),
                            ),
                            'right'            => array(
                                'placeholder'       => __('Right', 'bb-njba'),
                                'icon'              => 'fa-long-arrow-right',
                                'description'       => 'px',
                                'preview'           => array(
                                    'selector'          => '.njba-contact-form .njba-contact-submit-btn',
                                    'property'          => 'margin-right',
                                ),
                            )
                        )
                    ),
                )
            ),      
        )
    ),
    'form_typography'       => array( // Tab
        'title'         => __('Typography', 'bb-njba'), // Tab title
        'sections'      => array( // Tab Sections
            'title_typography'       => array( // Section
                'title'         => __('Title', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
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
            'description_typography'    => array(
                'title' => __('Description', 'bb-njba'),
                'fields'    => array(
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
            'label_typography'       => array( // Section
                'title'         => __('Label', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'label_font_family' => array(
                        'type'          => 'font',
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-contact-form label'
                        )
                    ),
                    'label_font_size'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '',
                            'medium' => '',
                            'small' => ''
                        )
                    ),  
                    'label_text_transform'    => array(
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
            'input_typography'       => array( // Section
                'title'         => __('Input', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'input_font_family' => array(
                        'type'          => 'font',
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-contact-form input',
                        )
                    ),
                    'input_font_size'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
                        'default'       => array(
                            'desktop' => '',
                            'medium' => '',
                            'small' => ''
                        )
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
            'button_typography'       => array( // Section
                'title'         => __('Button', 'bb-njba'), // Section Title
                'fields'        => array( // Section Fields
                    'button_font_family' => array(
                        'type'          => 'font',
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 300
                        ),
                        'label'         => __('Font', 'bb-njba'),
                        'preview'         => array(
                            'type'            => 'font',
                            'selector'        => '.njba-contact-form-submit'
                        )
                    ),
                   'button_font_size'   => array(
                        'type'          => 'njba-simplify',
                        'size'          => '5',
                        'label'         => __('Font Size', 'bb-njba'),
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
         
));    