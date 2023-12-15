<?php
/**
 * Display all wedding-photos functions and definitions
 *
 * @package Theme Freesia
 * @subpackage Wedding Photos
 * @since Wedding Photos 1.0
 */
// Some Default Values
function wedding_photos_defaults_values() {
		global $wedding_photos_default;
		$wedding_photos_default = array(
			'wedding_photos_disable_features'	=> '',
			'wedding_photos_disable_wedding_icon'	=> '',
			'wedding_photos_featured_title'	=> '',
			'wedding_photos_img_upload'	=> '',
			'wedding_photos_featured_info' => '',
			'wedding_photos_boxed_gallery' => ''

			
			);
		return apply_filters( 'wedding_photos_defaults_values', $wedding_photos_default );
	}


if(!function_exists('wedding_photos_get_theme_options')):
	function wedding_photos_get_theme_options() {
	    return wp_parse_args(  get_option( 'wedding_photos_theme_options', array() ), wedding_photos_defaults_values() );
	}
endif;

add_action( 'wp_enqueue_scripts', 'wedding_photos_enqueue_styles' );

function wedding_photos_enqueue_styles() {
	$wedding_photos_settings = wedding_photos_get_theme_options();

	wp_enqueue_style( 'wedding-photos-parent-style', trailingslashit(get_template_directory_uri() ) . '/style.css' );
	/* Inline Css */
	$wedding_photos_internal_css='';
	if ($wedding_photos_settings['wedding_photos_img_upload'] !=''){
		$wedding_photos_internal_css= '.wedding-couple-wrap .wedding-header {
			background: url(' .esc_url($wedding_photos_settings['wedding_photos_img_upload']).')' .' '.'no-repeat center top;
		}';

	}

	if ($wedding_photos_settings['wedding_photos_disable_wedding_icon'] !=''){
		$wedding_photos_internal_css= '/* Disable Couples Icon */
			.couples-row .couples-column:first-child:after,
			.couples-row .couples-column:first-child:before {
				display: none;
			}';

	}
	wp_add_inline_style( 'wedding-photos-parent-style', wp_strip_all_tags($wedding_photos_internal_css) );

}

require get_stylesheet_directory() . '/inc/welcome-notice.php';


