<?php
/**
 * Settings Pages in Dashboard
 *
 * @package     BBP
 * @copyright   Copyright (c) 2021, Dumitru Brinzan
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * BBP_Settings Class
 *
 * This class handles plugin settings in the back-end
 *
 * @since 1.0.0
 */
class BBP_Settings {

	/**
	 * Get things going
	 *
	 * @since 1.0.0
	 */

	public $settings = array();

	public function __construct() {

		add_action( 'admin_menu', array( $this, 'admin_menu_options' ) );
		add_action( 'admin_init', array( $this, 'bbp_settings_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'bbp_admin_scripts_styles' ) );
	}

	/**
	 * Enqueue admin styles and scripts.
	 *
	 * @param string $page
	 * @return void
	 */
	public function bbp_admin_scripts_styles( $page ) {
		
		$bbp_page = strpos($page, 'better-block-patterns');
		if ( $bbp_page === false ) {
			return;
		}

		wp_enqueue_script( 'bbp-admin-scripts', BBP_PLUGIN_URL . 'assets/js/bbp-admin.js', array( 'jquery', 'jquery-ui-tabs' ) );
		wp_enqueue_style( 'bbp-admin-styles', BBP_PLUGIN_URL . 'assets/css/bbp-admin.css', array());

	}

	/**
	 * Register options page
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	public function admin_menu_options() {

		add_menu_page(
			__( 'Better Block Patterns', 'better-block-patterns' ), 
			__( 'Better Block Patterns', 'better-block-patterns' ), 
			'manage_options', 
			'better-block-patterns',
			'',
			'dashicons-layout',
			81
		);

		add_submenu_page( 
			'better-block-patterns',
			__( 'Getting Started with Better Block Patterns', 'better-block-patterns' ), 
			__( 'Getting Started', 'better-block-patterns' ), 
			'manage_options', 
			'better-block-patterns',
			array($this, 'bbp_settings_page_general')
		);

		if ( current_user_can( 'manage_options' ) ) {
			add_submenu_page( 
				'better-block-patterns',
				__( 'Settings', 'better-block-patterns' ), 
				__( 'Settings', 'better-block-patterns' ), 
				'manage_options', 
				'better-block-patterns-settings',
				array($this, 'bbp_settings_page_settings')
			);

		}

	}

	function bbp_settings_init() {

		global $BBP_instance;
		$bbp_options = get_option( 'better_block_patterns' );

		$default_packages = apply_filters( 'bbp_default_pattern_packages', $BBP_instance->default_pattern_packages );
		$custom_packages = apply_filters( 'bbp_custom_pattern_packages', $BBP_instance->custom_pattern_packages );

		register_setting( 'better-block-patterns-settings-packages', 'better_block_patterns' );
		register_setting( 'better-block-patterns-settings-patterns', 'better_block_patterns' );
		register_setting( 'better-block-patterns-settings-performance', 'better_block_patterns' );
		register_setting( 'better-block-patterns-tools-find-templates', 'better_block_patterns_tools' );

		add_settings_section(
			'bbp_section_pattern_packages',
			__( 'Pattern Packages', 'better-block-patterns' ), 
			array($this, 'bbp_section_pattern_packages_callback'),
			'better-block-patterns-settings-packages'
		);

		add_settings_field(
			'bbp_pattern_packages', 
			__( 'Pattern Packages', 'better-block-patterns' ),
			array($this,'bbp_multicheck_packages'),
			'better-block-patterns-settings-packages',
			'bbp_section_pattern_packages',
			array(
				'label_for'         => '',
				'class'             => 'row',
				'values'			=> $default_packages
			)
		);

		if ( isset($custom_packages) && !empty($custom_packages) ) {
			add_settings_field(
				'bbp_pattern_packages_custom', 
				__( 'Custom Pattern Packages', 'better-block-patterns' ),
				array($this,'bbp_multicheck_packages'),
				'better-block-patterns-settings-packages',
				'bbp_section_pattern_packages',
				array(
					'label_for'         => '',
					'class'             => 'row',
					'values'			=> $custom_packages
				)
			);
		}

		if ( isset($default_packages) && !empty($default_packages) ) {

			add_settings_section(
				'bbp_section_pattern_patterns',
				__( 'Individual Patterns', 'better-block-patterns' ), 
				array($this, 'bbp_section_pattern_patterns_callback'),
				'better-block-patterns-settings-patterns'
			);

			foreach ($default_packages as $package_slug => $package_data) {

				if ( !isset($bbp_options['bbp_pattern_packages'][$package_data['slug']]) ) {
					continue;
				}

				if ( isset($package_data['patterns']) && !empty($package_data['patterns']) ) {

					add_settings_field(
						'bbp_pattern_package_' . esc_attr($package_slug), 
						$package_data['title'],
						array($this,'bbp_multicheck_patterns'),
						'better-block-patterns-settings-patterns',
						'bbp_section_pattern_patterns',
						array(
							'label_for'         => '',
							'class'             => 'row row-patterns',
							'values'			=> $package_data
						)
					);

				}

			}

			foreach ($custom_packages as $package_slug => $package_data) {

				if ( !isset($bbp_options['bbp_pattern_packages'][$package_data['slug']]) ) {
					continue;
				}

				if ( isset($package_data['patterns']) && !empty($package_data['patterns']) ) {

					add_settings_field(
						'bbp_pattern_package_' . esc_attr($package_slug), 
						$package_data['title'],
						array($this,'bbp_multicheck_patterns'),
						'better-block-patterns-settings-patterns',
						'bbp_section_pattern_patterns',
						array(
							'label_for'         => '',
							'class'             => 'row row-patterns',
							'values'			=> $package_data
						)
					);

				}

			}

		}

		add_settings_section(
			'bbp_section_performance',
			__( 'Performance Settings', 'better-block-patterns' ), 
			array($this, 'bbp_section_performance_callback'),
			'better-block-patterns-settings-performance'
		);

		add_settings_field(
			'bbp_load_block_styles', 
			__( 'Load BBP CSS Assets', 'better-block-patterns' ),
			array($this,'bbp_checkbox'),
			'better-block-patterns-settings-performance',
			'bbp_section_performance',
			array(
				'label_for'         => 'bbp_load_block_styles',
				'class'             => 'row',
				'description'		=> __( 'Uncheck this if you want to style the patterns with your own CSS code. Default: checked.', 'better-block-patterns' ), 
			)
		);

		add_settings_field(
			'bbp_load_fontawesome_styles', 
			__( 'Load BBP FontAwesome', 'better-block-patterns' ),
			array($this,'bbp_checkbox'),
			'better-block-patterns-settings-performance',
			'bbp_section_performance',
			array(
				'label_for'         => 'bbp_load_fontawesome_styles',
				'class'             => 'row',
				'description'		=> __( 'Uncheck this if you don\'t need to load the FontAwesome library (if your theme or a different plugin already includes it). Default: checked.', 'better-block-patterns' ), 
			)
		);

		add_settings_field(
			'bbp_speed_load_location', 
			__( 'When to load Assets', 'better-block-patterns' ),
			array($this,'bbp_select'),
			'better-block-patterns-settings-performance',
			'bbp_section_performance',
			array(
				'label_for'         => 'bbp_speed_load_location',
				'class'             => 'row',
				'values'			=> array(
					'everywhere'		=> __( '1. On all pages &mdash; default', 'better-block-patterns' ),
					'singular'			=> __( '2. On single pages', 'better-block-patterns' ),
					'needed'			=> __( '3. Only when needed &mdash; recommended', 'better-block-patterns' ),
				),
				'description'		=> sprintf(
							__( 'Option #3 is best for performance and works for most users. If some patterns don\'t look as expected, try switching to #1. Default: 1.', 'better-block-patterns' )
						)
			)
		);

	}

	/**
	* @param array $args  The settings array, defining title, id, callback.
	*/
	function bbp_section_pattern_packages_callback( $args ) {
		?>
		<p><?php esc_html_e( 'Enable the pattern packages that you would like to use on your website.', 'better-block-patterns' ); ?><br />
		<?php esc_html_e( 'Click on the "Save Changes" button before switching to the "Individual Patterns" tab.', 'better-block-patterns' ); ?></p>
		<?php
	}

	/**
	* @param array $args  The settings array, defining title, id, callback.
	*/
	function bbp_section_pattern_patterns_callback( $args ) {
		?>
		<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'These options control the contents of the bbp-core.css file that is automatically generated by the plugin.', 'better-block-patterns' ); ?><br /><?php esc_html_e( 'You can exclude the parts that you don\'t need in order to keep a smaller .css file.', 'better-block-patterns' ); ?></p>
		<?php
	}

	/**
	* @param array $args  The settings array, defining title, id, callback.
	*/
	function bbp_section_performance_callback( $args ) {
		?>
		<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php printf( 
				__( '<p>Performance settings are explained <a href="%1$s" target="_blank" rel="noopener">in the documentation here</a>.</p>', 'better-block-patterns' ), 
				esc_url( 'https://www.ilovewp.com/documentation/better-block-patterns/' ) ); ?></p>
		<?php
	}

	/**
	 * Select
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	function bbp_select($args) { 
		
		$bbp_options = get_option( 'better_block_patterns' );
		if ( isset($args['values']) && !empty($args['values']) ) {
		?>
		<select id="<?php echo esc_attr( $args['label_for'] ); ?>" name="better_block_patterns[<?php echo esc_attr( $args['label_for'] ); ?>]">
			<?php
			foreach ($args['values'] as $option_key => $option_title) {
				echo '<option value="' . esc_attr($option_key) . '"';

				if ( isset($bbp_options[ $args['label_for'] ]) && $bbp_options[ $args['label_for'] ] == $option_key ) {
					echo ' selected="selected"';
				}

				echo '>';
				echo esc_html($option_title);
				echo '</option>';
			}
			?>
		</select>
		<?php
		} // if there are valid values
		if ( isset($args['description']) ) {
			echo '<span class="bbp-description">' . esc_html($args['description']) . '</span>';
		}
	}

	/**
	 * Checkbox
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	function bbp_checkbox($args) { 
		
		$bbp_options = get_option( 'better_block_patterns' );

		echo '<input type="checkbox" id="' . esc_attr( $args['label_for'] ) . '" name="better_block_patterns[' . esc_attr( $args['label_for'] ) . ']" value="1"';
		if ( isset($bbp_options[ $args['label_for'] ]) ) {
			echo ' checked';
		}
		echo '/>';
		if ( isset($args['description']) ) {
			echo '<span class="bbp-description">' . esc_html($args['description']) . '</span>';
		}
	}

	/**
	 * Pattern Packages
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	function bbp_multicheck_packages($args) { 
		
		$bbp_options 	= get_option( 'better_block_patterns' );
		$base_dir 		= BBP_PLUGIN_DIR . 'patterns/';

		if ( isset($args['values']) && !empty( $args['values'] ) ) {

			?><table class="bbp-packages__list"><tbody><?php

			foreach ($args['values'] as $category_key => $category_data) {

				echo '<tr class="bbp-package__item">';

				echo '<td class="bbp-package__patterns-content"><label><input class="bbp-checkbox-block" type="checkbox" id="' . esc_attr( $args['label_for'] ) . '" name="better_block_patterns[bbp_pattern_packages][' . esc_attr($category_key) . ']" value="1"';
				if ( isset($bbp_options['bbp_pattern_packages'][$category_data['slug']]) ) {
					echo ' checked';
				}
				echo '/><span class="bbp-package__item-title">' . esc_html($category_data['title']) . '</span>';

				if ( !empty($category_data['patterns']) ) {
					printf( 
						__( '<span class="bbp-package__item-patterns"> &ndash; %1$s patterns</span>', 'better-block-patterns' ), 
						esc_html(count($category_data['patterns']))
					);
				}

				echo '</label><p class="bbp-package__item-description">' . esc_html($category_data['description']) . '</p>';

				/*
				if ( !empty($category_data['preview_url']) ) {
					printf( 
						__( ' <span class="bbp-package__item-preview"><a href="%1$s" target="_blank" rel="noopener">Package information</a></span>', 'better-block-patterns' ), 
						esc_url($category_data['preview_url'])
					);
				}
				*/

				echo '</td></tr><!-- .bbp-package__item -->';

			}

