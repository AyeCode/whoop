(function( $ ) {

	$( document ).ready( function () {

		$('body').on('click','a.whoop-account-link',function () {
			$("#whoop_user_account_panel").slideToggle();
		});

		var gd_list_view = localStorage.getItem("gd_list_view");

		$('.whoop-list-view-select select#gd_list_view option[value='+gd_list_view+']').attr("selected",true);

		$(".whoop-list-view-select select#gd_list_view").on( 'change', function() {

			var current_val = $(this).val();

			localStorage.setItem("gd_list_view", current_val);

			$('.geodir-loop-container ul.geodir-category-list-view').removeAttr('class');

			$('.geodir-loop-container ul').addClass('geodir-category-list-view');

			if( '1' == current_val ) {
				$('.geodir-loop-container ul.geodir-category-list-view').addClass('list-view');
			} else{
				$('.geodir-loop-container ul.geodir-category-list-view').addClass('grid-view-'+current_val);
			}

		} ).change();

	});

})( jQuery );