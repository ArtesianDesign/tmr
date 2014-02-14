<?php defined('C5_EXECUTE') or die(_('Access Denied.'));
$ih = Loader::helper('image');
$token = rand();
$slides = array();
foreach ($images as $img) { 
	$file = File::getByID($img['fID']);
	$slide = new stdClass();
	$slide->large = $ih->getThumbnail($file, 1600, 1200, false);
	$slide->small = $ih->getThumbnail($file, 400, 9999, false);
	$slide->alt = $file->getTitle();
	$slides[] = $slide;
}
?>
<div class="panel">
	<ul id="slides-<?php echo $token; ?>" class="slides" data-token="<?php echo $token; ?>" data-timeout="<?php echo $duration * 1000; ?>" data-speed="<?php echo $fadeDuration * 1000; ?>">
		<?php foreach ($slides as $slide) { ?>
		<li class="slide">
			<a href="<?php echo $slide->large->src; ?>" rel="slide-<?php echo $token; ?>" title="<?php echo $slide->alt; ?>">
				<img src="<?php echo $slide->small->src; ?>" alt="<?php echo $slide->alt; ?>" />
			</a>
		</li>
		<?php } ?>
	</ul>
	<div class="slides-nav"></div>
</div>