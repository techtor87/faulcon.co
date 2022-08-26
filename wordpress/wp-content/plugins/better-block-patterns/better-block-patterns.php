<?php
/**
 * Plugin Name: Better Block Patterns
 * Plugin URI: https://betterblockpatterns.com
 * Description: The easiest way to use block patterns in the WordPress Block editor. From portfolios, pricing tables, hotel room pages, user testimonials, to staff directories and more, we make creating these pages easier.
 * Author: ILOVEWP.com
 * Author URI: https://www.ilovewp.com
 * Version: 1.0.3
 * Text Domain: better-block-patterns
 * Domain Path: languages
 *
 * Better Block Patterns is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with Better Block Patterns. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package BBP
 * @category Core
 * @author Dumitru Brinzan
 * @version 1.0.3
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Better_Block_Patterns' ) ) :

/**
 * Main Better_Block_Patterns Class.
 *
 * @since 1.0
 */
final class Better_Block_Patterns {

	/** Singleton *************************************************************/

	/**
	 * @var Better_Block_Patterns The one true Better_Block_Patterns
	 * @since 1.0
	 */
	private static $instance;

	public $default_pattern_packages;
	public $custom_pattern_packages;

	/**
	 * Main Better_Block_Patterns Instance.
	 *
	 * Insures that only one instance of Better_Block_Patterns exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0
	 * @static
	 * @staticvar array $instance
	 * @uses Better_Block_Patterns::setup_constants() Setup the constants needed.
	 * @uses Better_Block_Patterns::load_textdomain() load the language files.
	 * @uses Better_Block_Patterns::includes() Include the required files.
	 * @see BBP()
	 * @return object|Better_Block_Patterns The one true Better_Block_Patterns
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Better_Block_Patterns ) ) {
			self::$instance = new Better_Block_Patterns;
			self::$instance->setup_constants();
			self::$instance->includes();
			
			$BBP_Pattern_Packages	= new BBP_Pattern_Packages();
			$BBP_Settings			= new BBP_Settings();
			$BBP_Scripts			= new BBP_Scripts();
			
			self::$instance->default_pattern_packages = $BBP_Pattern_Packages->get_default_pattern_packages();
			self::$instance->custom_pattern_packages = $BBP_Pattern_Packages->get_custom_pattern_packages();

			add_action( 'update_option_better_block_patterns', array( $BBP_Scripts, 'bbp_refresh_core_styles' ), 100 );
			add_action( 'customize_save_after', array( $BBP_Scripts, 'bbp_refresh_core_styles' ) );

			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
			add_filter( 'plugin_action_links_better-block-patterns/better-block-patterns.php', array( self::$instance, 'bbp_custom_action_links' ) );

			register_activation_hook( __FILE__, array( self::$instance, 'bbp_on_plugin_activation' ) );

		}

		return self::$instance;
	}

	/**
	 * Throw error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'better-block-patterns' ), '1.0' );
	}

	/**
	 * Disable unserializing of the class.
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'better-block-patterns' ), '1.0' );
	}

	/**
	 * Setup plugin constants.
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function setup_constants() {

		// Plugin version.
		if ( ! defined( 'BBP_VERSION' ) ) {
			define( 'BBP_VERSION', '1.0.3' );
		}

		// Plugin Folder Path.
		if ( ! defined( 'BBP_PLUGIN_DIR' ) ) {
			define( 'BBP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL.
		if ( ! defined( 'BBP_PLUGIN_URL' ) ) {
			define( 'BBP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File.
		if ( ! defined( 'BBP_PLUGIN_FILE' ) ) {
			define( 'BBP_PLUGIN_FILE', __FILE__ );
		}

		$bbp_upload_dir = wp_upload_dir();

		// WordPress Uploads Basedir
		if ( ! defined( 'BBP_WP_BASEDIR' ) ) {
			define( 'BBP_WP_BASEDIR', $bbp_upload_dir['basedir'] );
		}

		// WordPress Uploads Baseurl
		if ( ! defined( 'BBP_WP_BASEURL' ) ) {
			define( 'BBP_WP_BASEURL', $bbp_upload_dir['baseurl'] );
		}

	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function includes() {

		require_once BBP_PLUGIN_DIR . 'includes/template-functions.php';
		require_once BBP_PLUGIN_DIR . 'includes/class-pattern-packages.php';
		require_once BBP_PLUGIN_DIR . 'includes/class-blocks-manager.php';
		require_once BBP_PLUGIN_DIR . 'includes/class-patterns-manager.php';
		require_once BBP_PLUGIN_DIR . 'includes/class-settings.php';
		require_once BBP_PLUGIN_DIR . 'includes/class-customizer.php';
		require_once BBP_PLUGIN_DIR . 'includes/class-scripts.php';

	}

	/**
	 * Loads the plugin language files.
	 *
	 * @since 1.0
	 * @return void
	 */
	public function load_textdomain() {
		global $wp_version;

		$bbp_lang_dir  = apply_filters( 'bbp_languages_directory', dirname( plugin_basename( BBP_PLUGIN_FILE ) ) . '/languages/');
		load_plugin_textdomain( 'better-block-patterns', false, $bbp_lang_dir );

	}

	public function bbp_custom_action_links( $links ) { 

/*
		if ( !is_plugin_active( 'better-block-patterns-pro/better-block-patterns-pro.php' ) ) {
			$url = add_query_arg( 'page', 'better-block-patterns-upgrade', get_admin_url() . 'admin.php' );
			$premium_link = '<a href="' . esc_url( $url ) . '" style="font-weight: bold;">' . __( 'Get Premium', 'better-block-patterns' ) . '</a>';
			array_unshift( $links, $premium_link );
		}
*/
		$url = add_query_arg( 'page', 'better-block-patterns-settings', get_admin_url() . 'admin.php' );
		$setting_link = '<a href="' . esc_url( $url ) . '" style="font-weight: bold;">' . __( 'Settings', 'better-block-patterns' ) . '</a>';
		array_unshift( $links, $setting_link );

		$url = add_query_arg( 'page', 'better-block-patterns', get_admin_url() . 'admin.php' );
		$setting_link = '<a href="' . esc_url( $url ) . '">' . __( 'Getting Started', 'better-block-patterns' ) . '</a>';
		array_unshift( $links, $setting_link );

		return $links;
		
	}

	public function bbp_on_plugin_activation() {

		$this->bbp_set_default_plugin_settings();

	}

	private function bbp_set_default_plugin_settings() {

		if ( !get_option('better_block_patterns') ) {
		
			$bbp_options = array(
				'bbp_pattern_packages' 			=> array(
					'general-features'			=> '1'
				),
				'bbp_load_block_styles' 		=> '1',
				'bbp_load_fontawesome_styles' 	=> '1',
				'bbp_speed_load_location'		=> '1'
			);

			update_option( 'better_block_patterns', $bbp_options );

		}

	}

}

endif; // End if class_exists check.

/**
 * The main function for that returns Better_Block_Patterns
 *
 * @since 1.0
 * @return object|Better_Block_Patterns The one true Better_Block_Patterns Instance.
 */
if ( ! function_exists( 'better_block_patterns' ) ) :
	function better_block_patterns() {
		return Better_Block_Patterns::instance();
	}
endif;

// Get BBP Running.
$BBP_instance = better_block_patterns();