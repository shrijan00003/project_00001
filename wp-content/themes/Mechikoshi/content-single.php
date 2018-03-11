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
   <?php
      $image_popup_id = get_post_thumbnail_id();
      $image_popup_url = wp_get_attachment_url( $image_popup_id );
   ?>

   

   <div class="article-content clearfix">

   <?php if( get_post_format() ) { get_template_part( 'inc/post-formats' ); } ?>

   <?php my_newsportal_colored_category(); ?>

      <header class="entry-header">
         <h1 class="entry-title" style="font-size:40px;">
            <?php the_title(); ?>
         </h1>
      </header>

        <hr style="margin-bottom:0px;">
      <?php 

            echo do_shortcode( '[mashshare]' );//this is for mashshare plugin coded manually 
        
            my_newsportal_entry_meta();
         ?>
    
        <hr style="margin-top:0px;">
        
<!--this code originall above article content class-->
      <?php if ( has_post_thumbnail() ) { ?>
      <div class="featured-image">
      <?php if (get_theme_mod('my_newsportal_featured_image_popup', 0) == 1) { ?>
         <a href="<?php echo $image_popup_url; ?>" class="image-popup"><?php the_post_thumbnail( 'my_newsportal-featured-image' ); ?></a>
      <?php } else { ?>
         <?php the_post_thumbnail( 'my_newsportal-featured-image' ); ?>
      <?php } ?>
      </div>
   <?php } ?>

      <div class="entry-content clearfix">
         <?php
            the_content();

            wp_link_pages( array(
               'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'my_newsportal' ),
               'after'             => '</div>',
               'link_before'       => '<span>',
               'link_after'        => '</span>'
            ) );
         ?>
      </div>

   </div><hr>

   <?php do_action( 'my_newsportal_after_post_content' ); ?>

</article>
