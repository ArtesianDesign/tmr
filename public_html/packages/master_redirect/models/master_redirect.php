<?php  defined('C5_EXECUTE') or die("Access Denied.");

/**
 * Class that is used to redirect based on a page attribute
 * @package Master Redirect
 * @author From the collective works of Michael Krasnow <mnkras@gmail.com>
 * @category Packages
 * @copyright  Copyright (c) 2012 Michael Krasnow. (http://www.mnkras.com)
 * @copyright  Copyright (c) 2012 Andrew Householder. (http://www.aghouseh.com)
 *
 * Modified to allow for custom types, not just specific page IDs by
 * Andrew Householder <andrew@artesiandesigninc.com>
 */

class MasterRedirect {

	/**
	 * Fired by the on_page_view event to check the current 
	 */
	public function checkRedirect() {

		// for some reason the first arg returns a view object 
		// instead of a page obj as documented at
		// http://www.concrete5.org/documentation/developers/system/events
		$page = Page::getCurrentPage();

		// sort out our redirect logic
		$npage = self::getTargetPage($page);

		// verify that we indeed have a page object to go to
		if($npage && is_object($npage) && !$npage->isError()) {

			// send headers if created
			if ($npage->extrahead) { header($npage->extrahead); }

			//redirect
			if(!$npage->isExternalLink()) {
				header('Location: ' . Loader::Helper('navigation')->getLinkToCollection($npage, true));
			} else {
				header('Location: ' . $npage->getCollectionPointerExternalLink());
				exit;
			}

		}

	}

	/**
	 * Returns the resulting redirected target page for a given page object
	 */
	public function getTargetPage($page) {

		$npage = false;

		// see if we have an redirect attribute set
		if($redirect = $page->getCollectionAttributeValue('page_redirect')) {

			// check if we've saved a specific page id, or just a type
			if (ctype_digit($redirect)) {

				$npage = Page::getByID($redirect);
				$npage->extrahead = 'HTTP/1.1 301 Moved Permanently';

			} else {

				$pl = new PageList();
				$pl->filterByParentID($page->getCollectionID());

				switch($redirect){

					case('parent'):
						$npage = Page::getByID($page->getCollectionParentID());
						unset($pl);
						break;

					case('first'):
						$npage = $page->getFirstChild();
						unset($pl);
						break;

					case('newest'):
						$pl->sortByPublicDateDescending();
						$pages = $pl->get(1);
						$npage = $pages[0];
					
					case('random'):
						$pages = $pl->get();
						$npage = $pages[array_rand($pages)];
						break;

					default:
				}

			}

		}

		return $npage;

	}

}

?>