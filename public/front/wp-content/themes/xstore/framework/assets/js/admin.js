jQuery(document).ready(function($){

	// ! Search by options
	$( '.etheme-options-search' ).on( 'keyup', function(e){
		var value = $(this).val();

		$( '.etheme-search .spinner' ).addClass( 'is-active' );
    	$( '.etheme-search .et-zoom' ).addClass( 'et-invisible' );

    	if ( value.length >= 2 ) {
	    	$( '.redux-container .redux-group-tab' ).removeClass( 'et-show' ).addClass( 'et-hide' );
	    	$( '.redux-container .redux-group-tab tr' ).removeClass( 'et-show' ).addClass( 'et-hide' );
    		$.each( $( '.redux-container .redux_field_th' ), function(){
    			var text = $(this).text();
	    		if ( text.toLowerCase().includes(value.toLowerCase()) ) {
	    			$(this).parents( '.redux-container .redux-group-tab' ).removeClass( 'et-hide' ).addClass( 'et-show' );
	    			$(this).parents( '.redux-container .redux-group-tab tr' ).removeClass( 'et-hide' );
	    			$(this).parents( '.redux-container .redux-group-tab tr' ).not( '.fold' ).css( 'display', 'table-row' );
	    			$(this).parents( '.redux-container .redux-group-tab tr.fold' ).addClass( 'et-fold-show' ).css( 'display', 'table-row' );

	    		}
	    	} );
    	} else {
			$( '.redux-container .redux-group-tab' ).removeClass( 'et-hide' ).removeClass( 'et-show' )
			$( '.redux-container .redux-group-tab tr' ).removeClass( 'et-hide' ).removeClass( 'et-show' );
			$( '.redux-container .redux-group-tab tr.fold.et-fold-show' ).css( 'display', 'table-row' );
			$( '.redux-container .redux-group-tab tr.fold.hide.et-fold-show' ).css( 'display', 'none' );
			$( '.redux-container .redux-group-tab tr.fold.et-fold-show' ).removeClass( 'et-fold-show' )
    	}

    	$.redux.initFields();

    	setTimeout(function() {
    		$( '.etheme-search .spinner' ).removeClass( 'is-active' );
			$( '.etheme-search .et-zoom' ).removeClass( 'et-invisible' );
    	}, 500);

	});

	$( '.redux-group-tab-link-li, .redux-group-tab-link-a' ).on( 'click', function(e){
		if ( ! $( '.etheme-options-search' ).val() ) return;
		$( '.etheme-options-search' ).val( '' );
		$( '.etheme-options-search' ).trigger( 'keyup' );
	});

	/* Promo banner in admin panel */
	
	jQuery('.et-extra-message .close-btn').click(function(){
		
		var confirmIt = confirm('Are you sure?');
		
		if(!confirmIt) return;
		
		var widgetBlock = jQuery(this).parent();
	
		var data =  {
			'action':'et_close_extra_notice',
			'close': widgetBlock.attr('data-etag')
		};
		
		widgetBlock.hide();
		
		jQuery.ajax({
			url: ajaxurl,
			data: data,
			success: function(response){
				widgetBlock.remove();
			},
			error: function(data) {
				alert('Error while deleting');
				widgetBlock.show();
			}
		});
	});
	
	/* UNLIMITED SIDEBARS */
	
	var delSidebar = '<div class="delete-sidebar">delete</div>';
	
	jQuery('.sidebar-etheme_custom_sidebar').find('.handlediv').before(delSidebar);
	
	jQuery('.delete-sidebar').click(function(){
		
		var confirmIt = confirm('Are you sure?');
		
		if(!confirmIt) return;
		
		var widgetBlock = jQuery(this).closest('.sidebar-etheme_custom_sidebar');
	
		var data =  {
			'action':'etheme_delete_sidebar',
			'etheme_sidebar_name': jQuery(this).parent().find('h2').text()
		};
		
		widgetBlock.hide();
		
		jQuery.ajax({
			url: ajaxurl,
			data: data,
			success: function(response){
				console.log(response);
				widgetBlock.remove();
			},
			error: function(data) {
				alert('Error while deleting sidebar');
				widgetBlock.show();
			}
		});
	});

	
	/* end sidebars */
    
	    // ! New wp.media for widgets
		jQuery(document).ready(function ($) {
			$(document).on("click", ".etheme_upload-image", function (e) {
				e.preventDefault();
				var $button = $(this);
		 
		      	// Create the media frame.
				var file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select or upload image',
					library: { // remove these to show all
				    	type: 'image' // specific mime
					},
					button: {
				    	text: 'Select'
					},
					multiple: false  // Set to true to allow multiple files to be selected
				});
		 
		      	// When an image is selected, run a callback.
			  	file_frame.on('select', function () {
					// We set multiple to false so only get one image from the uploader
					var attachment = file_frame.state().get('selection').first().toJSON();
					var parent = $button.parents( '.media-widget-control' );
					var thumb = '<img class="attachment-thumb" src="' + attachment.url + '">';

					parent.find( '.placeholder.etheme_upload-image' ).addClass( 'hidden' );
					parent.find( '.attachment-thumb' ).remove();
					parent.find( '.etheme_media-image' ).prepend( thumb );
					parent.find( 'input.widefat' ).attr( 'value', attachment.url );
					parent.find( 'input.widefat' ).change();	 
			  	});
		 
				// Finally, open the modal
				file_frame.open();
			});
		});

    $(document).ready(function(){
		setTimeout(function() {
			$('.et-tab-label.vc_tta-section-append').removeClass('vc_tta-section-append').addClass('et-tab-append');
		}, 1000);
	});

	$(document).on('click', '#et_tabs', function(event) {
		setTimeout(function() {
			$('.et-tab-label.vc_tta-section-append').removeClass('vc_tta-section-append').addClass('et-tab-append');
		}, 1000);
	});

    $(document).on('click', '.et-tab-label.et-tab-append', function(event) {
    	if( typeof vc == 'undefined' ) return;

        var newTabTitle = 'Tab', 
        	params, 
        	shortcode,
        	modelId = $(this).parents('.wpb_et_tabs').data('model-id'),
        	prepend = false;

        params = {
            shortcode: "et_tab",
            params: {
                title: newTabTitle
            },
            parent_id: modelId,
            order: _.isBoolean(prepend) && prepend ? vc.add_element_block_view.getFirstPositionIndex() : vc.shortcodes.getNextOrder(),
            prepend: prepend
        }

        shortcode = vc.shortcodes.create(params);

    });

    $('.et-button:not(.no-loader)').on('click', function() {
        $(this).addClass('loading');
    });


	// **********************************************************************//
	// ! Actions for expired support
	// **********************************************************************//

	if ( $( '#et_options-support_chat .switch-options .cb-disable' ).hasClass( 'selected' ) ) {
		//$( '#et_options-support_chat .description.field-desc' ).addClass( 'hidden' );
	}

	$( '#et_options-support_chat' ).on( 'click', '.cb-disable, .cb-enable', function() {
		if ( $(this).is( '.cb-disable' ) ){
			$( '[name="intercom-launcher-discovery-frame"]' ).css( 'display', 'none' );
			$( '[name="intercom-launcher-frame"]' ).css( 'display', 'none' );
		} else {
			$( '.et-support-error' ).remove();

			var $this = $(this);
            var mask = '<div class="mask"></div>';

            $( '#et_options-support_chat' ).append( mask );

			$.ajax({
                url: ajaxurl,
                method: "POST",
                data: {
                    'action': 'etheme_check_support',
                },
                success: function(data){
                    var data = JSON.parse( data );
                    if ( data['stop'] ) {
                    	$this.parents( 'tr' ).find( '.cb-enable.selected' ).removeClass( 'selected' );
                    	$this.parents( 'tr' ).find( '.cb-disable' ).addClass( 'selected' );
                    }
                    if ( data['enabled'] && ! data['stop'] ){
                     	$this.parents( 'tr' ).find( '.description.field-desc' ).html( data['enabled'] );
                    }
                    if ( data['succes'] && ! data['stop'] ){
                     	$this.parents( 'tr' ).find( '.description.field-desc' ).html( data['succes'] );
                    }
                    if ( data['errors'] ) {
                    	$.each(data['errors'], function( i, val ){
                            $( '#et_options-support_chat' ).append('<p class="et-support-error">ERROR: ' + val + '</p>');
                        });
                    }
                    if ( data['chat'] && ! data['errors'] && ! data['stop'] ) {
                    	et_enable_support( data['chat'] );
                    	$( '[name="intercom-launcher-discovery-frame"]' ).css( 'display', 'inline-block' );
                    	$( '[name="intercom-launcher-frame"]' ).css( 'display', 'inline-block' );
                    }
                },
                error: function(data){
                	$( '#et_options-support_chat' ).append('<p class="et-support-error">Ajax request error</p>');
                },
                complete: function() {
                	$( '#et_options-support_chat .mask' ).remove();
                }
            });

			$( '#et_options-support_chat .et-expired-support' ).removeClass( 'hidden' );
		}
	});


	function et_enable_support(data){
	  	window.intercomSettings = {
			app_id: 't84fcdk1',
			"buyer": data['buyer'],
			"support" : data['support'],
			"supported_until": data['support_time_left'],
			"support_time_left" : data['supported_until'],
			"theme": "Xstore"
		}

		$(document).ready(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/t84fcdk1';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}});

	}


	// **********************************************************************//
	// ! Theme deactivating action
	// **********************************************************************//

	$( '.et_theme-deactivator' ).on( 'click', function(event) {
		event.preventDefault();

		var confirmIt = confirm( 'Are you sure that you want to deactivate theme on this domain?' );
		if( ! confirmIt ) return;

		var data =  {
			'action':'etheme_deactivate_theme',
		};

		var redirect = window.location.href;

		jQuery.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: ajaxurl,
			data: data,
			success: function(data){
				console.log(data);
				var out = ''
				if ( data == 'deleted' ) {
					redirect = redirect.replace( '_options&tab=1', 'xstore_activation_page' );
					redirect = redirect.replace( '_options', 'xstore_activation_page' );
					window.location.href=redirect;
				} else {
					$.each( data, function( e, t ){
						$( '#redux-header' ).prepend( '<span class="et_deactivate-error">' + t + '</span>' );
					});
				}
			},
			error: function(data) {
				alert( 'Error while deactivating' );
			},
		});
	});

	// ! Set major-update message
	if (  $( '.et_major-version' ).length > 0 && $( 'body' ).is( '.themes-php' ) ) {
		$.each( $( '.themes .theme' ), function( i, t ) {
			if ( $(this).data( 'slug' ) == 'xstore'){
				$(this).find( '.update-message' ).append( '<p class="et_major-update">' + $( '.et_major-version' ).data( 'message' ) + '</p>' );
			}
		});

		// ! show it for multisites
		$.each( $( '.plugin-update-tr.active' ), function( i, t ) {
			if ( $(this).is( '#xstore-update' ) ){
				$(this).find( '.update-message' ).append( '<p class="et_major-update">' + $( '.et_major-version' ).data( 'message' ) + '</p>' );
			}
		});

	};

	// Functions for updating et_content in menu item 

	function et_update_item () {

		var items = $("ul#menu-to-edit li.menu-item");
		// Go through all items and display link & thumb
		for ( var i = 0; i < items.length; i++ ) {
			var id = $(items[i]).children("#nmi_item_id").val();

			var sibling   = $("#edit-menu-item-attr-title-"+id).parent().parent();
			var image_div = $("li#menu-item-"+id+" .nmi-current-image");
			var link_div  = $("li#menu-item-"+id+" .nmi-upload-link");
			var other_fields  = $("li#menu-item-"+id+" .nmi-other-fields");

			if ( image_div ) {
				sibling.after( image_div );
				image_div.show();
			}
			if ( link_div ) {
				sibling.after( link_div );
				link_div.show();
			}
			if ( other_fields ) {
				sibling.after( other_fields );
				other_fields.show();
			}

		}

		// Save item ID on click on a link
		$(".nmi-upload-link").click( function() {
			window.clicked_item_id = $(this).parent().parent().children("#nmi_item_id").val();
		} );

		// Display alert when not added as featured
		window.send_to_editor = function( html ) {
			alert(nmi_vars.alert);
			tb_remove();
		};
	}

	function ajax_update_item_content () {
		$.ajax({
		    url: window.location.href, 
		    success: function() {
		    	if ( $('.add-to-menu .spinner').hasClass('is-active') ) {
		    		ajax_update_item_content();
		    	}
		    	else {
		    		et_update_item();
		    	}
		    },
		});
		$('.et_item-popup').hide();
	};

	$('.submit-add-to-menu').click(function(){

		ajax_update_item_content();

	});

	// end et_content items

	var menu_id = $('#menu').val();

	// Visibility option
	$(document).on('change', '.field-item_visibility select', function(){
		var item = $(this).closest('.menu-item');
		var id = $(item).find('.menu-item-data-db-id').val();
		var el_vis = $(item).find('.field-item_visibility select').val();
		changed_settings = true;
		function et_refresh_item_visibility (id, el_vis) {
			if ( $('ul#menu-to-edit').find('input.menu-item-data-parent-id[value="'+id+'"]').length > 0 ) {
				var child = $('ul#menu-to-edit').find('input.menu-item-data-parent-id[value="'+id+'"]').closest('.menu-item');
				var select = child.find('.field-item_visibility select');
				var c_vis = select.val();
				if ( c_vis != el_vis ) {
					select.val(el_vis).change();
					var id = child.find('.menu-item-data-db-id').val();
					et_refresh_item_visibility(id, el_vis);
				}
			}
		}
		et_refresh_item_visibility(id, el_vis);
	});

	// Open options

	$(document).on( 'click', '.item-type', function(){
		var parent = $(this).closest('.menu-item');
		parent.prepend('<div class="popup-back"></div>');
		var menu_setgs = $(parent).find('.menu-item-settings');
		var children = $(parent).find('.et_item-popup');
		$(children).addClass('popup-opened');
		$('body').addClass('et_modal-opened');
		if (  $(parent).hasClass('menu-item-edit-inactive') ) {
			$(parent).removeClass('menu-item-edit-inactive').addClass('menu-item-edit-active');
		}
		$(menu_setgs).css('display', 'block');
		$(children).show();
	});

	// Single item
	$(document).on( 'click', '.et-saveItem, .popup-back', function() {
		if ( $('body').hasClass('et_modal-opened') ) {

			var el = $(this).closest('.menu-item');
			var children = el.find('.et_item-popup');
			
			if ( $(this).hasClass('et-close-modal') ) {
				if ( $(children).hasClass('popup-opened') ) {
					$(children).removeClass('popup-opened').hide();
					$('body').removeClass('et_modal-opened');
					el.find('.popup-back').remove();
				}
				return;
			}

			$(children).addClass('et-saving');

			var db_id = anchor = design = dis_titles = column_width = column_height = columns = icon_type = 
			icon = item_label = background_repeat = background_position = background_position = use_img = open_by_click = sublist_width = '';

			db_id = el.find('.menu-item-data-db-id').val();
			

			anchor = el.find('.field-anchor input').val();
			design = el.find('.field-design select option:selected').val();
			design2 = el.find('.field-design2 select option:selected').val();
			dis_titles = el.find('.field-disable_titles input:checked').val() ? 1 : 0;
			column_width = el.find('.field-column_width input').val();
			column_height = el.find('.field-column_height input').val();
			sublist_width = el.find('.field-sublist_width input').val();
			columns = el.find('.field-columns select option:selected').val();
			icon_type = el.find('.field-icon_type select option:selected').val();
			icon = el.find('.field-icon input').val();
			item_label = el.find('.field-label select option:selected').val();
			background_repeat = el.find('.field-background_repeat select option:selected').val();
			background_position = el.find('.field-background_position select option:selected').val();
			widget_area = ( el.hasClass('menu-item-depth-1') || el.hasClass('menu-item-depth-2')) ? el.find('.field-widget_area select option:selected').val() : '';
			static_block = el.find('.field-static_block select option:selected').val();
			use_img = el.find('.field-use_img select option:selected').val();
			// open_by_click = el.find('.field-open_by_click input:checked').val() ? 1 : 0;
			// visibility = el.find('.field-item_visibility select option:selected').val();

		 	item_menu = { db_id: db_id, anchor : anchor,  design : design, design2: design2, column_width : column_width,  column_height : column_height,  columns : columns, icon_type : icon_type, icon : icon,  
			item_label : item_label,  background_repeat : background_repeat,  background_position : background_position, widget_area : widget_area, static_block : static_block, use_img : use_img, sublist_width : sublist_width };

			$.ajax({
				url: ajaxurl,
				method: 'POST',
				dataType: 'json',
				data: {
					'action' : 'et_update_menu_ajax',
					's_meta' : 'item',
					'item_menu' : item_menu,
					'menu_id' : menu_id,
				},
				success: function (data) {
					if ( $(children).hasClass('popup-opened') ) {
						$(children).removeClass('et-saving').removeClass('popup-opened').hide();
						$('body').removeClass('et_modal-opened');
						el.find('.popup-back').remove();
					}
				},
			});
		}
	});

	// Remove item 
	$("a.item-delete").addClass('custom-remove-item');
	$("a.custom-remove-item").removeClass('item-delete');

	$(document).on('click', '.custom-remove-item', function(e) {
		e.preventDefault();
		button = $(this);
		delid = button.attr('id');
		var itemID = parseInt(button.attr('id').replace('delete-', ''), 10);
		button.addClass('item-delete');
		ajaxdelurl = button.attr('href');
		$.ajax({
			type: 'GET',
			url: ajaxdelurl,
			beforeSend: function(xhr){
				button.text('Removing...');
			},
			success: function(data){
				button.text('Remove');
				$("#"+delid).trigger("click");
			}
		});
		return false;
	});

	/****************************************************/
	/* Search for versions */
	/****************************************************/
	$( '.etheme-versions-search' ).on( 'keyup', function(e){
		var value = $(this).val();

		$( '.etheme-search .spinner' ).addClass( 'is-active' );
    	$( '.etheme-search .et-zoom' ).addClass( 'et-invisible' );

    	if ( value.length >= 2 ) {
	    	$( '.version-preview' ).removeClass( 'et-show' ).addClass( 'et-hide' );
    		$.each( $( '.version-preview' ), function(){
    			var text = $(this).text();
	    		if ( text.toLowerCase().includes(value.toLowerCase()) ) {
	    			$(this).removeClass( 'et-hide' ).addClass( 'et-show' );
	    		}
	    	} );
    	} else {
    		$( '.version-preview' ).removeClass( 'et-hide' ).removeClass( 'et-show' );
    	}

    	setTimeout(function() {
    		$( '.etheme-search .spinner' ).removeClass( 'is-active' );
			$( '.etheme-search .et-zoom' ).removeClass( 'et-invisible' );
    	}, 500);

	});

	/****************************************************/
	/* Import XML data */
	/****************************************************/

	var importSection = $('.etheme-import-section'),
		loading = false,
		additionalSection = importSection.find('.import-additional-pages'),
		pagePreview = additionalSection.find('img').first(),
		pagesSelect = additionalSection.find('select'),
		pagesPreviewBtn = additionalSection.find('.preview-page-button'),
		importPageBtn = additionalSection.find('.et-button');

	pagesSelect.change(function() {
		var url = $(this).data('url'),
			version = $(this).find(":selected").val(),
			previewUrl = $(this).find(":selected").data('preview');

		pagePreview.attr('src', url + version + '/screenshot.jpg');
		importPageBtn.data('version', version);
		pagesPreviewBtn.attr('href', previewUrl);
	}).trigger('select');

	importSection.on('click', '.button-import-version', function(e) {
		e.preventDefault();

		var version = $(this).data('version');

		importVersion(version);
	});

	var importVersion = function(version) {
		if( loading ) return false;

		if(!confirm('Are you sure you want to install demo data? (It will change all your theme configuration, menu etc.)')) {
			return false;
		}

		$('html, body').animate({scrollTop:100}, 600);

		loading = true;
		importSection.addClass('import-process');

		importSection.find('.import-results').remove();

		var data = {
			action:'etheme_import_ajax',
			version: version,
			pageid: 0
		};

		$.ajax({
			method: "POST",
			url: ajaxurl,
			data: data,
			success: function(data){
				importSection.prepend('<div class="import-results et-message et-success">' + data + '</div>');
				if( version == 'default' ) {
					importSection.removeClass('no-default-imported');
					importSection.find('.et-default-content-info').remove();
				}
				importSection.find('.version-preview-' + version).removeClass('not-imported').addClass('version-imported just-imported').find('.et-button').remove();
			},
			complete: function(){
				importSection.removeClass('import-process');
				loading = false;
			}
		});
	};

	/****************************************************/
	/* Load YouTybe videos use youtube/v3 api*/
	/****************************************************/
	GetYouTybe();
	$('.et-button.more-videos').on('click', function(e){
 		e.preventDefault();
	 	GetYouTybe();
	});

	// ! Get data from YouTybe
	function GetYouTybe(){
		// ! Do it only on support page
		if ( $( '.etheme-support' ).length < 1 ) {
			return;
		}

	    var nextPageToken = $('.et-button.more-videos').attr( 'next-page' );
	    $.get(
	        "https://www.googleapis.com/youtube/v3/playlistItems",{
		        part : 'snippet', 
		        maxResults : 6,
		        playlistId : 'PLMqMSqDgPNmCCyem_z9l2ZJ1owQUaFCE3',
		        order: 'date',
		        pageToken : nextPageToken,
	        	key: 'AIzaSyBNsAxteDRIwO1A6Ainv8u-_vVYcPPRYB8'
	        },
	        function(data){
              	ShowFrames(data);
	        }        
	    );  
	}

	// ! Insert frames to the page
	function ShowFrames(data){
	    var spinner = '<span class="spinner is-active">\
            <div class="et-loader ">\
                <svg class="loader-circular" viewBox="25 25 50 50">\
                <circle class="loader-path" cx="50" cy="50" r="12" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>\
                </svg>\
            </div>\
            </span>';

	    $('.et-button.more-videos').attr( 'next-page', data['nextPageToken'] );

	    $.each( data.items, function(k, v){
	      	var rand = Math.floor((Math.random() * 100) + 1);
	      	$( '.etheme-videos' ).append( '<div class="etheme-video text-center holder-'+ rand +'">' + spinner + '<iframe src="https://www.youtube.com/embed/' + v['snippet']['resourceId']['videoId'] + '" allowfullscreen></iframe></div>' );
	      	$('.holder-' + rand + ' iframe').load(function(){
				$( '.holder-' + rand + ' .spinner' ).removeClass('is-active');
			});
	     });

      	if ( data.pageInfo.totalResults == $( '.etheme-video' ).length ) {
  			$('.et-button.more-videos').remove();
  			return;
  		} 
	}
});