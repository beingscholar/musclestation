jQuery( function( $ ) {

	$( 'table.widefat tbody th, table.widefat tbody td' ).css( 'cursor', 'move' );

	$( 'table.widefat tbody' ).sortable({
		items 	: 'tr:not(.inline-edit-row)',
		cursor 	: 'move',
		axis 	: 'y',
		containment 		: '.wrap form#posts-filter',
		scrollSensitivity 	: 40,
		placeholder 		: "ui-state-highlight",
		helper: function( event, ui ) {
			return ui;
		},
		start: function( event, ui ) {
			if ( ! ui.item.hasClass( 'alternate' ) ) {
				ui.item.css( 'background-color', '#ffffff' );
			}
		},
		stop: function( event, ui ) {
		},
		update: function( event, ui ) {
			if ( ! ui.item.hasClass( 'alternate' ) ) {
				ui.item.css( 'background-color', '' );
			}
		}
	});

	/* Onlick of save sort order button */
	$(document).on('click', '.wpsisac-save-order', function(){

		var current_obj = $(this);
		current_obj.attr('disabled', 'disabled');
		current_obj.parent().find('.wpsisac-spinner').css('visibility', 'visible');
		$('.wpsisac-notice').remove();

		var data = {
						action      : 'wpsisac_pro_update_post_order',
						form_data   : current_obj.closest('form#posts-filter').serialize()
					};
		$.post(ajaxurl,data,function(response) {
			var result = $.parseJSON(response);

			if( result.success == 1 ) {
				current_obj.closest('.wrap').find('h1:first').after('<div class="updated notice notice-success is-dismissible wpsisac-notice"><p>'+result.msg+'</p></div>');
			} else if( result.success == 0 ){
				current_obj.closest('.wrap').find('h1:first').after('<div class="error notice notice-error is-dismissible wpsisac-notice"><p>'+result.msg+'</p></div>');
			}

			current_obj.removeAttr('disabled', 'disabled');
			current_obj.parent().find('.wpsisac-spinner').css('visibility', 'hidden');
		});
	});

});