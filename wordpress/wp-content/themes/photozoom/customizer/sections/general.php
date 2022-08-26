<?php

function ilovewp_customizer_define_general_sections( $sections ) {
    $panel           = 'ilovewp' . '_general';
    $general_sections = array();

    $theme_header_style = array(
        'default' => esc_html__('Default', 'photozoom'),
        'centered' => esc_html__('Centered', 'photozoom')
    );

    $theme_color_palettes = array(
        'dark'         => esc_html__('Dark', 'photozoom'),
        'light'          => esc_html__('Light', 'photozoom')
    );

    $general_sections['general'] = array(
        'title'     => esc_html__( 'Theme Settings', 'photozoom' ),
        'priority'  => 4900,
        'options'   => array(

            'theme-color-palette'    => array(
                'setting'               => array(
                    'default'           => 'light',
                    'sanitize_callback' => 'ilovewp_sanitize_text'
                ),
                'control'           => array(
                    'label'         => esc_html__( 'Theme Color Palette', 'photozoom' ),
                    'type'          => 'select',
                    'choices'       => $theme_color_palettes
                ),
            ),

            'theme-header-style'     => array(
                'setting' => array(
                    'default' => 'default',
                    'sanitize_callback' => 'ilovewp_sanitize_text'
                ),
                'control' => array(
                    'label' => esc_html__( 'Header Layout', 'photozoom' ),
                    'type'  => 'radio',
                    'choices' => $theme_header_style
                ),
            ),

            'photozoom-display-featured-hero' => array(
                'setting'               => array(
                    'sanitize_callback' => 'absint',
                    'default'           => 0
                ),
                'control'               => array(
                    'label'             => __( 'Display Featured Images on Single Pages', 'photozoom' ),
                    'type'              => 'checkbox'
                )
            ),

            'photozoom-display-pages'    => array(
                'setting'               => array(
                    'sanitize_callback' => 'absint',
                    'default'           => 0
                ),
                'control'               => array(
                    'label'             => __( 'Display Featured Pages on Homepage', 'photozoom' ),
                    'type'              => 'checkbox'
                )
            ),

            'photozoom-featured-page-1'  => array(
                'setting'               => array(
                    'default'           => 'none',
                    'sanitize_callback' => 'photozoom_sanitize_pages'
                ),
                'control'               => array(
                    'label'             => esc_html__( 'Featured Page #1', 'photozoom' ),
                    'description'       => /* translators: link to pages */ sprintf( wp_kses( __( 'This list is populated with <a href="%1$s">Pages</a>.', 'photozoom' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'edit.php?post_type=page' ) ) ),
                    'type'              => 'select',
                    'choices'           => photozoom_get_pages()
                ),
            ),

            'photozoom-featured-page-2'  => array(
                'setting'               => array(
                    'default'           => 'none',
                    'sanitize_callback' => 'photozoom_sanitize_pages'
                ),
                'control'               => array(
                    'label'             => esc_html__( 'Featured Page #2', 'photozoom' ),
                    'type'              => 'select',
                    'choices'           => photozoom_get_pages()
                ),
            ),

            'photozoom-featured-page-3'  => array(
                'setting'               => array(
                    'default'           => 'none',
                    'sanitize_callback' => 'photozoom_sanitize_pages'
                ),
                'control'               => array(
                    'label'             => esc_html__( 'Featured Page #3', 'photozoom' ),
                    'type'              => 'select',
                    'choices'           => photozoom_get_pages()
                ),
            ),

        ),
    );

    return array_merge( $sections, $general_sections );
}

add_filter( 'ilovewp_customizer_sections', 'ilovewp_customizer_define_general_sections' );
