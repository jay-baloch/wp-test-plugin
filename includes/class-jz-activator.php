<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wordpress.com/
 * @since      1.0.0
 *
 * @package    JZ_Public
 * @subpackage JZ_Public/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    JZ_Public
 * @subpackage JZ_Public/includes
 * @author     Jahanzaib <jahanzaibbaloch14@gmail.com>
 */

class JZ_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		JZ_Activator::init();
	}


	/**
	 * [init add the tables]
	 * if wants to add database table
	 */
	public static function init() {
		
		ini_set('max_execution_time', 0);

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		global $wpdb;
		$charset_collate = 'utf8';
		$prefix 	 	 = $wpdb->prefix."jz";
		$database    = $wpdb->dbname;

	}


	
}
