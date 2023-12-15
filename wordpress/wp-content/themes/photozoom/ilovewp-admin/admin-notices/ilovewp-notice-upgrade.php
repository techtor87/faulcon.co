<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class photozoom_notice_upgrade extends photozoom_notice {

	public function __construct() {

		add_action( 'wp_loaded', array( $this, 'upgrade_notice' ), 20 );
		add_action( 'wp_loaded', array( $this, 'hide_notices' ), 15 );

		$this->current_user_id       = get_current_user_id();

	}

	public function upgrade_notice() {
		
		$welcome_notice_was_dismissed = $this->get_notice_status('welcome');

		if ( ! get_option( 'photozoom_theme_installed_time' ) ) {
			update_option( 'photozoom_theme_installed_time', time() );
		}

		$this_notice_was_dismissed = $this->get_notice_status('upgrade-user-' . $this->current_user_id);
		
		if ( !$this_notice_was_dismissed && $welcome_notice_was_dismissed ) {
			add_action( 'admin_notices', array( $this, 'upgrade_notice_markup' ) ); // Display this notice.
		}

	}

	/**
	 * Show HTML markup if conditions meet.
	 */
	public function upgrade_notice_markup() {
		
		$dismiss_url = wp_nonce_url(
			remove_query_arg( array( 'activated' ), add_query_arg( 'photozoom-hide-notice', 'upgrade-user-' . $this->current_user_id ) ),
			'photozoom_hide_notices_nonce',
			'_photozoom_notice_nonce'
		);

		$theme_data	 	= wp_get_theme();
		$current_user 	= wp_get_current_user();

		if ( ( get_option( 'photozoom_theme_installed_time' ) > strtotime( '-2 days' ) ) ) {
			return;
		}

		?>
		<div id="message" class="notice notice-success ilovewp-notice ilovewp-upgrade-notice">
			<a class="ilovewp-message-close notice-dismiss" href="<?php echo esc_url( $dismiss_url ); ?>"></a>
			<div class="ilovewp-message-content">

				<div class="ilovewp-message-image">
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=photozoom-doc' ) ); ?>"><img class="ilovewp-screenshot" src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png" alt="<?php esc_attr_e( 'Photozoom Theme Screenshot', 'photozoom' ); ?>" /></a>
				</div><!-- ws fix
				--><div class="ilovewp-message-text">
				
					<p>
						<?php
						printf(
							/* Translators: %1$s current user display name. */
							esc_html__(
								'Dear %1$s! I hope you are happy with everything that the %2$s has to offer. %3$sIf you like the free Photozoom Theme, you will love my new theme for photographers - CAPA. %3$s%4$s is a new (2022) theme that makes it very easy to create a custom-looking WordPress website.',
								'photozoom'
							),
							'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
							'<a href="' . esc_url( admin_url( 'themes.php?page=photozoom-doc' ) ) . '">' . esc_html( $theme_data->Name ) . '</a>',
							'<br>',
							'<strong><a href="https://www.ilovewp.com/product/capa/">CAPA</a></strong>');
						?>
					</p>

					<p class="notice-buttons"><a href="https://www.ilovewp.com/product/capa/?utm_source=dashboard&utm_medium=upgrade-notice&utm_campaign=photozoom&utm_content=notice-upgrade-link" class="btn button button-primary ilovewp-button" target="_blank"><?php esc_html_e( 'CAPA Details & Video', 'photozoom' ); ?></a></p>

				</div><!-- .ilovewp-message-text -->

			</div><!-- .ilovewp-message-content -->

		</div><!-- #message -->
		<?php
	}
}

new photozoom_notice_upgrade();