<?php
/**
 * Plugin Name: MK Simple Marquee
 * Description: Customizable scrolling marquee bar with admin panel settings.
 * Version: 1.0
 * Author: Mamikon
 * Author URI: https://linkedin.com/in/mamikon-arustamyan-3969301ab?/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: mk-simple-marquee
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/render-marquee.php';

add_action( 'admin_menu', 'mk_simple_marquee_add_admin_menu' );

function mk_simple_marquee_add_admin_menu() {
	add_menu_page(
		'MK Simple Marquee Settings',
		'MK Simple Marquee',
		'manage_options',
		'mk-simple-marquee',
		'mk_simple_marquee_settings_page'
	);
}

add_action( 'wp_enqueue_scripts', 'mk_simple_marquee_front_assets' );
function mk_simple_marquee_front_assets() {
	wp_enqueue_style( 'mk-simple-marquee-style', plugin_dir_url( __FILE__ ) . 'assets/css/marquee.css' );
	wp_enqueue_script( 'mk-simple-marquee-script', plugin_dir_url( __FILE__ ) . 'assets/js/marquee.js', [ 'jquery' ], null, true );
}

add_action( 'admin_enqueue_scripts', 'mk_simple_marquee_admin_assets' );

function mk_simple_marquee_admin_assets( $hook ) {
	if ( $hook !== 'toplevel_page_mk-simple-marquee' ) {
		return;
	}

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style(
		'mk-simple-marquee-admin-style',
		plugin_dir_url( __FILE__ ) . 'assets/css/admin.css'
	);

	wp_enqueue_script(
		'mk-simple-marquee-admin-script',
		plugin_dir_url( __FILE__ ) . 'assets/js/admin.js',
		[ 'jquery', 'wp-color-picker' ],
		null,
		true
	);
}

register_activation_hook( __FILE__, 'mk_simple_marquee_activate' );

function mk_simple_marquee_activate() {
	if ( get_option( 'mk_simple_marquee_options' ) === false ) {
		$default_options = [ 
			'enable' => 1,
			'bg_color' => '#000',
			'text_color' => '#fff',
			'font_size' => '16',
			'speed' => '200',
			'height' => '40',
			'hover_pause' => 'true',
			'position' => 'bottom',
			'limit' => 10,
			'post_type' => 'post',
			'disable_on_mobile' => 'false'
		];
		add_option( 'mk_simple_marquee_options', $default_options );
	}
}

