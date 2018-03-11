<?php
/**
 * Functions for configuring demo importer.
 *
 * @author   my_newsportal
 * @category Admin
 * @package  Importer/Functions
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup demo importer packages.
 *
 * @param  array $packages
 * @return array
 */
function my_newsportal_demo_importer_packages( $packages ) {
	$new_packages = array(
		'my_newsportal-free' => array(
			'name'    => __( 'my_newsportal', 'my_newsportal' ),
			'preview' => 'http://demo.themegrill.com/my_newsportal/',
		),
	);

	return array_merge( $new_packages, $packages );
}
add_filter( 'themegrill_demo_importer_packages', 'my_newsportal_demo_importer_packages' );