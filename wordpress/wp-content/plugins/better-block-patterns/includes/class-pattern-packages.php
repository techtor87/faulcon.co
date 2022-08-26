<?php

/**
 * Pattern Packages
 *
 * @package     BBP
 * @copyright   Copyright (c) 2021, Dumitru Brinzan
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * BBP_Pattern_Packages Class
 *
 * This class handles pattern packages
 *
 * @since 1.0.0
 */
class BBP_Pattern_Packages {

	/**
	 * Get things going
	 *
	 * @since 1.0.0
	 */

	public function __construct() {

		// add_filter( 'bbp_custom_pattern_packages', array( $this, 'add_pattern_packages' ), 10, 2 );

	}

	/**
	 * Define default pattern packages
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function get_default_pattern_packages() {

		$preview_url_prefix = 'https://www.ilovewp.com/better-block-patterns/packages/';

		$pattern_packages = array(
			'general-features'	=> array(
				'slug'				=> __('general-features', 'better-block-patterns'),
				'title'				=> __('All purpose patterns', 'better-block-patterns'),
				'description'		=> __('All purpose block patterns that are appropriate for all types of websites.', 'better-block-patterns'),
				'preview_url'		=> $preview_url_prefix . 'general-features',
				'patterns'			=> array (
					'about-1'	=> array (
						'slug'				=> 'about-1',
						'pattern_class'		=> 'bbp-pattern-general-about-1',
						'title'				=> __('About #1', 'better-block-patterns'),
						'description'		=> __('An easy way to describe a person or a product. An image on one side and text on the other.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/about-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/about-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/about-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/about-1/block-css-back.css'
					),
					'audio-player-1'	=> array (
						'slug'				=> 'audio-player-1',
						'pattern_class'		=> 'bbp-pattern-general-audio-player-1',
						'title'				=> __('Audio Player #1', 'better-block-patterns'),
						'description'		=> __('Embed an audio file with an image and some text to better describe it.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features','bbp-podcast'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/audio-player-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/audio-player-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/audio-player-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/audio-player-1/block-css-back.css'
					),
					'call-to-action-1'	=> array (
						'slug'				=> 'call-to-action-1',
						'pattern_class'		=> 'bbp-pattern-general-call-to-action-1',
						'title'				=> __('Call to Action #1', 'better-block-patterns'),
						'description'		=> __('Text on one side and buttons on the other.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/call-to-action-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/call-to-action-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/call-to-action-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/call-to-action-1/block-css-back.css'
					),
					'call-to-action-2'	=> array (
						'slug'				=> 'call-to-action-2',
						'pattern_class'		=> 'bbp-pattern-general-call-to-action-2',
						'title'				=> __('Call to Action #2', 'better-block-patterns'),
						'description'		=> __('Centered heading, text and buttons.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/call-to-action-2/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/call-to-action-2/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/call-to-action-2/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/call-to-action-2/block-css-back.css'
					),
					'call-to-action-3'	=> array (
						'slug'				=> 'call-to-action-3',
						'pattern_class'		=> 'bbp-pattern-general-call-to-action-3',
						'title'				=> __('Call to Action #3', 'better-block-patterns'),
						'description'		=> __('An image on one side and text on the other.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/call-to-action-3/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/call-to-action-3/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/call-to-action-3/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/call-to-action-3/block-css-back.css'
					),
					'contact-1'	=> array (
						'slug'				=> 'contact-1',
						'pattern_class'		=> 'bbp-pattern-general-contact-1',
						'title'				=> __('Contact #1', 'better-block-patterns'),
						'description'		=> __('A compact way to display contact information.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/contact-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/contact-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/contact-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/contact-1/block-css-back.css'
					),
					'contact-2'	=> array (
						'slug'				=> 'contact-2',
						'pattern_class'		=> 'bbp-pattern-general-contact-2',
						'title'				=> __('Contact #2', 'better-block-patterns'),
						'description'		=> __('Two columns with contact information, with text, links and social media icons on one side, and a Map on the other side.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/contact-2/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/contact-2/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/contact-2/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/contact-2/block-css-back.css'
					),
					'description-1'	=> array (
						'slug'				=> 'description-1',
						'pattern_class'		=> 'bbp-pattern-general-description-1',
						'title'				=> __('Description #1', 'better-block-patterns'),
						'description'		=> __('Describe a product or a service, with multiple headings and paragraphs on one side and an image on the other.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/description-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/description-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/description-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/description-1/block-css-back.css'
					),
					'description-2'	=> array (
						'slug'				=> 'description-2',
						'pattern_class'		=> 'bbp-pattern-general-description-2',
						'title'				=> __('Description #2', 'better-block-patterns'),
						'description'		=> __('Describe a product or a service with some overlaid text over a cover image.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid','cover'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/description-2/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/description-2/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/description-2/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/description-2/block-css-back.css'
					),
					'description-3'	=> array (
						'slug'				=> 'description-3',
						'pattern_class'		=> 'bbp-pattern-general-description-3',
						'title'				=> __('Description #3', 'better-block-patterns'),
						'description'		=> __('A wide image followed by multiple columns with text. Use multiple shades of the same color for the best effect.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/description-3/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/description-3/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/description-3/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/description-3/block-css-back.css'
					),
					'feature-simple-1'	=> array (
						'slug'				=> 'feature-simple-1',
						'pattern_class'		=> 'bbp-pattern-general-feature-simple-1',
						'title'				=> __('Feature Simple #1', 'better-block-patterns'),
						'description'		=> __('A simple pattern to describe a product or a section of the website.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/feature-simple-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/feature-simple-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/feature-simple-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/feature-simple-1/block-css-back.css'
					),
					'featured-pages-1'	=> array (
						'slug'				=> 'featured-pages-1',
						'pattern_class'		=> 'bbp-pattern-general-featured-pages-1',
						'title'				=> __('Featured Pages #1', 'better-block-patterns'),
						'description'		=> __('Highlight multiple sections of your website. ', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/featured-pages-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/featured-pages-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/featured-pages-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/featured-pages-1/block-css-back.css'
					),
					'featured-pages-2'	=> array (
						'slug'				=> 'featured-pages-2',
						'pattern_class'		=> 'bbp-pattern-general-featured-pages-2',
						'title'				=> __('Featured Pages #2', 'better-block-patterns'),
						'description'		=> __('Highlight multiple sections of your website. Text is overlaid on an image.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/featured-pages-2/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/featured-pages-2/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/featured-pages-2/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/featured-pages-2/block-css-back.css'
					),
					'intro-1'	=> array (
						'slug'				=> 'intro-1',
						'pattern_class'		=> 'bbp-pattern-general-intro-1',
						'title'				=> __('Intro #1', 'better-block-patterns'),
						'description'		=> __('Add an introduction for a page or a page section. A two columns layout, with the heading in one column and text in the other.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/intro-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/intro-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/intro-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/intro-1/block-css-back.css'
					),
					'intro-2'	=> array (
						'slug'				=> 'intro-2',
						'pattern_class'		=> 'bbp-pattern-general-intro-2',
						'title'				=> __('Intro #2', 'better-block-patterns'),
						'description'		=> __('A centered introduction for a page or a page section.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/intro-2/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/intro-2/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/intro-2/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/intro-2/block-css-back.css'
					),
					'partners-1'	=> array (
						'slug'				=> 'partners-1',
						'pattern_class'		=> 'bbp-pattern-general-partners-1',
						'title'				=> __('Partners #1', 'better-block-patterns'),
						'description'		=> __('An easy way to display a grid of client or partner logos.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/partners-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/partners-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/partners-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/partners-1/block-css-back.css'
					),
					'partners-2'	=> array (
						'slug'				=> 'partners-2',
						'pattern_class'		=> 'bbp-pattern-general-partners-2',
						'title'				=> __('Partners #2', 'better-block-patterns'),
						'description'		=> __('An easy way to display a grid of client or partner logos, with a border around every logo.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/partners-2/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/partners-2/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/partners-2/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/partners-2/block-css-back.css'
					),
					'portfolio-1'	=> array (
						'slug'				=> 'portfolio-1',
						'pattern_class'		=> 'bbp-pattern-general-portfolio-1',
						'title'				=> __('Portfolio #1', 'better-block-patterns'),
						'description'		=> __('Describe a product or a service using this two columns layout, with text in one column and multiple image in the other.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/portfolio-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/portfolio-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/portfolio-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/portfolio-1/block-css-back.css'
					),
					'portfolio-2'	=> array (
						'slug'				=> 'portfolio-2',
						'pattern_class'		=> 'bbp-pattern-general-portfolio-2',
						'title'				=> __('Portfolio #2', 'better-block-patterns'),
						'description'		=> __('Highlight multiple categories or sections of your website, with buttons overlaid on Cover blocks.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/portfolio-2/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/portfolio-2/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/portfolio-2/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/portfolio-2/block-css-back.css'
					),
					'pricing-1'	=> array (
						'slug'				=> 'pricing-1',
						'pattern_class'		=> 'bbp-pattern-general-pricing-1',
						'title'				=> __('Pricing Table #1', 'better-block-patterns'),
						'description'		=> __('Display multiple pricing plans with bordered columns, with a plan title, list of features and a link to buy or learn more.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid','pricing'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/pricing-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/pricing-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/pricing-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/pricing-1/block-css-back.css'
					),
					'pricing-2'	=> array (
						'slug'				=> 'pricing-2',
						'pattern_class'		=> 'bbp-pattern-general-pricing-2',
						'title'				=> __('Pricing Table #2', 'better-block-patterns'),
						'description'		=> __('A minimalist way to present multiple pricing plans.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid','pricing'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/pricing-2/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/pricing-2/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/pricing-2/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/pricing-2/block-css-back.css'
					),
					'services-1'	=> array (
						'slug'				=> 'services-1',
						'pattern_class'		=> 'bbp-pattern-general-services-1',
						'title'				=> __('Services #1', 'better-block-patterns'),
						'description'		=> __('Multiple columns with a tagline, a heading, text and a link.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/services-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/services-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/services-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/services-1/block-css-back.css'
					),
					'services-2'	=> array (
						'slug'				=> 'services-2',
						'pattern_class'		=> 'bbp-pattern-general-services-2',
						'title'				=> __('Services #2', 'better-block-patterns'),
						'description'		=> __('Multiple columns with a large number, a heading and some text.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/services-2/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/services-2/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/services-2/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/services-2/block-css-back.css'
					),
					'team-1'	=> array (
						'slug'				=> 'team-1',
						'pattern_class'		=> 'bbp-pattern-general-team-1',
						'title'				=> __('Team #1', 'better-block-patterns'),
						'description'		=> __('A compact way to present your staff or team in a grid of 2.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/team-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/team-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/team-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/team-1/block-css-back.css'
					),
					'team-2'	=> array (
						'slug'				=> 'team-2',
						'pattern_class'		=> 'bbp-pattern-general-team-2',
						'title'				=> __('Team #2', 'better-block-patterns'),
						'description'		=> __('Present your staff or team in multiple columns. Works best with 2, 3 or 4 columns. ', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/team-2/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/team-2/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/team-2/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/team-2/block-css-back.css'
					),
					'team-3'	=> array (
						'slug'				=> 'team-3',
						'pattern_class'		=> 'bbp-pattern-general-team-3',
						'title'				=> __('Team #3', 'better-block-patterns'),
						'description'		=> __('A modern way to present your staff or team. One column has a large image, the other column has smaller images.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/team-3/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/team-3/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/team-3/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/team-3/block-css-back.css'
					),
					'testimonials-1'	=> array (
						'slug'				=> 'testimonials-1',
						'pattern_class'		=> 'bbp-pattern-general-testimonials-1',
						'title'				=> __('Testimonials #1', 'better-block-patterns'),
						'description'		=> __('A quick way to display multiple testimonials.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/testimonials-1/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/testimonials-1/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/testimonials-1/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/testimonials-1/block-css-back.css'
					),
					'testimonials-2'	=> array (
						'slug'				=> 'testimonials-2',
						'pattern_class'		=> 'bbp-pattern-general-testimonials-2',
						'title'				=> __('Testimonials #2', 'better-block-patterns'),
						'description'		=> __('A quick way to display multiple testimonials.', 'better-block-patterns'),
						'categories'		=> array('bbp-general-features'),
						'keywords'			=> array('row','column','grid'),
						'viewportWidth'		=> 1200,
						'file_content'		=> BBP_PLUGIN_DIR . 'patterns/general-features/testimonials-2/block-data.php',
						'file_screenshot'	=> BBP_PLUGIN_URL . 'patterns/general-features/testimonials-2/screenshot.png',
						'file_css_front'	=> BBP_PLUGIN_DIR . 'patterns/general-features/testimonials-2/block-css-front.css',
						'file_css_back'		=> BBP_PLUGIN_DIR . 'patterns/general-features/testimonials-2/block-css-back.css'
					),
				)
			)
		);

		return apply_filters( 'bbp_default_pattern_packages', $pattern_packages );

	}

	/**
	 * Get all custom pattern packages
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function get_custom_pattern_packages() {

		return apply_filters( 'bbp_custom_pattern_packages', array() );

	}

}
