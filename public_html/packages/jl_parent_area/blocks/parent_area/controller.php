<?php  defined('C5_EXECUTE') or die("Access Denied.");

/*
Parent Area by John Liddiard (aka JohntheFish)
This is extensively based on the "Global Areas" addon by Mnkras
http://www.concrete5.org/marketplace/addons/global-areas/

This software is licensed under the terms described in the concrete5.org marketplace. 
Please find the add-on there for the latest license copy.
*/
 
class ParentAreaBlockController extends BlockController {

	protected $btTable = 'btParentArea';
	protected $btInterfaceWidth = "300";
	protected $btInterfaceHeight = "250";
	
	protected $btCacheBlockOutput = false;
	protected $btCacheBlockOutputOnPost = false;
	protected $btCacheBlockOutputForRegisteredUsers = false;
	
	public function getBlockTypeName() {
         return t('Parent Area');
	}

	public function getBlockTypeDescription() {
		return t('Pull areas from parent page or other ancestors into the page.');
	}
	
	
	public function save($args) {
		parent::save($args);
	}
	
	/*
	This is the clever bit from Mnkras' Global Areas block.
	Changed to deliver headers based on an ancestor to the current page
	*/	 
	public function outputAutoHeaderItems(){ 
	
		// try and trap recursion loops created by users
		$rt = Loader::helper('jl_parent_area_recursion_trap','jl_parent_area');
		if ($rt -> check_trap()){
			return;
		}
	
		//$page = Page::getByID($this->getAncestorID($this->ancestor));
		$page = Page::getByID($this->ancestor);
		$area = new Area($this->tarHandle);
		$blocks = $area->getAreaBlocksArray($page);

		if (is_array($blocks)) {
			
			// grab this block's header items
			$b = $this->getBlockObject();
			$bvt = new BlockViewTemplate($b);
			$headers = $bvt->getTemplateHeaderItems();

			// grab child blocks' header items and merge together
			foreach($blocks as $block){
				$controller = $block->getInstance();
				if($controller instanceof BlockController && method_exists($controller, 'on_page_view')) {
					$controller->on_page_view();
				}
				
				$bvt = new BlockViewTemplate($block);
				$headers = array_merge($headers,$bvt->getTemplateHeaderItems());
			}
	
			// add all of the header items
			if (count($headers) > 0){ 
				foreach($headers as $h){ 
					$this->addHeaderItem($h); 
				}
			} 
		}
	}
	
	/*
	This is also from Global Areas.
	Changed to take cID and target area as parameters
	*/	 
	public function getNumberOfBlocks($tcID,$tah) {
		// make sure we don't ask for an area that doesn't exists because that could create the area!!
		if (in_array($tah, $this->getAreasForId($tcID))){
			$page = Page::getByID($tcID);
			$area = new Area($tah);
			$blocks = $area->getAreaBlocksArray($page);
			return count($blocks);
		}
		return 0;
	}

	/*
	Loop back through -X ancestors. Stop at the highest ancestor.
	Always return a valid ancestor (even if it is the home page)
	*/
	public function getAncestorID($ancestor) {
		$ac = Page::getCurrentPage();
		$acid = $ac->getCollectionID();
		$max_loop = 10;
		while ($max_loop && $ancestor <0 && $ac->getCollectionParentID()){
			$max_loop --;
			$acid = $ac->getCollectionParentID();
			if(empty($acid)){
				break;
			}
			$ancestor ++;
			$ac = Page::getByID($acid);
		}
		return $acid;
	}

	/*
	Make the possible areas a compedium of area names from all ancestors.
	This list can't be relied upon because the ancestors change depending
	on where a stacked Parent Area block is rendered.
	
	This is not the most efficient way of doing it, but this is used in an edit dialog,
	so will not impact on overall site efficiency.	
	*/
	public function getPossibleAreas(){
		$areas = array();
		
		/*
		Special case if current page is a stack
		Another special caser if version < 5.6. In 5.6 the stack model appears to be globally loaded.
		*/
		if(version_compare(Config::get('SITE_APP_VERSION'), 5.6, 'lt')) {
			Loader::model('stack');
		}
		if (Stack::getByID(Page::getCurrentPage()->getCollectionID())){
			$areas = $this->getAllAreaHandles();
		
		// Any old page, so get relevant ancestor areas
		} else {
			$areas = 	array_unique (
							array_merge($this->getAreasForId($this->getAncestorID(-1)),
										$this->getAreasForId($this->getAncestorID(-2)),
										$this->getAreasForId($this->getAncestorID(-3)),
										$this->getAreasForId($this->getAncestorID(-4))
										)
									);
		}
		sort($areas);
		return array_combine(array_values($areas),array_values($areas));
	}

	/* 
	Code taken from the tool in Global Areas, changed to use GetArray
	and to have defaults, not that the defaults shold ever be needed.
	*/
	private function getAreasForId($cID){
		$areas = array();	
		if ($cID){
			$db = Loader::db();
			foreach( $db->GetArray('SELECT DISTINCT arHandle FROM Areas WHERE cID = ?', array($cID)) as $row){
				$areas[] = $row['arHandle'];
			}
		}
		return $areas;
	}
	
	/*
	Used in case of no areas being found above, such as in a stack
	*/
	private function getAllAreaHandles(){
		$areas = array();	
		$db = Loader::db();		
		foreach( $db->GetArray('SELECT DISTINCT arHandle FROM Areas') as $row){
			$areas[] = $row['arHandle'];
		}
		return $areas;
	}
	


}