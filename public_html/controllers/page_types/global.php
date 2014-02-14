<?php defined('C5_EXECUTE') or die('Access Denied.');

abstract class GlobalAbstractController extends Controller {	

	static $nh, $th;

	function __construct(){
		$this->nh = Loader::helper('navigation');
		$this->th = Loader::helper('text');
	}

	public function on_start() {}

	public function on_before_render(){
		$hh = Loader::helper('html');
		$assetPath = View::getInstance()->getThemePath();
/*
		$this->addHeaderItem($hh->css($assetPath . '/_/js/libs/fancybox/jquery.fancybox.css'));
		$this->addHeaderItem(Loader::helper('html')->javascript('jquery.ui.js'));
		$this->addFooterItem($hh->javascript($assetPath . '/_/js/libs/fancybox/jquery.fancybox.pack.js'));
*/
	}

	public function view() {
		$this->set('th', $this->th);
		$this->set('cView', $this->setupView());
	}

	public function setupView() {

		global $c;

		// load helpers/models
		Loader::model('social_link','social_links');

		// prepare some variables for the page
		if (!$cView = $this->getCache('cView')) {
			$cView = new stdClass();
			$cView->bodyId = $this->th->urlify($c->getCollectionName());
			$cView->bodyClasses = $this->getClasses();
			$cView->nav = new stdClass();
			$cView->nav->site = $this->getNavigation();
			$cView->nav->left = ($c->getAttribute('hide_side_nav')) ? '' : $this->getNavigation('section');
			$cView->breadcrumbs = ($c->getAttribute('hide_breadcrumbs')) ? '' : $this->getNavigation('breadcrumbs');
			$cView->headingSlideshow = $this->getHeadingSlideshow();
			$cView->heading = $this->getPageTitle();
			$cView->description = $this->getPageDescription();
			$cView->socialLinks = SocialLink::getActive();
			$cView->layout = $this->getLayoutData();
		}

		$this->setCache('cView', $cView);
		return $cView;

	}

	// this allows us to specify which columns in the layout get rendered per pagetype
	public function getLayoutData() {
		
		$c = Page::getCurrentPage();
		$layout = new stdClass();
		$layout->handle = ($pt = $c->getCollectionTypeHandle()) ? $pt : 'view';
		$layout->content = new stdClass();

		switch ($layout->handle) {

			case('full_width'):
			case('view'):
				$layout->content->main = 'span12';
				break;

			default:
				$layout->content->main = 'span5';
				$layout->content->left = 'span7';

		}

		return $layout;
	}

	public function setAndCache($handle, $data) {

		$this->setCache($handle, $data);
		$this->set($handle, $data);

	}

	public function setCache($handle, $data) {
		return Cache::set($handle, Page::getCurrentPage()->getCollectionID(), $data);
	}

	public function getCache($handle) {

		if ($data = Cache::get($handle, Page::getCurrentPage()->getCollectionID())) {
			return $data;
		} else {
			return false;
		}

	}

	public function getClasses() {

		global $c;
		$classes = array();

		// pagetype handle
		$classes[] = str_replace('_', '-', ($handle = $c->getCollectionTypeHandle()) ? $handle : 'view');

		// if toolbar is visible
		global $cp; 
		if (is_object($cp) && $cp->canWrite()) {
			$classes[] = 'toolbar-visible';
		}

		// edit-mode styling
		$classes[] = ($c->isEditMode()) ? 'edit-mode' : '';
		
		// hide title
		$classes[] = ($c->getAttribute('hide_title')) ? 'hide-title' : '';

		return implode(' ', array_filter($classes));
		//return implode(' ', $classes);

	}

	public function getPageTitle($c = null) {
		if (!$c) { $c = Page::getCurrentPage(); }
		return ($title = $c->getAttribute('alt_title')) ? $title : $c->getCollectionName();
	}
	
	public function getPageDescription($c = null) {
	  if (!$c) $c = Page::getCurrentPage();
  	$sd = Loader::helper('sitewide_data');
  	return $sd->scrapePageForSummary($c);
	}

