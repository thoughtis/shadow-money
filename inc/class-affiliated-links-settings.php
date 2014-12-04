<?php

namespace Athletics\WordPress;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Settings Page
 */
class Affiliated_Links_Settings {

	/**
	 * @var $instance Affiliated_Links
	 * @access public
	 */
	public static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Get Instance of This Class
	 *
	 * @return Affiliated_Links
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

}