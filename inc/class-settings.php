<?php

namespace Athletics\Shadow_Money;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Settings Page
 */

class Settings {

	/**
	 * @var $instance Settings
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
	 * @return Settings
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

		register_setting(
			'shadow_money_settings',
			'shadow_money_settings'
		);

		add_submenu_page(
			'options-general.php',
			'Shadow Money Settings',
			'Shadow Money',
			'manage_options',
			'shadow-money-settings',
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

		$sections = apply_filters( 'shadow_money_settings_sections', $sections );

		foreach ( $sections as $section ) {

			add_settings_section(
				$section['id'],
				$section['title'],
				$section['callback'],
				'shadow-money-settings'
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

		$fields = apply_filters( 'shadow_money_settings_fields', $fields );

		foreach ( $fields as $field ) {

			add_settings_field(
				$field['id'],
				$field['title'],
				array( $this, $field['callback'] ),
				'shadow-money-settings',
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
			<h2>Shadow Money Settings</h2>
			<form action="options.php" method="post">
				<?php
				wp_nonce_field( 'shadow_money_settings', 'shadow_money_settings_nonce', false );
				settings_fields( 'shadow_money_settings' );
				do_settings_sections( 'shadow-money-settings' );
				?>
				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * Checkbox Field Type
	 */
	public function checkbox( $args ) {

		$checked = $this->get_option( "{$args['section']}[{$args['id']}]" );
		?>
		<label>
			<input type="checkbox" name="<?php echo esc_attr( $args['section'] ) ?>[<?php echo esc_attr( $args['id'] ); ?>]" <?php checked( $checked ); ?>>
			<?php echo esc_html( $option['title'] ); ?>
		</label>
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
			$this->options = get_option( 'shadow_money_settings', array() );
		}

		return isset( $this->options[$key] ) ? $this->options[$key] : false;

	}

}