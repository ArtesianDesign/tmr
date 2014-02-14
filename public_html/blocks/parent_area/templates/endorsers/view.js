$(function(){
	if (!CCM_EDIT_MODE && !window.location.href.match(/stack/)) {
		var $list = $('.parent-area.endorsers ul');
		if ($list.find('li').length > 4) {
			$list.totemticker({
				next: null,
				previous: null,
				stop: null,
				start: null,
				row_height: '23px',
				speed: 1500,
				interval: 1500,
				max_items: null,
				mousestop: true,
				direction: 'down'		
			});
		} else {
			$list.height('auto');
		}
	}
});