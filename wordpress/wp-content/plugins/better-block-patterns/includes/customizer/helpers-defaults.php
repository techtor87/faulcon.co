<?php
function bbp_option_defaults() {

	$defaults = array();

	$defaults_all = array(

        // Layout
        'bbp-layout-width-desktop'					=> 1200,
        'bbp-layout-width-tablet'					=> 768,
        'bbp-layout-width-mobile'					=> 460,

        // Quick Vars
		'bbp-color-primary-text'					=> '',
		'bbp-color-secondary-text'					=> '',
		'bbp-color-accent-text'						=> '',
		'bbp-color-white-100'						=> '#ffffff',
		'bbp-color-black-100'						=> '#000000',

	);

	return apply_filters( 'bbp_customizer_option_defaults', $defaults_all );
}

function bbp_get_default( $option ) {

	if ( !is_customize_preview() ) {
		global $bbp_customizer_defaults;
	}

	if ( !isset($bbp_customizer_defaults) ) {
		$bbp_customizer_defaults = bbp_option_defaults();
	}
	
	// $bbp_customizer_defaults = bbp_option_defaults();
	$default  = ( isset( $bbp_customizer_defaults[ $option ] ) ) ? $bbp_customizer_defaults[ $option ] : false;

	return $default;
}

function bbp_get_all_defaults() {
	$bbp_customizer_defaults = bbp_option_defaults();
	return $bbp_customizer_defaults;
}

function bbp_get_a_default($array, $id) {
	$default  = ( isset( $array[ $id ] ) ) ? $array[ $id ] : false;
	return $default;
}