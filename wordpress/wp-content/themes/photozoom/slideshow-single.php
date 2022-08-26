<?php 
if ( is_single() || is_page() || is_page_template() ) {

	$meta_target_id = $post->ID;

	if ( $post->ID == 0 ) {
		global $wp_query;
		if ( isset( $wp_query->queried_object->ID ) ) { $meta_target_id = $wp_query->queried_object->ID; }
	}

	$post_meta = get_post_custom($meta_target_id);

	if ( has_post_thumbnail( $meta_target_id ) ) {
		$featured_image_id = get_post_thumbnail_id($meta_target_id);
		?>
		<div class="site-section-wrapper site-section-hero-wrapper">
			<div id="ilovewp-hero" class="site-section-slideshow">
				<?php the_post_thumbnail('thumb-ilovewp-featured'); ?>
			</div><!-- #ilovewp-hero .site-section .site-section-slideshow -->
		</div><!-- .site-section-wrapper .site-section-hero-wrapper --><?php

	}

} 