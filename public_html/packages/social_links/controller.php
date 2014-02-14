<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Manage your social links from a dashboard page and display them with a block.
 * @author Andrew Householder <andrew@artesiandesigninc.com>
 * @copyright Copyright (c) Andrew Householder / Artesian Design 2012
 */
class SocialLinksPackage extends Package {

	protected $pkgHandle = 'social_links';
	protected $appVersionRequired = '5.4.1';
	protected $pkgVersion = '1.1';
	
	public function getPackageName() {
		return t('Social Links Manager');
	}
	
	public function getPackageDescription() {
		return t('Manage your social networking links site-wide.');
	}
	
	public function install() {
		$pkg = parent::install();
		$this->configure();		
	}

	public function upgrade(){
		$this->configure();		
		parent::upgrade();
	}

	public function configure(){
		$this->installDashboard();
		$this->importXML('blocktypes');
	}
	
	public function importXML($type){
		$pkg = Package::getByHandle($this->pkgHandle);
		$co = new Config();
		$co->setPackageObject($pkg);
		$cfgHandle = strtoupper($this->pkgHandle . '_' . $type . '_installed');
		if (!$co->get($cfgHandle)) {
			$path = $pkg->getPackagePath();
			if (file_exists($xml = $path . '/xml/' . $type . '.xml')) {
				Loader::library('content/importer');
				$ci = new ContentImporter();
				$ci->importContentFile($xml);
				$co->save($cfgHandle, true);
			}
		}
	}

	public function installDashboard(){

		// go see if we have this page already
		Loader::model('single_page');
		$path = '/dashboard/'.$this->pkgHandle.'/';
		$page = Page::getByPath($path);

		if (!$page instanceof Page || $page->error) { // make it, then.

			$page = SinglePage::add($path, Package::getByHandle($this->pkgHandle));
			$page->update(array('cName'=>$this->getPackageName(), 'cDescription'=>$this->getPackageDescription()));

		}

		return $page;

	}

}