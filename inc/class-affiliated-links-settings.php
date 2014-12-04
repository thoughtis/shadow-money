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

		$this->add_sections();

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
	 * Add Settings Sections
	 */
	private function add_sections() {

		$sections = array(
			array(
				'id' => 'affiliate-providers',
				'title' => 'Affiliate Providers',
				'callback' => '__return_false',
			),
		);

		$sections = apply_filters( 'affiliated_links_settings_sections', $sections );

		foreach ( $sections as $section ) {

			add_settings_section(
				$section['id'],
				$section['title'],
				$section['callback'],
				'affiliated-links-settings'
			);

		}

	}

	/**
	 * Settings Page
	 */
	public function settings_page() {}

}