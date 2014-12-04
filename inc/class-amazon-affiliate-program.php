<?php

namespace Athletics\WordPress;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Amazon.com Affiliate Program
 *
 * @link https://affiliate-program.amazon.com
 */
class Amazon_Affiliate_Program {

	/**
	 * @var $instance Amazon_Affiliate_Program
	 * @access public
	 */
	public static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {

		add_filter( 'affiliated_link_filters', array( $this, 'link_filter' ) );

	}

	/**
	 * Get Instance of This Class
	 *
	 * @return Affiliate_Links
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/**
	 * Link Filter
	 *
	 * @param  string $link
	 * @return string $link
	 */
	public function link_filter( $link ) {

		if ( $this->is_amazon_link( $link ) ) {
			$link = $this->add_affiliate_code( $link );
		}

		return $link;

	}

	/**
	 * Is this an Amazon Link?
	 *
	 * @param  string $link
	 * @return boolean
	 */
	private function is_amazon_link( $link ) {

		$regex =  '/' .
			'http:\/\/' .
				'(' .
					'.*amazon\.' .
						'(' .
							'com' .
								'|' .
							'at' .
								'|' .
							'ca' .
								'|' .
							'de' .
								'|' .
							'es' .
								'|' .
							'fr' .
								'|' .
							'it' .
								'|' .
							'co.jp' .
								'|' .
							'co.uk' .
						')' .
					'\/.*' .
						'|' .
					'.*amzn\.com\/.*' .
				')' .
		'/i';

		preg_match( $regex, $link, $matches );

		if ( empty( $matches ) ) return false;

		return true;

	}

	/**
	 * Add Affiliate Tag to Amazon Link
	 *
	 * @param  string $link
	 * @return string $link
	 */
	public function add_affiliate_code( $link ) {

		$og = $link;

		$query = array();
		$components = parse_url( html_entity_decode( $link ) );
		$tag = $this->get_affiliate_tag( $components['host'] );

		if ( empty( $tag ) ) return $link;

		if ( isset( $components['query'] ) ) {
			parse_str( $components['query'], $query );
		}

		$query['tag'] = $tag;
		$components['query'] = http_build_query( $query );

		$link = $components['scheme'] . '://' . $components['host'] . $components['path'] . '?' . htmlentities( $components['query'] );

		return $link;

	}

	/**
	 * Get Affiliate Tag
	 *
	 * @param  string $domain
	 * @return string
	 */
	private function get_affiliate_tag( $domain ) {

		$domain = str_replace( 'www.', '', $domain );

		$tags = array(
			'at' => '',
			'ca' => '',
			'de' => '',
			'es' => '',
			'fr' => '',
			'it' => '',
			'jp' => '',
			'uk' => '',
			'us' => '',
		);

		$tags = apply_filters( 'affiliated_amazon_affiliate_tags', $tags );

		$country = '';

		$hosts = array(
			array(
				'country' => 'at',
				'domains' => array(
					'amazon.at',
				),
			),
			array(
				'country' => 'ca',
				'domains' => array(
					'amazon.ca',
				),
			),
			array(
				'country' => 'de',
				'domains' => array(
					'amazon.de',
				),
			),
			array(
				'country' => 'es',
				'domains' => array(
					'amazon.es',
				),
			),
			array(
				'country' => 'fr',
				'domains' => array(
					'amazon.fr',
				),
			),
			array(
				'country' => 'it',
				'domains' => array(
					'amazon.it',
				),
			),
			array(
				'country' => 'jp',
				'domains' => array(
					'amazon.co.jp',
				),
			),
			array(
				'country' => 'uk',
				'domains' => array(
					'amazon.co.uk',
				),
			),
			array(
				'country' => 'us',
				'domains' => array(
					'amazon.com',
					'amzn.com',
				),
			),
		);

		foreach ( $hosts as $host ) {
			if ( ! in_array( $domain, $host['domains'] ) ) continue;

			$country = $host['country'];
			break;
		}

		return ( empty( $country ) || ! isset( $tags[ $country ] ) ) ? '' : $tags[ $country ];

	}

}