<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php

$aBlocks = $controller->generateNav();
$c = Page::getCurrentPage();
$nh = Loader::helper('navigation');
$i = 0;
$found = false;

if (count($aBlocks) > 0) {

	?><ul id="breadcrumbs"><?php

	foreach($aBlocks as $ni) {

		$_c = $ni->getCollectionObject();

		$pageLink = false;

		$target = $ni->getTarget();
		$target = ($target != '') ? 'target="' . $target . '"' : $target;
		
		if ($_c->getCollectionAttributeValue('replace_link_with_first_in_nav')) {
			$subPage = $_c->getFirstChild();
			if ($subPage instanceof Page) {
				$pageLink = $nh->getLinkToCollection($subPage);
			}
		}
		
		$pageLink = (!$pageLink) ? $ni->getURL() : $pageLink;

		$name = $ni->getName();

		?><li><?php
		if ($c->getCollectionID() == $_c->getCollectionID()) { 
			echo('<span class="current">' . $name . '</span>');
		} else {
			echo('<a href="' . $pageLink . '" ' . $target . '>' . $name . '</a>&nbsp;|&nbsp;');
		}	
		?></li><?php

		$lastLevel = $thisLevel;
		$i++;

	}

	?></ul><?php

}

$thisLevel = 0;