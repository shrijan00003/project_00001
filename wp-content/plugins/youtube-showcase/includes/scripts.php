<?php
/**
 * Enqueue Scripts Functions
 *
 * @package YOUTUBE_SHOWCASE
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
add_action('admin_enqueue_scripts', 'youtube_showcase_load_admin_enq');
/**
 * Enqueue style and js for each admin entity pages and settings
 *
 * @since WPAS 4.0
 * @param string $hook
 *
 */
function youtube_showcase_load_admin_enq($hook) {
	global $typenow;
	$dir_url = YOUTUBE_SHOWCASE_PLUGIN_URL;
	do_action('emd_ext_admin_enq', 'youtube_showcase', $hook);
	$min_trigger = get_option('youtube_showcase_show_rateme_plugin_min', 0);
	$tracking_optin = get_option('youtube_showcase_tracking_optin', 0);
	if (-1 !== intval($tracking_optin) || - 1 !== intval($min_trigger)) {
		wp_enqueue_style('emd-plugin-rateme-css', $dir_url . 'assets/css/emd-plugin-rateme.css');
		wp_enqueue_script('emd-plugin-rateme-js', $dir_url . 'assets/js/emd-plugin-rateme.js');
	}
	if ($hook == 'edit-tags.php') {
		return;
	}
	if (isset($_GET['page']) && $_GET['page'] == 'youtube_showcase_settings') {
		wp_enqueue_script('accordion');
		wp_enqueue_style('codemirror-css', $dir_url . 'assets/ext/codemirror/codemirror.min.css');
		wp_enqueue_script('codemirror-js', $dir_url . 'assets/ext/codemirror/codemirror.min.js', array() , '', true);
		wp_enqueue_script('codemirror-css-js', $dir_url . 'assets/ext/codemirror/css.min.js', array() , '', true);
		wp_enqueue_script('codemirror-jvs-js', $dir_url . 'assets/ext/codemirror/javascript.min.js', array() , '', true);
		return;
	} else if (isset($_GET['page']) && in_array($_GET['page'], Array(
		'youtube_showcase_notify',
		'youtube_showcase_glossary'
	))) {
		wp_enqueue_script('accordion');
		return;
	} else if (isset($_GET['page']) && $_GET['page'] == 'youtube_showcase') {
		wp_enqueue_style('lazyYT-css', $dir_url . 'assets/ext/lazyyt/lazyYT.min.css');
		wp_enqueue_script('lazyYT-js', $dir_url . 'assets/ext/lazyyt/lazyYT.min.js');
		wp_enqueue_script('getting-started-js', $dir_url . 'assets/js/getting-started.js');
		return;
	} else if (isset($_GET['page']) && in_array($_GET['page'], Array(
		'youtube_showcase_store',
		'youtube_showcase_support'
	))) {
		wp_enqueue_style('admin-tabs', $dir_url . 'assets/css/admin-store.css');
		return;
	} else if (isset($_GET['page']) && $_GET['page'] == 'youtube_showcase_licenses') {
		wp_enqueue_style('admin-css', $dir_url . 'assets/css/emd-admin.min.css');
		return;
	}
	if (in_array($typenow, Array(
		'emd_video'
	))) {
		$theme_changer_enq = 1;
		$sing_enq = 0;
		$tab_enq = 0;
		if ($hook == 'post.php' || $hook == 'post-new.php') {
			$unique_vars['msg'] = __('Please enter a unique value.', 'youtube-showcase');
			$unique_vars['reqtxt'] = __('required', 'youtube-showcase');
			$unique_vars['app_name'] = 'youtube_showcase';
			$ent_list = get_option('youtube_showcase_ent_list');
			if (!empty($ent_list[$typenow])) {
				$unique_vars['keys'] = $ent_list[$typenow]['unique_keys'];
				if (!empty($ent_list[$typenow]['req_blt'])) {
					$unique_vars['req_blt_tax'] = $ent_list[$typenow]['req_blt'];
				}
			}
			$tax_list = get_option('youtube_showcase_tax_list');
			if (!empty($tax_list[$typenow])) {
				foreach ($tax_list[$typenow] as $txn_name => $txn_val) {
					if ($txn_val['required'] == 1) {
						$unique_vars['req_blt_tax'][$txn_name] = Array(
							'hier' => $txn_val['hier'],
							'type' => $txn_val['type'],
							'label' => $txn_val['label'] . ' ' . __('Taxonomy', 'youtube-showcase')
						);
					}
				}
			}
			wp_enqueue_script('unique_validate-js', $dir_url . 'assets/js/unique_validate.js', array(
				'jquery',
				'jquery-validate'
			) , YOUTUBE_SHOWCASE_VERSION, true);
			wp_localize_script("unique_validate-js", 'unique_vars', $unique_vars);
		} elseif ($hook == 'edit.php') {
			wp_enqueue_style('youtube-showcase-allview-css', YOUTUBE_SHOWCASE_PLUGIN_URL . '/assets/css/allview.css');
		}
		switch ($typenow) {
			case 'emd_video':
			break;
		}
	}
}
add_action('wp_enqueue_scripts', 'youtube_showcase_frontend_scripts');
/**
 * Enqueue style and js for each frontend entity pages and components
 *
 * @since WPAS 4.0
 *
 */
