<?php
/**
 * Scripts
 *
 * @package     BBP
 * @copyright   Copyright (c) 2021, Dumitru Brinzan
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * BBP_Scripts Class
 *
 * This class handles pattern packages
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'BBP_Scripts' ) ) :

	class BBP_Scripts {

		public $bbp_file_core = 'bbp-core';

		public function __construct() {

			add_action( 'wp_enqueue_scripts', array( $this, 'bbp_register_dependencies' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'bbp_register_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'bbp_load_admin_scripts' ), 100 );

		}

		/**
		 * Register Styles
		 *
		 * @since 1.0
		 * @return void
		 */
		public function bbp_register_styles() {
			
			$css_dir 		= BBP_PLUGIN_URL . 'assets/css/';
			$file_theme		= 'bbp-theme.css';
			$bbp_prefix		= $this->bbp_file_core;
			$url_front		= BBP_WP_BASEURL . '/' . $bbp_prefix . '.css';
			$path_front		= BBP_WP_BASEDIR . '/' . $this->bbp_file_core . '.css';
			$path_admin		= BBP_WP_BASEDIR . '/' . $this->bbp_file_core . '-admin.css';

			$bbp_options 	= get_option( 'better_block_patterns' );

			$load_assets			= isset($bbp_options['bbp_load_block_styles']) ? $bbp_options['bbp_load_block_styles'] : '0';
			$load_assets_location	= isset($bbp_options['bbp_speed_load_location']) ? $bbp_options['bbp_speed_load_location'] : 'everywhere';

			// REMOVE IN PRODUCTION
			// $this->bbp_delete_core_styles();

			if ( !file_exists( $path_front ) || !file_exists( $path_admin ) ) {
				$this->bbp_create_core_styles();
			}

			wp_register_style( $this->bbp_file_core, $url_front, array(), BBP_VERSION, 'all' );

			if ( $load_assets !== '0' ) {
				if ( $load_assets_location == 'everywhere' || ( $load_assets_location == 'singular' && is_singular() ) ) {
					wp_enqueue_style( $this->bbp_file_core );
				}
				elseif ( $load_assets_location == 'needed' ) {
					if ( is_singular() ) {
						
						$the_content = strtolower(get_the_content());

						if ( strpos($the_content, 'bbp-pattern') !== false || strpos($the_content, 'is-style-bbp') !== false ) {
							wp_enqueue_style( $this->bbp_file_core );
						}
					}
				}
			}

			// Next: Check if parent or child theme has a CSS file that overloads the default CSS
			$templates_dir = bbp_get_theme_template_dir_name();

			$child_theme_style_sheet    = trailingslashit( get_stylesheet_directory() ) . $templates_dir . $file_theme;
			$parent_theme_style_sheet   = trailingslashit( get_template_directory()   ) . $templates_dir . $file_theme;

			$url_front = '';
			// Look in the child theme directory first, followed by the parent theme
			if ( file_exists( $child_theme_style_sheet ) ) {
				$url_front = trailingslashit( get_stylesheet_directory_uri() ) . $templates_dir . $file_theme;
			} elseif ( file_exists( $parent_theme_style_sheet ) ) {
				$url_front = trailingslashit( get_template_directory_uri() ) . $templates_dir . $file_theme;
			}

			wp_register_style( 'bbp-theme', $url_front, array(), BBP_VERSION, 'all' );
			wp_enqueue_style( 'bbp-theme' );

		}

		/**
		 * Enqueues the required admin scripts.
		 *
		 * @since 1.0
		 * @global $post
		 * @param string $hook Page hook
		 * @return void
		 */
		public function bbp_load_admin_scripts( $hook ) {

			if ( $hook == 'post-new.php' || $hook == 'post.php' ) {

				$css_dir = BBP_WP_BASEURL . '/' . $this->bbp_file_core . '-admin.css';

				wp_register_style( $this->bbp_file_core . '-admin', $css_dir, array(), BBP_VERSION );
				wp_enqueue_style( $this->bbp_file_core . '-admin' );

			}

		}

		/**
		 * Register Script & Style Dependencies
		 *
		 * @since 1.0
		 * @return void
		 */
		public function bbp_register_dependencies() {
			
			$js_dir 		= BBP_PLUGIN_URL . 'assets/js/';
			$css_dir 		= BBP_PLUGIN_URL . 'assets/css/';

			$bbp_options 	= get_option( 'better_block_patterns' );

			$load_fontawesome = isset($bbp_options['bbp_load_fontawesome_styles']) ? $bbp_options['bbp_load_fontawesome_styles'] : '0';
			
			$fontawesome_array = array();
			if ( $load_fontawesome != '0' ) {
				wp_register_style( 'bbp-fontawesome', $css_dir . 'bbp-fontawesome-all-min.css', array(), '5.15.4', 'all' );
				$fontawesome_array[] = 'bbp-fontawesome';
			}

			wp_register_script( 'bbp-flexslider', $js_dir . 'flexslider-min.js', array('jquery'), '2.7.2', true );
			wp_register_script( 'bbp-flexslider-init', $js_dir . 'flexslider-init.js', array('jquery','bbp-flexslider'), '1.0.0', true );
			wp_register_script( 'bbp-init', $js_dir . 'bbp-init.js', array('jquery'), '1.0.0', true );
			wp_register_style( 'bbp-flexslider', $css_dir . 'bbp-flexslider.css', $fontawesome_array, BBP_VERSION, 'all' );

			$this->bbp_enqueue_dependencies_js();
			$this->bbp_enqueue_dependencies_css();

		}

		/**
		 * Enqueue Pattern CSS Dependencies
		 *
		 * @since 1.0
		 * @return void
		 */
		public function bbp_enqueue_dependencies_css() {
			
			global $BBP_instance;

			$base_dir 			= BBP_PLUGIN_DIR . 'patterns/';
			$front_css			= array('bbp-flexslider' => 'is-style-bbp-block-with-flexslider');

			$bbp_options 			= get_option( 'better_block_patterns' );
			$bbp_enabled_packages 	= $bbp_options['bbp_pattern_packages'];
			$load_assets_location	= isset($bbp_options['bbp_speed_load_location']) ? $bbp_options['bbp_speed_load_location'] : 'everywhere';

			if ( isset($BBP_instance->default_pattern_packages) && !empty($BBP_instance->default_pattern_packages) ) {
				
				foreach ($BBP_instance->default_pattern_packages as $category_slug => $category_data) {

					// Check if this patterns package is enabled on the Settings page
					if ( !isset( $bbp_enabled_packages[$category_slug] ) ) {
						continue;
					}

					// Check if this patterns package contains patterns
					if ( !isset($category_data['patterns']) || empty($category_data['patterns']) ) {
						continue;
					}

					foreach ($category_data['patterns'] as $pattern_key => $pattern_data) {

						// Check if this pattern is enabled on the Settings page
						if ( !isset($bbp_options[ 'bbp_pattern_package_' . $category_slug ][$pattern_data['slug']]) ) {
							continue;
						}

						if ( !isset($pattern_data['css_dependencies'] ) ) {
							continue;
						}

						foreach ( $pattern_data['css_dependencies'] as $css_handle => $css_title ) {
							if ( !isset($front_css[$css_handle]) ) {
								$front_css[$css_handle] = $pattern_data['pattern_class'];
							}
						}

					}

				} // foreach pattern packages
			} // if pattern packages are defined

			if ( isset($BBP_instance->custom_pattern_packages) && !empty($BBP_instance->custom_pattern_packages) ) {
				
				foreach ($BBP_instance->custom_pattern_packages as $category_slug => $category_data) {

					// Check if this patterns package is enabled on the Settings page
					if ( !isset( $bbp_enabled_packages[$category_slug] ) ) {
						continue;
					}

					// Check if this patterns package contains patterns
					if ( !isset($category_data['patterns']) || empty($category_data['patterns']) ) {
						continue;
					}

					foreach ($category_data['patterns'] as $pattern_key => $pattern_data) {

						// Check if this pattern is enabled on the Settings page
						if ( !isset($bbp_options[ 'bbp_pattern_package_' . $category_slug ][$pattern_data['slug']]) ) {
							continue;
						}

						if ( !isset($pattern_data['css_dependencies'] ) ) {
							continue;
						}

						foreach ( $pattern_data['css_dependencies'] as $css_handle => $css_title ) {
							if ( !isset($front_css[$css_handle]) ) {
								$front_css[$css_handle] = $pattern_data['pattern_class'];
							}
						}

					}

				} // foreach pattern packages
			} // if pattern packages are defined

			if ( !empty($front_css) && !is_admin() ) {

				if ( $load_assets_location == 'everywhere' || ( $load_assets_location == 'singular' && is_singular() ) ) {
					
					foreach ($front_css as $style_handle => $style_slug) {
						wp_enqueue_style( $style_handle );
					}

				}
				elseif ( $load_assets_location == 'needed' && is_singular() ) {
					$the_content = strtolower(get_the_content());

					foreach ($front_css as $style_handle => $style_slug) {
						if ( strpos($the_content, $style_slug) !== false ) {
							wp_enqueue_style( $style_handle );
						}
					}

				}

			}

		}

		/**
		 * Enqueue Pattern JS Dependencies
		 *
		 * @since 1.0
		 * @return void
		 */
		public function bbp_enqueue_dependencies_js() {
			
			global $BBP_instance;

			$base_dir 			= BBP_PLUGIN_DIR . 'patterns/';
			$front_js			= array('bbp-flexslider-init' => 'is-style-bbp-block-with-flexslider');

			$bbp_options 			= get_option( 'better_block_patterns' );
			$bbp_enabled_packages 	= $bbp_options['bbp_pattern_packages'];
			$load_assets_location	= isset($bbp_options['bbp_speed_load_location']) ? $bbp_options['bbp_speed_load_location'] : 'everywhere';

			if ( isset($BBP_instance->default_pattern_packages) && !empty($BBP_instance->default_pattern_packages) ) {
				
				foreach ($BBP_instance->default_pattern_packages as $category_slug => $category_data) {

					// Check if this patterns package is enabled on the Settings page
					if ( !isset( $bbp_enabled_packages[$category_slug] ) ) {
						continue;
					}

					// Check if this patterns package contains patterns
					if ( !isset($category_data['patterns']) || empty($category_data['patterns']) ) {
						continue;
					}

					foreach ($category_data['patterns'] as $pattern_key => $pattern_data) {

						// Check if this pattern is enabled on the Settings page
						if ( !isset($bbp_options[ 'bbp_pattern_package_' . $category_slug ][$pattern_data['slug']]) ) {
							continue;
						}

						if ( !isset($pattern_data['js_dependencies'] ) ) {
							continue;
						}

						foreach ( $pattern_data['js_dependencies'] as $js_handle => $js_title ) {
							if ( !isset($front_js[$js_handle]) ) {
								$front_js[$js_handle] = $pattern_data['pattern_class'];
							}
						}

					}

				} // foreach pattern packages
			} // if pattern packages are defined

			if ( !empty($front_js) && !is_admin() ) {

				if ( $load_assets_location == 'everywhere' || ( $load_assets_location == 'singular' && is_singular() ) ) {
					
					foreach ($front_js as $script_handle => $script_slug) {
						wp_enqueue_script( $script_handle );
					}

				}
				elseif ( $load_assets_location == 'needed' && is_singular() ) {
					$the_content = strtolower(get_the_content());

					foreach ($front_js as $script_handle => $script_slug) {
						if ( strpos($the_content, $script_slug) !== false ) {
							wp_enqueue_script( $script_handle );
						}
					}

				}

			}

		}

		/**
		 * Create core .css file for selected patterns.
		 *
		 * @since 1.0
		 * @return void
		 */
		public function bbp_create_core_styles() {
			
			global $BBP_instance;

			$base_dir 			= BBP_PLUGIN_DIR . 'patterns/';
			$common_css_path 	= BBP_PLUGIN_DIR . 'assets/css/' . 'bbp-common.css';
			$front_css_path 	= BBP_WP_BASEDIR . '/' . $this->bbp_file_core . '.css';
			$back_css_path 		= BBP_WP_BASEDIR . '/' . $this->bbp_file_core . '-admin.css';
			$front_css 			= array();
			$front_css_mobile	= array();
			$back_css 			= array();

			$bbp_options = get_option( 'better_block_patterns' );
			$bbp_enabled_packages = $bbp_options['bbp_pattern_packages'];

			// Add short debug info to the beginning of file.
			$front_css[] = '/* Better Block Patterns - Generated on ' . date('r') . ' */';
			$back_css[] = '/* Better Block Patterns - Generated on ' . date('r') . ' */';

			$parsed_css_contents = $this->bbp_parse_css_from_file($common_css_path);

			if ( isset($parsed_css_contents) && $parsed_css_contents !== NULL ) {

				$front_css[]		= $parsed_css_contents['front'];
				$front_css_mobile[]	= $parsed_css_contents['mobile'];
				$back_css[]			= $parsed_css_contents['back'];

			}

			if ( isset($BBP_instance->default_pattern_packages) && !empty($BBP_instance->default_pattern_packages) ) {
				
				foreach ($BBP_instance->default_pattern_packages as $category_slug => $category_data) {

					// Check if this patterns package is enabled on the Settings page
					if ( !isset( $bbp_enabled_packages[$category_slug] ) ) {
						continue;
					}

					// Check if this patterns package contains patterns
					if ( !isset($category_data['patterns']) || empty($category_data['patterns']) ) {
						continue;
					}

					foreach ($category_data['patterns'] as $pattern_key => $pattern_data) {

						// Check if this pattern is enabled on the Settings page
						if ( !isset($bbp_options[ 'bbp_pattern_package_' . $category_slug ][$pattern_data['slug']]) ) {
							continue;
						}

						if ( is_file( $pattern_data['file_css_front'] ) ) {

							$parsed_css_contents = $this->bbp_parse_css_from_file($pattern_data['file_css_front']);

							if ( isset($parsed_css_contents) && $parsed_css_contents !== NULL ) {

								$front_css[]		= $parsed_css_contents['front'];
								if ( isset($parsed_css_contents['mobile']) ) {
									$front_css_mobile[]	= $parsed_css_contents['mobile'];
								}

							}
							
						} // if front-end pattern CSS file exists

						if ( is_file( $pattern_data['file_css_back'] ) ) {

							$back_css[] = file_get_contents($pattern_data['file_css_back']);
							
						} // if front-end pattern CSS file exists

					}

				} // foreach pattern packages
			} // if pattern packages are defined

			if ( isset($BBP_instance->custom_pattern_packages) && !empty($BBP_instance->custom_pattern_packages) ) {
				
				foreach ($BBP_instance->custom_pattern_packages as $category_slug => $category_data) {

					// Check if this patterns package is enabled on the Settings page
					if ( !isset( $bbp_enabled_packages[$category_slug] ) ) {
						continue;
					}

					// Check if this patterns package contains patterns
					if ( !isset($category_data['patterns']) || empty($category_data['patterns']) ) {
						continue;
					}

					foreach ($category_data['patterns'] as $pattern_key => $pattern_data) {

						// Check if this pattern is enabled on the Settings page
						if ( !isset($bbp_options[ 'bbp_pattern_package_' . $category_slug ][$pattern_data['slug']]) ) {
							continue;
						}

						if ( is_file( $pattern_data['file_css_front'] ) ) {

							$parsed_css_contents = $this->bbp_parse_css_from_file($pattern_data['file_css_front']);

							if ( isset($parsed_css_contents) && $parsed_css_contents !== NULL ) {

								$front_css[]		= $parsed_css_contents['front'];
								if ( isset($parsed_css_contents['mobile']) ) {
									$front_css_mobile[]	= $parsed_css_contents['mobile'];
								}

							}
							
						} // if front-end pattern CSS file exists

						if ( is_file( $pattern_data['file_css_back'] ) ) {

							$back_css[] = file_get_contents($pattern_data['file_css_back']);
							
						} // if front-end pattern CSS file exists

					}

				} // foreach pattern packages
			} // if pattern packages are defined

			if ( !empty($front_css) || !empty($front_css_mobile) ) {

				$all_css_files = array_merge($front_css,$front_css_mobile);

				// Combine all CSS files into one
				$patterns_css_all = implode(PHP_EOL . PHP_EOL, $all_css_files);
				
				// Write to file the CSS code
				$result = file_put_contents($front_css_path, $patterns_css_all);

			}

			if ( !empty($back_css) ) {

				// Combine all CSS files into one
				$patterns_css_all = implode(PHP_EOL . PHP_EOL, $back_css);
				
				// Write to file the CSS code
				$result = file_put_contents($back_css_path, $patterns_css_all);

			}

		}

		/**
		 * Delete core .css file for selected patterns.
		 *
		 * @since 1.0
		 * @return void
		 */
		public function bbp_delete_core_styles() {
			
			$front_css_path 	= BBP_WP_BASEDIR . '/' . $this->bbp_file_core . '.css';
			$admin_css_path 	= BBP_WP_BASEDIR . '/' . $this->bbp_file_core . '-admin.css';
			
			if ( is_file( $front_css_path ) ) {
				unlink($front_css_path);
			}

			if ( is_file( $admin_css_path ) ) {
				unlink($admin_css_path);
			}

		}

		/**
		 * Refresh core .css file.
		 *
		 * @since 1.0
		 * @return void
		 */
		public function bbp_refresh_core_styles() {
			
			$this->bbp_delete_core_styles();
			$this->bbp_create_core_styles();

		}

		/**
		 * Fetch CSS from file and return array with CSS code for different purposes.
		 *
		 * @since 1.0
		 * @return void
		 */
		private function bbp_parse_css_from_file($css_file) {

			if ( !is_file( $css_file ) ) {
				return NULL;
			}

			$css_file_contents			= file_get_contents($css_file);

			if ( !isset($css_file_contents) || strlen($css_file_contents) == 0 ) {
				return NULL;
			}

			$css_contents_array 	= $this->bbp_split_css_into_array($css_file_contents); 

			return $css_contents_array;

		}

		/**
		 * Explode CSS from variable and return array with CSS code for different purposes.
		 *
		 * @since 1.0
		 * @return void
		 */
		private function bbp_split_css_into_array($css_contents) {

			if ( !isset($css_contents) || strlen($css_contents) == 0 ) {
				return NULL;
			}

			$theme_mod_defaults 		= bbp_get_all_defaults();
			$theme_mods 				= get_theme_mods();

			$bbp_breakpoint_desktop 	= ( isset($theme_mods['bbp-layout-width-desktop']) ? $theme_mods['bbp-layout-width-desktop'] : $theme_mod_defaults['bbp-layout-width-desktop'] );
			$bbp_breakpoint_tablet 		= ( isset($theme_mods['bbp-layout-width-tablet']) ? $theme_mods['bbp-layout-width-tablet'] : $theme_mod_defaults['bbp-layout-width-tablet'] );
			$bbp_breakpoint_mobile 		= ( isset($theme_mods['bbp-layout-width-mobile']) ? $theme_mods['bbp-layout-width-mobile'] : $theme_mod_defaults['bbp-layout-width-mobile'] );

			$css_contents 		= str_replace('@@layout-width-desktop@@', $bbp_breakpoint_desktop . 'px', $css_contents);
			$css_contents 		= str_replace('@@layout-width-tablet@@', $bbp_breakpoint_tablet . 'px', $css_contents);
			$css_contents 		= str_replace('@@layout-width-mobile@@', $bbp_breakpoint_mobile . 'px', $css_contents);

			$css_contents_array 	= explode('/* BBP Core Media Queries */', $css_contents);
			$css_return = array();
			$css_return['front'] 	= trim($css_contents_array['0']);
			$css_return['back'] 	= trim($css_contents_array['0']);
			if ( isset($css_contents_array['1']) ) {
				$css_return['mobile'] 	= trim($css_contents_array['1']);
			}

			return $css_return;

		}

	}

endif;