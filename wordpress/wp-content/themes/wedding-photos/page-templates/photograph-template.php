<?php
/**
 * Template Name: Photograph Template
 *
 * Displays Magazine template.
 *
 * @package Theme Freesia
 * @subpackage Wedding Photos
 * @since Wedding Photos 1.0
 */
get_header();

$photograph_settings = photograph_get_theme_options();
$wedding_photos_settings = wedding_photos_get_theme_options();
$photograph_feature_tab_title = $photograph_settings['photograph_feature_tab_title'];
$photograph_disable_feature_tab_category = $photograph_settings['photograph_disable_feature_tab_category'];
$photograph_total_feature_tab_tag = $photograph_settings['photograph_total_feature_tab_tag'];
$photograph_column_gallery_layout = $photograph_settings['photograph_column_gallery_layout'];
$photograph_hide_gallery_border = $photograph_settings['photograph_hide_gallery_border'];
$photograph_hide_show_gallery_title = $photograph_settings['photograph_hide_show_gallery_title'];
$photograph_gallery_layout = $photograph_settings['photograph_gallery_layout'];
$photograph_gray_scale = $photograph_settings['photograph_gray_scale'];
$photograph_gallery_box = $photograph_settings['photograph_gallery_box'];
$potograph_total_posts_display = $photograph_settings['potograph_total_posts_display'];
$photograph_tab_category = $photograph_settings['photograph_tab_category'];

$wedding_photos_disable_features = $wedding_photos_settings['wedding_photos_disable_features'];
$wedding_photos_featured_title = $wedding_photos_settings['wedding_photos_featured_title'];
$wedding_photos_featured_info = $wedding_photos_settings['wedding_photos_featured_info'];
$wedding_photos_boxed_gallery = $wedding_photos_settings['wedding_photos_boxed_gallery'];

$photograph_list_tab_tags	= array();
$border_class ='';
$gallery_title ='';
$gallery_layout ='';
$gray_scale = '';
$gallery_box = '';
if($photograph_hide_gallery_border =='no-border'){
	$border_class = 'no-border';
} 

if($photograph_hide_show_gallery_title =='show-fgt'){
	$gallery_title = 'show-fgt';
} elseif($photograph_hide_show_gallery_title =='show-fgt-hover') {
	$gallery_title = 'show-fgt-hover';
} else{
	$gallery_title = '';
}

if($photograph_gallery_layout =='fg-layout-2'){
	$gallery_layout = 'fg-layout-2';
}
if($photograph_gray_scale=='on'){
	$gray_scale ='grayscale-img';
}
if($photograph_gallery_box =='box-gallery'){
	$gallery_box = 'box-gallery';
} ?>