function youtube_showcase_frontend_scripts() {
	$dir_url = YOUTUBE_SHOWCASE_PLUGIN_URL;
	wp_register_style('emd-pagination', $dir_url . 'assets/css/emd-pagination.min.css');
	wp_register_style('youtube-showcase-allview-css', $dir_url . '/assets/css/allview.css');
	$grid_vars = Array();
	$local_vars['ajax_url'] = admin_url('admin-ajax.php');
	$wpas_shc_list = get_option('youtube_showcase_shc_list');
	wp_register_script('ytscjs', $dir_url . 'assets/js/ytscjs.js');
	wp_register_script('ytsc-js', $dir_url . 'assets/js/ytsc.js');
	wp_register_style('wpas-boot', $dir_url . 'assets/ext/wpas/wpas-bootstrap.min.css');
	wp_register_script('wpas-boot-js', $dir_url . 'assets/ext/wpas/wpas-bootstrap.min.js', array(
		'jquery'
	));
	wp_register_style('videowid', $dir_url . 'assets/css/videowid.css');
	wp_register_script('video-gallery-js', $dir_url . 'assets/js/video-gallery.js');
	if (is_single() && get_post_type() == 'emd_video') {
		youtube_showcase_enq_bootstrap();
		wp_enqueue_style('youtube-showcase-allview-css');
		youtube_showcase_enq_custom_css_js();
		return;
	}
}
function youtube_showcase_enq_bootstrap($type = '') {
	$misc_settings = get_option('youtube_showcase_misc_settings');
	if ($type == 'css' || $type == '') {
		if (empty($misc_settings) || (isset($misc_settings['disable_bs_css']) && $misc_settings['disable_bs_css'] == 0)) {
			wp_enqueue_style('wpas-boot');
		}
	}
	if ($type == 'js' || $type == '') {
		if (empty($misc_settings) || (isset($misc_settings['disable_bs_js']) && $misc_settings['disable_bs_js'] == 0)) {
			wp_enqueue_script('wpas-boot-js');
		}
	}
}
/**
 * Enqueue custom css if set in settings tool tab
 *
 * @since WPAS 5.3
 *
 */
function youtube_showcase_enq_custom_css_js() {
	$tools = get_option('youtube_showcase_tools');
	if (!empty($tools['custom_css'])) {
		$url = home_url();
		if (is_ssl()) {
			$url = home_url('/', 'https');
		}
		wp_enqueue_style('youtube-showcase-custom', add_query_arg(array(
			'youtube-showcase-css' => 1
		) , $url));
	}
	if (!empty($tools['custom_js'])) {
		$url = home_url();
		if (is_ssl()) {
			$url = home_url('/', 'https');
		}
		wp_enqueue_script('youtube-showcase-custom', add_query_arg(array(
			'youtube-showcase-js' => 1
		) , $url));
	}
}
/**
 * If app custom css query var is set, print custom css
 */
function youtube_showcase_print_css() {
	// Only print CSS if this is a stylesheet request
	if (!isset($_GET['youtube-showcase-css']) || intval($_GET['youtube-showcase-css']) !== 1) {
		return;
	}
	ob_start();
	header('Content-type: text/css');
	$tools = get_option('youtube_showcase_tools');
	$raw_content = isset($tools['custom_css']) ? $tools['custom_css'] : '';
	$content = wp_kses($raw_content, array(
		'\'',
		'\"'
	));
	$content = str_replace('&gt;', '>', $content);
	echo $content; //xss okay
	die();
}
function youtube_showcase_print_js() {
	// Only print CSS if this is a stylesheet request
	if (!isset($_GET['youtube-showcase-js']) || intval($_GET['youtube-showcase-js']) !== 1) {
		return;
	}
	ob_start();
	header('Content-type: text/javascript');
	$tools = get_option('youtube_showcase_tools');
	$raw_content = isset($tools['custom_js']) ? $tools['custom_js'] : '';
	$content = wp_kses($raw_content, array(
		'\'',
		'\"'
	));
	$content = str_replace('&gt;', '>', $content);
	echo $content;
	die();
}
function youtube_showcase_print_css_js() {
	youtube_showcase_print_js();
	youtube_showcase_print_css();
}
add_action('plugins_loaded', 'youtube_showcase_print_css_js');
/**
 * Enqueue if allview css is not enqueued
 *
 * @since WPAS 4.5
 *
 */
function youtube_showcase_enq_allview() {
	if (!wp_style_is('youtube-showcase-allview-css', 'enqueued')) {
		wp_enqueue_style('youtube-showcase-allview-css');
	}
}
