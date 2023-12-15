<?php

function bbp_get_css_rules(){
	
	$customizer_rules = array(

		'layout-rules' => array(

        	// Quick Vars
			array(
				'id' => 'bbp-layout-width',
				'selector' => ':root',
				'rule' => '--bbp-layout-width',
			),
		),

		'color-rules' => array(

        	// Quick Vars
			array(
				'id' => 'bbp-color-primary-text',
				'selector' => ':root',
				'rule' => '--bbp-color-primary-text',
			),

			array(
				'id' => 'bbp-color-secondary-text',
				'selector' => ':root',
				'rule' => '--bbp-color-secondary-text',
			),

			array(
				'id' => 'bbp-color-accent-text',
				'selector' => ':root',
				'rule' => '--bbp-color-accent-text',
			),

			array(
				'id' => 'bbp-color-white-100',
				'selector' => ':root',
				'rule' => '--bbp-color-white-100',
			),

			array(
				'id' => 'bbp-color-black-100',
				'selector' => ':root',
				'rule' => '--bbp-color-black-100',
			),

            // General

			array(
				'id' => 'bbp-color-body-text',
				'selector' => 'body',
				'rule' => 'color'
			),

			array(
				'id' => 'bbp-color-body-link',
				'selector' => 'a',
				'rule' => 'color'
			),

			array(
				'id' => 'bbp-color-body-link-hover',
				'selector' => 'a:hover, a:focus, h1 a:hover, h1 a:focus, h2 a:hover, h2 a:focus, h3 a:hover, h3 a:focus, h4 a:hover, h4 a:focus, h5 a:hover, h5 a:focus, h6 a:hover, h6 a:focus, .site-archive-posts .entry-meta a:hover, .site-archive-posts .entry-meta a:focus, .entry-meta a:hover, .entry-meta a:focus',
				'rule' => 'color'
			),

			array(
				'id' => 'bbp-color-body-link',
				'selector' => 'input[type="text"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="password"]:focus, input[type="search"]:focus, input[type="number"]:focus, input[type="tel"]:focus, input[type="range"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="week"]:focus, input[type="time"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="color"]:focus, textarea:focus',
				'rule' => 'border-color'
			),

			array(
				'id' => 'bbp-color-body-link-hover',
				'selector' => 'input[type="submit"]:hover, input[type="submit"]:focus',
				'rule' => 'background'
			),

			array(
				'id' => 'bbp-color-widget-title',
				'selector' => '.widget-title',
				'rule' => 'color'
			),
			array(
				'id' => 'bbp-color-widget-title-accent',
				'selector' => '.widget-title span:before, .widget-title span:after',
				'rule' => 'background'
			),

		)
	);

	return apply_filters( 'bbp_customizer_css_rules', $customizer_rules );
}

/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * This function reads in the options from theme mods and determines whether a CSS rule is needed to implement an
 * option. CSS is only written for choices that are non-default in order to avoid adding unnecessary CSS. All options
 * are also filterable allowing for more precise control via a child theme or plugin.
 *
 * Note that all CSS for options is present in this function except for the CSS for fonts and the logo, which require
 * a lot more code to implement.
 *
 * @return void
 */
function bbp_css_add_rules() {

	$bbp_options = get_option( 'better_block_patterns' );
	$rules = bbp_get_css_rules();

	foreach($rules['layout-rules'] as $layout_rule) {
		bbp_css_add_simple_px_rule($layout_rule['id'], $layout_rule['selector'], $layout_rule['rule']);
	}

	foreach($rules['color-rules'] as $color_rule) {
		bbp_css_add_simple_color_rule($color_rule['id'], $color_rule['selector'], $color_rule['rule']);
	}

	if ( isset($bbp_options['bbp_speed_load_fonts']) && $bbp_options['bbp_speed_load_fonts'] == '1' ) {
		if ( isset($rules['font-rules'])) {
			foreach($rules['font-rules'] as $font_rule) {
				bbp_css_add_simple_font_rule($font_rule['id'], $font_rule['selector'], $font_rule['rule']);
			}
		}
	}
}

add_action( 'bbp_css', 'bbp_css_add_rules' );

function bbp_css_add_simple_px_rule( $setting_id, $selectors, $declarations ) {
	
	$default_value = bbp_get_default( $setting_id );
	$value =  get_theme_mod( $setting_id, $default_value );

	if ( $value == '' ) {
		return;
	}

	if ( strtolower( $value ) === strtolower( $default_value ) ) {
		return;
	}

	if ( is_string( $selectors ) ) {
		$selectors = array( $selectors );
	}

	if ( is_string( $declarations ) ) {
		$declarations = array(
			$declarations => $value . 'px'
		);
	}

	bbp_get_css()->add( array(
		'selectors'    => $selectors,
		'declarations' => $declarations
	) );
}

function bbp_css_add_simple_color_rule( $setting_id, $selectors, $declarations ) {
	
	$default_value = bbp_get_default( $setting_id );
	$value = bbp_maybe_hash_hex_color( get_theme_mod( $setting_id, $default_value ) );

	if ( $value == '' ) {
		return;
	}

	if ( strtolower( $value ) === strtolower( $default_value ) ) {
		return;
	}

	if ( is_string( $selectors ) ) {
		$selectors = array( $selectors );
	}

	if ( is_string( $declarations ) ) {
		$declarations = array(
			$declarations => $value
		);
	}

	bbp_get_css()->add( array(
		'selectors'    => $selectors,
		'declarations' => $declarations
	) );
}

function bbp_css_add_simple_font_rule( $setting_id, $selectors, $declarations ) {
	
	$default_value = bbp_get_default( $setting_id );
	$value =  get_theme_mod( $setting_id, $default_value );

	if ( $value == '' ) {
		return;
	}

	if ( strtolower( $value ) === strtolower( $default_value ) ) {
		return;
	}

	if ( is_string( $selectors ) ) {
		$selectors = array( $selectors );
	}

	if ( is_string( $declarations ) ) {
		$declarations = array(
			$declarations => $value
		);
	}

	bbp_get_css()->add( array(
		'selectors'    => $selectors,
		'declarations' => $declarations
	) );
}
