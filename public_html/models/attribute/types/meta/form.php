<?php defined('C5_EXECUTE') or die('Access Denied.');
$fh = Loader::helper('form');
?>
<div class="meta-attribute">
	<table id="meta-<?php echo $akID; ?>" class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="key"><?php echo t('Key'); ?></th>
				<th class="value"><?php echo t('Value'); ?></th>
			</tr>
		</thead>
		<?php if (0) { ?>
		<tfoot>
			<tr>
				<td colspan="2">
					<button class="add-state btn btn-small" type="button"><?php echo t('Add Another Value'); ?></button>
				</td>
			</tr>
		</tfoot>
		<?php } else { ?>
		<tfoot>
			<tr class="input">
				<td class="key">
					<input id="key" type="text" name="key" class="span1" placeholder="Key" value="" />
				</td>
				<td class="value">
					<input id="value" type="text" name="value" class="span1" placeholder="Value" value="" />
				</td>
				<td class="edit">
					<button id="meta-add" type="button" class="btn btn-primary btn-small">
						<?php echo t('Add'); ?>
					</button>
				</td>
			</tr>
		</tfoot>
		<?php } ?>
		<tbody>
			<?php if (is_array($data)) { foreach($data as $pos => $meta) { ?>
			<tr class="data">
				<td class="key">
					<?php //echo $meta['key']; ?>
					<input type="text" class="kID" name="meta[<?php $pos ?>][kID]" value="<?php echo $meta['key']; ?>" />
				</td>
				<td class="value">
					<?php //echo $meta['value']; ?>
					<input type="text" class="vID" name="meta[<?php $pos; ?>][vID]" value="<?php echo $meta['value']; ?>" />
				</td>
				<td class="edit">
					<span class="pos">
						<input type="hidden" class="pos" name="meta[<?php $pos; ?>][pos]" />
					</span>
					<a href="#" class="close">x</a>
				</td>
			</tr>
			<?php } } else { // if we have no data ?>
			<tr class="empty">
				<td colspan="2">
					<?php echo t('No data found.') ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php //echo $fh->hidden($this->field('value'), htmlspecialchars($data)); ?>
	<script>
	var keyList = <?php echo json_encode($keys); ?>;
	var reindex = function(){
		$('#meta-<?php echo $akID; ?>').find('tr.data').each(function(i, val){
			var $row = $(this);
			var index = i;
			$.each(['key','value','pos'], function(j, className){
				var name = 'meta['+index+']['+className+']';
				var $input = $row.find('.'+className+' input').attr('name', name);
				if (className === 'pos') {
					$input.attr('value', index);
				}
			});
		});
	};

	var initSortable = function(destroy){
		var $cont = $('#meta-<?php echo $akID; ?>');
		if (destroy) { $cont.sortable('destroy'); }
		$cont.sortable({
			items: $('tr.data'),
			update: function() {
				reindex();
			}
		});
		reindex();
	}

	$(function(){

		$('#meta-<?php echo $akID; ?>').
			on('click', 'td.edit .close', function(e){
				e.preventDefault();
				if (confirm('Are you sure you wish to remove this data?')) {
					$(this).closest('tr').remove();
					reindex();
				}
			}).
			on('click', '#meta-add', function(e){
				e.preventDefault();
				var $keyInput = $('#key'), $valueInput = $('#value'), $table = $('#meta-<?php echo $akID; ?>');
				var kVal = $keyInput.val(), vVal = $valueInput.val();
				if (kVal === '' || vVal === '') {
					alert('Please enter both key and value data.');
					return;
				}
				var $row = $('<tr/>').addClass('data');
				var $key = $('<td/>').addClass('key');//.html(kVal);
					$key.append('<input type="text" class="kID" name="" value="'+kVal.replace(/"/g, '&quot;')+'" />');
				var $value = $('<td/>').addClass('value');//.html(vVal);
					$value.append('<input type="text" class="vID" name="" value="'+vVal.replace(/"/g, '&quot;')+'" />');
				var $remove = $('<td/>').addClass('edit').html('<span class="pos"><input type="hidden" name="" value=""/></span><a href="#" class="close">x</a>');

				$row.
					append($key).
					append($value).
					append($remove).
					appendTo($table);

				$valueInput.val(''); $keyInput.val('').focus();

				initSortable('destroy');
			}).
			on('keyup', '#value', function(e){
				if(e.keyCode == 13){
					$('#meta-add').click();
				}
			});

			<?php if (count($keys)) { ?>
			$('#key').autocomplete({
				source: <?php echo json_encode(array_filter($keys)); ?>
			});
			<?php } ?>

		initSortable();

	});
	</script>
</div> 