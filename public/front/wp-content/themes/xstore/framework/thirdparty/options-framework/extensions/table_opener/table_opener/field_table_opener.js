/* global confirm, redux, redux_change */

jQuery(function($){ 
	var modal_wrapper = $('.et-close-modal').closest('.et-modal-wrapper');

	$('.et-modal-button').click (function(){
		var container_id = $(this).data('id');
		var modal = $('body').find('#'+container_id+'');
		modal.addClass('modal-opened').removeClass('modal-closed');
		$('body').addClass('full-modal-opened');
	});
	$('.et-close-modal').click(function(){
		modal_wrapper.removeClass('modal-opened').addClass('modal-closed');
		setTimeout( function (){
			$('body').removeClass('full-modal-opened');
		}, 300);
	});

	$('.modal_save-changes').click(function(e){
		var modal = $(this).closest('.et-modal-wrapper');
		modal.addClass('loading');
		$('#redux_save').trigger('click');
		e.preventDefault();
		setTimeout(function(){
			modal.removeClass('loading');
		}, 700);
	});

});