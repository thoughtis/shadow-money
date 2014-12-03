<?php

/**
 * Plugin Name: Affiliated Links
 * Plugin URI: http://github.com/athletics/affiliated-links
 * Description: Add affiliate codes to links in post and page content
 * Version: 0.1.0
 * Author: Athletics
 * Author URI: http://athleticsnyc.com
 * Copyright: 2014 Athletics
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

if ( ! defined( 'ABSPATH' ) ) exit;

class Affiliated_Links {

	public function __contruct() {}

	/**
	 * Content Filters
	 */
	public function content_filters() {}

	/**
	 * Link Filters
	 */
	public function link_filters() {}

	/**
	 * Load DOMDocument
	 */
	private function load_dom_document() {}

	/**
	 * Find Links
	 */
	private function get_links() {}

}