<?php 
/**
 * @package Helpers
 * @category Concrete
 * @author Andrew Embler <andrew@concrete5.org>
 * @copyright  Copyright (c) 2003-2008 Concrete5. (http://www.concrete5.org)
 * @license    http://www.concrete5.org/license/     MIT License
 */

/**
 * Helpful functions for working with navigating Concrete and other sites.
 * @package Helpers
 * @category Concrete
 * @author Andrew Embler <andrew@concrete5.org>
 * @copyright  Copyright (c) 2003-2008 Concrete5. (http://www.concrete5.org)
 * @license    http://www.concrete5.org/license/     MIT License
 */
 
defined('C5_EXECUTE') or die("Access Denied.");
class NavigationHelper extends Concrete5_Helper_Navigation {

	/**
	 * Retrieves a specific ancestor Page object (not including the home page) of any descendant Page object
	 * 
	 * @param object Page $cObj - Starting descendant Page object to check from
	 * @param integer $nth - The nth ancestor to retrieve starting from the descendant page. Omit to retrieve the highest ancestor
	 * @return object - Page object
	 */
	public function getCollectionAncestor($cObj, $nth = NULL){
		// We return null if passed argument is not a valid Page object, if we're on the home page, a system page, a master collection or the current highest ancestor
		if((!is_object($cObj) || !$cObj instanceof Page || $cObj->error) || $cObj->cID === HOME_CID || $cObj->isSystemPage() || $cObj->isMasterCollection()){
			return NULL;
		// We return our current Page object if we haven't requested any ancestors
		}elseif($nth === 0 || $cObj->cParentID == HOME_CID){
			return $cObj;
		// We return the parent Page object if we only want the immediate ancestor
		}elseif($nth === 1){
			return Page::getByID($cObj->getCollectionParentID());
		}
		// If we've made it this far we know our Page object is at least 3rd tier
		// so our breadcrumb array will have the home page and a 2nd tier Page object at minimum
		$arrTrail = array();
		$arrTrail = $this->getTrailToCollection($cObj);

		// Pop off the last Page object since it's the home page
		array_pop($arrTrail);
		
		// If we requested an ancestor that doesn't exist (or we didn't specify) we choose the highest ancestor Page object to return
		$intAncestors = count($arrTrail);
		$nth = (!is_integer($nth) || $nth < 0) || $nth >= $intAncestors ? $intAncestors : $nth;
		
		return $arrTrail[($nth - 1)];
	}
}