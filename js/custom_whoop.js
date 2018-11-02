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

        $(document).on('change','.whoop-common.whoop-featured select.search_by_post',function(){

            var post_type = $(this).val();

            $.ajax({
                url : geodir_params.ajax_url,
                type : 'post',
                data : {
                    action : 'get_categories_html',
                    post_type : post_type
                },
                success : function( response ) {

                    $('.popular-category ul.cat-menu').html('');
                    $('.popular-category ul.cat-menu').html(response);
                }
            });

        });

	});

})( jQuery );