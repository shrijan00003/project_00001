<?php
/**
 * my_newsportal functions related to defining constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
* @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 800;

/**
 * $content_width global variable adjustment as per layout option.
 */
function my_newsportal_content_width() {
	global $post;
	global $content_width;

	if( $post ) { $layout_meta = get_post_meta( $post->ID, 'my_newsportal_page_layout', true ); }
	if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
	$my_newsportal_default_layout = get_theme_mod( 'my_newsportal_default_layout', 'right_sidebar' );

	if( $layout_meta == 'default_layout' ) {
		if ( $my_newsportal_default_layout == 'no_sidebar_full_width' ) { $content_width = 1140; /* pixels */ }
		else { $content_width = 800; /* pixels */ }
	}
	elseif ( $layout_meta == 'no_sidebar_full_width' ) { $content_width = 1140; /* pixels */ }
	else { $content_width = 800; /* pixels */ }
}
add_action( 'template_redirect', 'my_newsportal_content_width' );

add_action( 'after_setup_theme', 'my_newsportal_setup' );
/**
 * All setup functionalities.
 *
 * @since 1.0
 */
if( !function_exists( 'my_newsportal_setup' ) ) :
function my_newsportal_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'my_newsportal', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
	add_theme_support( 'post-thumbnails' );

	// Registering navigation menu.
	register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'my_newsportal' ) );

	// Cropping the images to different sizes to be used in the theme
	add_image_size( 'my_newsportal-highlighted-post', 392, 272, true );
	add_image_size( 'my_newsportal-featured-post-medium', 390, 205, true );
	add_image_size( 'my_newsportal-featured-post-small', 130, 90, true );
	add_image_size( 'my_newsportal-featured-image', 800, 445, true );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'my_newsportal_custom_background_args', array(
		'default-color' => 'eaeaea'
	) ) );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'chat', 'audio', 'status' ) );

	// Adding excerpt option box for pages as well
	add_post_type_support( 'page', 'excerpt' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support('html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	));

	// adding the WooCommerce plugin support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support('html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	));

	// Adds the support for the Custom Logo introduced in WordPress 4.5
	add_theme_support( 'custom-logo',
		array(
			'flex-width' => true,
			'flex-height' => true,
		)
	);

	// Support for selective refresh widgets in Customizer
	add_theme_support( 'customize-selective-refresh-widgets' );

	$starter_content = array(
		'widgets' => array(
			'my_newsportal_header_sidebar' => array(
				'ad_banner_header'	=> array(
					'my_newsportal_728x90_advertisement_widget',
					array(
						'728x90_image_link' => 'https://demo.themegrill.com/my_newsportal-pro/',
						'728x90_image_url' 	=> get_template_directory_uri() . '/img/ad-large.jpg',
					),
				),
			),
			'my_newsportal_front_page_slider_area' => array(
				'featured_posts_slider'	=> array(
					'my_newsportal_featured_posts_slider_widget',
					array(
						'number' 	=> 2,
					),
				),
			),
			'my_newsportal_front_page_area_beside_slider' => array(
				'featured_posts_slider'	=> array(
					'my_newsportal_highlighted_posts_widget',
					array(
						'number' 	=> 4,
					),
				),
			),
			'my_newsportal_right_sidebar' => array(
				'featured_posts_right_sidebar'	=> array(
					'my_newsportal_featured_posts_vertical_widget',
					array(
						'title' 	=> 'NEWS',
						'number' 	=> 2,
					),
				),
				'text_premium_themes'	=> array(
					'text',
					array(
						'title'	=> 'Premium Themes',
						'text'	=> '<ul>
										<li><a href="https://themegrill.com/themes/spacious-pro/">Spacious Pro</a></li>
										<li><a href="https://themegrill.com/themes/foodhunt-pro/">FoodHunt Pro</a></li>
										<li><a href="https://themegrill.com/themes/colornews-pro/">ColorNews Pro</a></li>
										<li><a href="https://themegrill.com/themes/accelerate-pro/">Accelerate Pro</a></li>
										<li><a href="https://themegrill.com/themes/esteem-pro/">Esteem Pro</a></li>
										<li><a href="https://http://themegrill.com/themes/radiate-pro/">Radiate Pro</a></li>
										<li><a href="https://themegrill.com/themes/fitclub-pro/">Fitclub Pro</a></li>
										<li><a href="https://themegrill.com/themes/himalayas-pro/">Himalayas Pro</a></li>
									</ul>',
					),
				),
				'ad_banner_right'	=> array(
					'my_newsportal_125x125_advertisement_widget',
					array(
						'title'  => 'TG: 125x125 Ads',
						'125x125_image_link_1' 	=> 'https://themegrill.com/',
						'125x125_image_url_1' 	=> get_template_directory_uri() . '/img/ad-small.jpg',
						'125x125_image_link_2' 	=> 'https://themegrill.com/',
						'125x125_image_url_2' 	=> get_template_directory_uri() . '/img/ad-small.jpg',
						'125x125_image_link_3' 	=> 'https://themegrill.com/',
						'125x125_image_url_3' 	=> get_template_directory_uri() . '/img/ad-small.jpg',
						'125x125_image_link_4' 	=> 'https://themegrill.com/',
						'125x125_image_url_4' 	=> get_template_directory_uri() . '/img/ad-small.jpg',
					),
				),
			),
			'my_newsportal_front_page_content_top_section' => array(
				'featured_posts_style_1'	=> array(
					'my_newsportal_featured_posts_widget',
					array(
						'title'		=> 'HEALTH',
						'number' 	=> 5,
					),
				),
			),
			'my_newsportal_front_page_content_middle_left_section' => array(
				'featured_posts_style_2_left'	=> array(
					'my_newsportal_featured_posts_vertical_widget',
					array(
						'title'		=> 'FASHION',
						'number' 	=> 4,
					),
				),
			),
			'my_newsportal_front_page_content_middle_right_section' => array(
				'featured_posts_style_2_right'	=> array(
					'my_newsportal_featured_posts_vertical_widget',
					array(
						'title'		=> 'SPORTS',
						'number' 	=> 4,
					),
				),
			),
			'my_newsportal_front_page_content_bottom_section' => array(
				'featured_posts_style_1_bottom'	=> array(
					'my_newsportal_featured_posts_widget',
					array(
						'title'		=> 'TECHNOLOGY',
						'text'		=> 'Check out technology changing the life.',
						'number' 	=> 4,
					),
				),
			),
			'my_newsportal_footer_sidebar_one' => array(
				'text_footer_about'	=> array(
					'text',
					array(
						'title'	=> 'About Us',
						'text'	=> '<a title="logo" href="' . home_url() .'"><img src="' . get_template_directory_uri() . '/img/my_newsportal-logo.png" alt="Logo" /></a> <br> We love WordPress and we are here to provide you with professional looking WordPress themes so that you can take your website one step ahead. We focus on simplicity, elegant design and clean code.',
					),
				),
			),
			'my_newsportal_footer_sidebar_two' => array(
				'text_footer_links'	=> array(
					'text',
					array(
						'title'	=> 'Useful Links',
						'text'	=> '<ul>
										<li><a href="https://themegrill.com/">ThemeGrill</a></li>
										<li><a href="https://themegrill.com/support-forum/">Support</a></li>
										<li><a href="https://themegrill.com/theme-instruction/my_newsportal/">Documentation</a></li>
										<li><a href="https://themegrill.com/frequently-asked-questions/">FAQ</a></li>
										<li><a href="https://themegrill.com/themes/">Themes</a></li>
										<li><a href="https://themegrill.com/plugins/">Plugins</a></li>
										<li><a href="https://themegrill.com/blog/">Blog</a></li>
										<li><a href="https://themegrill.com/plans-pricing/">Plans &amp; Pricing</a></li>
									</ul>',
					),
				),
			),
			'my_newsportal_footer_sidebar_three' => array(
				'text_footer_other_themes'	=> array(
					'text',
					array(
						'title'	=> 'Other Themes',
						'text'	=> '<ul>
										<li><a href="https://themegrill.com/themes/envince/">Envince</a></li>
										<li><a href="https://themegrill.com/themes/estore/">eStore</a></li>
										<li><a href="https://themegrill.com/themes/ample/">Ample</a></li>
										<li><a href="https://themegrill.com/themes/spacious/">Spacious</a></li>
										<li><a href="https://themegrill.com/themes/accelerate/">Accelerate</a></li>
										<li><a href="https://themegrill.com/themes/radiate/">Radiate</a></li>
										<li><a href="https://themegrill.com/themes/esteem/">Esteem</a></li>
										<li><a href="https://themegrill.com/themes/himalayas/">Himalayas</a></li>
										<li><a href="https://themegrill.com/themes/colornews/">ColorNews</a></li>
									</ul>',
					),
				),
			),
			'my_newsportal_footer_sidebar_four' => array(
				'ad_banner_footer'	=> array(
					'my_newsportal_300x250_advertisement_widget',
					array(
						'title'  => 'my_newsportal Pro',
						'300x250_image_link' => 'https://demo.themegrill.com/my_newsportal-pro/',
						'300x250_image_url' => get_template_directory_uri() . '/img/ad-medium.jpg',
					),
				),
				'text_footer_my_newsportal_pro'	=> array(
					'text',
					array(
						'text'	=> 'Contains all features of free version and many new additional features.',
					),
				),
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'layout' => array(
				'post_type' 	=> 'page',
				'post_title' 	=> 'Layout',
				'post_content' 	=> 'ThemeGrill layout content',
			),
			'contact'			=> array(
				'template'		=> 'page-templates/contact.php',
			),

			// Create posts
			'coffee-is-health-food-myth-or-fact' => array(
				'post_type' 	=> 'post',
				'post_title' 	=> 'Coffee is health food: Myth or fact?',
				'post_content' 	=> 'Vivamus vestibulum ut magna vitae facilisis. Maecenas laoreet lobortis tristique. Aenean accumsan malesuada convallis. Suspendisse egestas luctus nisl, sit amet',
				'thumbnail' 	=> '{{featured-image-coffee}}',
			),
			'get-more-nutrition-in-every-bite' => array(
				'post_type' 	=> 'post',
				'post_title' 	=> 'Get more nutrition in every bite',
				'post_content' 	=> 'Fusce non nunc mi. Integer placerat nulla id quam varius dapibus. Nulla sit amet tellus et purus lobortis efficitur. Vivamus tempus posuere ipsum in suscipit. Quisque pulvinar fringilla cursus. Morbi malesuada laoreet dui, vitae consequat arcu vehicula vel. Fusce vel turpis non ante mollis bibendum a ac risus. Morbi ornare ipsum sit amet enim rhoncus, sed eleifend felis tristique. Mauris sed sollicitudin libero. In nec lacus quis erat rhoncus molestie.',
				'thumbnail' 	=> '{{featured-image-yummy}}',
			),
			'womens-relay-competition' => array(
				'post_type' 	=> 'post',
				'post_title' 	=> 'Women’s Relay Competition',
				'post_content' 	=> 'The young team of Franziska Hildebrand, Franziska Preuss, Vanessa Hinz and Dahlmeier clocked 1 hour, 11 minutes, 54.6 seconds to beat France by just over 1 minute. Italy took bronze, 1:06.1 behind. Germany missed six targets overall, avoiding any laps around the penalty loop. Maria Dorin Habert of France, who has two individual gold medals at these worlds, passed Russia and France on the last leg and to take her team from fourth to second.',
				'thumbnail' 	=> '{{featured-image-relay-race}}',
			),
			'a-paradise-for-holiday' => array(
				'post_type' 	=> 'post',
				'post_title' 	=> 'A Paradise for Holiday',
				'post_content' 	=> 'Chocolate bar marzipan sweet marzipan. Danish tart bear claw donut cake bonbon biscuit powder croissant. Liquorice cake cookie. Dessert cotton candy macaroon gummies sweet gingerbread sugar plum. Biscuit tart cake. Candy jelly ice cream halvah jelly-o jelly beans brownie pastry sweet. Candy sweet roll dessert. Lemon drops jelly-o fruitcake topping. Soufflé jelly beans bonbon.',
				'thumbnail' 	=> '{{featured-image-paradise-for-holiday}}',
			),
			'destruction-in-montania' => array(
				'post_type' 	=> 'post',
				'post_title' 	=> 'Destruction in Montania',
				'post_content' 	=> 'Nunc consectetur ipsum nisi, ut pellentesque felis tempus vitae. Integer eget lacinia nunc. Vestibulum consectetur convallis augue id egestas. Nullam rhoncus, arcu in tincidunt ultricies, velit diam imperdiet lacus, sed faucibus mi massa vel nunc. In ac viverra augue, a luctus nisl. Donec interdum enim tempus, aliquet metus maximus, euismod quam. Sed pretium finibus rhoncus. Phasellus libero diam, rutrum non ipsum ut, ultricies sodales sapien. Duis viverra purus lorem.',
				'thumbnail' 	=> '{{featured-image-fireman}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'my_newsportal-logo' => array(
				'post_title' 	=> 'my_newsportal Logo',
				'file' 			=> 'img/my_newsportal-logo.png',
			),
			'featured-image-fireman' => array(
				'post_title' 	=> 'Featured image fireman',
				'file' 			=> 'img/fireman.jpg',
			),
			'featured-image-coffee' => array(
				'post_title' 	=> 'Featured image coffee',
				'file' 			=> 'img/coffee.jpg',
			),
			'featured-image-yummy' => array(
				'post_title' 	=> 'Featured image yummy',
				'file' 			=> 'img/yummy.jpg',
			),
			'featured-image-relay-race' => array(
				'post_title' 	=> 'Featured image relay race',
				'file' 			=> 'img/relay-race.jpg',
			),
			'featured-image-paradise-for-holiday' => array(
				'post_title' 	=> 'Featured image paradise for holiday',
				'file' 			=> 'img/sea.jpg',
			),
			'featured-image-ad-medium' => array(
				'post_title' 	=> 'Featured image ad medium',
				'file' 			=> 'img/ad-medium.jpg',
			),
			'featured-image-ad-large' => array(
				'post_title' 	=> 'Featured image ad large',
				'file' 			=> 'img/ad-large.jpg',
			),
		),

		'options' => array(
			'blogname'			=> 'my_newsportal',
			'blogdescription'	=> 'my_newsportal Demo site',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'custom_logo'						 	=> '{{my_newsportal-logo}}',
			'my_newsportal_breaking_news' 				=> 1,
			'my_newsportal_date_display' 				=> 1,
			'my_newsportal_header_logo_placement' 		=> 'header_logo_only',
			'my_newsportal_hide_blog_front' 				=> 1,
			'my_newsportal_search_icon_in_menu' 			=> 1,
			'my_newsportal_random_post_in_menu' 			=> 1,
			'my_newsportal_social_link_activate' 		=> 1,
			'my_newsportal_home_icon_display' 			=> 1,
			'my_newsportal_primary_sticky_menu'			=> 1,
			'my_newsportal_related_posts_activate'		=> 1,
			'my_newsportal_social_facebook' 				=> '#',
			'my_newsportal_social_twitter' 				=> '#',
			'my_newsportal_social_googleplus' 			=> '#',
			'my_newsportal_social_instagram' 			=> '#',
			'my_newsportal_social_pinterest' 			=> '#',
			'my_newsportal_social_youtube' 				=> '#',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "primary" location.
			'primary' => array(
				'name' => 'Primary',
				'items' => array(
					'link_download' => array(
						'type' 		=> 'custom',
						'title' => 'Download',
						'url' => 'https://downloads.wordpress.org/theme/my_newsportal.zip',
					),
					'link_theme-info' => array(
						'type' 		=> 'custom',
						'title' => 'Theme Info',
						'url' => 'https://themegrill.com/themes/my_newsportal/',
					),
					'link_view-pro' => array(
						'type' 		=> 'custom',
						'title' => 'View pro',
						'url' => 'https://themegrill.com/themes/my_newsportal/',
					),
					'page_layout' 	=> array(
						'type' 		=> 'post_type',
						'object' 	=> 'page',
						'object_id' => '{{layout}}',
					),
					'page_contact',
				),
			),
		),

	);
	$starter_content = apply_filters( 'my_newsportal_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
endif;

/**
 * Define Directory Location Constants
 */
define( 'my_newsportal_PARENT_DIR', get_template_directory() );
define( 'my_newsportal_CHILD_DIR', get_stylesheet_directory() );

define( 'my_newsportal_INCLUDES_DIR', my_newsportal_PARENT_DIR. '/inc' );
define( 'my_newsportal_CSS_DIR', my_newsportal_PARENT_DIR . '/css' );
define( 'my_newsportal_JS_DIR', my_newsportal_PARENT_DIR . '/js' );
define( 'my_newsportal_LANGUAGES_DIR', my_newsportal_PARENT_DIR . '/languages' );

define( 'my_newsportal_ADMIN_DIR', my_newsportal_INCLUDES_DIR . '/admin' );
define( 'my_newsportal_WIDGETS_DIR', my_newsportal_INCLUDES_DIR . '/widgets' );

define( 'my_newsportal_ADMIN_IMAGES_DIR', my_newsportal_ADMIN_DIR . '/images' );

/**
 * Define URL Location Constants
 */
define( 'my_newsportal_PARENT_URL', get_template_directory_uri() );
define( 'my_newsportal_CHILD_URL', get_stylesheet_directory_uri() );

define( 'my_newsportal_INCLUDES_URL', my_newsportal_PARENT_URL. '/inc' );
define( 'my_newsportal_CSS_URL', my_newsportal_PARENT_URL . '/css' );
define( 'my_newsportal_JS_URL', my_newsportal_PARENT_URL . '/js' );
define( 'my_newsportal_LANGUAGES_URL', my_newsportal_PARENT_URL . '/languages' );

define( 'my_newsportal_ADMIN_URL', my_newsportal_INCLUDES_URL . '/admin' );
define( 'my_newsportal_WIDGETS_URL', my_newsportal_INCLUDES_URL . '/widgets' );

define( 'my_newsportal_ADMIN_IMAGES_URL', my_newsportal_ADMIN_URL . '/images' );

/** Load functions */
require_once( my_newsportal_INCLUDES_DIR . '/custom-header.php' );
require_once( my_newsportal_INCLUDES_DIR . '/functions.php' );
require_once( my_newsportal_INCLUDES_DIR . '/header-functions.php' );
require_once( my_newsportal_INCLUDES_DIR . '/customizer.php' );

require_once( my_newsportal_ADMIN_DIR . '/meta-boxes.php' );

/** Load Widgets and Widgetized Area */
require_once( my_newsportal_WIDGETS_DIR . '/widgets.php' );

/**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Load Demo Importer Configs.
 */
if ( class_exists( 'TG_Demo_Importer' ) ) {
	require get_template_directory() . '/inc/demo-config.php';
}

/**
 * Assign the my_newsportal version to a variable.
 */
$theme            = wp_get_theme( 'my_newsportal' );
$my_newsportal_version = $theme['Version'];

/* Calling in the admin area for the Welcome Page */
if ( is_admin() ) {
	require get_template_directory() . '/inc/admin/class-my_newsportal-admin.php';
}

/**
 * Load TGMPA Configs.
 */
//require_once( my_newsportal_INCLUDES_DIR . '/tgm-plugin-activation/class-tgm-plugin-activation.php' );
//require_once( my_newsportal_INCLUDES_DIR . '/tgm-plugin-activation/tgmpa-my_newsportal.php' );

function my_newsportal_seo_setup() {
  global $page, $paged, $post;
	$default_keywords = 'News,Nepal,newsportal,best,true,recent,neutral,Nepali, newspaper,online,khabar,kantipur,naya, patrika,kathmandu,pokhara,purba,paschim,nirbachan,samshad,pratinidhi,shava,pradesh,hot,fast,election,electionNepal,samachar,patra'; // customize
	$output = '';
	// description
	$seo_desc = get_post_meta($post->ID, 'mm_seo_desc', true);
	$description = get_bloginfo('description', 'display');
	$pagedata = get_post($post->ID);
	if (is_singular()) {
		if (!empty($seo_desc)) {
			$content = $seo_desc;
		} else if (!empty($pagedata)) {
			$content = apply_filters('the_excerpt_rss', $pagedata->post_content);
			$content = substr(trim(strip_tags($content)), 0, 155);
			$content = preg_replace('#\n#', ' ', $content);
			$content = preg_replace('#\s{2,}#', ' ', $content);
			$content = trim($content);
		} 
	} else {
		$content = $description;	
	}
	$output .= '<meta name="description" content="' . esc_attr($content) . '">' . "\n";
	// keywords
	$keys = get_post_meta($post->ID, 'mm_seo_keywords', true);
	$cats = get_the_category();
	$tags = get_the_tags();
	if (empty($keys)) {
		if (!empty($cats)) foreach($cats as $cat) $keys .= $cat->name . ', ';
		if (!empty($tags)) foreach($tags as $tag) $keys .= $tag->name . ', ';
		$keys .= $default_keywords;
	}
	$output .= "\t\t" . '<meta name="keywords" content="' . esc_attr($keys) . '">' . "\n";
	// robots
	if (is_category() || is_tag()) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if ($paged > 1) {
			$output .=  "\t\t" . '<meta name="robots" content="noindex,follow">' . "\n";
		} else {
			$output .=  "\t\t" . '<meta name="robots" content="index,follow">' . "\n";
		}
	} else if (is_home() || is_singular()) {
		$output .=  "\t\t" . '<meta name="robots" content="index,follow">' . "\n";
	} else {
		$output .= "\t\t" . '<meta name="robots" content="noindex,follow">' . "\n";
	}
	// title
	$title_custom = get_post_meta($post->ID, 'mm_seo_title', true);
	$url = ltrim(esc_url($_SERVER['REQUEST_URI']), '/');
	$name = get_bloginfo('name', 'display');
	$title = trim(wp_title('', false));
	$cat = single_cat_title('', false);
	$tag = single_tag_title('', false);
	$search = get_search_query();
	if (!empty($title_custom)) $title = $title_custom;
	if ($paged >= 2 || $page >= 2) $page_number = ' | ' . sprintf('Page %s', max($paged, $page));
	else $page_number = '';
	if (is_home() || is_front_page()) $seo_title = $name . ' | ' . $description;
	elseif (is_singular())            $seo_title = $title . ' | ' . $name;
	elseif (is_tag())                 $seo_title = 'Tag Archive: ' . $tag . ' | ' . $name;
	elseif (is_category())            $seo_title = 'Category Archive: ' . $cat . ' | ' . $name;
	elseif (is_archive())             $seo_title = 'Archive: ' . $title . ' | ' . $name;
	elseif (is_search())              $seo_title = 'Search: ' . $search . ' | ' . $name;
	elseif (is_404())                 $seo_title = '404 - Not Found: ' . $url . ' | ' . $name;
	else                              $seo_title = $name . ' | ' . $description;
	$output .= "\t\t" . '<title>' . esc_attr($seo_title . $page_number) . '</title>' . "\n";
	return $output;
}

/*
 =========the following function is for displaying post by category 

*/
 function videosbycat() {
// the query
$the_query = new WP_Query( array( 'category_name' => 'top-videos', 'posts_per_page' => 10 ) ); 
 
// The Loop
if ( $the_query->have_posts() ) {
    $string .= '<ul class="postsbycategory widget_recent_entries">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
            if ( has_post_thumbnail() ) {
            $string .= '<li>';
            $string .= '<a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_post_thumbnail($post_id, array( 50, 50) ) . get_the_title() .'</a></li>';
            } else { 
            // if no featured image is found
            $string .= '<li><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() .'</a></li>';
            }
            }
    } else {
    // no posts found
}
$string .= '</ul>';
 
return $string;
 
/* Restore original Post Data */
wp_reset_postdata();
}
// Add a shortcode
add_shortcode('topvideos', 'videosbycat');
 
// Enable shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');
?>
