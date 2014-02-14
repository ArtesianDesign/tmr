<?php defined('C5_EXECUTE') or die(_('Access Denied.'));

class ShareYourStoryController extends Controller {

	public function on_before_render(){
		$hh = Loader::helper('html');
		$assetPath = View::getInstance()->getThemePath();
		$this->addHeaderItem($hh->css($assetPath . '/_/css/share-story.css'));
		$this->addFooterItem($hh->javascript($assetPath . '/_/js/share-story.js'));
	}

	public function submit(){
		if ($errors = $this->hasErrors()) {
			$this->set('error', $errors);
		} else {
			// lets process the story
			$this->createStory();
			$this->set('success', true);
		}
	}

	public function createStory(){

		$th = Loader::helper('text');
		$stories = Page::getByPath('/stories');
		$data['name'] = $th->entities($_REQUEST['title']);
		$data['cvIsApproved'] = false;
		$story = $stories->add(CollectionType::getByHandle('story'), $data);

		// if we have been granted rights, we import the image
		if ($_REQUEST['rights'] && !empty($_FILES['image'])) {
			Loader::library('file/importer');
			$fi = new FileImporter();
			if ($image = $fi->import($_FILES['image']['tmp_name'], $_FILES['image']['name'])) {
				// add the caption as a description for the file object
				$image->updateDescription($_REQUEST['caption']);
				// set as the page thumbnail
				$story->setAttribute('page_thumbnail', $image);
				// add to the story images fileset
				$fs = FileSet::getByName('Story Images');
				$fs->addFileToSet($image);
			}
		}

		// set a few attributes
		$story->setAttribute('author_name', $_REQUEST['name']);
		$story->setAttribute('author_email', $_REQUEST['email']);

		// insert block to the page
		$body = $story->addBlock(
			BlockType::getByHandle('content'), // blocktype
			'Main', // area
			array( // block settings
				'content' => '<p>' . nl2br($_REQUEST['story']) . '</p>'
			)
		);

	}

	public function hasErrors(){

		$vh = Loader::helper('validation/form');
		$vh->setData($_REQUEST);
		$vh->setFiles();
		$vh->addRequired('name', 'Your name is required.');
		$vh->addRequiredEmail('email', 'Please enter a valid email address.');
		$vh->addUploadedImage('image', null, !(Boolean) $_REQUEST['rights']);
		$vh->addRequired('title', 'A story title is required.');
		$vh->addRequired('story', 'Cannot submit an empty story.');

		return ($vh->test()) ? false : $vh->getError();

	}

}