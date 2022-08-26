<?php			

if ( ! isset( $content_width ) ) $content_width = 660;

/**
 * Define some constats
 */
if( ! defined( 'ILOVEWP_VERSION' ) ) {
	define( 'ILOVEWP_VERSION', '1.1.3' );
}
if( ! defined( 'ILOVEWP_THEME_LITE' ) ) {
	define( 'ILOVEWP_THEME_LITE', true );
}
if( ! defined( 'ILOVEWP_THEME_PRO' ) ) {
	define( 'ILOVEWP_THEME_PRO', false );
}
if( ! defined( 'ILOVEWP_DIR' ) ) {
	define( 'ILOVEWP_DIR', trailingslashit( get_template_directory() ) );
}
if( ! defined( 'ILOVEWP_DIR_URI' ) ) {
	define( 'ILOVEWP_DIR_URI', trailingslashit( get_template_directory_uri() ) );
}

/**
 * Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 */

if ( ! function_exists( 'photozoom_setup' ) ) :
/**
 * Theme setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 */
function photozoom_setup() {
    // This theme styles the visual editor to resemble the theme style.
    add_editor_style( array( 'css/editor-style.css' ) );

	add_image_size( 'photozoom-thumb-featured', 1100, 500, true );
	add_image_size( 'photozoom-thumb-featured-page', 300, 200, true );

	add_theme_support( 'responsive-embeds' );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

	/* Add support for Custom Background 
	==================================== */
	
	add_theme_support( 'custom-background', array(
		'default-color'	=> 'ffffff'
	) );
	
    /* Add support for Custom Logo 
	==================================== */

    add_theme_support( 'custom-logo', array(
	   'height'      => 100,
	   'width'       => 300,
	   'flex-width'  => true,
	   'flex-height' => true,
	) );

	/* Add support for post and comment RSS feed links in <head>
	==================================== */
	
	add_theme_support( 'automatic-feed-links' ); 

	add_theme_support( 'customize-selective-refresh-widgets' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	set_post_thumbnail_size( 300, 300, true );

	/* Add support for Localization
	==================================== */
	
	load_theme_textdomain( 'photozoom', get_template_directory() . '/languages' );
	
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);

	/* Add support for Custom Headers 
	==================================== */
	
	add_theme_support(
		'custom-header', apply_filters(
			'photozoom_custom_header_args', array(
				'width'            => 1100,
				'height'           => 500,
				'flex-height'      => true,
				'video'            => true
			)
		)
	);
    
	// Register nav menus
    register_nav_menus( array(
        'primary'	=> __( 'Main Menu', 'photozoom' ),
        'mobile'	=> __( 'Mobile Menu', 'photozoom' )
    ) );

}
endif;

add_action( 'after_setup_theme', 'photozoom_setup' );

add_filter( 'image_size_names_choose', 'photozoom_custom_sizes' );
 
function photozoom_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'photozoom-thumb-featured' => __( 'Featured Image: Slideshow Size', 'photozoom' ),
		'photozoom-thumb-featured-page' => __( 'Featured Image: Page Thumbnail', 'photozoom' ),
		'post-thumbnail' => __( 'Featured Image: Thumbnail', 'photozoom' ),
	) );
}

if ( ! function_exists( 'photozoom_fonts_url' ) ) :
/**
 * Register Google fonts for Photozoom
 *
 * Create your own photozoom_fonts_url() function to override in a child theme.
 *
 * @since Photozoom 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function photozoom_fonts_url() {
	
	$fonts_url = '';
	$subsets   = 'latin,latin-ext';	

	/* translators: If there are characters in your language that are not supported by Noto Serif, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'photozoom' ) ) {
		$fonts[] = 'Noto Serif:400,400i,700,700i';
	}
	if ( 'off' !== _x( 'on', 'Old Standard TT font: on or off', 'photozoom' ) ) {
		$fonts[] = 'Old Standard TT:400,700';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => rawurlencode( implode( '|', $fonts ) ),
			'subset' => rawurlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/* Add javascripts and CSS used by the theme 
================================== */

function photozoom_js_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	// Theme stylesheet.
	wp_enqueue_style( 'photozoom-style', get_stylesheet_uri(), array(), $theme_version );

	if (! is_admin()) {

		wp_enqueue_script(
			'jquery-superfish',
			get_template_directory_uri() . '/js/superfish.min.js',
			array('jquery'),
			true
		);

		wp_enqueue_script(
			'jquery-flexslider',
			get_template_directory_uri() . '/js/jquery.flexslider-min.js',
			array('jquery'),
			true
		);

		wp_register_script( 'photozoom-scripts', get_template_directory_uri() . '/js/photozoom.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'photozoom-scripts' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		
		/* Font-Awesome */
		wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/fontawesome.all.min.css', null, '5.15.3');
		
		// Loads our default Google Webfont
		wp_enqueue_style( 'photozoom-webfonts', photozoom_fonts_url(), array(), null, null );

	}

}
add_action('wp_enqueue_scripts', 'photozoom_js_scripts');

if ( ! function_exists( 'photozoom_get_the_archive_title' ) ) :
/* Custom Archives titles.
=================================== */
function photozoom_get_the_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }

    return $title;
}
endif;
add_filter( 'get_the_archive_title', 'photozoom_get_the_archive_title' );

/* Enable Excerpts for Static Pages
==================================== */

add_action( 'init', 'photozoom_excerpts_for_pages' );

function photozoom_excerpts_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}

/* Custom Excerpt Length
==================================== */

if ( ! function_exists( 'photozoom_new_excerpt_length' ) ) :

	add_filter( 'excerpt_length', 'photozoom_new_excerpt_length' );

	function photozoom_new_excerpt_length( $length ) {
		return is_admin() ? $length : 30;
	}

endif;

