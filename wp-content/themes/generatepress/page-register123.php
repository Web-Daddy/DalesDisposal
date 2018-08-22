<?php /* Template Name: Register page */ 
if (class_exists('Profile_Builder_Form_Creator')) {
	$form = new Profile_Builder_Form_Creator( array(
		'form_type' => 'register',
		'form_name' => 'unspecified',
		'role' => get_option( 'default_role' ),
		'redirect_url' => '',//home_url(), 
		'logout_redirect_url' => '',
		'redirect_priority' => 'normal' 
		)
	);
	if (!empty($_POST)) {
		if (isset($_POST['username']) && !empty($_POST['username']) &&
			isset($_POST['passw1']) && !empty($_POST['passw1']) && 
			isset($_POST['email']) && !empty($_POST['email']) && 
			isset($_POST['passw2']) && !empty($_POST['passw2']) && 
			$_POST['passw2'] === $_POST['passw1']) {

			$userdata =  $form->wppb_register_user($_POST, [
				'user_login' => $_POST['username'],
				'first_name' => isset($_POST['first_name']) && !empty($_POST['first_name']) ? $_POST['first_name'] : '',
				'last_name'  => isset($_POST['last_name']) && !empty($_POST['last_name']) ? $_POST['last_name'] : '',
				'user_pass'  => $_POST['passw1'],
				'nickname'   => isset($_POST['nickname']) && !empty($_POST['nickname']) ? $_POST['nickname'] : $_POST['username'],
				'user_email' => $_POST['email'],
			]);
			if (isset($userdata['user_id'])) {
				auto_login_new_user(($userdata['user_id']));
			}
		}
	}
}
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

get_footer();