			?></tbody></table><!-- .bbp-packages__list --><?php

		}
		
	}

	/**
	 * Package Patterns
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	function bbp_multicheck_patterns($args) { 
		
		$bbp_options 		= get_option( 'better_block_patterns' );
		$base_dir 			= BBP_PLUGIN_DIR . 'patterns/';
		$category_slug 		= $args['values']['slug'];

		if ( isset($args['values']['patterns']) && !empty( $args['values']['patterns'] ) ) {

			?><table class="bbp-patterns__list"><tbody><?php

			foreach ($args['values']['patterns'] as $pattern_key => $pattern_data) {

				echo '<tr class="bbp-pattern__item">';
				echo '<td class="bbp-package__patterns-content">';

				echo '<div class="bbp-pattern__item-screenshot"><a href="' . esc_url($pattern_data['file_screenshot']) . '" title="' . esc_attr($pattern_data['description']) . '"><img class="bbp-img-pattern" src="' . esc_url($pattern_data['file_screenshot']) . '" alt="' . esc_attr($pattern_data['title']) . '" /></a></div><!-- .bbp-pattern__item-screenshot -->';

				echo '<label><input class="bbp-checkbox-block" type="checkbox" id="' . esc_attr( $args['label_for'] ) . '" name="better_block_patterns[' . esc_attr( $args['label_for'] ) . '][' . esc_attr($pattern_data['slug']) . ']" value="1"';
				if ( isset($bbp_options[ $args['label_for'] ][$pattern_data['slug']]) ) {
					echo ' checked';
				}
				echo '/><span class="bbp-pattern__item-title">' . esc_html($pattern_data['title']) . '</span>';

				echo '</label><p class="bbp-pattern__item-description">' . esc_html($pattern_data['description']) . '</p>';

				echo '</td></tr><!-- .bbp-pattern__item -->';

			}

			?></tbody></table><!-- .bbp-patterns__list --><?php

		}
	}

	/**
	 * General settings page navigation
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	function bbp_settings_page_nav_tabs() {

		if ( isset($_GET['page']) ) { 
			$current_page = sanitize_text_field($_GET['page']);
		} else { 
			$current_page = '';
		}

		$bbp_navs = array(
			'better-block-patterns'				=> __('Getting Started', 'better-block-patterns'),
			'better-block-patterns-settings'	=> __('Settings', 'better-block-patterns')
		);

		$bbp_navs = apply_filters( 'bbp_settings_page_nav_tabs', $bbp_navs );

		if ( isset($bbp_navs) && !empty($bbp_navs) ) { ?>			
		<div class="wrap">
			<div class="nav-tab-wrapper"><?php
				foreach ($bbp_navs as $bbp_nav_key => $bbp_nav_title ) {
					echo '<a href="' . esc_url(admin_url('admin.php?page=' . esc_attr($bbp_nav_key))) . '" class="nav-tab';
					if ( $current_page == $bbp_nav_key ) {
						echo ' nav-tab-active';
					}
					echo '">' . esc_html($bbp_nav_title) . '</a>';
				} ?>			
			</div><!-- .nav-tab-wrapper -->
		</div><!-- .wrap --><?php
		} // if isset($bbp_navs) 
	}

	/**
	 * General page HTML
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	function bbp_settings_page_general() {

		$theme_data = wp_get_theme();
		$current_user = wp_get_current_user();

		$this->bbp_settings_page_nav_tabs();
		?>
		
		<div id="better-block-patterns" class="wrap">

			<div class="bbp-admin-columns">
				<div class="bbp-admin-column bbp-admin-column--main">
					<div class="bbp-admin-column__wrapper">

						<h1 class="page-title"><?php echo esc_html(get_admin_page_title()); ?></h1>
						<p class="welcome-description"><?php esc_html_e( 'This plugin includes custom block patterns that blend in with your active WordPress theme.', 'better-block-patterns' ); ?></p>

						<hr />

						<h2><?php esc_html_e('1. How to Enable Custom Block Patterns', 'better-block-patterns'); ?></h2>

						<p><strong><?php esc_html_e('Before you can start using Better Block Patterns in your posts and pages, you have to enable some pattern packages and individual patterns.','better-block-patterns'); ?></strong></p>

						<p><?php echo sprintf(
							__( 'You can enable pattern packages on the <a href="%1$s">Settings</a> page in the <strong>Pattern Packages</strong> tab. Click on the <strong>Save Changes</strong> button.', 'better-block-patterns' ),
							esc_url(admin_url('admin.php?page=better-block-patterns-settings'))
							)
						?></p>

						<p><?php echo sprintf(
							__( 'After that you can enable individual patterns in the <strong>Individual Patterns</strong> tab.', 'better-block-patterns' ));
						?></p>

						<div class="bbp-doc-block bbp-doc-block--faq">
						<p><?php esc_html_e('Q: Why do I have to manually enable patterns?','better-block-patterns'); ?></p>
						<p><?php _e('A: The short answer: <strong>for better performance</strong>. This way the plugin will load only the minimum necessary CSS code on the front-end, thus keeping its impact to a minimum.','better-block-patterns'); ?></p>
						</div>

						<h2><?php esc_html_e('2. How to Add Block Patterns', 'better-block-patterns'); ?></h2>

						<p><?php esc_html_e('To add a block pattern to a page or a post, simply create a new one or edit an existing one.','better-block-patterns'); ?></p>

						<p><?php esc_html_e('In the Block Editor, click on the plus button to add a new block.','better-block-patterns'); ?></p>

						<img src="<?php echo esc_url( BBP_PLUGIN_URL . '/assets/images/bbp-doc-step-1.png' ); ?>" class="bbp-help-screenshot" width="900" height="510" alt="" />

						<p><?php esc_html_e('In the newly opened pull-out panel switch from Blocks to Patterns.','better-block-patterns'); ?></p>

						<img src="<?php echo esc_url( BBP_PLUGIN_URL . '/assets/images/bbp-doc-step-2.png' ); ?>" class="bbp-help-screenshot" width="900" height="510" alt="" />

						<p><?php esc_html_e('Select one of the categories containing custom block patterns. All Better Block Patterns are grouped into categories that have the BBP: prefix.','better-block-patterns'); ?></p>

						<img src="<?php echo esc_url( BBP_PLUGIN_URL . '/assets/images/bbp-doc-step-3.png' ); ?>" class="bbp-help-screenshot" width="900" height="510" alt="" />

					</div><!-- .bbp-admin-column__wrapper -->
				</div><!-- .bbp-admin-column .bbp-admin-column--main -->
				<div class="bbp-admin-column bbp-admin-column--sidebar">
					<div class="bbp-admin-column__wrapper">

						<div class="bbp-admin-section bbp-section__branding">
							<a href="https://www.ilovewp.com/better-block-patterns/" target="_blank" rel="noopener"><img src="<?php echo esc_url( BBP_PLUGIN_URL . '/assets/images/bbp-logo-dark.png' ); ?>" width="241" height="74" class="bbp-logo-welcome" alt="<?php esc_attr_e(__('Better Block Patterns Logo', 'better-block-patterns')); ?>" /></a>
						</div><!-- .bbp-admin-section .bbp-section__branding -->

						<div class="bbp-admin-section bbp-section__newsletter">

							<h2 class="bbp-admin-section__title"><?php esc_html_e('Subscribe to the Newsletter', 'better-block-patterns'); ?></h2>

							<p class="newsletter-description"><?php esc_html_e('We send out the newsletter once every few weeks. It contains information about upcoming plugin and theme updates, special offers and other WordPress-related useful content.','better-block-patterns'); ?></p>

							<form action="https://ilovewp.us14.list-manage.com/subscribe/post?u=b9a9c29fe8fb1b02d49b2ba2b&amp;id=18a2e743db" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="">
								<div id="mc_embed_signup_scroll">
									<input type="email" value="<?php echo esc_attr($current_user->user_email); ?>" name="EMAIL" class="email" id="mce-EMAIL" placeholder="<?php esc_attr_e(__('email address','better-block-patterns')); ?>" required="">
									<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
									<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_b9a9c29fe8fb1b02d49b2ba2b_18a2e743db" tabindex="-1" value=""></div>
									<input type="submit" value="<?php esc_attr_e('Subscribe','better-block-patterns'); ?>" name="subscribe" id="mc-embedded-subscribe" class="button button-primary">
								</div><!-- #mc_embed_signup_scroll -->
								<p class="newsletter-disclaimer"><?php esc_html_e('*We use Mailchimp as our marketing platform. By clicking above to subscribe, you acknowledge that your information will be transferred to Mailchimp for processing.','better-block-patterns'); ?></p>
							</form>
							
						</div><!-- .bbp-admin-section .bbp-section__newsletter -->

					</div><!-- .bbp-admin-column__wrapper -->
				</div><!-- .bbp-admin-column .bbp-admin-column--sidebar -->
			</div><!-- .bbp-admin-columns -->
		
		</div><!-- #better-block-patterns .wrap -->

	<?php }

	/**
	 * Settings page HTML
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	function bbp_settings_page_settings() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		global $wp_settings_fields;
		$bbp_options = get_option( 'better_block_patterns' );

		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'bbp_messages', 'bbp_message', __( 'Settings Saved', 'better-block-patterns' ), 'updated' );
		}

		settings_errors( 'bbp_messages' );

		$this->bbp_settings_page_nav_tabs();
		?>
		
		<div id="better-block-patterns" class="wrap">

			<h1 class="page-title"><?php echo esc_html(get_admin_page_title()); ?></h1>

			<div class="wp-filter">
				<ul class="filter-links">
					<li><a href="#bbp-pattern-packages"><?php esc_html_e( 'Pattern Packages', 'better-block-patterns' ) ?></a></li>
					<li><a href="#bbp-pattern-patterns"><?php esc_html_e( 'Individual Patterns', 'better-block-patterns' ) ?></a></li>
					<li><a href="#bbp-performance"><?php esc_html_e( 'Performance', 'better-block-patterns' ) ?></a></li>
				</ul><!-- .filter-links -->
			</div><!-- .wp-filter -->

			<form method="post" action="options.php">

				<div id="bbp-pattern-packages" class="tab">
					<?php 
					settings_fields( 'better-block-patterns-settings-packages' );
					do_settings_sections( 'better-block-patterns-settings-packages' );
					?>
				</div><!-- #bbp-pattern-packages -->

				<div id="bbp-pattern-patterns" class="tab">
					<?php 
					settings_fields( 'better-block-patterns-settings-patterns' );
					//do_settings_sections( 'better-block-patterns-settings-patterns' );

					$bbp_theme_supported_patterns = array();
					$bbp_theme_supported_patterns = apply_filters( 'bbp_theme_supported_patterns', $bbp_theme_supported_patterns );
					if ( isset($bbp_theme_supported_patterns) ) {
						$bbp_theme_supported_patterns_count = count($bbp_theme_supported_patterns);
					}

					if ( !empty($wp_settings_fields['better-block-patterns-settings-patterns']['bbp_section_pattern_patterns']) ) {

						if ( isset($bbp_theme_supported_patterns) && $bbp_theme_supported_patterns_count > 0 ) {
							printf( 
								__( '<p><strong>Patterns marked with a dashed border <span class="bbp-icon__item--supported"></span> are recommended by your active theme.</strong></p>', 'better-block-patterns' )
							);
						}

						foreach ( $wp_settings_fields['better-block-patterns-settings-patterns']['bbp_section_pattern_patterns'] as $package_slug => $package_data ) {

							if ( !empty($package_data['args']['values']) ) {

								echo '<div class="bbp-pattern-package__wrapper">';
								echo '<h2 class="bbp-pattern-package__title">' . esc_html($package_data['title']) . '</h2>';
								echo '<p class="bbp-pattern__item-description">' . esc_html($package_data['args']['values']['description']);

								/*
								if ( !empty($package_data['args']['values']['preview_url']) ) {
									printf( 
										__( ' <span class="bbp-pattern__item-preview"><a href="%1$s" target="_blank" rel="noopener">Package information</a></span>', 'better-block-patterns' ), 
										esc_url($package_data['args']['values']['preview_url'])
									);
								}
								*/

								echo '</p>';

								if ( !empty($package_data['args']['values']['patterns']) ) {

									echo '<div class="bbp-patterns__list">';

									foreach ( $package_data['args']['values']['patterns'] as $pattern_slug => $pattern_data ) {

										echo '<div class="bbp-pattern__item';

										if ( $bbp_theme_supported_patterns_count > 0 && in_array($pattern_data['pattern_class'], $bbp_theme_supported_patterns) ) {
											echo ' bbp-pattern__item--supported';
										}

										if ( isset($bbp_options[ $package_slug ][$pattern_slug]) ) {
											echo ' bbp-pattern__item--active';
										}
										echo '">';

										echo '<div class="bbp-package__patterns-content">';

										echo '<div class="bbp-pattern__item-screenshot"><a href="' . esc_url($pattern_data['file_screenshot']) . '" title="' . esc_attr($pattern_data['description']) . '"><img class="bbp-pattern__item-thumbnail" src="' . esc_url($pattern_data['file_screenshot']) . '" alt="' . esc_attr($pattern_data['title']) . '" /></a></div><!-- .bbp-pattern__item-screenshot -->';

										echo '<div class="bbp-pattern__item-content"><label><input class="bbp-checkbox-block" type="checkbox" id="' . esc_attr( $package_slug ) . '" name="better_block_patterns[' . esc_attr( $package_slug ) . '][' . esc_attr($pattern_slug) . ']" value="1"';
										if ( isset($bbp_options[ $package_slug ][$pattern_slug]) ) {
											echo ' checked';
										}
										echo '/><span class="bbp-pattern__item-title">' . esc_html($pattern_data['title']) . '</span>';

										echo '</label><p class="bbp-pattern__item-description">' . esc_html($pattern_data['description']) . '</p>';

										echo '</div><!-- .bbp-pattern__item-content --></div><!-- .bbp-package__patterns-content -->';

										echo '</div><!-- .bbp-pattern__item -->';

									} // foreach

									echo '</div><!-- .bbp-patterns__list -->';

								} // if !empty['patterns']

								echo '</div><!-- .bbp-pattern-package__wrapper -->';

							} // if !empty ['values']

						} // foreach()

					} // if !empty ['patterns']

					?>
				</div><!-- #bbp-pattern-patterns -->

				<div id="bbp-performance" class="tab">
					<?php 
					settings_fields( 'better-block-patterns-settings-performance' );
					do_settings_sections( 'better-block-patterns-settings-performance' );
					?>
				</div><!-- #bbp-performance -->

				<br /><?php submit_button(); ?>
			</form>
		
		</div><!-- #better-block-patterns .wrap -->

	<?php }

}