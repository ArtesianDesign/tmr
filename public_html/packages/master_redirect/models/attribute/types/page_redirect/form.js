$.fn.checkSelect = function(){
	$(this).closest('.page-redirect').find('.selector').toggle(Boolean($(this).find(':selected').val() == 'specific'));
	return this;
};

$(function(){
	$('#redirect-type').change(function(){
		var theType = $(this).find(':selected').val();
		if (theType !== 'specific') {
			$theValue.val(theType);
		}
		$(this).checkSelect();
	}).checkSelect();
});