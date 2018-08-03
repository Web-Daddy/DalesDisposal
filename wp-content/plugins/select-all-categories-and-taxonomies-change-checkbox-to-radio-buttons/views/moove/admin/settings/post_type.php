<?php foreach ( json_decode( $data['taxonomies'] ) as $taxonomy) : ?>
    <div class="moove-taxonomy-cnt">
        <h4> <?php echo $taxonomy->labels->name; ?> </h4>

        <select name="moove_radioselect[<?php echo sanitize_title( $data['post_type'] );?>][<?php echo $taxonomy->name ?>][select]" id="<?php echo $taxonomy->name ;?>">

            <option value="default" <?php echo isset( $data['options'][ sanitize_title( $data['post_type'] ) ][ $taxonomy->name ]['select']) && $data['options'][ sanitize_title( $data['post_type'] ) ][ $taxonomy->name ]['select'] == 'default' ? ' selected="selected"':''?>>
                <?php _e( 'Default' , 'moove' ); ?>
            </option>

            <option value="radio" <?php echo isset( $data['options'][ sanitize_title( $data['post_type'] ) ][ $taxonomy->name ]['select']) && $data['options'][ sanitize_title( $data['post_type'] ) ][ $taxonomy->name ]['select'] == 'radio' ? ' selected="selected"':''?>>
                <?php _e( 'Radio button' , 'moove' ); ?>
            </option>

            <option value="checkbox" <?php echo isset( $data['options'][ sanitize_title( $data['post_type'] ) ][ $taxonomy->name ]['select']) && $data['options'][ sanitize_title( $data['post_type'] ) ][ $taxonomy->name ]['select'] == 'checkbox' ? ' selected="selected"':''?>>
                <?php _e( 'Checkbox' , 'moove' ); ?>
            </option>

        </select>
        <?php
            $checkbox_class = 'moove-hidden';
            if ( isset( $data['options'][ sanitize_title( $data['post_type'] ) ][ $taxonomy->name ]['select']) ) :
                if ( $data['options'][ sanitize_title( $data['post_type'] ) ][ $taxonomy->name ]['select'] === 'checkbox' ) :
                    $checkbox_class = '';
                endif;
            endif;
        ?>

        <label for="moove_radioselect[<?php echo sanitize_title( $data['post_type'] );?>][<?php echo $taxonomy->name ?>][selectall]" class="moove_select_all_btn <?php echo $checkbox_class; ?>">
            <?php _e( 'Include <span>"Select All"</span> button', 'moove' ); ?>
            <input
                type="checkbox"
                value="on"
                name="moove_radioselect[<?php echo sanitize_title( $data['post_type'] );?>][<?php echo $taxonomy->name; ?>][selectall]"
                id="moove_radioselect[<?php echo sanitize_title( $data['post_type'] );?>][<?php echo $taxonomy->name; ?>][selectall]"
                <?php echo isset( $data['options'][ sanitize_title( $data['post_type'] ) ][ $taxonomy->name ]['selectall']) && $data['options'][ sanitize_title( $data['post_type'] ) ][ $taxonomy->name ]['selectall'] === 'on' ? ' checked="checked"':''?>>
        </label>
    </div>
    <!-- moove-taxonomy-cnt -->
<?php endforeach; ?>
