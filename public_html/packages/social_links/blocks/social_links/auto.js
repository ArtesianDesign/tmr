$(function(){
	$('.social-links .ccm-group-inner').click(function(e){
		e.preventDefault();
		var $item = $(this),
			value = (!$item.hasClass('selected')) ? $item.data('link-id') : ''
		$item.toggleClass('selected', Boolean(value));
		$item.find('input[type=hidden]').val(value);
	})
});