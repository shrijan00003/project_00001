<?php
/**
 * Implements a custom header for my_newsportal.
 * See http://codex.wordpress.org/Custom_Headers
 *
 * @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 */
function my_newsportal_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'my_newsportal_custom_header_args', array(
		'default-image'				=> '',
		'header-text'				=> '',
		'default-text-color'		=> '',
		'width'						=> 1400,
		'height'					=> 400,
		'flex-width'				=> true,
		'flex-height'				=> true,
		'wp-head-callback'			=> '',
		'admin-head-callback'		=> '',
		'video'						=> true,
		'admin-preview-callback'	=> 'my_newsportal_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'my_newsportal_custom_header_setup' );

if ( ! function_exists( 'my_newsportal_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 */
function my_newsportal_admin_header_image() {
?>
	<div id="headimg">
		<?php if ( function_exists( 'the_custom_header_markup' ) ) {
			the_custom_header_markup();
		} else {
			if ( get_header_image() ) : ?>
				<img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>">
			<?php endif;
		} ?>
	</div>
<?php
}
endif; // my_newsportal_admin_header_image