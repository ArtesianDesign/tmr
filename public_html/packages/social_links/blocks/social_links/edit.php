<?php defined('C5_EXECUTE') or die(_('Access Denied.')); ?>
<style>
.ccm-group-inner {

}
.ccm-group-inner.selected  {
	background: url(<?php echo BASE_URL . DIR_REL . ASSETS_URL_IMAGES; ?>/icons/success.png);
}
</style>
<div class="ccm-ui social-links">

	<h4><?php echo t('Title'); ?></h4>
	<div>
		<?php echo Loader::helper('form')->text('title', $title); ?>
		<p class="help-block">
			<?php echo t('This field is optional.'); ?>
		</p>
	</div>
	<hr/>
	<h4><?php echo t('Choose Links(s)'); ?></h4>
	<?php
	foreach ($allLinks as $link) {
		$isActive = (in_array($link, $links)) ? $link['lID'] : null;
		?>
		<div class="ccm-group">
			<a class="ccm-group-inner<?php echo ($isActive) ? ' selected' : ''; ?>" href="#" title="<?php echo $link['name']; ?>" data-link-id="<?php echo $link['lID']; ?>">
				<?php echo $link['name']; ?>
				<input type="hidden" name="lID[]" value="<?php echo $isActive; ?>"/>
			</a>
		</div>
	<?php } ?>

	<div class="clearfix"></div>

</div>