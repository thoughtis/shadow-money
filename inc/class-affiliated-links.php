<?php

namespace Athletics\WordPress;
use DOMDocument;

if ( ! defined( 'ABSPATH' ) ) exit;

class Affiliated_Links {

	/**
	 * @var $instance Affiliated_Links
	 * @access public
	 */
	public static $instance = null;

	/**
	 * @var $document DOMDocument
	 * @access private
	 */
	private $document;

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->content_filter_locations();
		$this->link_filter_locations();

	}

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
	 * Content Filter Locations
	 */
	public function content_filter_locations() {

		$locations = array(
			'the_content',
			'the_content_feed',
			'comment_text',
			'comment_text_rss',
		);

		$locations = apply_filters( 'affiliated_content_locations', $locations );

		if ( empty( $locations ) ) return;

		foreach ( $locations as $location ) {
			add_filter( $location, array( $this, 'content_filter' ) );
		}

	}

	/**
	 * Link Filter Locations
	 */
	public function link_filter_locations() {

		$locations = array();

		$locations = apply_filters( 'affiliated_link_locations', $locations );

		if ( empty( $locations ) ) return;

		foreach ( $locations as $location ) {
			add_filter( $location, array( $this, 'link_filter' ) );
		}

	}

	/**
	 * Content Filter
	 *
	 * @param  string $content
	 * @return string $content
	 */
	public function content_filter( $content ) {

		if ( empty( $content ) ) return $content;

		$this->load_dom_document( $content );
		$links = $this->load_links();

		if ( empty( $links ) ) return $content;

		foreach ( $links as $key => $link ) {
			$links[$key]['replace'] = $this->link_filter( $link );
		}

		foreach ( $links as $link ) {
			$content = str_replace( $link['search'], $link['replace'], $content );
		}

		return $content;

	}

	/**
	 * Link Filter
	 *
	 * @param  string $link
	 * @return string $link
	 */
	public function link_filter( $link ) {

		return apply_filters( 'affiliated_link_filters', $link );

	}

	/**
	 * Load DOMDocument
	 *
	 * @param  string $content
	 */
	private function load_dom_document( $content ) {

		$this->document = new DOMDocument();

		libxml_use_internal_errors( true );
		$this->document->loadHTML( $content );
		libxml_clear_errors();

		$this->document->preserveWhiteSpace = false;

	}

	/**
	 * Load Links from DOMDocument
	 *
	 * @return  array $links
	 */
	private function load_links() {

		$links = array();
		$elements = $this->document->getElementsByTagName( 'a' );

		foreach ( $elements as $link ) {
			$links[] = array(
				'search' => $link->getAttribute( 'href' ),
			);
		}

		return $links;

	}

}