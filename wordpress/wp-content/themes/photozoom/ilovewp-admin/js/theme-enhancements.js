jQuery(document).ready(function($) {

	/**
	 *	Process request to dismiss our admin notice
	 */
	$('#photozoom-admin-notice-postsnum .notice-dismiss').click(function() {

		//* Data to make available via the $_POST variable
		data = {
			action: 'photozoom_admin_notice_postsnum',
			photozoom_admin_notice_nonce: photozoom_admin_notice_postsnum.photozoom_admin_notice_nonce
		};

		//* Process the AJAX POST request
		$.post( ajaxurl, data );

		return false;
	});
});