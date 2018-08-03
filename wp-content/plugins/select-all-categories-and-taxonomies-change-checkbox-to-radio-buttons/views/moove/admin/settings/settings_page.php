<div class="wrap moove-taxonomy-settings-plugin-wrap">
	<h1><?php _e('Taxonomy Buttons - Plugin Settings','moove'); ?></h1>
    <?php
        $current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '';
        if( isset( $current_tab ) &&  $current_tab !== '' ) {
            $active_tab = $current_tab;
        } else {
            $active_tab = "post_type_radioselect";
        } // end if
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=moove-taxonomy-settings&tab=post_type_radioselect" class="nav-tab <?php echo $active_tab == 'post_type_radioselect' ? 'nav-tab-active' : ''; ?>">
            <?php _e('Plugin Settings','moove'); ?>
        </a>

        <a href="?page=moove-taxonomy-settings&tab=plugin_documentation" class="nav-tab <?php echo $active_tab == 'plugin_documentation' ? 'nav-tab-active' : ''; ?>">
            <?php _e('Documentation','moove'); ?>
        </a>
    </h2>
    <div class="moove-form-container <?php echo $active_tab; ?>">
        <a href="http://mooveagency.com" target="blank" title="WordPress agency"><span class="moove-logo"></span></a>
        <?php
        if( $active_tab == 'post_type_radioselect' ) : ?>
            <form action="options.php" method="post" class="moove-taxonomy-settings-form">
                <?php
                settings_fields( 'moove_radio_select' );
                do_settings_sections( 'moove-taxonomy-settings' );
                echo "<hr>";
                submit_button();
                ?>
            </form>
        <?php elseif( $active_tab == 'plugin_documentation' ): ?>
            <?php echo Moove_Radioselect_View::load( 'moove.admin.settings.documentation' , true ); ?>
        <?php endif; ?>
    </div>
    <!-- moove-form-container -->
</div>
<!-- wrap -->