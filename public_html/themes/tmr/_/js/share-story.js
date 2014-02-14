$(function(){

	var checkImageRights = (function(){
		var has_rights = $('#has-rights').is(':checked');
		$('#upload-thumbnail').toggle(has_rights);
	});

	$('#has-rights').click(function(){
		checkImageRights();
	});
	
});