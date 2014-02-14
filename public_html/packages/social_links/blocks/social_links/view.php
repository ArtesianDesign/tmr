<?php defined('C5_EXECUTE') or die(_('Access Denied.')); ?>
<?php if (isset($title)) {?>
<p class="help-block">
	<?php echo $title; ?>
</p>
<?php } ?>
<ul>
	<?php foreach ($links as $i => $link) { ?>
	<li class="icon <?php echo $link['handle']; ?>">
		<a class="social-link <?php echo $link['handle']; ?><?php if(!$i) { ?> first<?php } ?>" target="_blank" href="<?php echo $link['url']; ?>">
			<span><?php echo $link['name']; ?></span>
		</a>
	</li>
	<?php } ?>
</ul>
