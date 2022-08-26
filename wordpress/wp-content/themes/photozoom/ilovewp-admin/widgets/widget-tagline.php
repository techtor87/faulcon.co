<?php

/*------------------------------------------*/
/* ILOVEWP: Widget Tagline		            */
/*------------------------------------------*/
 
class photozoom_widget_tagline extends WP_Widget {
	
	public function __construct() {

		parent::__construct(
			'photozoom-widget-featured-pages',
			esc_html__( 'ILOVEWP: Widget Tagline', 'photozoom' ),
			array(
				'classname'   => 'ilovewp-widget-tagline',
				'description' => esc_html__( 'Displays a line of text that appears before the title of the widget that goes after it.', 'photozoom' )
			)
		);

	}

	public function widget( $args, $instance ) {
		
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters( 'widget_title', empty($instance['widget_title']) ? '' : $instance['widget_title'], $instance );

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Title of widget (before and after defined by themes). */
		if ( $title ) {
			echo '<p class="widget-pretitle">'; 
			echo esc_html($title);
			echo '</p>';
		}

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['widget_title'] = sanitize_text_field( $new_instance['widget_title'] );

		return $instance;
	}
	
	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'widget_title' 		=> __('Some Text','photozoom')
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php esc_html_e('Widget Title', 'photozoom'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" value="<?php echo esc_attr($instance['widget_title']); ?>" type="text" class="widefat" />
		</p>

		<?php
	}
}

/* Register site widgets */
if ( ! function_exists( 'photozoom_register_widgets' ) ) :
	/**
	* Load widgets.
	*
	* @since 1.0.0
	*/
	function photozoom_register_widgets() {
		register_widget( 'photozoom_widget_tagline' );
	}
endif;

add_action( 'widgets_init', 'photozoom_register_widgets' );