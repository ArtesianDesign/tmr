<?php defined('C5_EXECUTE') or die(_('Access Denied.'));
$token = rand();
?>
<ul id="slides-<?php echo $token; ?>" class="slides" data-token="<?php echo $token; ?>" data-timeout="7000" data-speed="1200" data-pager="false" data-nav="false" data-controls="false">
	<?php foreach ($images as $image) { ?>
	<li class="slide">
		<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['fileName']; ?>" />
	</li>
	<?php } ?>
</ul>