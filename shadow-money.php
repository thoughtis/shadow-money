<?php

/**
 * Plugin Name: Shadow Money
 * Plugin URI: http://github.com/athletics/shadow-money
 * Description: Add affiliate codes to links in post and page content
 * Version: 0.1.3
 * Author: Athletics
 * Author URI: http://athleticsnyc.com
 * Copyright: 2014 Athletics
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once( __DIR__ . '/inc/class-amazon-affiliate-program.php' );
require_once( __DIR__ . '/inc/class-client.php' );

Athletics\Shadow_Money\Amazon_Affiliate_Program::instance();
Athletics\Shadow_Money\Client::instance();