<?php

/**
 * my_newsportal Theme Customizer
 *
 * @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */
function my_newsportal_customize_register($wp_customize) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '#site-title a',
			'render_callback' => 'my_newsportal_customize_partial_blogname',
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '#site-description',
			'render_callback' => 'my_newsportal_customize_partial_blogdescription',
		) );
	}

   // Theme important links started
   class my_newsportal_Important_Links extends WP_Customize_Control {

      public $type = "my_newsportal-important-links";

      public function render_content() {
         //Add Theme instruction, Support Forum, Demo Link, Rating Link
         $important_links = array(
            'view-pro' => array(
               'link' => esc_url('https://themegrill.com/themes/my_newsportal-pro/'),
               'text' => esc_html__('View Pro', 'my_newsportal'),
            ),
            'theme-info' => array(
               'link' => esc_url('https://themegrill.com/themes/my_newsportal/'),
               'text' => esc_html__('Theme Info', 'my_newsportal'),
            ),
            'support' => array(
               'link' => esc_url('https://themegrill.com/support-forum/'),
               'text' => esc_html__('Support', 'my_newsportal'),
            ),
            'documentation' => array(
               'link' => esc_url('https://docs.themegrill.com/my_newsportal/'),
               'text' => esc_html__('Documentation', 'my_newsportal'),
            ),
            'demo' => array(
               'link' => esc_url('https://demo.themegrill.com/my_newsportal/'),
               'text' => esc_html__('View Demo', 'my_newsportal'),
            ),
            'rating' => array(
               'link' => esc_url('https://wordpress.org/support/view/theme-reviews/my_newsportal?filter=5'),
               'text' => esc_html__('Rate this theme', 'my_newsportal'),
            ),
         );
         foreach ($important_links as $important_link) {
            echo '<p><a target="_blank" href="' . $important_link['link'] . '" >' . esc_attr($important_link['text']) . ' </a></p>';
         }
      }

   }

   $wp_customize->add_section('my_newsportal_important_links', array(
      'priority' => 1,
      'title' => __('my_newsportal Important Links', 'my_newsportal'),
   ));

   /**
    * This setting has the dummy Sanitizaition function as it contains no value to be sanitized
    */
   $wp_customize->add_setting('my_newsportal_important_links', array(
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_links_sanitize'
   ));

   $wp_customize->add_control(new my_newsportal_Important_Links($wp_customize, 'important_links', array(
      'label' => __('Important Links', 'my_newsportal'),
      'section' => 'my_newsportal_important_links',
      'settings' => 'my_newsportal_important_links'
   )));
   // Theme Important Links Ended

   // Start of the Header Options
   $wp_customize->add_panel('my_newsportal_header_options', array(
      'capabitity' => 'edit_theme_options',
      'description' => __('Change the Header Settings from here as you want', 'my_newsportal'),
      'priority' => 500,
      'title' => __('Header Options', 'my_newsportal')
   ));

   // breaking news enable/disable
   $wp_customize->add_section('my_newsportal_breaking_news_section', array(
      'title' => __('Breaking News', 'my_newsportal'),
      'panel' => 'my_newsportal_header_options'
   ));

   $wp_customize->add_setting('my_newsportal_breaking_news', array(
      'priority' => 1,
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_breaking_news', array(
      'type' => 'checkbox',
      'label' => __('Check to enable the breaking news section', 'my_newsportal'),
      'section' => 'my_newsportal_breaking_news_section',
      'settings' => 'my_newsportal_breaking_news'
   ));

   // date display enable/disable
   $wp_customize->add_section('my_newsportal_date_display_section', array(
      'title' => __('Show Date', 'my_newsportal'),
      'panel' => 'my_newsportal_header_options'
   ));

   $wp_customize->add_setting('my_newsportal_date_display', array(
      'priority' => 2,
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_date_display', array(
      'type' => 'checkbox',
      'label' => __('Check to show the date in header', 'my_newsportal'),
      'section' => 'my_newsportal_date_display_section',
      'settings' => 'my_newsportal_date_display'
   ));

	// date in header display type
	$wp_customize->add_setting('my_newsportal_date_display_type', array(
		'default' => 'theme_default',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'my_newsportal_radio_select_sanitize'
	));

	$wp_customize->add_control('my_newsportal_date_display_type', array(
		'type' => 'radio',
		'label' => esc_html__('Date in header display type:', 'my_newsportal'),
		'choices' => array(
			'theme_default' => esc_html__('Theme Default Setting', 'my_newsportal'),
			'wordpress_date_setting' => esc_html__('From WordPress Date Setting', 'my_newsportal'),
		),
		'section' => 'my_newsportal_date_display_section',
		'settings' => 'my_newsportal_date_display_type'
	));

   // home icon enable/disable in primary menu
   $wp_customize->add_section('my_newsportal_home_icon_display_section', array(
      'title' => __('Show Home Icon', 'my_newsportal'),
      'panel' => 'my_newsportal_header_options'
   ));

   $wp_customize->add_setting('my_newsportal_home_icon_display', array(
      'priority' => 3,
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_home_icon_display', array(
      'type' => 'checkbox',
      'label' => __('Check to show the home icon in the primary menu', 'my_newsportal'),
      'section' => 'my_newsportal_home_icon_display_section',
      'settings' => 'my_newsportal_home_icon_display'
   ));

   // primary sticky menu enable/disable
   $wp_customize->add_section('my_newsportal_primary_sticky_menu_section', array(
      'title' => __('Sticky Menu', 'my_newsportal'),
      'panel' => 'my_newsportal_header_options'
   ));

   $wp_customize->add_setting('my_newsportal_primary_sticky_menu', array(
      'priority' => 4,
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_primary_sticky_menu', array(
      'type' => 'checkbox',
      'label' => __('Check to enable the sticky behavior of the primary menu', 'my_newsportal'),
      'section' => 'my_newsportal_primary_sticky_menu_section',
      'settings' => 'my_newsportal_primary_sticky_menu'
   ));

   // search icon in menu enable/disable
   $wp_customize->add_section('my_newsportal_search_icon_in_menu_section', array(
      'title' => __('Search Icon', 'my_newsportal'),
      'panel' => 'my_newsportal_header_options'
   ));

   $wp_customize->add_setting('my_newsportal_search_icon_in_menu', array(
      'priority' => 5,
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_search_icon_in_menu', array(
      'type' => 'checkbox',
      'label' => __('Check to display the Search Icon in the primary menu', 'my_newsportal'),
      'section' => 'my_newsportal_search_icon_in_menu_section',
      'settings' => 'my_newsportal_search_icon_in_menu'
   ));

   // random posts in menu enable/disable
   $wp_customize->add_section('my_newsportal_random_post_in_menu_section', array(
      'title' => __('Random Post', 'my_newsportal'),
      'panel' => 'my_newsportal_header_options'
   ));

   $wp_customize->add_setting('my_newsportal_random_post_in_menu', array(
      'priority' => 6,
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_random_post_in_menu', array(
      'type' => 'checkbox',
      'label' => __('Check to display the Random Post Icon in the primary menu', 'my_newsportal'),
      'section' => 'my_newsportal_random_post_in_menu_section',
      'settings' => 'my_newsportal_random_post_in_menu'
   ));

   // Responsive new menu enable/disable
   $wp_customize->add_section('my_newsportal_responsive_menu_section', array(
      'title' => esc_html__('Responsive Menu Style', 'my_newsportal'),
      'panel' => 'my_newsportal_header_options'
   ));

   $wp_customize->add_setting('my_newsportal_responsive_menu', array(
      'priority' => 7,
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_responsive_menu', array(
      'type' => 'checkbox',
      'label' => esc_html__('Check to switch to new responsive menu.', 'my_newsportal'),
      'section' => 'my_newsportal_responsive_menu_section',
      'settings' => 'my_newsportal_responsive_menu'
   ));

   // logo upload options
   $wp_customize->add_section('my_newsportal_header_logo', array(
      'priority' => 1,
      'title' => __('Header Logo', 'my_newsportal'),
      'panel' => 'my_newsportal_header_options'
   ));

	if ( ! function_exists('the_custom_logo') ) {
		$wp_customize->add_setting('my_newsportal_logo', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		));

		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'my_newsportal_logo', array(
			'label' => __('Upload logo for your header', 'my_newsportal'),
			'section' => 'my_newsportal_header_logo',
			'setting' => 'my_newsportal_logo'
		)));
	}

   $wp_customize->add_setting('my_newsportal_header_logo_placement', array(
      'default' => 'header_text_only',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_show_radio_saniztize'
   ));

   $wp_customize->add_control('my_newsportal_header_logo_placement', array(
      'type' => 'radio',
      'label' => __('Choose the option that you want', 'my_newsportal'),
      'section' => 'my_newsportal_header_logo',
      'choices' => array(
         'header_logo_only' => __('Header Logo Only', 'my_newsportal'),
         'header_text_only' => __('Header Text Only', 'my_newsportal'),
         'show_both' => __('Show Both', 'my_newsportal'),
         'disable' => __('Disable', 'my_newsportal')
      )
   ));

   // header image position setting
   $wp_customize->add_section('my_newsportal_header_image_position_setting', array(
      'priority' => 6,
      'title' => __('Header Image Position', 'my_newsportal'),
      'panel' => 'my_newsportal_header_options'
   ));

   $wp_customize->add_setting('my_newsportal_header_image_position', array(
      'default' => 'position_two',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_header_image_position_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_header_image_position', array(
      'type' => 'radio',
      'label' => __('Header image display position', 'my_newsportal'),
      'section' => 'my_newsportal_header_image_position_setting',
      'choices' => array(
         'position_one' => __('Display the Header image just above the site title/text.', 'my_newsportal'),
         'position_two' => __('Default: Display the Header image between site title/text and the main/primary menu.', 'my_newsportal'),
         'position_three' => __('Display the Header image below main/primary menu.', 'my_newsportal')
      )
   ));

   $wp_customize->add_setting('my_newsportal_header_image_link', array(
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_header_image_link', array(
      'type' => 'checkbox',
      'label' => __('Check to make header image link back to home page', 'my_newsportal'),
      'section' => 'my_newsportal_header_image_position_setting'
   ));

   // Start of the Design Options
   $wp_customize->add_panel('my_newsportal_design_options', array(
      'capabitity' => 'edit_theme_options',
      'description' => __('Change the Design Settings from here as you want', 'my_newsportal'),
      'priority' => 505,
      'title' => __('Design Options', 'my_newsportal')
   ));

   // FrontPage setting
   $wp_customize->add_section('my_newsportal_front_page_setting', array(
      'priority' => 1,
      'title' => __('Front Page Settings', 'my_newsportal'),
      'panel' => 'my_newsportal_design_options'
   ));
   $wp_customize->add_setting('my_newsportal_hide_blog_front', array(
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_hide_blog_front', array(
      'type' => 'checkbox',
      'label' => __('Check to hide blog posts/static page on front page', 'my_newsportal'),
      'section' => 'my_newsportal_front_page_setting'
   ));

   // site layout setting
   $wp_customize->add_section('my_newsportal_site_layout_setting', array(
      'priority' => 2,
      'title' => __('Site Layout', 'my_newsportal'),
      'panel' => 'my_newsportal_design_options'
   ));

   $wp_customize->add_setting('my_newsportal_site_layout', array(
      'default' => 'wide_layout',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_site_layout_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_site_layout', array(
      'type' => 'radio',
      'label' => __('Choose your site layout. The change is reflected in whole site', 'my_newsportal'),
      'choices' => array(
         'boxed_layout' => __('Boxed Layout', 'my_newsportal'),
         'wide_layout' => __('Wide Layout', 'my_newsportal')
      ),
      'section' => 'my_newsportal_site_layout_setting'
   ));

   class my_newsportal_Image_Radio_Control extends WP_Customize_Control {

 		public function render_content() {

			if ( empty( $this->choices ) )
				return;

			$name = '_customize-radio-' . $this->id;

			?>
			<style>
				#my_newsportal-img-container .my_newsportal-radio-img-img {
					border: 3px solid #DEDEDE;
					margin: 0 5px 5px 0;
					cursor: pointer;
					border-radius: 3px;
					-moz-border-radius: 3px;
					-webkit-border-radius: 3px;
				}
				#my_newsportal-img-container .my_newsportal-radio-img-selected {
					border: 3px solid #AAA;
					border-radius: 3px;
					-moz-border-radius: 3px;
					-webkit-border-radius: 3px;
				}
				input[type=checkbox]:before {
					content: '';
					margin: -3px 0 0 -4px;
				}
			</style>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<ul class="controls" id = 'my_newsportal-img-container'>
			<?php
				foreach ( $this->choices as $value => $label ) :
					$class = ($this->value() == $value)?'my_newsportal-radio-img-selected my_newsportal-radio-img-img':'my_newsportal-radio-img-img';
					?>
					<li style="display: inline;">
					<label>
						<input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
						<img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo $class; ?>' />
					</label>
					</li>
					<?php
				endforeach;
			?>
			</ul>
			<script type="text/javascript">

				jQuery(document).ready(function($) {
					$('.controls#my_newsportal-img-container li img').click(function(){
						$('.controls#my_newsportal-img-container li').each(function(){
							$(this).find('img').removeClass ('my_newsportal-radio-img-selected') ;
						});
						$(this).addClass ('my_newsportal-radio-img-selected') ;
					});
				});

			</script>
			<?php
		}
	}

	// default layout setting
	$wp_customize->add_section('my_newsportal_default_layout_setting', array(
		'priority' => 3,
		'title' => __('Default layout', 'my_newsportal'),
		'panel'=> 'my_newsportal_design_options'
	));

	$wp_customize->add_setting('my_newsportal_default_layout', array(
		'default' => 'right_sidebar',
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'my_newsportal_layout_sanitize'
	));

	$wp_customize->add_control(new my_newsportal_Image_Radio_Control($wp_customize, 'my_newsportal_default_layout', array(
		'type' => 'radio',
		'label' => __('Select default layout. This layout will be reflected in whole site archives, categories, search page etc. The layout for a single post and page can be controlled from below options', 'my_newsportal'),
		'section' => 'my_newsportal_default_layout_setting',
		'settings' => 'my_newsportal_default_layout',
		'choices' => array(
			'right_sidebar' => my_newsportal_ADMIN_IMAGES_URL . '/right-sidebar.png',
			'left_sidebar' => my_newsportal_ADMIN_IMAGES_URL . '/left-sidebar.png',
			'no_sidebar_full_width'	=> my_newsportal_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
			'no_sidebar_content_centered'	=> my_newsportal_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
		)
	)));

	// default layout for pages
	$wp_customize->add_section('my_newsportal_default_page_layout_setting', array(
		'priority' => 4,
		'title' => __('Default layout for pages only', 'my_newsportal'),
		'panel'=> 'my_newsportal_design_options'
	));

	$wp_customize->add_setting('my_newsportal_default_page_layout', array(
		'default' => 'right_sidebar',
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'my_newsportal_layout_sanitize'
	));

	$wp_customize->add_control(new my_newsportal_Image_Radio_Control($wp_customize, 'my_newsportal_default_page_layout', array(
		'type' => 'radio',
		'label' => __('Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page', 'my_newsportal'),
		'section' => 'my_newsportal_default_page_layout_setting',
		'settings' => 'my_newsportal_default_page_layout',
		'choices' => array(
			'right_sidebar' => my_newsportal_ADMIN_IMAGES_URL . '/right-sidebar.png',
			'left_sidebar' => my_newsportal_ADMIN_IMAGES_URL . '/left-sidebar.png',
			'no_sidebar_full_width'	=> my_newsportal_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
			'no_sidebar_content_centered'	=> my_newsportal_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
		)
	)));

	// default layout for single posts
	$wp_customize->add_section('my_newsportal_default_single_posts_layout_setting', array(
		'priority' => 5,
		'title' => __('Default layout for single posts only', 'my_newsportal'),
		'panel'=> 'my_newsportal_design_options'
	));

	$wp_customize->add_setting('my_newsportal_default_single_posts_layout', array(
		'default' => 'right_sidebar',
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'my_newsportal_layout_sanitize'
	));

	$wp_customize->add_control(new my_newsportal_Image_Radio_Control($wp_customize, 'my_newsportal_default_single_posts_layout', array(
		'type' => 'radio',
		'label' => __('Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post', 'my_newsportal'),
		'section' => 'my_newsportal_default_single_posts_layout_setting',
		'settings' => 'my_newsportal_default_single_posts_layout',
		'choices' => array(
			'right_sidebar' => my_newsportal_ADMIN_IMAGES_URL . '/right-sidebar.png',
			'left_sidebar' => my_newsportal_ADMIN_IMAGES_URL . '/left-sidebar.png',
			'no_sidebar_full_width'	=> my_newsportal_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
			'no_sidebar_content_centered'	=> my_newsportal_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
		)
	)));

   // primary color options
   $wp_customize->add_section('my_newsportal_primary_color_setting', array(
      'panel' => 'my_newsportal_design_options',
      'priority' => 7,
      'title' => __('Primary color option', 'my_newsportal')
   ));

   $wp_customize->add_setting('my_newsportal_primary_color', array(
      'default' => '#289dcc',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_color_option_hex_sanitize',
      'sanitize_js_callback' => 'my_newsportal_color_escaping_option_sanitize'
   ));

   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'my_newsportal_primary_color', array(
      'label' => __('This will reflect in links, buttons and many others. Choose a color to match your site', 'my_newsportal'),
      'section' => 'my_newsportal_primary_color_setting',
      'settings' => 'my_newsportal_primary_color'
   )));

	if ( ! function_exists( 'wp_update_custom_css_post' ) ) {
		// Custom CSS setting
		class my_newsportal_Custom_CSS_Control extends WP_Customize_Control {

			public $type = 'custom_css';

			public function render_content() {
			?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
				</label>
			<?php
			}

		}

		$wp_customize->add_section('my_newsportal_custom_css_setting', array(
			'priority' => 9,
			'title' => __('Custom CSS', 'my_newsportal'),
			'panel' => 'my_newsportal_design_options'
		));

		$wp_customize->add_setting('my_newsportal_custom_css', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses'
		));

		$wp_customize->add_control(new my_newsportal_Custom_CSS_Control($wp_customize, 'my_newsportal_custom_css', array(
			'label' => __('Write your Custom CSS', 'my_newsportal'),
			'section' => 'my_newsportal_custom_css_setting',
			'settings' => 'my_newsportal_custom_css'
		)));
	}
	// End of the Design Options

   // Start of the Social Link Options
   $wp_customize->add_panel('my_newsportal_social_links_options', array(
   	'priority' => 510,
   	'title' => __('Social Options', 'my_newsportal'),
   	'description'=> __('Change the Social Links settings from here as you want', 'my_newsportal'),
   	'capability' => 'edit_theme_options',
	));

	$wp_customize->add_section('my_newsportal_social_link_activate_settings', array(
		'priority' => 1,
		'title' => __('Activate social links area', 'my_newsportal'),
		'panel' => 'my_newsportal_social_links_options'
	));

	$wp_customize->add_setting('my_newsportal_social_link_activate', array(
		'default' => 0,
      'capability' => 'edit_theme_options',
		'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
	));

	$wp_customize->add_control('my_newsportal_social_link_activate', array(
		'type' => 'checkbox',
		'label' => __('Check to activate social links area', 'my_newsportal'),
		'section' => 'my_newsportal_social_link_activate_settings',
		'settings' => 'my_newsportal_social_link_activate'
	));

	$my_newsportal_social_links = array(
		'my_newsportal_social_facebook' => array(
			'id' => 'my_newsportal_social_facebook',
			'title' => __('Facebook', 'my_newsportal'),
			'default' => ''
		),
		'my_newsportal_social_twitter' => array(
			'id' => 'my_newsportal_social_twitter',
			'title' => __('Twitter', 'my_newsportal'),
			'default' => ''
		),
		'my_newsportal_social_googleplus' => array(
			'id' => 'my_newsportal_social_googleplus',
			'title' => __('Google-Plus', 'my_newsportal'),
			'default' => ''
		),
		'my_newsportal_social_instagram' => array(
			'id' => 'my_newsportal_social_instagram',
			'title' => __('Instagram', 'my_newsportal'),
			'default' => ''
		),
		'my_newsportal_social_pinterest' => array(
			'id' => 'my_newsportal_social_pinterest',
			'title' => __('Pinterest', 'my_newsportal'),
			'default' => ''
		),
		'my_newsportal_social_youtube' => array(
			'id' => 'my_newsportal_social_youtube',
			'title' => __('YouTube', 'my_newsportal'),
			'default' => ''
		),
	);

	$i = 20;

	foreach($my_newsportal_social_links as $my_newsportal_social_link) {

		$wp_customize->add_setting($my_newsportal_social_link['id'], array(
			'default' => $my_newsportal_social_link['default'],
         'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		));

		$wp_customize->add_control($my_newsportal_social_link['id'], array(
			'label' => $my_newsportal_social_link['title'],
			'section'=> 'my_newsportal_social_link_activate_settings',
			'settings'=> $my_newsportal_social_link['id'],
			'priority' => $i
		));

		$wp_customize->add_setting($my_newsportal_social_link['id'].'_checkbox', array(
			'default' => 0,
         'capability' => 'edit_theme_options',
			'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
		));

		$wp_customize->add_control($my_newsportal_social_link['id'].'_checkbox', array(
			'type' => 'checkbox',
			'label' => __('Check to open in new tab', 'my_newsportal'),
			'section'=> 'my_newsportal_social_link_activate_settings',
			'settings'=> $my_newsportal_social_link['id'].'_checkbox',
			'priority' => $i
		));

		$i++;

	}
   // End of the Social Link Options

   // Start of the Additional Options
   $wp_customize->add_panel('my_newsportal_additional_options', array(
   	'capability' => 'edit_theme_options',
   	'description'=> __('Change the Additional Settings from here as you want', 'my_newsportal'),
   	'priority' => 515,
   	'title' => __('Additional Options', 'my_newsportal')
	));

	if ( ! function_exists( 'has_site_icon' ) || ( ! has_site_icon() && ( get_theme_mod( 'my_newsportal_favicon_upload', '' ) != '' ) ) ) {
		// favicon options
		$wp_customize->add_section('my_newsportal_favicon_show_setting', array(
			'priority' => 1,
			'title' => __('Activate favicon', 'my_newsportal'),
			'panel' => 'my_newsportal_additional_options'
		));

		$wp_customize->add_setting('my_newsportal_favicon_show', array(
			'default' => 0,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
		));

		$wp_customize->add_control('my_newsportal_favicon_show', array(
			'type' => 'checkbox',
			'label' => __('Check to activate favicon. Upload favicon from below option', 'my_newsportal'),
			'section' => 'my_newsportal_favicon_show_setting',
			'settings' => 'my_newsportal_favicon_show'
		));

		$wp_customize->add_setting('my_newsportal_favicon_upload', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		));

		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'my_newsportal_favicon_upload', array(
			'label' => __('Upload favicon for your site', 'my_newsportal'),
			'section' => 'my_newsportal_favicon_show_setting',
			'settings' => 'my_newsportal_favicon_upload'
		)));
	}

   // related posts
   $wp_customize->add_section('my_newsportal_related_posts_section', array(
      'priority' => 4,
      'title' => __('Related Posts', 'my_newsportal'),
      'panel' => 'my_newsportal_additional_options'
   ));

   $wp_customize->add_setting('my_newsportal_related_posts_activate', array(
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_related_posts_activate', array(
      'type' => 'checkbox',
      'label' => __('Check to activate the related posts', 'my_newsportal'),
      'section' => 'my_newsportal_related_posts_section',
      'settings' => 'my_newsportal_related_posts_activate'
   ));

   $wp_customize->add_setting('my_newsportal_related_posts', array(
      'default' => 'categories',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_related_posts_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_related_posts', array(
      'type' => 'radio',
      'label' => __('Related Posts Must Be Shown As:', 'my_newsportal'),
      'section' => 'my_newsportal_related_posts_section',
      'settings' => 'my_newsportal_related_posts',
      'choices' => array(
         'categories' => __('Related Posts By Categories', 'my_newsportal'),
         'tags' => __('Related Posts By Tags', 'my_newsportal')
      )
   ));

   // featured image popup check
   $wp_customize->add_section('my_newsportal_featured_image_popup_setting', array(
      'priority' => 6,
      'title' => __('Image Lightbox', 'my_newsportal'),
      'panel' => 'my_newsportal_additional_options'
   ));

   $wp_customize->add_setting('my_newsportal_featured_image_popup', array(
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'my_newsportal_checkbox_sanitize'
   ));

   $wp_customize->add_control('my_newsportal_featured_image_popup', array(
      'type' => 'checkbox',
      'label' => __('Check to enable the lightbox for the featured images in single post', 'my_newsportal'),
      'section' => 'my_newsportal_featured_image_popup_setting',
      'settings' => 'my_newsportal_featured_image_popup'
   ));
	// End of the Additional Options

	// Category Color Options
   $wp_customize->add_panel('my_newsportal_category_color_panel', array(
      'priority' => 535,
      'title' => __('Category Color Options', 'my_newsportal'),
      'capability' => 'edit_theme_options',
      'description' => __('Change the color of each category items as you want.', 'my_newsportal')
   ));

   $wp_customize->add_section('my_newsportal_category_color_setting', array(
      'priority' => 1,
      'title' => __('Category Color Settings', 'my_newsportal'),
      'panel' => 'my_newsportal_category_color_panel'
   ));

   $i = 1;
   $args = array(
       'orderby' => 'id',
       'hide_empty' => 0
   );
   $categories = get_categories( $args );
   $wp_category_list = array();
   foreach ($categories as $category_list ) {
      $wp_category_list[$category_list->cat_ID] = $category_list->cat_name;

      $wp_customize->add_setting('my_newsportal_category_color_'.get_cat_id($wp_category_list[$category_list->cat_ID]), array(
         'default' => '',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'my_newsportal_color_option_hex_sanitize',
         'sanitize_js_callback' => 'my_newsportal_color_escaping_option_sanitize'
      ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'my_newsportal_category_color_'.get_cat_id($wp_category_list[$category_list->cat_ID]), array(
         'label' => sprintf(__('%s', 'my_newsportal'), $wp_category_list[$category_list->cat_ID] ),
         'section' => 'my_newsportal_category_color_setting',
         'settings' => 'my_newsportal_category_color_'.get_cat_id($wp_category_list[$category_list->cat_ID]),
         'priority' => $i
      )));
      $i++;
   }

	// sanitization works
	// radio/select buttons sanitization
	function my_newsportal_radio_select_sanitize( $input, $setting ) {
		// Ensuring that the input is a slug.
		$input = sanitize_key( $input );
		// Get the list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;
		// If the input is a valid key, return it, else, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

   // radio button sanitization
   function my_newsportal_related_posts_sanitize($input) {
      $valid_keys = array(
         'categories' => __('Related Posts By Categories', 'my_newsportal'),
         'tags' => __('Related Posts By Tags', 'my_newsportal')
      );
      if ( array_key_exists( $input, $valid_keys ) ) {
         return $input;
      } else {
         return '';
      }
   }

   function my_newsportal_show_radio_saniztize($input) {
      $valid_keys = array(
         'header_logo_only' => __('Header Logo Only', 'my_newsportal'),
         'header_text_only' => __('Header Text Only', 'my_newsportal'),
         'show_both' => __('Show Both', 'my_newsportal'),
         'disable' => __('Disable', 'my_newsportal')
      );
      if ( array_key_exists( $input, $valid_keys ) ) {
         return $input;
      } else {
         return '';
      }
   }

   function my_newsportal_header_image_position_sanitize($input) {
      $valid_keys = array(
         'position_one' => __('Display the Header image just above the site title/text.', 'my_newsportal'),
         'position_two' => __('Default: Display the Header image between site title/text and the main/primary menu.', 'my_newsportal'),
         'position_three' => __('Display the Header image below main/primary menu.', 'my_newsportal')
      );
      if ( array_key_exists( $input, $valid_keys ) ) {
         return $input;
      } else {
         return '';
      }
   }

   function my_newsportal_site_layout_sanitize($input) {
      $valid_keys = array(
         'boxed_layout' => __('Boxed Layout', 'my_newsportal'),
         'wide_layout' => __('Wide Layout', 'my_newsportal')
      );
      if ( array_key_exists( $input, $valid_keys ) ) {
         return $input;
      } else {
         return '';
      }
   }

   function my_newsportal_layout_sanitize($input) {
   	$valid_keys = array(
         'right_sidebar' => my_newsportal_ADMIN_IMAGES_URL . '/right-sidebar.png',
			'left_sidebar' => my_newsportal_ADMIN_IMAGES_URL . '/left-sidebar.png',
			'no_sidebar_full_width'	=> my_newsportal_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
			'no_sidebar_content_centered'	=> my_newsportal_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
      );
      if ( array_key_exists( $input, $valid_keys ) ) {
         return $input;
      } else {
         return '';
      }
   }

   // color sanitization
   function my_newsportal_color_option_hex_sanitize($color) {
      if ($unhashed = sanitize_hex_color_no_hash($color))
         return '#' . $unhashed;

      return $color;
   }

   function my_newsportal_color_escaping_option_sanitize($input) {
      $input = esc_attr($input);
      return $input;
   }

   // checkbox sanitization
   function my_newsportal_checkbox_sanitize($input) {
      if ( $input == 1 ) {
         return 1;
      } else {
         return '';
      }
   }

   // sanitization of links
   function my_newsportal_links_sanitize() {
      return false;
   }

}

