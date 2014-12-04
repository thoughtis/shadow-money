<?php

namespace Athletics\WordPress;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Settings Page
 */
class Affiliated_Links_Settings {

	/**
	 * @var $instance Affiliated_Links_Settings
	 * @access public
	 */
	public static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'admin_menu') );

	}

	/**
	 * Get Instance of This Class
	 *
	 * @return Affiliated_Links_Settings
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/**
	 * Admin Menu
	 */
	public function admin_menu() {

		add_submenu_page(
			'options-general.php',
			'Affiliated Links Settings',
			'Affiliated Links',
			'manage_options',
			'affiliated-links-settings',
			array( $this, 'settings_page' )
		);

	}

	/**
	 * Settings Page
	 */
	public function settings_page() {}

}