<main id="main" class="site-main" role="main">
	<?php
	if($wedding_photos_disable_features ==''){ ?>
		<div class="wedding-couple-wrap">
			<div class="wedding-couple-content clearfix">
				<?php if($wedding_photos_featured_title !='' || $wedding_photos_featured_info !=''){ ?>
					<div class="wedding-header">
						<?php if($wedding_photos_featured_title !=''){ ?>
							<h2 class="entry-title"><?php echo esc_attr($wedding_photos_featured_title); ?></h2>
						<?php }
						 if($wedding_photos_featured_info !=''){ ?>
							<div class=""><?php echo esc_attr($wedding_photos_featured_info); ?></div>
						<?php } ?>
					</div>
				<?php }
				$wedding_photos_total_page_no = 0; 
				$wedding_photos_list_page	= array();
				for ( $i=1; $i <=2; $i++ ) {
					if( isset ( $wedding_photos_settings['wedding_photos_' . $i] ) && $wedding_photos_settings['wedding_photos_' . $i] > 0 ){
						$wedding_photos_total_page_no++;

						$wedding_photos_list_page	=	array_merge( $wedding_photos_list_page, array( $wedding_photos_settings['wedding_photos_' . $i] ) );
					}

				}
				if ( !empty( $wedding_photos_list_page ) && $wedding_photos_total_page_no > 0 ) {
				 ?>
					<div class="couples-row">
						<?php 
						$get_featured_posts 		= new WP_Query(array(
							'posts_per_page'      	=> 2,
							'post_type'           	=> array('page'),
							'post__in'            	=> array_values($wedding_photos_list_page),
							'orderby'             	=> 'post__in',
						)); 
						$j =1; 
						while ($get_featured_posts->have_posts()):$get_featured_posts->the_post(); ?>
							<div class="couples-column">
								<div class="couples-content">
									<?php if ( has_post_thumbnail() ) { ?>
										<div class="couple-thumb">
											<?php the_post_thumbnail(); ?>
										</div>
									<?php } ?>
									<div class="couple-info">
										<div class="couple-title">
											<h2><?php the_title(); ?></h2>
										</div><?php the_content(); ?>
									</div>
								</div>
							</div>
							<!-- end .couples-column -->
							<?php $j++;
						endwhile; ?>
					</div>
					<!-- end .couples-row -->
				<?php } ?>
			</div>
			<!-- end .wedding-couple-content -->
		</div>
		<!-- end .wedding-couple-wrap -->
	<?php } ?>



	<?php if($photograph_disable_feature_tab_category !=1){ 
	 ?>
		<div class="featured-gallery-wrap <?php if($wedding_photos_boxed_gallery !=1){ echo 'boxed-gallery'; } ?> <?php echo esc_attr($gallery_title).' ' . esc_attr($border_class). ' '. esc_attr($gray_scale). ' ' .esc_attr($gallery_box);  ?>">
			<div class="featured-gallery-content <?php echo esc_attr($gallery_layout); ?> clearfix">
				<div class="featured-gallery-header">
					<?php if($photograph_feature_tab_title !=''){ ?>
						<h2 class="featured-gallery-title freesia-animation fadeInDown"><?php echo esc_html($photograph_feature_tab_title); ?></h2>
					<?php } ?>
					<div class="filters filter-button freesia-animation fadeInDown">
						<ul>
							<?php 

							$photograph_list_tab_tags = array();
							for($i=1; $i<=$photograph_total_feature_tab_tag; $i++){
								if( isset ( $photograph_settings['photograph_featured_tab_tag_' . $i] ) && $photograph_settings['photograph_featured_tab_tag_' . $i] !='' ){
									$category_id = $photograph_settings['photograph_featured_tab_tag_' . $i];

									$photograph_list_tab_tags	=	array_merge( $photograph_list_tab_tags, array( $category_id ) );
									}
								}
								$i=1;

								foreach ( $photograph_list_tab_tags as $photograph_tag_list) :
									$post_tags = get_term_by('slug', $photograph_tag_list, 'post_tag');
									if($i==1){ 

										if($photograph_settings['photograph_feature_tab_all_text'] !=''){  ?>
										<li class="active" data-category="*"><?php echo esc_attr($photograph_settings['photograph_feature_tab_all_text']); ?></li>
										<li data-category=".tag-<?php echo esc_attr($photograph_tag_list); ?>"><?php echo esc_html($post_tags->name); ?></li>
										<?php } else { ?>
										<li class="active" data-category=".tag-<?php echo esc_attr($photograph_tag_list); ?>"><?php echo esc_html($post_tags->name); ?></li>
										<?php }
									} else { ?>
										<li data-category=".tag-<?php echo esc_attr($photograph_tag_list); ?>"><?php echo esc_html($post_tags->name); ?></li>
									<?php } 
									 $i++;
								endforeach; ?>
						</ul>
					</div> <!-- end .filter-button-group -->
				</div><!-- end .featured-gallery-header -->
				
				<?php if($photograph_column_gallery_layout == '2'){
					$category_gallery_col='2';
				} elseif ($photograph_column_gallery_layout == '3'){
					$category_gallery_col='3';
				}elseif ($photograph_column_gallery_layout == '4'){
					$category_gallery_col='4';
				} else {
					$category_gallery_col='5';
				}?>
				<div class="featured-gallery gallery-col-<?php echo absint($category_gallery_col); ?>">
					<?php
					$get_featured_posts = new WP_Query( array(
							'posts_per_page' => intval($potograph_total_posts_display),
							'post_status'		=>	'publish',
							'ignore_sticky_posts'=>	'true',
							'category_name' => esc_attr($photograph_tab_category)

					) );
						while( $get_featured_posts->have_posts()):$get_featured_posts->the_post();
								$attachment_id = get_post_thumbnail_id();
								$image_attributes = wp_get_attachment_image_src($attachment_id,'full');  ?>
									<article <?php post_class('featured-item');?>>
										<div class="post-gallery-wrap freesia-animation fadeInUp">
											<?php if(has_post_thumbnail()){ ?>
												<div class="featured-image-content">
													<a class="popup-image" data-fancybox="gallery" data-title="<?php the_title_attribute(); ?>" href="<?php echo esc_url($image_attributes[0]); ?>"><?php the_post_thumbnail(); ?></a>
												</div><!-- end.featured-image-content -->
											<?php }
											if($photograph_hide_show_gallery_title !=''){ ?>
												<div class="featured-text-content">
													<h3 class="featured-title">
														<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
													</h3> <!-- end.featured-title -->
												</div> <!-- end .featured-text-content -->
											<?php } ?>
										</div> <!-- end.post-gallery-wrap -->
									</article> <!-- end .post -->
						<?php
					endwhile;

					wp_reset_postdata(); ?>
					</div> <!-- end .featured-gallery -->
				</div> <!-- end .featured-gallery-content -->
		</div> <!-- end .featured-gallery-wrap -->
	<?php }
	the_content(); ?>
</main> <!-- end #main -->
<?php get_footer();