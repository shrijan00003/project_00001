<?php
/**
 * my_newsportal functions and definitions
 *
 * This file contains all the functions and it's defination that particularly can't be
 * in other files.
 *
 * @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */

/****************************************************************************************/

add_action( 'wp_enqueue_scripts', 'my_newsportal_scripts_styles_method' );
/**
 * Register jquery scripts
 */
function my_newsportal_scripts_styles_method() {
   /**
   * Using google font
   */
   wp_enqueue_style( 'my_newsportal_google_fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,600' );

   /**
	* Loads our main stylesheet.
	*/
	wp_enqueue_style( 'my_newsportal_style', get_stylesheet_uri() );

	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

   /**
    * Register bxSlider js file for slider.
    */
   wp_register_script( 'my_newsportal-bxslider', my_newsportal_JS_URL . '/jquery.bxslider.min.js', array( 'jquery' ), '4.2.10', true );

	/**
	 * Enqueue Slider setup js file.
	 */
	wp_enqueue_script( 'my_newsportal_slider', my_newsportal_JS_URL . '/my_newsportal-slider-setting.js', array( 'my_newsportal-bxslider' ), false, true );

	wp_enqueue_script( 'my_newsportal-navigation', my_newsportal_JS_URL . '/navigation.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'my_newsportal-custom', my_newsportal_JS_URL. '/my_newsportal-custom.js', array( 'jquery' ) );

	wp_enqueue_style( 'my_newsportal-fontawesome', get_template_directory_uri().'/fontawesome/css/font-awesome.css', array(), '4.2.1' );

   if (get_theme_mod('my_newsportal_breaking_news', 0) == 1) {
      wp_enqueue_script( 'my_newsportal-news-ticker', my_newsportal_JS_URL. '/news-ticker/jquery.newsTicker.min.js', array( 'jquery' ), '1.0.0', true );

      wp_enqueue_script( 'my_newsportal-news-ticker-setting', my_newsportal_JS_URL. '/news-ticker/ticker-setting.js', array( 'my_newsportal-news-ticker' ), '20150304', true );
   }

   if (get_theme_mod('my_newsportal_primary_sticky_menu', 0) == 1) {
      wp_enqueue_script( 'my_newsportal-sticky-menu', my_newsportal_JS_URL. '/sticky/jquery.sticky.js', array( 'jquery' ), '20150309', true );

      wp_enqueue_script( 'my_newsportal-sticky-menu-setting', my_newsportal_JS_URL. '/sticky/sticky-setting.js', array( 'my_newsportal-sticky-menu' ), '20150309', true );
   }

   if (get_theme_mod('my_newsportal_featured_image_popup', 0) == 1) {
      wp_enqueue_script( 'my_newsportal-featured-image-popup', my_newsportal_JS_URL. '/magnific-popup/jquery.magnific-popup.min.js', array( 'jquery' ), '20150310', true );
      wp_enqueue_style( 'my_newsportal-featured-image-popup-css', my_newsportal_JS_URL.'/magnific-popup/magnific-popup.css', array(), '20150310' );
      wp_enqueue_script( 'my_newsportal-featured-image-popup-setting', my_newsportal_JS_URL. '/magnific-popup/image-popup-setting.js', array( 'jquery' ), '20150310', true );
   }

   wp_enqueue_script( 'my_newsportal-fitvids', my_newsportal_JS_URL. '/fitvids/jquery.fitvids.js', array( 'jquery' ), '20150311', true );

   wp_enqueue_script( 'my_newsportal-fitvids-setting', my_newsportal_JS_URL. '/fitvids/fitvids-setting.js', array( 'my_newsportal-fitvids' ), '20150311', true );

   if( get_post_format() || is_archive() || is_search() ) {
      wp_enqueue_script( 'my_newsportal-postformat-setting', my_newsportal_JS_URL. '/post-format.js', array( 'jquery' ), '20150422', true );
   }

	wp_enqueue_script( 'html5', my_newsportal_JS_URL . '/html5shiv.min.js', true );
	wp_script_add_data( 'html5', 'conditional', 'lte IE 8' );

}

add_action('admin_enqueue_scripts', 'my_newsportal_image_uploader');
function my_newsportal_image_uploader() {
    wp_enqueue_media();
    wp_enqueue_script('my_newsportal-widget-image-upload', my_newsportal_JS_URL . '/image-uploader.js', false, '20150309', true);
}

/****************************************************************************************/

add_filter( 'excerpt_length', 'my_newsportal_excerpt_length' );
/**
 * Sets the post excerpt length to 40 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function my_newsportal_excerpt_length( $length ) {
	return 60;
}

add_filter( 'excerpt_more', 'my_newsportal_continue_reading' );
/**
 * Returns a "Continue Reading" link for excerpts
 */
function my_newsportal_continue_reading() {
	return '';
}

/****************************************************************************************/

/**
 * Removing the default style of wordpress gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Filtering the size to be full from thumbnail to be used in WordPress gallery as a default size
 */
function my_newsportal_gallery_atts( $out, $pairs, $atts ) {
	$atts = shortcode_atts( array(
	'size' => 'my_newsportal-featured-image',
	), $atts );

	$out['size'] = $atts['size'];

	return $out;

}
add_filter( 'shortcode_atts_gallery', 'my_newsportal_gallery_atts', 10, 3 );

/****************************************************************************************/

add_filter( 'body_class', 'my_newsportal_body_class' );
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function my_newsportal_body_class( $classes ) {
	global $post;

	if( $post ) { $layout_meta = get_post_meta( $post->ID, 'my_newsportal_page_layout', true ); }

	if( is_home() ) {
		$queried_id = get_option( 'page_for_posts' );
		$layout_meta = get_post_meta( $queried_id, 'my_newsportal_page_layout', true );
	}
	if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
	$my_newsportal_default_layout = get_theme_mod( 'my_newsportal_default_layout', 'right_sidebar' );

	$my_newsportal_default_page_layout = get_theme_mod( 'my_newsportal_default_page_layout', 'right_sidebar' );
	$my_newsportal_default_post_layout = get_theme_mod( 'my_newsportal_default_single_posts_layout', 'right_sidebar' );

	if( $layout_meta == 'default_layout' ) {
		if( is_page() ) {
			if( $my_newsportal_default_page_layout == 'right_sidebar' ) { $classes[] = ''; }
			elseif( $my_newsportal_default_page_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
			elseif( $my_newsportal_default_page_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
			elseif( $my_newsportal_default_page_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
		}
		elseif( is_single() ) {
			if( $my_newsportal_default_post_layout == 'right_sidebar' ) { $classes[] = ''; }
			elseif( $my_newsportal_default_post_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
			elseif( $my_newsportal_default_post_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
			elseif( $my_newsportal_default_post_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
		}
		elseif( $my_newsportal_default_layout == 'right_sidebar' ) { $classes[] = ''; }
		elseif( $my_newsportal_default_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
		elseif( $my_newsportal_default_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
		elseif( $my_newsportal_default_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
	}
	elseif( $layout_meta == 'right_sidebar' ) { $classes[] = ''; }
	elseif( $layout_meta == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
	elseif( $layout_meta == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
	elseif( $layout_meta == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }

	if( get_theme_mod( 'my_newsportal_site_layout', 'wide_layout' ) == 'wide_layout' ) {
		$classes[] = 'wide';
	}
	elseif( get_theme_mod( 'my_newsportal_site_layout', 'wide_layout' ) == 'boxed_layout' ) {
		$classes[] = '';
	}

	if ( get_theme_mod( 'my_newsportal_responsive_menu', 0 ) == 1 ) {
		$classes[] = 'better-responsive-menu';
	}

	return $classes;
}

/****************************************************************************************/

if ( ! function_exists( 'my_newsportal_sidebar_select' ) ) :
/**
 * Function to select the sidebar
 */
function my_newsportal_sidebar_select() {
	global $post;

	if( $post ) { $layout_meta = get_post_meta( $post->ID, 'my_newsportal_page_layout', true ); }

	if( is_home() ) {
		$queried_id = get_option( 'page_for_posts' );
		$layout_meta = get_post_meta( $queried_id, 'my_newsportal_page_layout', true );
	}

	if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
	$my_newsportal_default_layout = get_theme_mod( 'my_newsportal_default_layout', 'right_sidebar' );

   $my_newsportal_default_page_layout = get_theme_mod( 'my_newsportal_default_page_layout', 'right_sidebar' );
   $my_newsportal_default_post_layout = get_theme_mod( 'my_newsportal_default_single_posts_layout', 'right_sidebar' );

	if( $layout_meta == 'default_layout' ) {
		if( is_page() ) {
			if( $my_newsportal_default_page_layout == 'right_sidebar' ) { get_sidebar(); }
			elseif ( $my_newsportal_default_page_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
		}
		if( is_single() ) {
			if( $my_newsportal_default_post_layout == 'right_sidebar' ) { get_sidebar(); }
			elseif ( $my_newsportal_default_post_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
		}
		elseif( $my_newsportal_default_layout == 'right_sidebar' ) { get_sidebar(); }
		elseif ( $my_newsportal_default_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
	}
	elseif( $layout_meta == 'right_sidebar' ) { get_sidebar(); }
	elseif( $layout_meta == 'left_sidebar' ) { get_sidebar( 'left' ); }
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'my_newsportal_entry_meta' ) ) :
/**
 * Shows meta information of post.
 */
function my_newsportal_entry_meta() {
   if ( 'post' == get_post_type() ) :
   	echo '<div class="below-entry-meta">';
   	?>

      <?php
      $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
      if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
         $time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
      }
      $time_string = sprintf( $time_string,
         esc_attr( get_the_date( 'c' ) ),
         esc_html( get_the_date() ),
         esc_attr( get_the_modified_date( 'c' ) ),
         esc_html( get_the_modified_date() )
      );
   	printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"><i class="fa fa-calendar-o"></i> %3$s</a></span>', 'my_newsportal' ),
   		esc_url( get_permalink() ),
   		esc_attr( get_the_time() ),
   		$time_string
   	); ?>

      <span class="byline"><span class="author vcard"><i class="fa fa-user"></i><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo get_the_author(); ?>"><?php echo esc_html( get_the_author() ); ?></a></span></span>

      <?php
      if ( ! post_password_required() && comments_open() ) { ?>
         <span class="comments"><?php comments_popup_link( __( '<i class="fa fa-comment"></i> 0 Comments', 'my_newsportal' ), __( '<i class="fa fa-comment"></i> 1 Comment', 'my_newsportal' ), __( '<i class="fa fa-comments"></i> % Comments', 'my_newsportal' ) ); ?></span>
      <?php }
   	$tags_list = get_the_tag_list( '<span class="tag-links"><i class="fa fa-tags"></i>', __( ', ', 'my_newsportal' ), '</span>' );
   	if ( $tags_list ) echo $tags_list;

   	edit_post_link( __( 'Edit', 'my_newsportal' ), '<span class="edit-link"><i class="fa fa-edit"></i>', '</span>' );

   	echo '</div>';
   endif;
}
endif;

/****************************************************************************************/

add_action( 'admin_head', 'my_newsportal_favicon' );
add_action( 'wp_head', 'my_newsportal_favicon' );
/**
 * Favicon for the site
 */
function my_newsportal_favicon() {
	if ( get_theme_mod( 'my_newsportal_favicon_show', '0' ) == '1' ) {
		$my_newsportal_favicon = get_theme_mod( 'my_newsportal_favicon_upload', '' );
		$my_newsportal_favicon_output = '';
		if ( ! function_exists( 'has_site_icon' ) || ( ! empty( $my_newsportal_favicon ) && ! has_site_icon() ) ) {
			$my_newsportal_favicon_output .= '<link rel="shortcut icon" href="'.esc_url( $my_newsportal_favicon ).'" type="image/x-icon" />';
		}
		echo $my_newsportal_favicon_output;
	}
}

/****************************************************************************************/

/**
 * Generate darker color
 * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function my_newsportal_darkcolor( $hex, $steps ) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max( -255, min( 255, $steps ) );

	// Normalize into a six character long hex string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Split into three parts: R, G and B
	$color_parts = str_split( $hex, 2 );
	$return = '#';

	foreach ( $color_parts as $color ) {
		$color   = hexdec( $color ); // Convert to decimal
		$color   = max( 0, min( 255, $color + $steps ) ); // Adjust color
		$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
	}

	return $return;
}

/****************************************************************************************/

add_action('wp_head', 'my_newsportal_custom_css', 100);
/**
 * Hooks the Custom Internal CSS to head section
 */
function my_newsportal_custom_css() {
	$my_newsportal_internal_css = '';
	$primary_color = get_theme_mod( 'my_newsportal_primary_color', '#289dcc' );
	$primary_dark    = my_newsportal_darkcolor( $primary_color, -30 );
	if( $primary_color != '#289dcc' ) {
		$my_newsportal_internal_css .= ' .my_newsportal-button,blockquote,button,input[type=reset],input[type=button],input[type=submit]{background-color:'.$primary_color.'}#site-title a,.next a:hover,.previous a:hover,.social-links i.fa:hover,a{color:'.$primary_color.'}.fa.search-top:hover{background-color:'.$primary_color.'}#site-navigation{border-top:4px solid '.$primary_color.'}.home-icon.front_page_on,.main-navigation a:hover,.main-navigation ul li ul li a:hover,.main-navigation ul li ul li:hover>a,.main-navigation ul li.current-menu-ancestor>a,.main-navigation ul li.current-menu-item ul li a:hover,.main-navigation ul li.current-menu-item>a,.main-navigation ul li.current_page_ancestor>a,.main-navigation ul li.current_page_item>a,.main-navigation ul li:hover>a,.main-small-navigation li a:hover,.site-header .menu-toggle:hover{background-color:'.$primary_color.'}.main-small-navigation .current-menu-item>a,.main-small-navigation .current_page_item>a{background:'.$primary_color.'}.promo-button-area a:hover{border:2px solid '.$primary_color.';background-color:'.$primary_color.'}#content .wp-pagenavi .current,#content .wp-pagenavi a:hover,.format-link .entry-content a,.pagination span{background-color:'.$primary_color.'}.pagination a span:hover{color:'.$primary_color.';border-color:'.$primary_color.'}#content .comments-area a.comment-edit-link:hover,#content .comments-area a.comment-permalink:hover,#content .comments-area article header cite a:hover,.comments-area .comment-author-link a:hover{color:'.$primary_color.'}.comments-area .comment-author-link span{background-color:'.$primary_color.'}.comment .comment-reply-link:hover,.nav-next a,.nav-previous a{color:'.$primary_color.'}#secondary .widget-title{border-bottom:2px solid '.$primary_color.'}#secondary .widget-title span{background-color:'.$primary_color.'}.footer-widgets-area .widget-title{border-bottom:2px solid '.$primary_color.'}.footer-widgets-area .widget-title span{background-color:'.$primary_color.'}.footer-widgets-area a:hover{color:'.$primary_color.'}.advertisement_above_footer .widget-title{border-bottom:2px solid '.$primary_color.'}.advertisement_above_footer .widget-title span{background-color:'.$primary_color.'}a#scroll-up i{color:'.$primary_color.'}.page-header .page-title{border-bottom:2px solid '.$primary_color.'}#content .post .article-content .above-entry-meta .cat-links a,.page-header .page-title span{background-color:'.$primary_color.'}#content .post .article-content .entry-title a:hover,.entry-meta .byline i,.entry-meta .cat-links i,.entry-meta a,.post .entry-title a:hover,.search .entry-title a:hover{color:'.$primary_color.'}.entry-meta .post-format i{background-color:'.$primary_color.'}.entry-meta .comments-link a:hover,.entry-meta .edit-link a:hover,.entry-meta .posted-on a:hover,.entry-meta .tag-links a:hover,.single #content .tags a:hover{color:'.$primary_color.'}.more-link,.no-post-thumbnail{background-color:'.$primary_color.'}.post-box .entry-meta .cat-links a:hover,.post-box .entry-meta .posted-on a:hover,.post.post-box .entry-title a:hover{color:'.$primary_color.'}.widget_featured_slider .slide-content .above-entry-meta .cat-links a{background-color:'.$primary_color.'}.widget_featured_slider .slide-content .below-entry-meta .byline a:hover,.widget_featured_slider .slide-content .below-entry-meta .comments a:hover,.widget_featured_slider .slide-content .below-entry-meta .posted-on a:hover,.widget_featured_slider .slide-content .entry-title a:hover{color:'.$primary_color.'}.widget_highlighted_posts .article-content .above-entry-meta .cat-links a{background-color:'.$primary_color.'}.byline a:hover,.comments a:hover,.edit-link a:hover,.posted-on a:hover,.tag-links a:hover,.widget_highlighted_posts .article-content .below-entry-meta .byline a:hover,.widget_highlighted_posts .article-content .below-entry-meta .comments a:hover,.widget_highlighted_posts .article-content .below-entry-meta .posted-on a:hover,.widget_highlighted_posts .article-content .entry-title a:hover{color:'.$primary_color.'}.widget_featured_posts .article-content .above-entry-meta .cat-links a{background-color:'.$primary_color.'}.widget_featured_posts .article-content .entry-title a:hover{color:'.$primary_color.'}.widget_featured_posts .widget-title{border-bottom:2px solid '.$primary_color.'}.widget_featured_posts .widget-title span{background-color:'.$primary_color.'}.related-posts-main-title .fa,.single-related-posts .article-content .entry-title a:hover{color:'.$primary_color.'}@media (max-width: 768px) {.better-responsive-menu .sub-toggle{background-color:'.$primary_dark.'}}';
	}

	if( !empty( $my_newsportal_internal_css ) ) {
		echo '<!-- '.get_bloginfo('name').' Internal Styles -->';
		?><style type="text/css"><?php echo $my_newsportal_internal_css; ?></style>
<?php
	}

	$my_newsportal_custom_css = get_theme_mod( 'my_newsportal_custom_css' );
	if ( $my_newsportal_custom_css && ! function_exists( 'wp_update_custom_css_post' ) ) {
		echo '<!-- '.get_bloginfo('name').' Custom Styles -->';
		?><style type="text/css"><?php echo $my_newsportal_custom_css; ?></style><?php
	}
}

/**************************************************************************************/

add_filter('the_content_more_link', 'my_newsportal_remove_more_jump_link');
/**
 * Removing the more link jumping to middle of content
 */
function my_newsportal_remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}

/**************************************************************************************/

if ( ! function_exists( 'my_newsportal_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function my_newsportal_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h3 class="screen-reader-text"><?php _e( 'Post navigation', 'my_newsportal' ); ?></h3>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'my_newsportal' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'my_newsportal' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'my_newsportal' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'my_newsportal' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // my_newsportal_content_nav

/**************************************************************************************/

if ( ! function_exists( 'my_newsportal_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function my_newsportal_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'my_newsportal' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'my_newsportal' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 74 );
					printf( '<div class="comment-author-link"><i class="fa fa-user"></i>%1$s%2$s</div>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'my_newsportal' ) . '</span>' : ''
					);
					printf( '<div class="comment-date-time"><i class="fa fa-calendar-o"></i>%1$s</div>',
						sprintf( __( '%1$s at %2$s', 'my_newsportal' ), get_comment_date(), get_comment_time() )
					);
					printf( '<a class="comment-permalink" href="%1$s"><i class="fa fa-link"></i>Permalink</a>', esc_url( get_comment_link( $comment->comment_ID ) ) );
					edit_comment_link();
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'my_newsportal' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'my_newsportal' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</section><!-- .comment-content -->

		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

/**************************************************************************************/

add_action( 'my_newsportal_footer_copyright', 'my_newsportal_footer_copyright', 10 );
/**
 * function to show the footer info, copyright information
 */
if ( ! function_exists( 'my_newsportal_footer_copyright' ) ) :
function my_newsportal_footer_copyright() {
   $site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';

   //$wp_link = '<a href="https://wordpress.org" target="_blank" title="' . esc_attr__( 'WordPress', 'my_newsportal' ) . '"><span>' . __( 'WordPress', 'my_newsportal' ) . '</span></a>';

   //$tg_link =  '<a href="https://themegrill.com/themes/my_newsportal" target="_blank" title="'.esc_attr__( 'ThemeGrill', 'my_newsportal' ).'" rel="designer"><span>'.__( 'ThemeGrill', 'my_newsportal') .'</span></a>';

   $default_footer_value = sprintf( __( 'Copyright &copy; %1$s %2$s. All rights reserved.', 'my_newsportal' ), date( 'Y' ), $site_link ).'<br> Designed and Developed By '.'<a target="_blank" href="https://www.facebook.com/helloworldh">&nbsp;&nbsp;Team HelloWorld';//.sprintf( __( 'Theme: %1$s by %2$s.', 'my_newsportal' ), 'my_newsportal', $tg_link ).' '.sprintf( __( 'Powered by %s.', 'my_newsportal' ), $wp_link );

   $my_newsportal_footer_copyright = '<div class="">'.$default_footer_value.'</div>';
   echo $my_newsportal_footer_copyright;
}
endif;

/**************************************************************************************/

/*
 * Category Color Options
 */
if ( ! function_exists( 'my_newsportal_category_color' ) ) :
function my_newsportal_category_color( $wp_category_id ) {
   $args = array(
      'orderby' => 'id',
      'hide_empty' => 0
   );
   $category = get_categories( $args );
   foreach ($category as $category_list ) {
      $color = get_theme_mod('my_newsportal_category_color_'.$wp_category_id);
      return $color;
   }
}
endif;

/**************************************************************************************/

/*
 * Breaking News/Latest Posts ticker section in the header
 */
if ( ! function_exists( 'my_newsportal_breaking_news' ) ) :
function my_newsportal_breaking_news() {
   $post_status = 'publish';
   if( get_option( 'fresh_site') == 1 ){
  		$post_status = array( 'auto-draft', 'publish' );
   }

   $get_featured_posts = new WP_Query( array(
      'posts_per_page'        => 5,
      'post_type'             => 'post',
      'ignore_sticky_posts'   => true,
      'post_status'   => $post_status
   ) );
?>
   <div class="breaking-news">
   	<span style="padding: 14px;">
      <strong class="breaking-news-latest" style="color:yellow;"><?php _e( 'भर्खरै :', 'my_newsportal' ); ?></strong>
     </span>
      <ul class="newsticker">
      <?php while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post(); ?>
         <li>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
         </li>
      <?php endwhile; ?>
      </ul>
   </div>
   <?php
   // Reset Post Data
   wp_reset_query();
}
endif;

/**************************************************************************************/

/*
 * Display the date in the header
 */
if ( ! function_exists( 'my_newsportal_date_display' ) ) :
function my_newsportal_date_display() { ?>
	<div class="date-in-header">
		<?php
		if (get_theme_mod('my_newsportal_date_display_type', 'theme_default') == 'theme_default') {
			echo "&nbsp;| ".date_i18n('l, F j, Y');
		} elseif (get_theme_mod('my_newsportal_date_display_type', 'theme_default') == 'wordpress_date_setting') {
			echo " | ".date_i18n(get_option('date_format'));
		}
		?>
	</div>
<?php
}
endif;

/**************************************************************************************/

/*
 * Random Post in header
 */
if ( ! function_exists( 'my_newsportal_random_post' ) ) :
function my_newsportal_random_post() {
   $get_random_post = new WP_Query( array(
      'posts_per_page'        => 1,
      'post_type'             => 'post',
      'ignore_sticky_posts'   => true,
      'orderby'               => 'rand'
   ) );
?>
   <div class="random-post">
      <?php while( $get_random_post->have_posts() ):$get_random_post->the_post(); ?>
         <a href="<?php the_permalink(); ?>" title="<?php _e( 'View a random post', 'my_newsportal' ); ?>"><i class="fa fa-random"></i></a>
      <?php endwhile; ?>
   </div>
   <?php
   // Reset Post Data
   wp_reset_query();
}
endif;

/**************************************************************************************/

/*
 * Display the related posts
 */
if ( ! function_exists( 'my_newsportal_related_posts_function' ) ) {

   function my_newsportal_related_posts_function() {
      wp_reset_postdata();
      global $post;

      // Define shared post arguments
      $args = array(
         'no_found_rows'            => true,
         'update_post_meta_cache'   => false,
         'update_post_term_cache'   => false,
         'ignore_sticky_posts'      => 1,
         'orderby'               => 'rand',
         'post__not_in'          => array($post->ID),
         'posts_per_page'        => 3
      );
      // Related by categories
      if ( get_theme_mod('my_newsportal_related_posts', 'categories') == 'categories' ) {

         $cats = get_post_meta($post->ID, 'related-posts', true);

         if ( !$cats ) {
            $cats = wp_get_post_categories($post->ID, array('fields'=>'ids'));
            $args['category__in'] = $cats;
         } else {
            $args['cat'] = $cats;
         }
      }
      // Related by tags
      if ( get_theme_mod('my_newsportal_related_posts', 'categories') == 'tags' ) {

         $tags = get_post_meta($post->ID, 'related-posts', true);

         if ( !$tags ) {
            $tags = wp_get_post_tags($post->ID, array('fields'=>'ids'));
            $args['tag__in'] = $tags;
         } else {
            $args['tag_slug__in'] = explode(',', $tags);
         }
         if ( !$tags ) { $break = true; }
      }

      $query = !isset($break)?new WP_Query($args):new WP_Query;
      return $query;
   }

}

/**************************************************************************************/

/*
 * Category Color for widgets and other
 */
if ( !function_exists('my_newsportal_colored_category') ) :
   function my_newsportal_colored_category() {
      global $post;
      $categories = get_the_category();
      $separator = '&nbsp;';
      $output = '';
      if($categories) {
         $output .= '<div class="above-entry-meta"><span class="cat-links">';
         foreach($categories as $category) {
            $color_code = my_newsportal_category_color(get_cat_id($category->cat_name));
            if (!empty($color_code)) {
               $output .= '<a href="'.get_category_link( $category->term_id ).'" style="background:' . my_newsportal_category_color(get_cat_id($category->cat_name)) . '" rel="category tag">'.$category->cat_name.'</a>'.$separator;
            } else {
               $output .= '<a href="'.get_category_link( $category->term_id ).'"  rel="category tag">'.$category->cat_name.'</a>'.$separator;
            }
      }
         $output .='</span></div>';
         echo trim($output, $separator);
      }
   }
endif;

/**************************************************************************************/

/*
 * Creating responsive video for posts/pages
 */
if ( !function_exists('my_newsportal_responsive_video') ) :
   function my_newsportal_responsive_video( $html, $url, $attr, $post_ID ) {
       return '<div class="fitvids-video">'.$html.'</div>';
   }
   add_filter( 'embed_oembed_html', 'my_newsportal_responsive_video', 10, 4 ) ;
endif;

/**************************************************************************************/

/*
 * Use of the hooks for Category Color in the archive titles
 */
function my_newsportal_colored_category_title($title) {
   $color_value = my_newsportal_category_color(get_cat_id($title));
   $color_border_value = my_newsportal_category_color(get_cat_id($title));
   if ( !empty($color_value) ) {
      return '<h1 class="page-title" style="border-bottom-color: '.$color_border_value.'">'.'<span style="background-color: '.$color_value.'">'.$title.'</span></h1>';
   } else {
      return '<h1 class="page-title"><span>'.$title.'</span></h1>';
   }
}
function my_newsportal_category_title_function($category_title) {
   add_filter('single_cat_title', 'my_newsportal_colored_category_title');
}
add_action('my_newsportal_category_title','my_newsportal_category_title_function');

/**************************************************************************************/

/**
 * Making the theme Woocommrece compatible
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
// Remove WooCommerce default sidebar
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

add_filter( 'woocommerce_show_page_title', '__return_false' );

add_action('woocommerce_before_main_content', 'my_newsportal_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_newsportal_wrapper_end', 10);

function my_newsportal_wrapper_start() {
	echo '<div id="primary">';
}

function my_newsportal_wrapper_end() {
	echo '</div>';
	my_newsportal_sidebar_select();
}

// Displays the site logo
if ( ! function_exists( 'my_newsportal_the_custom_logo' ) ) {
	/**
	 * Displays the optional custom logo.
	 */
	function my_newsportal_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' )  && ( get_theme_mod( 'my_newsportal_logo','' ) == '') ) {
			the_custom_logo();
		}
	}
}

/**
 * Function to transfer the favicon added in Customizer Options of theme to Site Icon in Site Identity section
 */
function my_newsportal_site_icon_migrate() {
	if ( get_option( 'my_newsportal_site_icon_transfer' ) ) {
		return;
	}

	global $wp_version;
	$image_url = get_theme_mod( 'my_newsportal_favicon_upload', '' );

	if ( ( $wp_version >= 4.3 ) && ( ! has_site_icon() && ! empty( $image_url ) ) ) {
		$customizer_site_icon_id = attachment_url_to_postid( $image_url );
		update_option( 'site_icon', $customizer_site_icon_id );
		// Set the transfer as complete.
		update_option( 'my_newsportal_site_icon_transfer', 1 );
		// Delete the old favicon theme_mod option.
		remove_theme_mod( 'my_newsportal_favicon_upload' );
		remove_theme_mod( 'my_newsportal_favicon_show' );
	}
}

add_action( 'after_setup_theme', 'my_newsportal_site_icon_migrate' );

/**
 * Migrate any existing theme CSS codes added in Customize Options to the core option added in WordPress 4.7
 */
function my_newsportal_custom_css_migrate() {
	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		$custom_css = get_theme_mod( 'my_newsportal_custom_css' );
		if ( $custom_css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return = wp_update_custom_css_post( $core_css . $custom_css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'my_newsportal_custom_css' );
			}
		}
	}
}

add_action( 'after_setup_theme', 'my_newsportal_custom_css_migrate' );

/**
 * Function to transfer the Header Logo added in Customizer Options of theme to Site Logo in Site Identity section
 */
function my_newsportal_site_logo_migrate() {
	if ( function_exists( 'the_custom_logo' ) && ! has_custom_logo( $blog_id = 0 ) ) {
		$logo_url = get_theme_mod( 'my_newsportal_logo' );

		if ( $logo_url ) {
			$customizer_site_logo_id = attachment_url_to_postid( $logo_url );
			set_theme_mod( 'custom_logo', $customizer_site_logo_id );

			// Delete the old Site Logo theme_mod option.
			remove_theme_mod( 'my_newsportal_logo' );
		}
	}
}

add_action( 'after_setup_theme', 'my_newsportal_site_logo_migrate' );
?>
