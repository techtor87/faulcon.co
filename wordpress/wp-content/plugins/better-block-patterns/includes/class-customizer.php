<?php

if ( ! class_exists( 'BBP_Customizer' ) ) :
    class BBP_Customizer {

        public function __construct() {
			
			$bbp_options = get_option( 'better_block_patterns' );

			add_action( 'after_setup_theme', array( $this, 'init' ) );
			add_action( 'customize_register', array( $this, 'panels' ) );
			add_action( 'customize_register', array( $this, 'sections' ) );
			add_action( 'wp_head', array( $this, 'bbp_display_customization' ) );
			add_action( 'customize_preview_init', array( $this, 'bbp_customizer_js' ), 100 );
        }

        public function init() {
			
			require_once BBP_PLUGIN_DIR . 'includes/customizer/helpers.php';
			require_once BBP_PLUGIN_DIR . 'includes/customizer/helpers-css.php';
			require_once BBP_PLUGIN_DIR . 'includes/customizer/helpers-defaults.php';
			require_once BBP_PLUGIN_DIR . 'includes/customizer/helpers-display.php';

			$theme_editor_palette = self::get_editor_color_palette();
			// If we have colors, add them to the block editor palette.
			if ( $theme_editor_palette ) {
				add_theme_support( 'editor-color-palette', $theme_editor_palette );
			}

        }

		function bbp_customizer_js() {

			wp_enqueue_script(
				'bbp-vein-js',
				BBP_PLUGIN_URL . 'assets/js/vein.min.js',
				array(),
				false,
				true // In the footer!
			);

			wp_enqueue_script(
				'bbp-customizer-js',
				BBP_PLUGIN_URL . 'assets/js/customizer-preview.js',
				array('jquery', 'customize-preview'),
				false,
				true // In the footer!
			);

			wp_localize_script('bbp-customizer-js', 'bbp_css_rules', bbp_get_css_rules());

		}

        /**
         * Register Customizer panels.
         *
         * @param  WP_Customize_Manager $wp_customize
         *
         * @return void
         */
        public function panels( $wp_customize ) {
            $priority = 1000;
            
            foreach ( $this->get_panels() as $panel => $data ) {
                if (!isset($data['priority'])) {
                    $data['priority'] = $priority += 1;
                }

                $wp_customize->add_panel( $panel, $data );
            }

        }

        /**
         * Add sections and controls to the customizer.
         *
         * @param  WP_Customize_Manager $wp_customize
         *
         * @return void
         */
        public function sections( $wp_customize ) {
            $default_path = BBP_PLUGIN_DIR . 'includes/customizer/panels';

            foreach ( $this->get_panels() as $panel => $data ) {
                $file = trailingslashit( $default_path ) . $panel . '.php';

                if ( file_exists( $file ) ) {
                    require_once( $file );
                }
            }

            $sections = $this->get_sections();

            $priority = array();
            foreach ( $sections as $section => $data ) {
                $options = null;

                if ( isset( $data['options'] ) ) {
                    $options = $data['options'];
                    unset( $data['options'] );
                }

                if ( ! isset( $data['priority'] ) ) {
                    $panel_priority = ( 'none' !== $panel && isset( $panels[ $panel ]['priority'] ) ) ? $panels[ $panel ]['priority'] : 1000;

                    if ( ! isset( $priority[ $panel ] ) ) {
                        $priority[ $panel ] = $panel_priority;
                    }

                    $data['priority'] = $priority[ $panel ] += 10;
                }

                $wp_customize->add_section( $this->get_prefix() . $section, $data );

                // Add options to the section
                $this->add_sections_options( $wp_customize, $this->get_prefix() . $section, $options );
            }
        }

        /**
         * Register settings and controls for a section.
         *
         * @param WP_Customize_Manager $wp_customize
         * @param string $section
         * @param array $args
         */
        private function add_sections_options( $wp_customize, $section, $args ) {
            
	    	global $theme_defaults;
		    if ( !isset($theme_defaults) ) {
		    	$theme_defaults = bbp_get_all_defaults();
			}

            foreach ( $args as $setting_id => $option ) {
                // Add setting
                if ( isset( $option['setting'] ) ) {
                    $defaults = array(
                        'type'                 => 'theme_mod',
                        'capability'           => 'edit_theme_options',
                        'theme_supports'       => '',
                        'default'              => bbp_get_a_default($theme_defaults, $setting_id),
                        'transport'            => 'refresh',
                        'sanitize_callback'    => '',
                        'sanitize_js_callback' => '',
                    );

                    $setting = wp_parse_args( $option['setting'], $defaults );

                    // Add the setting arguments inline so Theme Check can verify the presence of sanitize_callback
                    $wp_customize->add_setting( $setting_id, array(
                        'type'                 => $setting['type'],
                        'capability'           => $setting['capability'],
                        'theme_supports'       => $setting['theme_supports'],
                        'default'              => $setting['default'],
                        'transport'            => $setting['transport'],
                        'sanitize_callback'    => $setting['sanitize_callback'],
                        'sanitize_js_callback' => $setting['sanitize_js_callback'],
                    ) );
                }

                // Add control
                if ( isset( $option['control'] ) ) {
                    $control_id = $this->get_prefix() . $setting_id;

                    $defaults = array(
                        'settings' => $setting_id,
                        'section'  => $section,
                    );

                    if ( ! isset( $option['setting'] ) ) {
                        unset( $defaults['settings'] );
                    }

                    $control = wp_parse_args( $option['control'], $defaults );

                    // Check for a specialized control class
                    if ( isset( $control['control_type'] ) ) {
                        $class = $control['control_type'];

                        if ( class_exists( $class ) ) {
                            unset( $control['control_type'] );

                            // Dynamically generate a new class instance
                            $reflection     = new ReflectionClass( $class );
                            $class_instance = $reflection->newInstanceArgs( array(
                                $wp_customize,
                                $control_id,
                                $control
                            ) );

                            $wp_customize->add_control( $class_instance );
                        }
                    } else {
                        $wp_customize->add_control( $control_id, $control );
                    }
                }
            }
        }

        private function get_panels() {
            return apply_filters( 'bbp_customizer_panels', array(
                'better-block-patterns'		=> array( 'title' => esc_html__( 'Better Block Patterns', 'better-block-patterns' ) )
            ) );
        }

        /**
         * @return array Customizer sections
         */
        private function get_sections() {
            return apply_filters( 'bbp_customizer_sections', array() );
        }

        /**
         * @return string Theme prefix
         */
        private function get_prefix() {
            // $theme_data = wp_get_theme();
			return 'bbp' . '-';
        }

        public function bbp_display_customization() {

            $css = $this->bbp_get_customization_css();

            if ( ! empty( $css ) ) {
                echo "\n<!-- Begin Better Block Patterns Custom CSS -->\n<style type=\"text/css\" id=\"bbp-custom-css\">\n";
                echo esc_html($css);
                echo "\n</style>\n<!-- End Better Block Patterns Custom CSS -->\n";
            }
        }

        public function bbp_get_customization_css() {
            do_action( 'bbp_css' );

            $css = bbp_get_css()->build();

            if ( ! empty( $css ) ) {
                return $css;
            }
        }

        private function get_editor_color_palette() {

			$all_theme_mods 			= get_theme_mods();
			$all_theme_defaults			= array_filter(bbp_get_all_defaults());
			$customizer_rules			= bbp_get_css_rules();
			$customizer_color_rules 	= array();
			$all_theme_colors			= array();
			$editor_color_palette		= array();

			// Fetch our Quick Colors settings from the Customizer
			$file = BBP_PLUGIN_DIR . 'includes/customizer/panels/better-block-patterns.php';

			if ( file_exists( $file ) ) {
				include( $file );
				$customizer_color_options = bbp_customizer_define_color_sections(array());
				$customizer_color_options = $customizer_color_options['color-quick']['options'];
			}

			// Get an array of all color mod IDs
			foreach ($customizer_rules['color-rules'] as $key => $value) {
				$customizer_color_rules[$value['id']] = '';
			}

			// Populate the array with default color values
			$all_theme_colors 	= array_intersect_key($all_theme_defaults, $customizer_color_rules);
			// Populate the array with custom color values from the customizer
			$all_custom_colors 	= array_intersect_key($all_theme_mods, $customizer_color_rules);
			$all_final_colors 	= array_merge($all_theme_colors, $all_custom_colors);

			if ( isset($all_custom_colors) && count($all_custom_colors) > 0 ) {
				foreach ($all_custom_colors as $id => $value) {
					if ( isset($all_theme_colors[$id]) ) {
						$all_theme_colors[$id] = $value;
					}
				}
			}

			if ( isset($all_theme_colors) && count($all_theme_colors) > 0 ) {
				foreach ( $all_theme_colors as $id => $color_hex ) {

					$editor_color_palette[] = array(
						'name'	=> $customizer_color_options[$id]['control']['label'] . ': ' . $color_hex,
						'slug'	=> str_replace('color-', '', $id),
						'color'	=> $color_hex
					);
				}
			}

			if ( isset($editor_color_palette) ) {
				return $editor_color_palette;
			}

        }

    }

endif;

new BBP_Customizer();