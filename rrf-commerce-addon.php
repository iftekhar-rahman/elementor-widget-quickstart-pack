<?php
/**
 * Plugin Name: RRF Commerce Addon
 * Description: RRF Commerce Addon
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Iftekhar Rahman
 * Author URI:  https://developers.elementor.com/
 * Text Domain: rrf-commerce-addon
 * 
 * Elementor tested up to:     3.5.0
 * Elementor Pro tested up to: 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function rrf_commerce_addon() {

	// Load plugin file
	require_once( __DIR__ . '/includes/plugin.php' );

	// Run the plugin
	\RRF_Commerce_Addon\Plugin::instance();

}
add_action( 'plugins_loaded', 'rrf_commerce_addon' );