<?php  defined('C5_EXECUTE') or die('Access Denied.');
//$targetCID = $controller->getAncestorID($ancestor);
$targetCID = $ancestor;
$target = Page::getByID($targetCID);
$c = Page::getCurrentPage();
?>
<div id="parent-area-<?php echo $bID; ?>" class="parent-area endorsers panel">
<h3>Endorsers</h3>
	<?php if ($c->isEditMode()) { ?>
	<div class="ccm-edit-mode-disabled-item">
		<div style="padding:8px 0px;">
			<?php  
			echo t("Currently pulling blocks from ancsetor area \"%s\" on the page \"%s\".<br/>To edit the blocks please go to that page.", $tarHandle, $target->getCollectionName());
			?>
		</div>
	</div>
	<?php } ?>
	<?php if ($c->isEditMode() && $controller->getNumberOfBlocks($targetCID, $tarHandle) == 0) { ?>
	<div class="ccm-edit-mode-disabled-item">
		<div style="padding:8px 0px;">
			<?php echo t("This area is empty!"); ?>
		</div>
	</div>
	<?php } ?>

	<?php
	$rt = Loader::helper('jl_parent_area_recursion_trap','jl_parent_area');
	// Report on possible recursion
	if ($rt -> check_trap()){
		throw new Exception (t("Error: maximum Parent Area count of \"%s\" exceededs limit of \"%s\". Have you created a recursive chain of ancestors and/or stacks and/or global areas?", $this -> get_count(), $rt -> get_limit() ));

	//make sure the page isn't the same as the area that we are going to show
	} else if ($c->getCollectionID() != $targetCID && $controller->getNumberOfBlocks($targetCID, $tarHandle) > 0) {

		$a = new Area($tarHandle);
		$a->disableControls();
		$a->display($target);
		?>
		<a href="<?php echo Loader::helper('navigation')->getLinkToCollection($target); ?>">
			<?php echo t('See all endorsers'); ?> &raquo;
		</a>
	<?php //otherwise, if its editmode show a nice message
	} else if($c->isEditMode()) { ?>
		<div class="ccm-edit-mode-disabled-item">
			<div style="padding:8px 0px;">
				<?php  
				echo t("You cannot use an area on the same page!");
				?>
			</div>
		</div>
		<?php 
	} ?>
</div>