<?php

/*
Plugin Name: WP Pronamic Secure Content
Plugin URI: http://pronamic.nl
Description: A Quick Secure Content Plugin
Version: 1.0.0
Author: Zogot, Pronamic
Author URI: http://pronamic.nl
License: GPLv2
*/

/* 
Copyright (C) 2013 Pronamic

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

if ( ! class_exists( 'WP_Pronamic_Secure_Content' ) ) :
	
	class WP_Pronamic_Secure_Content {
	
		/**
		 * Holds the version number
		 * 
		 * @var string
		 */
		public $version = '1.0.0';
		
	
		public function __construct() {
			spl_autoload_register( array( $this, 'autoload' ) );
			
			// Base actions
			add_action( 'init', array( $this, 'init' ) );
			
			// Activation/Deactivation hooks
			register_activation_hook( __FILE__, array( $this, 'activate' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
			
			// Get the includes
			include( $this->plugin_path() . '/includes/functions-common.php' );
		}
		
		/**
		 * Base init method. Loads text domain ( more )
		 * 
		 * @hooked init
		 * 
		 * @action before_wp_pronamic_secure_content_init
		 * @action after_wp_pronamic_secure_content_init
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function init() {
			do_action( 'before_wp_pronamic_secure_content_init' );
			
			load_plugin_textdomain( 'wp-pronamic-secure-content', false, $this->plugin_folder() . '/languages' );
			
			
			do_action( 'after_wp_pronamic_secure_content_init' );
		}
		
		/**
		 * Callback for the spl autoload register function. Will
		 * autoload the required classes for this plugin
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param string $class_name
		 */
		public function autoload( $class_name ) {
			// Replace the invalid characters
			$class_name = str_replace( '_', DIRECTORY_SEPARATOR, $class_name );
			
			// Build the file location
			$file = $this->plugin_path() . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $class_name . '.php';
			
			// Check if the file is there, and get it!
			if ( file_exists( $file ) ) {
					include_once( $file );
			}
		}
		
		/**
		 * Returns the name of the plugin folder. Useful
		 * and required for the plugin textdomain
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return string
		 */
		public function plugin_folder() {
			return dirname( plugin_basename( __FILE__ ) );
		}
		
		/**
		 * Returns the root plugin file
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return system
		 */
		public function plugin_file() {
			return __FILE__;
		}
		
		/**
		 * Returns the folder of the root plugin
		 * file
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return system
		 */
		public function plugin_path() {
			return dirname( __FILE__ );
		}
	}
	
	// Load master global class
	global $wp_pronamic_secure_content;
	$wp_pronamic_secure_content = new WP_Pronamic_Secure_Content();

	
	global $pronamic_secure_plugin;
	$pronamic_secure_plugin = new Pronamic_Secure_Plugin();
	
	if ( is_admin() ) {
		global $pronamic_secure_admin;
		$pronamic_secure_admin = new Pronamic_Secure_Admin();
	}
endif;
