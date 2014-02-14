<?php defined('C5_EXECUTE') or die('Access Denied.');
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$sd = Loader::helper('sitewide_data');
$parent = Page::getByID($this->controller->cParentID);
$parent_url = DIR_REL . $parent->getCollectionPath();
$parent_name = $parent->getCollectionName();
?>

<div class="ccm-page-list">
  <h3><a href="<?php echo $parent_url ?>"><?php echo $parent_name ?></a></h3>
	<?php  foreach ($pages as $page):

		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$author_name = $page->getAttribute('author_name');
		$author_email = $page->getAttribute('author_email');
		$description = $sd->scrapePageForSummary($page);
		$description = $controller->truncateSummaries ? $th->shorten($description, $controller->truncateChars) : $description;
		$description = $th->entities($description);
		$date = $page->getCollectionDateAdded('F j, Y'); ?>

		<h4 class="ccm-page-list-title">
			<a href="<?php  echo $url ?>" target="<?php  echo $target ?>"><?php  echo $title ?></a>
		</h4>
		<p class="ccm-page-list-description">
			<?php  echo $description ?>
		</p>
<!--
		<div class="author">
			<?php echo t('Submitted by'); ?> <a href="mailto:<?php echo $author_email; ?>"><?php echo $author_name; ?></a> on <?php echo $date; ?>
		</div>
-->
		
	<?php  endforeach; ?>
 
	<?php  if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
		  <hr/>
			<a href="<?php  echo $rssUrl ?>" target="_blank"><img src="<?php  echo $rssIconSrc ?>" width="14" height="14" alt="<?php  echo t('RSS Icon') ?>" title="<?php  echo t('RSS Feed') ?>" /></a>
		</div>
		<link href="<?php  echo BASE_URL.$rssUrl ?>" rel="alternate" type="application/rss+xml" title="<?php  echo $rssTitle; ?>" />
	<?php  endif; ?>
	
	<p><a href="<?php echo DIR_REL; ?>/stories">Read more stories  &raquo;</a></p>
	<p><a href="<?php echo DIR_REL; ?>/share-your-story">Submit your own memory</a> of Mt. Rubidoux</p>
</div><!-- end .ccm-page-list -->

<?php  if ($showPagination): ?>
	<div id="pagination">
		<div class="ccm-spacer"></div>
		<div class="ccm-pagination">
			<span class="ccm-page-left"><?php  echo $paginator->getPrevious('&laquo; ' . t('Previous')) ?></span>
			<?php  echo $paginator->getPages() ?>
			<span class="ccm-page-right"><?php  echo $paginator->getNext(t('Next') . ' &raquo;') ?></span>
		</div>
	</div>
<?php  endif; ?>