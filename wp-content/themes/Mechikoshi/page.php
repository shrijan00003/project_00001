<?php
/**
 * Theme Page Section for our theme.
 *
 * @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */
get_header(); ?>

	<?php do_action( 'my_newsportal_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					do_action( 'my_newsportal_before_comments_template' );
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
	      		do_action ( 'my_newsportal_after_comments_template' );
				?>

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

	<?php my_newsportal_sidebar_select(); ?>

	<?php do_action( 'my_newsportal_after_body_content' ); ?>

<?php get_footer(); ?>