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
	 * @var $options
	 * @access private
	 */
	private $options = null;

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
		$this->add_fields();

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
	 *
	 * @see http://codex.wordpress.org/Function_Reference/add_settings_section
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
	 * Add Settings Fields
	 *
	 * @see http://codex.wordpress.org/Function_Reference/add_settings_field
	 */
	private function add_fields() {

		$fields = array();

		$fields = apply_filters( 'affiliated_links_settings_fields', $fields );

		foreach ( $fields as $field ) {

			add_settings_field(
				$field['id'],
				$field['title'],
				array( $this, $field['callback'] ),
				'affiliated-links-settings',
				$field['section'],
				$field
			);

		}

	}

	/**
	 * Settings Page
	 */
	public function settings_page() {
		?>
		<div class="wrap">
			<h2>Affiliated Links Settings</h2>
			<form action="options.php" method="post">
				<?php
				wp_nonce_field( 'affiliated_links_settings', 'affiliated_links_settings_nonce', false );
				settings_fields( 'affiliated_links_settings' );
				do_settings_sections( 'affiliated-links-settings' );
				?>
				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * Get Option
	 *
	 * @param  string $key
	 * @return mixed $value
	 */
	private function get_option( $key ) {

		if ( is_null( $this->options ) ) {
			$this->options = get_option( 'affiliated_links_settings', array() );
		}

		return isset( $this->options[$key] ) ? $this->options[$key] : false;

	}

}