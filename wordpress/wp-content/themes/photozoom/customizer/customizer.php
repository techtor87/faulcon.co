<?php

if ( ! class_exists( 'ILOVEWP_Customizer' ) ) :
    class ILOVEWP_Customizer {
        public function __construct() {
            add_action( 'after_setup_theme', array( $this, 'init' ) );
            add_action( 'customize_register', array( $this, 'panels' ) );
            add_action( 'customize_register', array( $this, 'sections' ) );
        }

        public function init() {
            require_once get_template_directory() . '/customizer/helpers.php';
            require_once get_template_directory() . '/customizer/helpers-defaults.php';
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
                    $data['priority'] = $priority += 100;
                }

                $wp_customize->add_panel( $this->get_prefix() . $panel, $data );
            }

            // Re-prioritize and rename the Widgets panel
            if ( ! isset( $wp_customize->get_panel( 'widgets' )->priority ) ) {
                $wp_customize->add_panel( 'widgets' );
            }
            $wp_customize->get_panel( 'widgets' )->priority = $priority += 100;
        }

        /**
         * Add sections and controls to the customizer.
         *
         * @param  WP_Customize_Manager $wp_customize
         *
         * @return void
         */
        public function sections( $wp_customize ) {
            $default_path = get_template_directory() . '/customizer/sections';

            // Load built-in section mods
            $builtin_mods = array(
                'background',
                'navigation',
                'static-front-page',
            );

            foreach ( $builtin_mods as $slug ) {
                $file = trailingslashit( $default_path ) . $slug . '.php';

                if ( file_exists( $file ) ) {
                    require_once( $file );
                }
            }

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
            foreach ( $args as $setting_id => $option ) {
                // Add setting
                if ( isset( $option['setting'] ) ) {
                    $defaults = array(
                        'type'                 => 'theme_mod',
                        'capability'           => 'edit_theme_options',
                        'theme_supports'       => '',
                        'default'              => ilovewp_get_default( $setting_id ),
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
            return apply_filters( 'ilovewp_customizer_panels', array(
                'general'      => array( 'title' => esc_html__( 'General', 'photozoom' ) ),
                'footer'       => array( 'title' => esc_html__( 'Footer', 'photozoom' ) ),
            ) );
        }

        /**
         * @return array Customizer sections
         */
        private function get_sections() {
            return apply_filters( 'ilovewp_customizer_sections', array() );
        }

        /**
         * @return string Theme prefix
         */
        private function get_prefix() {
            // $theme_data = wp_get_theme();
			return 'ilovewp' . '_';
        }

    }
endif;

new ILOVEWP_Customizer();

// Extra styles
function photozoom_customizer_stylesheet() {
    
    // Stylesheet
    wp_enqueue_style( 'photozoom-customizer-css', get_template_directory_uri().'/ilovewp-admin/css/customizer-styles.css', NULL, NULL, 'all' );
    
}

add_action( 'customize_controls_print_styles', 'photozoom_customizer_stylesheet' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function photozoom_customize_register( $wp_customize ) {

    // Custom help section
	class Photozoom_WP_Help_Customize_Control extends WP_Customize_Control {
		public $type = 'text_help';
		public function render_content() {
			echo '
			<div class="bnt-customizer-help">
			<a class="bnt-customizer-link bnt-support-link" href="https://www.ilovewp.com/themes/photozoom/?utm_source=dashboard&utm_medium=customizer-page&utm_campaign=photozoom&utm_content=official-theme-page-link" target="_blank" rel="noopener">
			<span class="dashicons dashicons-info"></span>
			'.esc_html__( 'Official Theme Page', 'photozoom' ).'
			</a>
			<a class="bnt-customizer-link bnt-support-link" href="https://www.ilovewp.com/documentation/photozoom/?utm_source=dashboard&utm_medium=customizer-page&utm_campaign=photozoom&utm_content=theme-doc-link" target="_blank" rel="noopener">
			<span class="dashicons dashicons-book"></span>
			'.esc_html__( 'Theme Documentation', 'photozoom' ).'
			</a>
			<a class="bnt-customizer-link bnt-support-link" href="https://wordpress.org/support/theme/photozoom/" target="_blank" rel="noopener">
			<span class="dashicons dashicons-sos"></span>
			'.esc_html__( 'Support Forum', 'photozoom' ).'
			</a>
			<a class="bnt-customizer-link bnt-rate-link" href="https://wordpress.org/support/theme/photozoom/reviews/" target="_blank" rel="noopener">
			<span class="dashicons dashicons-heart"></span>
			'.esc_html__( 'Rate Photozoom', 'photozoom' ).'
			</a>
			<span class="bnt-customizer-link bnt-rate-link">
			<span class="dashicons dashicons-superhero"></span>
			' . esc_html__( 'Upgrade to CAPA', 'photozoom' ) . '
			<span class="customize-action">' . esc_html__( 'CAPA is a modern WordPress theme for photographers and the new Block Editor.', 'photozoom' ) . '</span>
			<br><a href="https://www.ilovewp.com/product/capa/?utm_source=dashboard&utm_medium=customizer-page&utm_campaign=photozoom&utm_content=upgrade-link" target="_blank" rel="noopener"><span class="button button-primary">' . esc_html__( 'More about CAPA', 'photozoom' ) . '</span></a></span>

			</div>
			';
		}
	}

	$wp_customize->add_section( 
		'photozoom_theme_support', 
		array(
			'title' => esc_html__( 'Theme Help & Support', 'photozoom' ),
			'priority' => 19,
		) 
	);

	$wp_customize->add_setting( 
		'photozoom_support', 
		array(
			'type' => 'theme_mod',
			'default' => '',
			'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control(
		new Photozoom_WP_Help_Customize_Control(
			$wp_customize,
			'photozoom_support', 
			array(
				'section' => 'photozoom_theme_support',
				'type' => 'text_help',
			)
		)
	);

	return $wp_customize;

}
add_action( 'customize_register', 'photozoom_customize_register' );