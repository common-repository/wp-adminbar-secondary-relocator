<?php

/**
 * Plugin Name: WP Adminbar Secondary Relocator
 * Plugin URI: https://wordpress.org/plugins/wp-adminbar-secondary-recolator/
 * Description: A Plugin that removes the annoying secondary admin bar menu so you don't click it accidentally when trying to save WP5.0+ post.
 * Author: ThemeStash
 * Author URI: https://themestash.com/
 * Version: 1.0.0
 * License: GPL2+
 * Text Domain: 
 * Domain Path: /languages
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}


if ( !class_exists('WPABSR') ) {

	class WPABSR {

		function __construct(){

			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 10);

		} // end __construct

		function admin_enqueue_scripts(){

			// Get the admin color scheme color
			global $_wp_admin_css_colors;
			$current_color = get_user_option( 'admin_color' );

			$hover_color = $_wp_admin_css_colors[ $current_color ]->colors[3];

			$inline_styles = '#wp-admin-bar-top-secondary{display: none;}.wpabsr-trigger{float: right;text-align: center;cursor:pointer;margin-right: 5px;display: inline-block;height: 32px !important;line-height:26px !important;width: 32px !important;}.wpabsr-trigger::before{vertical-align:middle;}.wpabsr-trigger.rewind{transform: rotate(180deg);line-height: 30px !important;}.wpabsr-trigger:hover{color: ' . esc_attr($hover_color) . ' !important;}';
			$inline_script = 'jQuery(document).ready(function(){
								var menuTrigger = \'<span class="wpabsr-trigger dashicons-before dashicons-admin-collapse"></span>\';
								jQuery("#wp-admin-bar-top-secondary").before(menuTrigger);

								jQuery(document).on("click", ".wpabsr-trigger", function(){
									jQuery("#wp-admin-bar-top-secondary").toggle();

									jQuery(this).toggleClass("rewind");
								});
							});';

			wp_add_inline_style( 'admin-bar', $inline_styles );

			wp_add_inline_script( 'jquery-core', $inline_script );

		}

	}

	new WPABSR();
}