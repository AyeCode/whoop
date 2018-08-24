(function( $ ) {

	$( document ).ready( function () {

		$('body').on('click','a.whoop-account-link',function () {
			$("#whoop_user_account_panel").slideToggle();
		});

	});

})( jQuery );