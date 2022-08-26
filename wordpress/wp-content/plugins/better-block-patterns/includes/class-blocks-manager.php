<?php

/* ---------------------------------------------------------------------------------------------
   BLOCKS MANAGER CLASS
   Handles block styles.
------------------------------------------------------------------------------------------------ */

if ( ! class_exists( 'BBP_Blocks_Manager' ) ) :
	class BBP_Blocks_Manager {

		public function __construct() {

			add_action( 'init', array( $this, 'bbp_register_block_styles' ) );

		}

		/*	-----------------------------------------------------------------------------------------------
			REGISTER BLOCK STYLES
		--------------------------------------------------------------------------------------------------- */

		public static function bbp_register_block_styles() {

			$options = get_option( 'better_block_patterns' );

			if ( !function_exists( 'register_block_style' ) ) return;

			// Gallery
			$gallery_block_styles = array( 
				'core/gallery'
			);

			foreach ( $gallery_block_styles as $block ) {
				register_block_style( $block, array(
					'label' 			=> esc_html__( 'BBP: Gallery Slideshow', 'better-black-patterns' ),
					'name'  			=> 'bbp-block-with-flexslider'
				) );
			}

			// Group
			$group_block_styles = array( 
				'core/group'
			);

			foreach ( $group_block_styles as $block ) {
				register_block_style( $block, array(
					'label' 			=> esc_html__( 'BBP: Black Border', 'better-black-patterns' ),
					'name'  			=> 'bbp-border-black'
				) );
				register_block_style( $block, array(
					'label' 			=> esc_html__( 'BBP: White Border', 'better-black-patterns' ),
					'name'  			=> 'bbp-border-white'
				) );
			}

			// Lists
			$list_styles_blocks = array( 
				'core/list'
			);

			foreach ( $list_styles_blocks as $block ) {
				register_block_style( $block, array(
					'label' => esc_html__( 'BBP: 2 Columns', 'better-black-patterns' ),
					'name'  => 'bbp-column-count--2',
				) );
				register_block_style( $block, array(
					'label' => esc_html__( 'BBP: 3 Columns', 'better-black-patterns' ),
					'name'  => 'bbp-column-count--3',
				) );
				register_block_style( $block, array(
					'label' => esc_html__( 'BBP: Ordered List - Alternative', 'better-black-patterns' ),
					'name'  => 'bbp-numbers-special',
				) );
				register_block_style( $block, array(
					'label' => esc_html__( 'BBP: Unordered List - Table', 'better-black-patterns' ),
					'name'  => 'bbp-table',
				) );
				register_block_style( $block, array(
					'label' => esc_html__( 'BBP: Unordered List - Underlined', 'better-black-patterns' ),
					'name'  => 'bbp-underlined',
				) );
			}

		}

	}

endif;

new BBP_Blocks_Manager();