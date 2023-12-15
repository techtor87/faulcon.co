<?php 

/*-----------------------------------------------------------------------------------*/
/* Initializing Widgetized Areas (Sidebars)																			 */
/*-----------------------------------------------------------------------------------*/

function photozoom_widgets_init() {

	register_sidebar(array(
		'name' => __('Homepage: Welcome Message','photozoom'),
		'id' => 'homepage-welcome',
		'description' => __('We recommend adding a single [Text Widget]. The widget\'s title will be wrapped in a H1 tag.','photozoom'),
		'before_widget' => '<div class="widget widget-welcome %2$s clearfix" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h1 class="title-welcome widget-title"><span class="page-title-span">',
		'after_title' => '</span></h1>',
	));

	register_sidebar(array(
		'name' => __('Homepage: Welcome Widgets (Left)','photozoom'),
		'id' => 'homepage-welcome-widgets-left',
		'description' => __('Recommended widgets: An image widget, social icons widget, subscribe banners, etc.','photozoom'),
		'before_widget' => '<div class="widget widget-welcome %2$s clearfix" id="%1$s">',
		'after_widget' => '</div>',
		'before_title'  => '<p class="widget-title"><span class="page-title-span">',
		'after_title'   => '</span></p>',
	));

	register_sidebar(array(
		'name' => __('Homepage: Welcome Widgets (Right)','photozoom'),
		'id' => 'homepage-welcome-widgets-right',
		'description' => __('We recommend adding a single [Text Widget].','photozoom'),
		'before_widget' => '<div class="widget widget-welcome %2$s clearfix" id="%1$s">',
		'after_widget' => '</div>',
		'before_title'  => '<p class="widget-title"><span class="page-title-span">',
		'after_title'   => '</span></p>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Footer: Full Width', 'photozoom' ),
		'id'            => 'footer-full',
		'description' => __('This is a full width widgetized area that appears before the 3 columns. Intended for an Instagram Feed widget.','photozoom'),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content-wrapper">',
		'after_widget'  => '</div><!-- .widget-content-wrapper --></div>',
		'before_title'  => '<p class="widget-title"><span class="page-title-span">',
		'after_title'   => '</span></p>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer: Column 1', 'photozoom' ),
		'id'            => 'footer-col-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content-wrapper">',
		'after_widget'  => '</div><!-- .widget-content-wrapper --></div>',
		'before_title'  => '<p class="widget-title"><span class="page-title-span">',
		'after_title'   => '</span></p>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer: Column 2', 'photozoom' ),
		'id'            => 'footer-col-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content-wrapper">',
		'after_widget'  => '</div><!-- .widget-content-wrapper --></div>',
		'before_title'  => '<p class="widget-title"><span class="page-title-span">',
		'after_title'   => '</span></p>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer: Column 3', 'photozoom' ),
		'id'            => 'footer-col-3',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content-wrapper">',
		'after_widget'  => '</div><!-- .widget-content-wrapper --></div>',
		'before_title'  => '<p class="widget-title"><span class="page-title-span">',
		'after_title'   => '</span></p>',
	) );

} 

add_action( 'widgets_init', 'photozoom_widgets_init' );