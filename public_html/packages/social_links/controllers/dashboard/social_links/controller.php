<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * @author Andrew Householder
 * @copyright Copyright (c) Andrew Householder 2011
 */

class DashboardSocialLinksController extends Controller {

	public function view() {
		$this->set('links', $this->get_links());
	}

	public function get_links() {
		Loader::model('social_link','social_links');
		return SocialLink::getAll();
	}

	public function on_before_render() {
		$html = Loader::helper('html');
		$this->addHeaderItem($html->css(BASE_URL . DIR_REL . '/' . DIRNAME_PACKAGES .'/social_links/single_pages/dashboard/social_links/view.css'));
		$this->addHeaderItem($html->javascript(BASE_URL . DIR_REL . '/' . DIRNAME_PACKAGES .'/social_links/single_pages/dashboard/social_links/view.js'));
	}

	public function update_links() {
		Loader::model('social_link','social_links');
		SocialLink::removeAll();
		foreach ($_GET['link'] as $link) {
			if (SocialLink::addLink($link['name'],$link['url'],$link['position'],$link['active'])) {
				$messages[] = 'Saved ' . $link['name'] . ' link in position '.$link['position'].'<br/>';
			} else {
				$this->set('error','Unable to save links.');
			}
		}
		echo 'Saved '.count($messages).' link(s).';
		exit;
	}

	
	public function add_link() {
		if (!$_POST['name']) {
			$error[] = 'Please input a name for this link.';
		}
		if (!$_POST['url']) {
			$error[] = 'Please input a URL for this link.';
		}
		if (!$error) {
			Loader::model('social_link','social_links');
			$link = new SocialLink();
			if ($link->addLink($_POST['name'],$_POST['url'])) {
				$this->set('message','Link added.');
			} else {
				$this->set('error','Unable to create link.');
			}
		} else {
			$this->set('error',$error);
		}
		$this->view();
	}
	
	public function remove_link() {
		Loader::model('social_link','social_links');
		if ($response = SocialLink::removeByID($_GET['lID'])) {
			$this->set('response',$response);
			echo 'Link removed.';
		} else {
			echo 'Unable to remove link.';
		}
		exit;
	}
	
}