<?php  defined('C5_EXECUTE') or die("Access Denied.");  

/*
Parent Area by John Liddiard (aka JohntheFish)
This is extensively based on the "Global Areas" addon by Mnkras
http://www.concrete5.org/marketplace/addons/global-areas/

This software is licensed under the terms described in the concrete5.org marketplace. 
Please find the add-on there for the latest license copy.
*/
$ps = Loader::helper('form/page_selector'); 

?>
<div id="parent_area_edit" class="ccm-ui">
	<div>
		<p>
			<?php 
				echo t('Select an area from a parent or other ancestor page to be inserted into the current page. When this page is viewed, if the ancestor page area does not exist or is empty, then nothing will be inserted.');
			?>
		</p>
	</div>



	<?php 
		$ancestor = $controller->ancestor;

		$tarHandle = $controller->tarHandle;
		$possible_areas = $controller->getPossibleAreas();		
		// some defaults for the area
		if (empty($tarHandle)){
			foreach (array('Main','main','Sidebar') as $default){
				if (in_array($default,$possible_areas)){
					$tarHandle = $default;
					break;
				}
			}
		}
				
		$form = Loader::helper('form');
		
		?><div><?php 
			// which ancestor
			echo $form->label('ancestor', t('Select an ancestor:'), array('style'=>'width:95%;text-align:left;')); 
		?><br><?php
			// echo $form->select('ancestor', 	
			// 					array(	-1 => t('Parent'),
			// 							-2 => t('Grand Parent'),
			// 							-3 => t('Great Grand Parent'),
			// 							-4 => t('Great Great Grand Parent')
			// 						),
			// 					$ancestor); 
			echo $ps->selectPage('ancestor', $ancestor);
		?></div>
		
		<div><?php 

			// area on ancestor
			echo $form->label('tarHandle', t('Pick an area:'), array('style'=>'width:95%;text-align:left;')); 
		?><br><?php 
			echo $form->select('tarHandle', $possible_areas, $tarHandle); 
		?></div><?php 
	?>
</div>