/* Replace invalid ellipsis from excerpts
==================================== */

function photozoom_excerpt($text)
{
   return str_replace(' [...]', '...', $text); // if there is a space before ellipsis
   return str_replace('[...]', '...', $text);
}
add_filter('the_excerpt', 'photozoom_excerpt');

/* Convert HEX color to RGB value (for the customizer)						
==================================== */

function photozoom_hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);
	
	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = "$r, $g, $b";
	return $rgb; // returns an array with the rgb values
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function photozoom_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo( 'pingback_url' )) );
	}
}
add_action( 'wp_head', 'photozoom_pingback_header' );

if ( ! function_exists( 'photozoom_theme_support_classic_widgets' ) ) :

function photozoom_theme_support_classic_widgets() {
	remove_theme_support( 'widgets-block-editor' );
}
endif;
add_action( 'after_setup_theme', 'photozoom_theme_support_classic_widgets' );

/**
 * --------------------------------------------
 * Enqueue scripts and styles for the backend.
 *
 * @package Photozoom
 * --------------------------------------------
 */

if ( ! function_exists( 'photozoom_scripts_admin' ) ) {
	/**
	 * Enqueue admin styles and scripts
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function photozoom_scripts_admin( $hook ) {

		// Styles
		wp_enqueue_style(
			'photozoom-style-admin',
			get_template_directory_uri() . '/ilovewp-admin/css/ilovewp_theme_settings.css',
			'', ILOVEWP_VERSION, 'all'
		);
	}
}
add_action( 'admin_enqueue_scripts', 'photozoom_scripts_admin' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Photozoom 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function photozoom_body_classes( $classes ) {

	$classes[] = ilovewp_helper_get_color_palette();
	$classes[] = ilovewp_helper_get_header_style();

	return $classes;
}

add_filter( 'body_class', 'photozoom_body_classes' );

if ( ! function_exists( 'photozoom_the_custom_logo' ) ) {

/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Photozoom 1.0
 */

	function photozoom_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			
			// We don't use the default the_custom_logo() function because of its automatic addition of itemprop attributes (they fail the ARIA tests)
			
			$site = get_bloginfo('name');
			$custom_logo_id = get_theme_mod( 'custom_logo' );

			if ( $custom_logo_id ) {
			$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>', 
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $custom_logo_id, 'full', false, array(
					'class'    => 'custom-logo',
					'alt' => __('Logo for ','photozoom') . esc_attr($site),
					) )
				);
			}

			echo $html;

		}

	}
}

if ( ! function_exists( 'photozoom_comment' ) ) :
/**
 * Template for comments and pingbacks.
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function photozoom_comment( $comment, $args, $depth ) {

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php esc_html_e( 'Pingback:', 'photozoom' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'photozoom' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

			<div class="comment-author vcard">
				<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</div><!-- .comment-author -->

			<header class="comment-meta">
				<?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php /* translators: 1: date, 2: time */ printf( esc_html_x( '%1$s at %2$s', '1: date, 2: time', 'photozoom' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'photozoom' ); ?></p>
				<?php endif; ?>

				<div class="comment-tools">
					<?php edit_comment_link( esc_html__( 'Edit', 'photozoom' ), '<span class="edit-link">', '</span>' ); ?>

					<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="reply">',
							'after'     => '</span>',
						) ) );
					?>
				</div><!-- .comment-tools -->
			</header><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for photozoom_comment()

if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

/* Include WordPress Theme Customizer
================================== */

require_once( get_template_directory() . '/customizer/customizer.php');

/* Include Additional Options and Components
================================== */

require_once( get_template_directory() . '/ilovewp-admin/sidebars.php');
require_once( get_template_directory() . '/ilovewp-admin/widgets/widget-tagline.php');
require_once( get_template_directory() . '/ilovewp-admin/helper-functions.php');
require_once( get_template_directory() . '/ilovewp-admin/components/ilovewp-tgmpa.php');

/* Include Theme Options Page for Admin
================================== */

//require only in admin!
if( is_admin() ) {	
	require_once('ilovewp-admin/ilovewp-theme-settings.php');

	if (current_user_can( 'manage_options' ) ) {
		require_once(get_template_directory() . '/ilovewp-admin/admin-notices/ilovewp-notices.php');
		require_once(get_template_directory() . '/ilovewp-admin/admin-notices/ilovewp-notice-welcome.php');
		require_once(get_template_directory() . '/ilovewp-admin/admin-notices/ilovewp-notice-upgrade.php');
		require_once(get_template_directory() . '/ilovewp-admin/admin-notices/ilovewp-notice-review.php');

		// Remove theme data from database when theme is deactivated.
		add_action('switch_theme', 'photozoom_db_data_remove');

		if ( ! function_exists( 'photozoom_db_data_remove' ) ) {
			function photozoom_db_data_remove() {

				delete_option( 'photozoom_admin_notices');
				delete_option( 'photozoom_theme_installed_time');

			}
		}

	}

}

if ( ! function_exists( 'photozoom_bbp_supported_patterns' ) ) :
function photozoom_bbp_supported_patterns($hook) {
	$pattern_slugs = array(
		'bbp-pattern-general-about-1',
		'bbp-pattern-general-contact-1',
		'bbp-pattern-general-contact-2',
		'bbp-pattern-general-description-2',
		'bbp-pattern-general-description-3',
		'bbp-pattern-general-partners-1',
		'bbp-pattern-general-partners-2',
		'bbp-pattern-general-portfolio-1',
		'bbp-pattern-general-portfolio-2',
		'bbp-pattern-general-pricing-1',
		'bbp-pattern-general-pricing-2'

	);
	return $pattern_slugs;
}
endif;

add_action( 'bbp_theme_supported_patterns', 'photozoom_bbp_supported_patterns' );