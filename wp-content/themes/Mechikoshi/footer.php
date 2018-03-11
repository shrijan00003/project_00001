<?php
/**
 * Theme Footer Section for our theme.
 *
 * Displays all of the footer section and closing of the #main div.
 *
 * @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */
?>

		</div><!-- .inner-wrap -->
	</div><!-- #main -->
   <?php if ( is_active_sidebar('my_newsportal_advertisement_above_the_footer_sidebar') ) { ?>
      <div class="advertisement_above_footer">
         <div class="inner-wrap">
            <?php dynamic_sidebar('my_newsportal_advertisement_above_the_footer_sidebar'); ?>
         </div>
      </div>
   <?php } ?>
	<?php do_action( 'my_newsportal_before_footer' ); ?>
		<footer id="colophon" class="clearfix">
			
			<div class="footer-socket-wrapper clearfix">
				<div class="inner-wrap">
						<div class="footer-socket-area">
							<?php get_sidebar( 'footer' ); ?>
		                  <div class="footer-socket-right-section">
		   						<?php if( get_theme_mod( 'my_newsportal_social_link_activate', 0 ) == 1 ) { my_newsportal_social_links(); } ?>
		                  </div>
                  			<hr style="background: gray;width:100%;height:1px;margin:auto;"/>
		                  <div class="footer-socket-left-sectoin">
		   						<?php do_action( 'my_newsportal_footer_copyright' ); ?>
		                  </div>
					</div>
				</div>
			</div>
		</footer>
		<a href="#masthead" id="scroll-up"><i class="fa fa-chevron-up"></i></a>
	</div><!-- #page -->
	<?php wp_footer(); ?>
</body>
</html>