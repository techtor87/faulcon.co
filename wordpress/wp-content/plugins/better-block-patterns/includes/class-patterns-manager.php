<?php

/* ---------------------------------------------------------------------------------------------
   PATTERNS MANAGER CLASS
   Handles block patterns.
------------------------------------------------------------------------------------------------ */

if ( ! class_exists( 'BBP_Patterns_Manager' ) ) :
	class BBP_Patterns_Manager {

		public function __construct() {

			add_action( 'init', array( $this, 'bbp_register_block_patterns' ), 9 );

		}

		/*	-----------------------------------------------------------------------------------------------
			REGISTER BLOCK PATTERNS
		--------------------------------------------------------------------------------------------------- */

		public function bbp_register_block_patterns() {

			if ( !function_exists( 'register_block_pattern_category' ) || !function_exists( 'register_block_pattern' ) ) {
				return;
			}

			global $BBP_instance;

			$bbp_prefix = 'bbp-';

			$bbp_options = get_option( 'better_block_patterns' );
			if ( empty($bbp_options['bbp_pattern_packages']) ) { 
				$bbp_packages = array();
			} else { 
				$bbp_packages = $bbp_options['bbp_pattern_packages'];
			}
			if ( empty($bbp_options['bbp_pattern_packages_custom']) ) { 
				$bbp_packages_custom = array();
			} else { 
				$bbp_packages_custom = $bbp_options['bbp_pattern_packages_custom'];
			}

			$bbp_enabled_packages = array_merge($bbp_packages, $bbp_packages_custom);
			
			if ( empty($bbp_enabled_packages) ) { return; }
			
			$bbp_pattern_categories = array();
			
			foreach ($bbp_enabled_packages as $package_slug => $package_value) {
				if ( !empty( $BBP_instance->default_pattern_packages[$package_slug]['patterns'] ) ) {
					$bbp_pattern_categories[$package_slug] = $BBP_instance->default_pattern_packages[$package_slug]['title'];
				}
				elseif ( !empty( $BBP_instance->custom_pattern_packages[$package_slug]['patterns'] ) ) {
					$bbp_pattern_categories[$package_slug] = $BBP_instance->custom_pattern_packages[$package_slug]['title'];
				}
			}

			if ( !empty($bbp_pattern_categories) ) {

				foreach ( $bbp_pattern_categories as $pattern_category_slug => $pattern_category_title ) {

					// Check if any patterns are enabled for this package
					if ( !empty($bbp_options['bbp_pattern_package_' . $pattern_category_slug]) ) {

						// Register the patterns category
						register_block_pattern_category( $bbp_prefix . esc_attr($pattern_category_slug), array( 
							'label' => sprintf( __( 'BBP: %1$s', 'better-block-patterns' ), $pattern_category_title )
						) );

						foreach ( $bbp_options['bbp_pattern_package_' . $pattern_category_slug] as $pattern_key => $pattern_data ) {

							$pattern_name = $bbp_prefix . $pattern_category_slug . '/' . $pattern_key;

							if ( !empty( $BBP_instance->default_pattern_packages[$pattern_category_slug]['patterns'][$pattern_key] ) ) {
								
								$pattern_data = $BBP_instance->default_pattern_packages[$pattern_category_slug]['patterns'][$pattern_key];

								$this->bbp_register_block_pattern($pattern_name, $pattern_data);

							} // if this pattern is in a default pattern package

							elseif ( !empty( $BBP_instance->custom_pattern_packages[$pattern_category_slug]['patterns'][$pattern_key] ) ) {
								
								$pattern_data = $BBP_instance->custom_pattern_packages[$pattern_category_slug]['patterns'][$pattern_key];

								$this->bbp_register_block_pattern($pattern_name, $pattern_data);

							} // if this pattern is in a custom pattern package

						} // foreach 

					} // if this pattern category has any enabled patterns

				} // foreach
			} // if any pattern packages with enabled patterns are enabled

		}


		public function bbp_register_block_pattern ( $pattern_name, $pattern_data ) {

			$data = array(
				'title'				=> $pattern_data['title'],
				'description'		=> $pattern_data['description'],
				'content'			=> $this->get_block_pattern_markup( $pattern_data['file_content'] ),
				'categories'		=> $pattern_data['categories'],
				'keywords'			=> $pattern_data['keywords'],
				'viewportWidth'		=> $pattern_data['viewportWidth'],
			);

			register_block_pattern( $pattern_name, $data );

		}

		/*	-----------------------------------------------------------------------------------------------
			GET BLOCK PATTERN
			Returns the markup of the block pattern at the specified theme path.
		--------------------------------------------------------------------------------------------------- */

		public static function get_block_pattern_markup( $path ) {

			// Define shared block pattern placeholder content, to minimize cluttering up of the polyglot list.
			$lorem_short_1 = esc_html_x( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 'Block pattern demo content', 'better-black-patterns' );
			$lorem_short_2 = esc_html_x( 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.', 'Block pattern demo content', 'better-black-patterns' );

			$lorem_long_1 = $lorem_short_1 . ' ' . $lorem_short_2;
			$lorem_long_2 =  esc_html_x( 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', 'Block pattern demo content', 'better-black-patterns' );
			$lorem_long_3 =  esc_html_x( 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.', 'Block pattern demo content', 'better-black-patterns' );

			if ( ! $path ) return;

			ob_start();
			include( $path );
			return ob_get_clean();

		}

	}

endif;

new BBP_Patterns_Manager();