add_action('customize_register', 'my_newsportal_customize_register');

/*****************************************************************************************/

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function my_newsportal_customize_partial_blogname() {
	bloginfo( 'name' );
}
/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function my_newsportal_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/*****************************************************************************************/

/*
 * Custom Scripts
 */
add_action( 'customize_controls_print_footer_scripts', 'my_newsportal_customizer_custom_scripts' );

function my_newsportal_customizer_custom_scripts() { ?>
<style>
	/* Theme Instructions Panel CSS */
	li#accordion-section-my_newsportal_important_links h3.accordion-section-title, li#accordion-section-my_newsportal_important_links h3.accordion-section-title:focus { background-color: #289DCC !important; color: #fff !important; }
	li#accordion-section-my_newsportal_important_links h3.accordion-section-title:hover { background-color: #289DCC !important; color: #fff !important; }
	li#accordion-section-my_newsportal_important_links h3.accordion-section-title:after { color: #fff !important; }
	/* Upsell button CSS */
	.themegrill-pro-info,
	.customize-control-my_newsportal-important-links a {
		/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#8fc800+0,8fc800+100;Green+Flat+%232 */
		background: #008EC2;
		color: #fff;
		display: block;
		margin: 15px 0 0;
		padding: 5px 0;
		text-align: center;
		font-weight: 600;
	}

	.customize-control-my_newsportal-important-links a{
		padding: 8px 0;
	}

	.themegrill-pro-info:hover,
	.customize-control-my_newsportal-important-links a:hover {
		color: #ffffff;
		/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#006e2e+0,006e2e+100;Green+Flat+%233 */
		background:#2380BA;
	}
</style>
<?php
}
