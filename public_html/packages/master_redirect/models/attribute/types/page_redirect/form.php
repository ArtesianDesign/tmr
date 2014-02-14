<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$ps = Loader::helper('form/page_selector');
$fh = Loader::helper('form');
$type = (is_null($value) || ctype_digit($value)) ? 'specific' : $value;
$pageid = (ctype_digit($value)) ? $value : 0;
?>
<div class="page-redirect">
	<?php echo $fh->select('redirect-type', $this->controller->types, $type); ?>
	<div class="selector">
		<?php echo $ps->selectPage($this->field('value'), $pageid); ?>
	</div>
	<script>
	$theValue = $('input[name="<?php echo $this->field("value"); ?>"]');
	</script>
</div>