function wedding_photos_customize_register( $wp_customize ) {
	if(!class_exists('Photograph_Plus_Features')){
		class Wedding_photos_Customize_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
				<a title="<?php esc_attr_e( 'Review Wedding Photos', 'wedding-photos' ); ?>" href="<?php echo esc_url( 'https://wordpress.org/support/view/theme-reviews/wedding-photos/' ); ?>" target="_blank" id="about-wedding-photos">
				<?php esc_html_e( 'Review Wedding Photos', 'wedding-photos' ); ?>
				</a><br/>
				<a href="<?php echo esc_url( 'https://themefreesia.com/theme-instruction/wedding-photos/' ); ?>" title="<?php esc_attr_e( 'Theme Instructions', 'wedding-photos' ); ?>" target="_blank" id="about-wedding-photos">
				<?php esc_html_e( 'Theme Instructions', 'wedding-photos' ); ?>
				</a><br/>
				<a href="<?php echo esc_url( 'https://tickets.themefreesia.com' ); ?>" title="<?php esc_attr_e( 'Support Ticket', 'wedding-photos' ); ?>" target="_blank" id="about-wedding-photos">
				<?php esc_html_e( 'Tickets', 'wedding-photos' ); ?>
				</a><br/>
			<?php
			}
		}

		$wp_customize->add_section('wedding_photos_upgrade_links', array(
			'title'					=> __('About Wedding Photos', 'wedding-photos'),
			'priority'				=> 1000,
		));
		$wp_customize->add_setting( 'wedding_photos_upgrade_links', array(
			'default'				=> false,
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Wedding_photos_Customize_upgrade(
			$wp_customize,
			'wedding_photos_upgrade_links',
				array(
					'section'				=> 'wedding_photos_upgrade_links',
					'settings'				=> 'wedding_photos_upgrade_links',
				)
			)
		);
	}
		$wedding_photos_settings = wedding_photos_get_theme_options();
		$wp_customize->add_section( 'wedding_photos_featured', array(
			'title' => __('Wedding Featured','photograph'),
			'priority' => 20,
			'panel' =>'photograph_frontpage_panel'
		));

		$wp_customize->add_setting( 'wedding_photos_theme_options[wedding_photos_disable_features]', array(
			'default' => $wedding_photos_settings['wedding_photos_disable_features'],
			'sanitize_callback' => 'photograph_checkbox_integer',
			'type' => 'option',
		));
		$wp_customize->add_control( 'wedding_photos_theme_options[wedding_photos_disable_features]', array(
			'priority' => 10,
			'label' => __('Disable Featured Section', 'wedding-photos'),
			'section' => 'wedding_photos_featured',
			'type' => 'checkbox',
		));

		$wp_customize->add_setting( 'wedding_photos_theme_options[wedding_photos_disable_wedding_icon]', array(
			'default' => $wedding_photos_settings['wedding_photos_disable_wedding_icon'],
			'sanitize_callback' => 'photograph_checkbox_integer',
			'type' => 'option',
		));
		$wp_customize->add_control( 'wedding_photos_theme_options[wedding_photos_disable_wedding_icon]', array(
			'priority' => 20,
			'label' => __('Disable Wedding Featured Icon', 'wedding-photos'),
			'section' => 'wedding_photos_featured',
			'type' => 'checkbox',
		));

		$wp_customize->add_setting( 'wedding_photos_theme_options[wedding_photos_featured_title]', array(
			'default' => $wedding_photos_settings['wedding_photos_featured_title'],
			'sanitize_callback' => 'sanitize_text_field',
			'type' => 'option',
			'capability' => 'manage_options'
			)
		);
		$wp_customize->add_control( 'wedding_photos_theme_options[wedding_photos_featured_title]', array(
			'priority' => 30,
			'label' => __( 'Title', 'photograph' ),
			'section' => 'wedding_photos_featured',
			'type' => 'text',
			)
		);
		$wp_customize->add_setting( 'wedding_photos_theme_options[wedding_photos_featured_info]', array(
			'default' => $wedding_photos_settings['wedding_photos_featured_info'],
			'sanitize_callback' => 'sanitize_text_field',
			'type' => 'option',
			'capability' => 'manage_options'
			)
		);
		$wp_customize->add_control( 'wedding_photos_theme_options[wedding_photos_featured_info]', array(
			'priority' => 40,
			'label' => __( 'Information', 'photograph' ),
			'section' => 'wedding_photos_featured',
			'type' => 'text',
			)
		);

		$wp_customize->add_setting( 'wedding_photos_theme_options[wedding_photos_img_upload]',array(
			'default'	=> $wedding_photos_settings['wedding_photos_img_upload'],
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
			'type' => 'option',
		));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wedding_photos_theme_options[wedding_photos_img_upload]', array(
			'label' => __('Featured Background Image','photograph'),
			'description' => __('Image will be displayed in featured section','photograph'),
			'priority'	=> 50,
			'section' => 'wedding_photos_featured',
			)
		));

		for ( $i=1; $i <=2; $i++ ) {
			$wp_customize->add_setting('wedding_photos_theme_options[wedding_photos_'. $i .']', array(
				'default' =>'',
				'sanitize_callback' =>'wedding_photos_sanitize_page',
				'type' => 'option',
				'capability' => 'manage_options'
			));
			$wp_customize->add_control( 'wedding_photos_theme_options[wedding_photos_'. $i .']', array(
				'priority' => 60,
				'label' => __('Select Page #','wedding-photos') . ' ' . $i ,
				'section' => 'wedding_photos_featured',
				'type' => 'dropdown-pages',
			));
		}

		$wp_customize->add_setting( 'wedding_photos_theme_options[wedding_photos_boxed_gallery]', array(
			'default' => $wedding_photos_settings['wedding_photos_boxed_gallery'],
			'sanitize_callback' => 'photograph_checkbox_integer',
			'type' => 'option',
		));
		$wp_customize->add_control( 'wedding_photos_theme_options[wedding_photos_boxed_gallery]', array(
			'priority' => 10,
			'label' => __('Disable Boxed Gallery(Child)', 'wedding-photos'),
			'section' => 'photograph_layout_options',
			'type' => 'checkbox',
		));
}
	add_action( 'customize_register', 'wedding_photos_customize_register' );

if(!class_exists('Photograph_Plus_Features')){
	// Add Upgrade to Plus Button.
	require_once( trailingslashit( get_stylesheet_directory() ) . 'inc/upgrade-plus/class-customize.php' );
}

function wedding_photos_sanitize_page( $input ) {
	if(  get_post( $input ) ){
		return $input;
	}
	else {
		return '';
	}
}
