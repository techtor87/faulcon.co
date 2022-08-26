<?php
/**
 * Template Functions
 *
 * @package     BBP
 * @subpackage  Functions/Templates
 * @copyright   Copyright (c) 2021, Dumitru Brinzan
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Returns the path to the BBP patterns directory
 *
 * @since 1.0.0
 * @return string
 */
if ( ! function_exists( 'bbp_get_patterns_dir' ) ) :
	function bbp_get_patterns_dir() {
		return BBP_PLUGIN_DIR . 'patterns';
	}
endif;

/**
 * Returns the URL to the BBP patterns directory
 *
 * @since 1.0.0
 * @return string
 */
if ( ! function_exists( 'bbp_get_patterns_url' ) ) :
	function bbp_get_patterns_url() {
		return BBP_PLUGIN_URL . 'patterns';
	}
endif;

/**
 * Retrieve the name of the highest priority template file that exists.
 *
 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
 * inherit from a parent theme can just overload one file. If the template is
 * not found in either of those, it looks in the theme-compat folder last.
 *
 * Taken from bbPress
 *
 * @since 1.0.0
 *
 * @param string|array $template_names Template file(s) to search for, in order.
 * @param bool $load If true the template file will be loaded if it is found.
 * @param bool $require_once Whether to require_once or require. Default true.
 *   Has no effect if $load is false.
 * @return string The template filename if one is located.
 */
if ( ! function_exists( 'bbp_locate_template' ) ) :
	function bbp_locate_template( $template_names, $load = false, $require_once = true ) {
		// No file found yet
		$located = false;

		// Try to find a template file
		foreach ( (array) $template_names as $template_name ) {

			// Continue if template is empty
			if ( empty( $template_name ) )
				continue;

			// Trim off any slashes from the template name
			$template_name = ltrim( $template_name, '/' );

			// try locating this template file by looping through the template paths
			foreach( bbp_get_theme_template_paths() as $template_path ) {

				if( file_exists( $template_path . $template_name ) ) {
					$located = $template_path . $template_name;
					break;
				}
			}

			if( $located ) {
				break;
			}
		}

		if ( ( true == $load ) && ! empty( $located ) )
			load_template( $located, $require_once );

		return $located;
	}
endif;

/**
 * Returns a list of paths to check for template locations
 *
 * @since 1.8.5
 * @return mixed|void
 */
if ( ! function_exists( 'bbp_get_theme_template_paths' ) ) :
	function bbp_get_theme_template_paths() {

		$template_dir = bbp_get_theme_template_dir_name();

		$file_paths = array(
			1 => trailingslashit( get_stylesheet_directory() ) . $template_dir,
			10 => trailingslashit( get_template_directory() ) . $template_dir,
			100 => bbp_get_templates_dir()
		);

		$file_paths = apply_filters( 'bbp_template_paths', $file_paths );

		// sort the file paths based on priority
		ksort( $file_paths, SORT_NUMERIC );

		return array_map( 'trailingslashit', $file_paths );
	}
endif;

/**
 * Returns the template directory name.
 *
 * Themes can filter this by using the bbp_templates_dir filter.
 *
 * @since 1.0.0
 * @return string
*/
if ( ! function_exists( 'bbp_get_theme_template_dir_name' ) ) :
	function bbp_get_theme_template_dir_name() {
		return trailingslashit( apply_filters( 'bbp_templates_dir', 'bbp_templates' ) );
	}
endif;