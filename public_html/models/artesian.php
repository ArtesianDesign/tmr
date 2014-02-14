<?php defined('C5_EXECUTE') or die('Access Denied.');

class Artesian {

	/**
	 * Function to load our view variables for single_pages
	 * @return Object View/layout data
	 */
	public function checkView($page, $ui){
		if ($page->getCollectionFilename()) {
			require_once(DIRNAME_CONTROLLERS . '/' . DIRNAME_PAGE_TYPES . '/default.php');
			$ptc = new DefaultPageTypeController();
			$cView = $ptc->setupView();
			$c = new Controller();
			$c->set('cView', $cView);
		}
	}

}