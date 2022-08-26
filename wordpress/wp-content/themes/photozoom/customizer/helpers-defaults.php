<?php

function ilovewp_option_defaults() {
    $defaults = array(

        // Copyright
        'footer-text' => /* translators: 1: current year 2: site title */ sprintf( esc_html__( 'Copyright &copy; %1$s %2$s.', 'photozoom' ), date( 'Y' ), get_bloginfo( 'name' ) ),
    );

    return $defaults;
}

function ilovewp_get_default( $option ) {
    $defaults = ilovewp_option_defaults();
    $default  = ( isset( $defaults[ $option ] ) ) ? $defaults[ $option ] : false;

    return $default;
}
