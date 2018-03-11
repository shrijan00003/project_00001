<?php
/**
 * The template for displaying Archive page.
 *
* @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */

get_header(); ?>

	<?php do_action( 'my_newsportal_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
               <?php if ( is_category() ) {
                  do_action('my_newsportal_category_title');
                  single_cat_title();
                  } else { ?>
					<h1 class="page-title">
               <span>
						<?php
							if ( is_tag() ) :
								single_tag_title();

							elseif ( is_author() ) :
								/* Queue the first post, that way we know
								 * what author we're dealing with (if that is the case).
								*/
								the_post();
								printf( __( 'Author: %s', 'my_newsportal' ), '<span class="vcard">' . get_the_author() . '</span>' );
								/* Since we called the_post() above, we need to
								 * rewind the loop back to the beginning that way
								 * we can run the loop properly, in full.
								 */
								rewind_posts();

							elseif ( is_day() ) :
								printf( __( 'Day: %s', 'my_newsportal' ), '<span>' . get_the_date() . '</span>' );

							elseif ( is_month() ) :
								printf( __( 'Month: %s', 'my_newsportal' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

							elseif ( is_year() ) :
								printf( __( 'Year: %s', 'my_newsportal' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

							elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
								_e( 'Asides', 'my_newsportal' );

							elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
								_e( 'Images', 'my_newsportal');

							elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
								_e( 'Videos', 'my_newsportal' );

							elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
								_e( 'Quotes', 'my_newsportal' );

							elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
								_e( 'Links', 'my_newsportal' );

							elseif ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) :
									woocommerce_page_title( false );

							else :
								_e( 'Archives', 'my_newsportal' );

							endif;
						?>
					</span></h1>
                  <?php } ?>
					<?php
						// Show an optional term description.
						$term_description = term_description();
						if ( ! empty( $term_description ) ) :
							printf( '<div class="taxonomy-description">%s</div>', $term_description );
						endif;
					?>
				</header><!-- .page-header -->

            <div class="article-container">

   				<?php global $post_i; $post_i = 1; ?>

   				<?php while ( have_posts() ) : the_post(); ?>

   					<?php get_template_part( 'content', 'archive' ); ?>

   				<?php endwhile; ?>

            </div>

				<?php get_template_part( 'navigation', 'archive' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'archive' ); ?>

			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

	<?php my_newsportal_sidebar_select(); ?>

	<?php do_action( 'my_newsportal_after_body_content' ); ?>

<?php get_footer(); ?>