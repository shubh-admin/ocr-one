<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://shubhcomputing.com
 * @since             1.0.0
 * @package           Ocr_One
 *
 * @wordpress-plugin
 * Plugin Name:       OCR ONE
 * Plugin URI:        http://shubhcomputing.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            shubhcomputing
 * Author URI:        http://shubhcomputing.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ocr-one
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ocr-one-activator.php
 */
function activate_ocr_one() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ocr-one-activator.php';
	Ocr_One_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ocr-one-deactivator.php
 */
function deactivate_ocr_one() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ocr-one-deactivator.php';
	Ocr_One_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ocr_one' );
register_deactivation_hook( __FILE__, 'deactivate_ocr_one' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ocr-one.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ocr_one() {
	$plugin = new Ocr_One();
	$plugin->run();
	add_action('admin_menu',array($plugin,'create_menu'));
	add_action('init',array($plugin,codex_ocrone_init));
	add_shortcode( 'ocr-one', array($plugin,'ocrone_shortcode') );
	if (isset($_POST['ocr_submit'])) {
		add_action('admin_init', array($plugin,'save_ocr_files'));
	}
	if(isset($_POST['ocr_submit_frontend']))
	{
		add_action('wp_head',array($plugin,'save_ocr_files'));
	}
	if(isset($_POST['isk_submit']))
	{
		add_action('admin_init', array($plugin,'save_subscription_key'));
	}

	if (isset($_POST['apc_delete_file'])) {
		add_action('admin_init', array($plugin,'delete_ocr_data'));
	}

	if (isset($_POST['apc_show_file'])) {
		add_action('wp_head', array($plugin,'show_ocr_data'));
	}

	if (isset($_POST['apc_show_admin_file'])) {
		add_action('admin_init', array($plugin,'show_ocr_admin_data'));
	}

	if (isset($_POST['apc_delete_file_frontend'])) {
		add_action('wp_head', array($plugin,'delete_ocr_data'));
	}

	if (isset($_POST['apc_show_file_frontend'])) {
		add_action('wp_head', array($plugin,'show_ocr_data'));
	}

	if(isset($_POST['edit_ocr_submit']))
	{
		add_action('wp_head', array($plugin,'save_ocr_frontend'));
	}
}



run_ocr_one();
