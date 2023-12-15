<?php
function bbp_customizer_define_layout_sections( $sections ) {
    $panel           = 'better-block-patterns';
    $layout_sections = array();

    /**
     * Layout Styling
     */
    $layout_sections['layout'] = array(
        'panel'   => $panel,
        'title'   => esc_html__( 'Layout Settings', 'better-block-patterns' ),
        'priority'  => 2000,
        'options' => array(
            'bbp-layout-width-desktop'		=> array(
                'setting' => array(
                    'sanitize_callback'		=> 'absint',
                    'transport'				=> 'postMessage'
                ),
                'control' => array(
                    'label' 		=> esc_html__( 'Pattern Max Width - Desktop', 'better-block-patterns' ),
                    'description'	=> esc_html__( 'This is the maximum width of all BBP Patterns. It is best if it matches the width of the content area in your theme.', 'better-block-patterns' ),
                    'type'  		=> 'number',
                ),
            ),
            'bbp-layout-width-tablet'		=> array(
                'setting' => array(
                    'sanitize_callback'		=> 'absint',
                    'transport'				=> 'postMessage'
                ),
                'control' => array(
                    'label'			=> esc_html__( 'CSS Breakpoint - Tablet', 'better-block-patterns' ),
                    'description'	=> esc_html__( 'The media breakpoint for tablets. Default is 768.', 'better-block-patterns' ),
                    'type'			=> 'number',
                ),
            ),
            'bbp-layout-width-mobile'		=> array(
                'setting' => array(
                    'sanitize_callback'		=> 'absint',
                    'transport'				=> 'postMessage'
                ),
                'control' => array(
                    'label'			=> esc_html__( 'CSS Breakpoint - Mobile', 'better-block-patterns' ),
                    'description'	=> esc_html__( 'The media breakpoint for smartphones. Default is 460.', 'better-block-patterns' ),
                    'type'			=> 'number',
                ),
            ),

        )
    );

    return array_merge( $sections, $layout_sections );
}


function bbp_customizer_define_color_sections( $sections ) {
    $panel           = 'better-block-patterns';
    $colors_sections = array();

    $colors_sections['color-quick'] = array(
        'panel'   => $panel,
        'title'   => esc_html__( 'Colors &ndash; General', 'better-block-patterns' ),
        'priority'  => 2000,
        'options' => array(

            'bbp-color-primary-text' => array(
                'setting' => array(
                    'sanitize_callback' => 'bbp_maybe_hash_hex_color',
                    'transport'  => 'postMessage'
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => esc_html__( 'Primary Text', 'better-block-patterns' ),
                ),
            ),

            'bbp-color-secondary-text' => array(
                'setting' => array(
                    'sanitize_callback' => 'bbp_maybe_hash_hex_color',
                    'transport'  => 'postMessage'
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => esc_html__( 'Secondary Text', 'better-block-patterns' ),
                ),
            ),

            'bbp-color-accent-text' => array(
                'setting' => array(
                    'sanitize_callback' => 'bbp_maybe_hash_hex_color',
                    'transport'  => 'postMessage'
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => esc_html__( 'Accent Text', 'better-block-patterns' ),
                ),
            ),

            'bbp-color-white-100' => array(
                'setting' => array(
                    'sanitize_callback' => 'bbp_maybe_hash_hex_color',
                    'transport'  => 'postMessage'
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => esc_html__( 'Neutral - White', 'better-block-patterns' ),
                ),
            ),

            'bbp-color-black-100' => array(
                'setting' => array(
                    'sanitize_callback' => 'bbp_maybe_hash_hex_color',
                    'transport'  => 'postMessage'
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => esc_html__( 'Neutral - Black', 'better-block-patterns' ),
                ),
            ),

        )
    );

    return array_merge( $sections, $colors_sections );
}

add_filter( 'bbp_customizer_sections', 'bbp_customizer_define_layout_sections' );
add_filter( 'bbp_customizer_sections', 'bbp_customizer_define_color_sections' );