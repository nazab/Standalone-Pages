<?php
/*
Plugin Name: Standalone Pages
Plugin URI: http://www.benjaminazan.com/standalone-pages
Description: An easy way to deploy standalone pages by just uploading new pages template files.
Author: Benjamin AZAN
Author URI: http://www.benjaminazan.com
Version: 0.1
Author Email: benjamin.azan@gmail.com
License:

  Copyright 2013 Benjamin AZAN (benjamin.Azan@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class StandalonePages {
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
		
		// Load plugin text domain
		add_action( 'init', array( $this, 'plugin_textdomain' ) );

		// Register admin styles and scripts
		//add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
		//add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		//add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );
	
		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( 'StandalonePages', 'uninstall' ) );

	} // end constructor
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate( $network_wide ) {
	} // end activate
	
	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function deactivate( $network_wide ) {
	} // end deactivate
	
	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public static function uninstall( $network_wide ) {
	} // end uninstall

	/**
	 * Loads the plugin text domain for translation
	 */
	public function plugin_textdomain() {
	
		$domain = 'standalone-pages-locale';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
        load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
        load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

	} // end plugin_textdomain

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
	
		wp_enqueue_style( 'standalone-pages-admin-styles', plugins_url( 'standalone-pages/css/admin.css' ) );
	
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
	
		wp_enqueue_script( 'standalone-pages-admin-script', plugins_url( 'standalone-pages/js/admin.js' ) );
	
	} // end register_admin_scripts
	
	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {
	
		wp_enqueue_style( 'standalone-pages-plugin-styles', plugins_url( 'standalone-pages/css/display.css' ) );
	
	} // end register_plugin_styles
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {
	
		wp_enqueue_script( 'standalone-pages-plugin-script', plugins_url( 'standalone-pages/js/display.js' ) );
	
	} // end register_plugin_scripts
	
	/*--------------------------------------------*
	 * Core Functions
	 *---------------------------------------------*/
	
	/**
 	 * Check for missing standalone page and add them if needed.
	 */
	function action_create_missing_standalone_pages() {
    	// Get the page-standalone-*.php files to cathc the standalone one
		$page_template_list = glob(get_template_directory().'/page-standalone-*.php');
		foreach($page_template_list as $v) {
			// Check if this template file has page in the database?
			$args = array(
				'sort_order' => 'DESC',
				'sort_column' => 'post_modified',
				'number' => 1,
				'offset' => 0,
				'post_type' => 'page',
				'post_status' => 'publish,draft,pending',
				'meta_key' => '_wp_page_template',
			    'meta_value' => basename($v)
			);
			$pages = get_pages($args);
			
			if(is_array($pages) && count($pages) == 0) {
				// Their is no page in the database with the standalon template.
				// We extract the Template Name atribute of the standalone template.
				$template_content = file_get_contents($v);
				if ( preg_match( '|Template Name:(.*)$|mi', $template_content, $name )) {
					$my_post = array(
					  'post_title'    	=> $name[1],
					  'post_content'  	=> 'This page has been created automaticaly as it use a standalone template. You can modify anything you want but any removal or unpublishing will makes this page reapear over and over. To fix this, use a non standalone template file.',
					  'post_status'   	=> 'publish',
					  'post_author'   	=> 1,
					  'post_type'		=> 'page',
					);					
					// Insert the post into the database
					$page_id = wp_insert_post( $my_post,true);
					update_post_meta($page_id,'_wp_page_template',basename($v));
				} else {
					// No Template Name: found int the template file or file was not found.
					// TODO: Log error somewhere.
				}
			} else {
				// This standalone page already has a page published.
			}
			
		}
	} // end action_create_missing_standalone_pages
	
	static function create_standalone_page($_template_name,$_user_id = NULL) {
		// Get the template name
		$tpl_path = get_stylesheet_directory().'/page-standalone-'.$_template_name.'.php';
		if(is_file($tpl_path) === false) {
			return false;
		}
		$data_file = get_file_data($tpl_path,array('tpl_name'=>'Template Name'));
		if(empty($data_file['tpl_name'])) {
			// TODO log info to the wp-admin.
			return false;
		}
		$tpl_name = $data_file['tpl_name'];
		// get first admin
		if($_user_id === NULL) {
			$admin_list = get_users(array('orderby'=>'ID','role'=>'administrator'));
			if(isset($admin_list[0]) && isset($admin_list[0]->ID)) {
				$_user_id = $admin_list[0]->ID;
			}
		}
		// Create the page
		$my_post = array(
		  'post_title'    	=> $tpl_name,
		  'post_content'  	=> 'This page has been created automaticaly as it use a standalone template. You can modify anything you want but any removal or unpublishing will makes this page reapear over and over. To fix this, use a non standalone template file.',
		  'post_status'   	=> 'publish',
		  'post_author'   	=> $_user_id,
		  'post_type'		=> 'page',
		);
		// Insert the post into the database
		$page_id = wp_insert_post( $my_post,true);
		update_post_meta($page_id,'_wp_page_template','page-standalone-'.$_template_name.'.php');
		return $page_id;
	}

	/**
	* @param string $_template_name	The standalone page template name (page-standalone-<TEMPLATE_NAME>.php)
	* Returns the full URL of the standalone page requested. If it doesn't exist, it return false.
	*/
	static function get_standalone_page_uri($_template_name,$_user_id = NULL) {
		$args = array(
			'sort_order' => 'DESC',
			'sort_column' => 'post_modified',
			'number' => 1,
			'offset' => 0,
			'post_type' => 'page',
			'post_status' => 'publish',
			'meta_key' => '_wp_page_template',
		    'meta_value' => 'page-standalone-'.$_template_name.'.php'
		);
		$pages = get_pages($args);
		if(isset($pages[0]) && isset($pages[0]->ID)) {
			return home_url().'/'.get_page_uri($pages[0]->ID);
		} else {
			// Try to create the missing standalone page
			$new_standalone_page  = self::create_standalone_page($_template_name,$_user_id);
			if($new_standalone_page !== false) {
				return self::get_standalone_page_uri($_template_name,$_user_id);
			} else {
				return false;
			}
		}
	} // end get_standalone_page_uri
} // end class

$standalone_pages = new StandalonePages();
