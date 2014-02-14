(function($){

	var updateRows = function(){
		$('td.sort input').each(function(){
			$(this).attr('value', $(this).closest('tr').index());
		});
	}

	$(function(){

		$('.links table tbody').sortable({
			handle: $('td.sort'),
			update: function() {
				updateRows();
			}
		});

		$('#links-table').submit(function(e){
			e.preventDefault();
			var $resp = $('.result');
			jqxhr = $.ajax({
				url: $(this).attr('action'),
				data: $(this).serialize(),
				success: function(data){
					$resp.html(data);
					setTimeout(function(){
						$resp.fadeOut();
					},4000);
				}
			});
			$img = $('<img>').attr('src',CCM_IMAGE_PATH+'/throbber_white_16.gif');
			$resp.html($img).show();
		});

		$('td.remove a').click(function(e){
			e.preventDefault();
			if (confirm('Are you sure you wish to delete this?')) {
				var $resp = $('.result'),
					$row = $(this).closest('tr');
				jqxhr = $.ajax({
					url: $(this).attr('href'),
					data: 'lID='+$(this).attr('data-link-id'),
					success: function(data){
						$resp.html(data);
						$row.fadeOut(function(){
							$(this).remove();
						});
						setTimeout(function(){
							$resp.fadeOut();
						},4000);
					}
				});
			}
		});

	});

})(jQuery);