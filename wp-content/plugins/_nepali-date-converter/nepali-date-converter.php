<?php
/*
Plugin Name: Nepali Date Converter
Plugin URI: http://www.codersantosh.com
Description: Easily convert English Date to Nepali Date and Vice Versa via different methods. 
Version: 1.0
Author: codersantosh
Author URI: http://codersantosh.com
License: GPLv2 or later
Copyright: CoderSantosh (Santosh Kunwar)
*/

/*Make sure we don't expose any info if called directly*/
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
/*Define Constants for this plugin*/
define( 'NEPALI_DATE_CONVERTER_VERSION', '1.0' );
define( 'NEPALI_DATE_CONVERTER_PATH', plugin_dir_path( __FILE__ ) );
define( 'NEPALI_DATE_CONVERTER_URL', plugin_dir_url( __FILE__ ) );

/*Now lets init the functionalities of this plugin*/
require_once( NEPALI_DATE_CONVERTER_PATH . '/inc/init.php' );

/**
 * Load plugin textdomain.
 * see here https://ulrich.pogson.ch/load-theme-plugin-translations
 */
if ( ! function_exists( 'nepali_date_converter_load_textdomain' ) ) :
    function nepali_date_converter_load_textdomain() {

        $domain = 'nepali-date-converter';
        $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

        // wp-content/languages/plugin-name/plugin-name-de_DE.mo
        load_textdomain( 'nepali-date-converter', trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

        // wp-content/plugins/plugin-name/languages/plugin-name-de_DE.mo
        load_plugin_textdomain( 'nepali-date-converter', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }
endif;
add_action( 'plugins_loaded', 'nepali_date_converter_load_textdomain' );

