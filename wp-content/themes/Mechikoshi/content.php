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
   <?php if ( has_post_thumbnail() ) { ?>
      <div class="featured-image">
         <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'my_newsportal-featured-image' ); ?></a>
      </div>
   <?php } ?>

   <div class="article-content clearfix">

      <?php if( get_post_format() ) { get_template_part( 'inc/post-formats' ); } ?>

      <?php my_newsportal_colored_category(); ?>

      <header class="entry-header">
         <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><? //php the_title(); ?></a>
         </h2>
      </header>

      <?php my_newsportal_entry_meta(); ?>

      <div class="entry-content clearfix">
         <?php
            the_excerpt();
         ?>
         <a class="more-link" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><span><?php _e( 'Read more', 'my_newsportal' ); ?></span></a>
      </div>

   </div>

   <?php do_action( 'my_newsportal_after_post_content' ); ?>
</article>