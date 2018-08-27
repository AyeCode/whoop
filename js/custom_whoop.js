(function( $ ) {

	$( document ).ready( function () {

		$('body').on('click','a.whoop-account-link',function () {
			$("#whoop_user_account_panel").slideToggle();
		});

		$('body').on('change','.whoop-list-view-select #gd_list_view',function () {

			var current_val = $(this).val();

			$('.geodir-loop-container ul.geodir-category-list-view').removeAttr('class');

			$('.geodir-loop-container ul').addClass('geodir-category-list-view');
			if( '1' == current_val ) {
				$('.geodir-loop-container ul.geodir-category-list-view').addClass('list-view');
			} else{

				$('.geodir-loop-container ul.geodir-category-list-view').addClass('grid-view-'+current_val);
			}


		});

	});

})( jQuery );