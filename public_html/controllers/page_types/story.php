<?php defined('C5_EXECUTE') or die('Access Denied.');

require_once('global.php');
class StoryPageTypeController extends GlobalAbstractController {

	public function view(){
		if (!$story = $this->getCache('story')) {
			$c = Page::getCurrentPage();
			$story = new stdClass();
			$story->author = $c->getAttribute('author_name');
			$story->email = $c->getAttribute('author_email');
			$story->date = $c->getCollectionDateAdded('F j, Y');
			$story->image = $c->getAttribute('page_thumbnail');
		}
		$this->setAndCache('story', $story);
		parent::view();
	}

}