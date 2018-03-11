<?php
/**
 * Contains all the fucntions and components related to header part.
 *
 * @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */

/****************************************************************************************/

if ( ! function_exists( 'my_newsportal_social_links' ) ) :
/**
 * This function is for social links display on header
 *
 * Get links through Theme Options
 */
function my_newsportal_social_links() {

	$my_newsportal_social_links = array(
		'my_newsportal_social_facebook'		=> __( 'Facebook', 'my_newsportal' ),
		'my_newsportal_social_twitter'		=> __( 'Twitter', 'my_newsportal' ),
		'my_newsportal_social_googleplus'	=> __( 'Google-Plus' , 'my_newsportal' ),
		'my_newsportal_social_instagram'		=> __( 'Instagram', 'my_newsportal' ),
		'my_newsportal_social_pinterest'		=> __( 'Pinterest', 'my_newsportal' ),
		'my_newsportal_social_youtube'		=> __( 'YouTube', 'my_newsportal' )
	);
	?>
	<div class="social-links clearfix">
		<ul>
		<?php
			$i=0;
			$my_newsportal_links_output = '';
			foreach( $my_newsportal_social_links as $key => $value ) {
				$link = get_theme_mod( $key , '' );
				if ( !empty( $link ) ) {
					if ( get_theme_mod( $key.'_checkbox', 0 ) == 1 ) { $new_tab = 'target="_blank"'; } else { $new_tab = ''; }
					$my_newsportal_links_output .=
						'<li><a href="'.esc_url( $link ).'" '.$new_tab.'><i class="fa fa-'.strtolower($value).'"></i></a></li>';
				}
				$i++;
			}
			echo $my_newsportal_links_output;
		?>
		</ul>
	</div><!-- .social-links -->
	<?php
}
endif;

/****************************************************************************************/
// Filter the get_header_image_tag() for option of adding the link back to home page option
function my_newsportal_header_image_markup( $html, $header, $attr ) {
	$output = '';
	$header_image = get_header_image();

	if( ! empty( $header_image ) ) {
		if ( get_theme_mod( 'my_newsportal_header_image_link', 0 ) == 1 ) {
			$output .= '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';
		}

		$output .= '<div class="header-image-wrap"><img src="' . esc_url( $header_image ) . '" class="header-image" width="' . get_custom_header()->width . '" height="' .  get_custom_header()->height . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"></div>';

		if ( get_theme_mod( 'my_newsportal_header_image_link', 0 ) == 1 ) {
			$output .= '</a>';
		}
	}

	return $output;
}

function my_newsportal_header_image_markup_filter() {
	add_filter( 'get_header_image_tag', 'my_newsportal_header_image_markup', 10, 3 );
}

add_action( 'my_newsportal_header_image_markup_render','my_newsportal_header_image_markup_filter' );

/****************************************************************************************/

if ( ! function_exists( 'my_newsportal_render_header_image' ) ) :
/**
 * Shows the small info text on top header part
 */
function my_newsportal_render_header_image() {
	if ( function_exists( 'the_custom_header_markup' ) ) {
		do_action( 'my_newsportal_header_image_markup_render' );
		the_custom_header_markup();
	} else {
		$header_image = get_header_image();
		if( ! empty( $header_image ) ) {
			if ( get_theme_mod( 'my_newsportal_header_image_link', 0 ) == 1 ) { ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<?php } ?>
			<div class="header-image-wrap"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></div>
		<?php
			if ( get_theme_mod( 'my_newsportal_header_image_link', 0 ) == 1 ) { ?>
				</a>
				<?php
			}
		}
	}
}
endif;