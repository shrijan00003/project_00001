<?php
/**
 * The left sidebar widget area.
 *
 * @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */
?>

<div id="secondary">
	<?php do_action( 'my_newsportal_before_sidebar' ); ?>
		<?php
			if( is_page_template( 'page-templates/contact.php' ) ) {
				$sidebar = 'my_newsportal_contact_page_sidebar';
			}
			else {
				$sidebar = 'my_newsportal_left_sidebar';
			}
		?>

		<?php if ( ! dynamic_sidebar( $sidebar ) ) :
         if ( $sidebar == 'my_newsportal_contact_page_sidebar' ) {
            $sidebar_display = __('Contact Page', 'my_newsportal');
         } else {
            $sidebar_display = __('Left', 'my_newsportal');
         }
         the_widget( 'WP_Widget_Text',
            array(
               'title'  => __( 'Example Widget', 'my_newsportal' ),
               'text'   => sprintf( __( 'This is an example widget to show how the %s Sidebar looks by default. You can add custom widgets from the %swidgets screen%s in the admin. If custom widgets are added then this will be replaced by those widgets.', 'my_newsportal' ), $sidebar_display, current_user_can( 'edit_theme_options' ) ? '<a href="' . admin_url( 'widgets.php' ) . '">' : '', current_user_can( 'edit_theme_options' ) ? '</a>' : '' ),
               'filter' => true,
            ),
            array(
               'before_widget' => '<aside class="widget widget_text clearfix">',
               'after_widget'  => '</aside>',
               'before_title'  => '<h3 class="widget-title"><span>',
               'after_title'   => '</span></h3>'
            )
         );
      endif; ?>

	<?php do_action( 'my_newsportal_after_sidebar' ); ?>
</div>