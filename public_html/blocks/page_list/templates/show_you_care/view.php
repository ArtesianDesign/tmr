<?php defined('C5_EXECUTE') or die(_('Access Denied.'));
$colors = array('blue', 'rust', 'teal', 'yellow');
$th = Loader::helper('text');
?>
<div class="steps">
	<h2>Show You Care</h2>
	<ul class="step-list">

	<?php foreach ($pages as $i => $page) {

		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$description = $page->getCollectionDescription();
		$description = $controller->truncateSummaries ? $th->shorten($description, $controller->truncateChars) : $description;
		$description = $th->entities($description);	
		$subtitle = $page->getAttribute('sub_title');
		$modal = ($page->getAttribute('open_in_modal'));

		?>
		<li class="step-item">
			<img class="background color" src="<?php echo $this->getThemePath(); ?>/_/img/bg-step-flag-background-<?php echo $colors[$i]; ?>.png" />
			<img class="background outline" src="<?php echo $this->getThemePath(); ?>/_/img/bg-step-flag-outline.png" />
			<span class="number">
				<img class="background" src="<?php echo $this->getThemePath(); ?>/_/img/bg-step-number.png" />
				<?php echo $i+1; ?>
			</span>
			<span class="title">
				<a <?php if ($modal) { ?>class="modal" <?php } ?>href="<?php echo $url; ?>"><?php echo $title; ?></a>
			</span>
			<span class="subtitle"><?php echo $subtitle; ?></span>
		</li>

	<?php } ?>
	</ul>
</div>
