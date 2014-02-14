<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$fh = Loader::helper('form');
$data = $this->controller->getValue();
$regions = json_decode($data);

$states = array_keys($list);
array_unshift($states, 'Please choose a state..');
foreach ($list as $state => &$counties) {
	$catchall = ($state == 'All' || $catchall);
	array_unshift($counties, 'All Counties');
}
?>

<div class="region-selector">
	<table id="region-<?php echo $akID; ?>" class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="state"><?php echo t('State'); ?></th>
				<th class="county"><?php echo t('County'); ?></th>
				<th class="remove"><?php echo t('Remove'); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					<button class="add-state btn btn-small" type="button"><?php echo t('Add Another State'); ?></button>
					<button class="toggle-catchall btn btn-small btn-warning pull-right" type="button" data-toggle="button" data-active-text="<?php echo t('This represenative is a catch-all.'); ?>"><?php echo t('Make This Representative A Catch-All'); ?></button>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (is_array($regions)) { foreach($regions as $region) { if ($region->state != 'All') { ?>
			<tr>
				<td class="region-state">
					<select name="states" class="ccm-input-select">
						<?php foreach ($states as $i => $state) { ?>
						<option value="<?php echo (!$i) ? $i : $state; ?>"<?php if ($state == $region->state) { ?> selected="selected"<?php } ?>>
							<?php echo $state; ?>
						</option>
						<?php } ?>
					</select>
				</td>
				<td class="region-county">
					<select name="counties" class="ccm-input-select" multiple="multiple">
						<?php foreach ($list[$region->state] as $county) { ?>
						<option value="<?php echo $county ;?>"<?php if (in_array($county, $region->counties)) { ?> selected="selected"<?php } ?>>
							<?php echo $county; ?>
						</option>
						<?php } ?>
					</select>
				</td>
				<td class="remove"><a href="#" class="close">x</a></td>
			</tr>
			<?php } } } else { // end if region != all; end foreach region; if isarray regions ?>
			<tr>
				<td class="region-state">
					<select name="states" class="ccm-input-select">
						<?php foreach ($states as $i => $state) { ?>
						<option value="<?php echo (!$i) ? $i : $state; ?>">
							<?php echo $state; ?>
						</option>
						<?php } ?>
					</select>
				</td>
				<td class="region-county"></td>
				<td class="remove"><a href="#" class="close">x</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php echo $fh->hidden($this->field('value'), htmlspecialchars($data)); ?>
	<script>
	var regionList = <?php echo json_encode($list); ?>;

	var updateValue = function(){
		var $table = $('#region-<?php echo $akID; ?>'),
			$eles = $table.find('tbody').add($table.find('.add-state')),
			data = [],
			value = '';

		if($table.find('.toggle-catchall').hasClass('active')) {
			data.push({state: 'All', counties: ['All Counties'] });
		}

		$table.find('tbody tr').each(function(i, val){
			if ($(this).find('.region-state select').val() !== 0) {
				data.push({
					state: $(this).find('.region-state select').val(), 
					counties: $(this).find('.region-county select').val()
				});
			}
		});
		value = JSON.stringify(data);

		console.log(value);
		$('input[name="<?php echo $this->field("value"); ?>"]').val(value);
	};

	$(function(){

		$('#region-<?php echo $akID; ?>').
			on('change', '.region-state select', function(){
				updateValue();
				var $states = $(this),
					state = $states.val(),
					existCheck = false;

				$('.region-state select').not($states).find('option:selected').each(function(){
					if ($(this).val() === state) {
						existCheck = true;
					}
				});

				if (existCheck) {
					alert('That state has been chosen already.');
					$states.find('option:selected').attr('selected', '');
					$states.find('option:eq(' + $states.data('previous-value') + ')').attr('selected', 'selected');
					return false;
				}

				if (typeof regionList[state] !== 'undefined') {
					var $counties = $('<select/>').attr({
						'multiple': 'multiple',
						'id': 'county',
						'name': 'county'
					}).addClass('ccm-input-select');
					$.each(regionList[state], function(i, val){
						$('<option/>').attr('value', val).html(val).appendTo($counties);
					});
					$states.parent().siblings('.region-county').html($counties);
				}
			}).
			on('change', '.region-county select', function(){
				updateValue();
			}).
			on('click', 'td.remove .close', function(e){
				e.preventDefault();
				if ($('td.remove .close').length > 1 && confirm('Are you sure you wish to remove this region?')) {
					$(this).closest('tr').remove();
					updateValue();
				}
			}).
			on('click', '.toggle-catchall', function(){
				$(this).toggleClass('active');
				updateValue();
			}).
			on('click', '.add-state', function(e){
				e.preventDefault();
				var $table = $('#region-<?php echo $akID; ?>');
				var $row = $table.find('tbody tr').first().clone(true);
				$row.find('.region-state select option:selected').attr('selected', '');
				$row.find('.region-county select').remove();
				$row.appendTo($table);
			});

		<?php if ($catchall) { ?>$('#region-<?php echo $akID; ?>').find('.toggle-catchall').click();<?php } ?>

	});
	</script>
</div> 