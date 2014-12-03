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

	/**
	 * @var $instance
	 * @access public
	 */
	public static $instance = null;

	public function __contruct() {}

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

	/**
	 * Content Filters
	 */
	public function content_filters() {

		$filters = array(
			'the_content',
			'the_content_feed',
			'comment_text',
			'comment_text_rss',
		);

		$filters = apply_filters( 'affiliated_content_filters', $filters );

		if ( empty( $filters ) ) return;

		foreach ( $filters as $filter ) {
			add_filter( $filter, array( $this, 'content_filter' ) );
		}

	}

	/**
	 * Link Filters
	 */
	public function link_filters() {

		$filters = array();

		$filters = apply_filters( 'affiliated_link_filters', $filters );

		if ( empty( $filters ) ) return;

		foreach ( $filters as $filter ) {
			add_filter( $filter, array( $this, 'link_filter' ) );
		}

	}

	/**
	 * Content Filter
	 *
	 * @param  string $content
	 * @return string $content
	 */
	public function content_filter( $content ) {
		return $content;
	}

	/**
	 * Link Filter
	 *
	 * @param  string $link
	 * @return string $link
	 */
	public function link_filter( $link ) {
		return $link;
	}

	/**
	 * Load DOMDocument
	 */
	private function load_dom_document() {}

	/**
	 * Find Links
	 */
	private function get_links() {}

}