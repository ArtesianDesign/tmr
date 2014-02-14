<?php defined('C5_EXECUTE') or die("Access Denied.");

$nh = Loader::helper('navigation');
$th = Loader::helper('text');
$ih = Loader::helper('image');

// some settings
$height = 178;
$width = 178;
$crop = false;

$navItems = $controller->getNavItems();
if (count($navItems) == 0) { return; }

$curLevel = 0;
$parent = Page::getByID($this->controller->cParentID);
?>

<h3><?php echo $parent->getCollectionName(); ?></h3>
<ul class="thumbnail-grid thumbnail-grid-four thumbnail-grid-two-level clearfix">

	<?php foreach ($navItems as $i => $ni):

		// Prepare data for each page being listed...
		$page = $ni->cObj;
		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;

		$img = SitewideDataHelper::getPageThumbnail($page, 'product', array('product_isolated'));
		$thumb = $ih->getThumbnail($img, $width, $height, $crop);
		if ($thumb->height != $height || $thumb->width != $width) {
			$thumb->margin  = 'margin:';
			$thumb->margin .= ($thumb->height < $height) ? ($height - $thumb->height) / 2 . 'px ' : '0 ';
			$thumb->margin .= ($thumb->width < $width) ? ($width - $thumb->width) / 2 . 'px;' : '0;';
		}
		$current = ($page->getCollectionID() == $cID) ? ' class="current"' : '';
		?>

		<?php if ($page->getCollectionTypeHandle() == 'category') { ?>
			</ul>
			<h3><?php echo $title; ?></h3>
			<ul class="thumbnail-grid thumbnail-grid-four thumbnail-grid-two-level clearfix">
		<? } else { ?>
		<li<?php echo $current; ?>>
			<?php if ($showLinks) { ?><a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php } ?>
				<span class="thumb">
					<img src="<?php echo $thumb->src; ?>" alt="<?php echo $title; ?>" <?php if ($thumb->margin) { ?>style="<?php echo $thumb->margin; ?>"<?php } ?>/>
					<?php if ($img->source) { ?><span class="overlay <?php echo $img->source; ?>"></span><?php } ?>
				</span>
				<h3><?php  echo $title ?></h3>
			<?php if ($showLinks) { ?></a><?php } ?>
		</li>
		<?php } //end else ?>
		
		
	<?php endforeach; ?>
 
</ul>