	public function showStack($name) {

		if (!$name) { return false; }

		$page = Page::getCurrentPage();
		$stack = Stack::getByName($name);
		if ($stack instanceof Stack) {
			$stack->display($c);
		} else {
			return false;
		}
	}

	private function getNavigation($type = 'main') {

		$cacheHandle = $this->th->sanitizeFileSystem($type);

		// if we have cache return instantly
		if ($output = $this->getCache($cacheHandle)) {

			return $output;

		} else { // otherwise build it

			switch ($type) {

				case('breadcrumbs'):
					$template         = 'templates/breadcrumbs';
					$displayPages     = 'top';
					$subPages         = 'relevant_breadcrumb';
					$subPageLevels    = 'all';
					break;

				case('links'):
					$template         = 'templates/links';
					$displayPages     = 'top';
					$subPages         = 'all';
					$subPageLevels    = 'all';
					break;

				case('main'):
					$template         = 'templates/main';
					$displayPages     = 'top';
					$subPages         = 'none';
					$subPageLevels    = 'custom';
					$subPageLevelsNum = 1;
					break;

				case('section'):
					$template         = 'templates/sidenav';
					$displayPages     = 'custom';
					$displayPagesCID  = $this->nh->getCollectionAncestor(Page::getCurrentPage());
					$subPages         = 'relevant';
					$subPageLevels    = 'custom';
					$subPageLevelsNum = 1;
					break;

				default:
					$template         = 'view';
					$displayPages     = 'custom';
					$subPages         = 'all';
					$subPageLevels    = 'custom';
					$subPageLevelsNum = 1;

			}

			// create the blocktype object
			$bt = BlockType::getByHandle('autonav');
			$bt->controller->orderBy = 'display_asc';
			$bt->controller->displayPages = $displayPages;
			$bt->controller->displayPagesCID = ($displayPagesCID) ? $displayPagesCID->getCollectionID() : HOME_CID;
			$bt->controller->displaySubPages = $subPages;
			$bt->controller->displaySubPageLevels = $subPageLevels;
			$bt->controller->displaySubPageLevelsNum = $subPageLevelsNum;

			// capture output of the block
			ob_start();
				$bt->render($template); // $template passed to the getNavigation function
				$output = ob_get_contents();
			ob_end_clean();
			
			// return the rendered item to to cache
			$this->setCache($cacheHandle, $output);

			return $output;

		}
	}

	public function getRelatedPages($template = 'view', $settings = array(), $blocktype = 'page_list') {

		$rp = BlockType::getByHandle($blocktype);
		switch ($blocktype) {
			case('autonav'):
				$rp->controller->orderBy                 = 'display_asc';
				$rp->controller->displayPages            = 'custom';
				$rp->controller->displayPagesCID         = Page::getCurrentPage()->getCollectionID();
				$rp->controller->displaySubPages         = 'all';
				$rp->controller->displaySubPageLevels    = 'all';
				break;
			case('page_list'):
			default:
				$rp->controller->orderBy        = 'display_asc';
				$rp->controller->cParentID      = Page::getCurrentPage()->getCollectionParentID();
				$rp->controller->cThis          = 0;
				$rp->controller->displayAliases = 1;
		}

		foreach ($settings as $setting => $value) {
			if (is_array($value)) {
				$rp->controller->{$setting}($value);
			} else {
				$rp->controller->{$setting} = $value;
			}
		}

		// capture output of the block
		ob_start();
			$rp->render($template); // $template passed to the getNavigation function
			$output = ob_get_contents();
		ob_end_clean();

		return $output;
		
	}
	
	public function getHeadingSlideshow() {
		if ($fs = FileSet::getByName('Heading Slideshow')){
			$ss = BlockType::getByHandle('slideshow');
			$ss->controller->fsID = $fs->getFileSetID();
			$ss->controller->playback = 'RANDOM';

			// capture output of the block
			ob_start();
				$ss->render('templates/heading');
				$output = ob_get_contents();
			ob_end_clean();

			return $output;

			// $fl = new FileList();
			// $fl->filterBySet($fs);
			// $fl->sortByFileSetDisplayOrder();
			// $files = $fl->get();
			// return $files;
		}
	}

}