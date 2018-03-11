<?php
/**
 * Template Name: Contact Page Template
 *
 * Displays the Contact Page Template of the theme.
 *
* @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */
?>

<?php get_header(); ?>

	<?php do_action( 'my_newsportal_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

	<?php my_newsportal_sidebar_select(); ?>

	<?php do_action( 'my_newsportal_after_body_content' ); ?>

<?php get_footer(); ?>