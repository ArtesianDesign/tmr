<?php       defined('C5_EXECUTE') or die(_("Access Denied."));?>
<?php    
	$h = Loader::helper('concrete/interface');
	$pageSelector = Loader::helper('form/page_selector');
	Loader::model("collection_types");
?>

<?php    

echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Add Multiple Pages'), false, 'span8 offset2', false);

?>
<style>
.ccm-summary-selected-item{background:#fff;}
</style>
<form method="post" id="sitemap-add-multi-page" action="<?php   echo $this->url('/dashboard/sitemap/jeramy_add_multi_page', 'save_pages')?>">
    
<div class="ccm-pane-body">

	<div class="well">
	<label class="control-label"  for="parent-page"><strong><?php  echo t('Select the Parent Page')?></strong></label>
    <?php      print $pageSelector->selectPage('parent-page','ccm_selectSitemapNode');   ?> 
	<span class="help-block"><?php    echo t('Pages will be added as children of this page')?></span>
    </div> 

	<div class="well">
 	<label class="control-label"  for="ctID"><strong><?php  echo t('Page Type')?></strong></label>       
	<?php  $ctArray = CollectionType::getList();
	
	if (is_array($ctArray)) { ?>
	  		<select name="ctID" id="selectCTID">
			<?php       foreach ($ctArray as $ct) { ?>
				<option <?php     if ($ctID == $ct->getCollectionTypeID()) echo 'selected '  ?>value="<?php      echo $ct->getCollectionTypeID()?>" >
						<?php      echo $ct->getCollectionTypeName()?>
				</option>
			<?php       } ?>
	  		</select>
	<?php       } ?>
    </div>

	<div class="well">
    <label class="control-label"  for="pagesToAdd"><strong><?php  echo t('Enter page names separated by carriage return (Enter)')?></strong></label>     
    <?php    echo $form->textarea('pagesToAdd', $pagesToAdd, array('style' => 'width: 98%; height: 250px','class'=>'controls'))?>
    </div>
    
	<div class="well">
    <label class="control-label"  for="description"><strong><?php  echo t('Description')?></strong></label>   
    <?php    echo $form->textarea('description', $description, array('style' => 'width: 98%; height: 100px','class'=>'controls'))?>
    <span class="help-block"><?php    echo t('Will be added to all pages above')?></span>
    </div>

	<div class="well">
    <label class="control-label"  for="header_extra_content"><strong><?php  echo t('Header Extra Content')?></strong></label>  
    <?php    echo $form->textarea('header_extra_content', $header_extra_content, array('style' => 'width: 98%; height: 100px','class'=>'controls'))?>
    <span class="help-block"><?php    echo t('Will be added to all pages above')?></span> 
    </div>
    
    <div class="well">
    <label class="control-label"  for="metaDescription"><strong><?php  echo t('Meta Description')?></strong></label>         
    <?php    echo $form->textarea('metaDescription', $metaDescription, array('style' => 'width: 98%; height: 100px','class'=>'controls'))?>
    <span class="help-block"><?php    echo t('Will be added to all pages above')?></span>
    </div>
    
    <div class="well">
    <label class="control-label"  for="metaKeywords"><strong><?php  echo t('Meta Keywords')?></strong></label>          
    <?php    echo $form->textarea('metaKeywords', $metaKeywords, array('style' => 'width: 98%; height: 100px','class'=>'controls'))?>
    <span class="help-block"><?php    echo t('Will be added to all pages above')?></span>
    </div>
        
	<div class="well">
    <ul class="inputs-list">
        <li>
            <label class="control-label" >
            	<input type="checkbox" name="exclude_nav" value="1" <?php     if ($exclude_nav) echo 'checked '; ?>/>
            	<span><?php       echo t('Exclude pages from navigation')?></span>
            </label>
        </li>
        <li>
            <label class="control-label" >
            	<input type="checkbox" name="exclude_page_list" value="1" <?php     if ($exclude_page_list) echo 'checked '; ?>/>
            	<span><?php       echo t('Exclude pages from page list')?></span>
            </label>
        </li>
        <li>
            <label class="control-label" >
            	<input type="checkbox" name="exclude_search_index" value="1" <?php     if ($exclude_search_index) echo 'checked '; ?>/>
            	<span><?php       echo t('Exclude pages from search index')?></span>
            </label>
        </li>
        <li>
            <label class="control-label" >
            	<input type="checkbox" name="exclude_sitemapxml" value="1" <?php     if ($exclude_sitemapxml) echo 'checked '; ?>/>
            	<span><?php       echo t('Exclude pages from sitemap.xml')?></span>
            </label>
        </li>
    </ul>
    </div>
   
	
</div>

<div class="ccm-pane-footer">
<?php     
print $h->submit(t('Add Pages'), 'sitemap-add-multi-page', 'right', 'primary');
print $h->button(t('Cancel'), $this->url('/dashboard/sitemap/jeramy_add_multi_page/'), 'left');
?>
</div>


</form>

<?php    echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);?>

