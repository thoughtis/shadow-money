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

require_once( __DIR__ . '/inc/class-affiliated-links.php' );

Athletics\WordPress\Affiliated_Links::instance();