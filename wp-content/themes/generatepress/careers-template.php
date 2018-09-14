<?php /* Template Name: Careers */ ?>
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header(); ?>

	<div id="primary" <?php generate_content_class();?>>
		<main id="main" <?php generate_main_class(); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			while ( have_posts() ) : the_post();

				get_template_part( 'content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || '0' != get_comments_number() ) : ?>

					<div class="comments-area">
						<?php comments_template(); ?>
					</div>

				<?php endif;

			endwhile;

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();
	?>
	<div class="container careers">
		<div class="fl-col fl-node-5b422736aa630 fl-col-small"></div>
		<?php 
		file_upload_email_function();
		$check_email = file_upload_email_function();
		if (is_a($check_email, "WP_Error") && $check_email->get_error_code()) { ?>
			<div class="error-box bd-callout bd-callout-warning">
				<?php foreach( $check_email->get_error_messages() as $error ){
					echo '<div class="alert alert-danger"><strong>Error</strong>: '. $error .'</div>';
				} ?>
			</div>

		<?php } ?>
		<form method="POST" class="email_fails" name="email_form_with_php" enctype="multipart/form-data">
			<!-- <label for='uploaded_file'>Select A File To Upload:</label> -->
			<label class="optimization_btn">
				<button class="btn" type="button">Upload a resume</button>
				<input id="file_for_upload_email" type="file" name="uploaded_file">
			</label>

			<input type="submit" value="Submit" name='submit'>
		</form>
		<div class="fl-col fl-node-5b422736aa630 fl-col-small"></div>
		<div class="dales_upload_file_name_container"><p class="dales_upload_file_name"></p></div>
	</div>
<?php get_footer(); ?>