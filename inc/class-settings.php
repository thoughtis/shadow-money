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
	 * @var $group
	 * @access public
	 */
	public $group = 'shadow_money_settings';

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );

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

		add_submenu_page(
			'options-general.php',
			'Shadow Money Settings',
			'Shadow Money',
			'manage_options',
			$this->group,
			array( $this, 'settings_page' )
		);

	}

	/**
	 * Admin Init
	 */
	public function admin_init() {

		$this->register_settings();
		$this->add_sections();
		$this->add_fields();

	}

	/**
	 * Register Settings
	 *
	 * @see http://codex.wordpress.org/Function_Reference/register_setting
	 */
	private function register_settings() {

		$settings = array();

		$settings = apply_filters( "{$this->group}_settings", $settings );

		foreach ( $settings as $setting ) {

			register_setting(
				$this->group,
				$setting['name'],
				array( $this, 'sanitize' )
			);
		}

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

		$sections = apply_filters( "{$this->group}_sections", $sections );

		foreach ( $sections as $section ) {

			add_settings_section(
				$section['id'],
				$section['title'],
				$section['callback'],
				$this->group
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

		$fields = apply_filters( "{$this->group}_fields", $fields );

		foreach ( $fields as $field ) {

			add_settings_field(
				$field['id'],
				$field['title'],
				array( $this, $field['callback'] ),
				$this->group,
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
				wp_nonce_field( $this->group, "{$this->group}_nonce", false );
				settings_fields( $this->group );
				do_settings_sections( $this->group );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Checkbox Field Type
	 */
	public function checkbox( $args ) {

		$option = $this->get_option( "{$args['section']}[{$args['id']}]" );
		?>
		<input type="checkbox" name="<?php echo esc_attr( $args['id'] ); ?>" value="1" <?php checked( $option, 1 ); ?>>
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
			$this->options = get_option( $this->group, array() );
		}

		return isset( $this->options[$key] ) ? $this->options[$key] : false;

	}

}