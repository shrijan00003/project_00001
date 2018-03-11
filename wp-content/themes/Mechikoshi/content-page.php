<?php
/**
 * The template used for displaying page content in page.php
 *
* @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'my_newsportal_before_post_content' ); ?>
<?php echo "here" ?>
	<header class="entry-header">
      <?php if ( is_front_page() ) : ?>
   		<h2 class="entry-title">
   			<!-- <?php the_title(); ?> -->
   		</h2>
      <?php else : ?>
         <h1 class="entry-title">
            <!-- <?php the_title(); ?> -->
         </h1>
      <?php endif; ?>
	</header>

	<div class="entry-content clearfix">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'my_newsportal' ),
				'after'             => '</div>',
				'link_before'       => '<span>',
				'link_after'        => '</span>'
	      ) );
		?>
	</div>

	<?php do_action( 'my_newsportal_after_post_content' ); ?>
</article>