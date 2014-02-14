<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

class JeramyAddMultiPagePackage extends Package {

	protected $pkgHandle = 'jeramy_add_multi_page';
	protected $appVersionRequired = '5.5';
	protected $pkgVersion = '2.1.1';
	
	public function getPackageDescription() {
		return t('Add multiple pages at once.');
	}
	
	public function getPackageName() {
		return t('Add Multiple Pages');
	}
	
	public function install() {
		$pkg = parent::install();
		Loader::model('single_page');
		$db_page = SinglePage::add('/dashboard/sitemap/jeramy_add_multi_page', $pkg);
    	$db_page->update(array('cName' => 'Add Multiple Pages', 'cDescription' => 'Add multiple pages to your site at once.'));
		$this->setupDashboardIcons();
	
	}
	
	public function upgrade(){
			$this->setupDashboardIcons();
			parent::upgrade(); 
	}

	public function uninstall(){
  			parent::uninstall();
  	}
	
	
	private function setupDashboardIcons() {
	  $cak = CollectionAttributeKey::getByHandle('icon_dashboard');
	  if (is_object($cak)) {
		$iconArray = array(
		  '/dashboard/sitemap/jeramy_add_multi_page' => 'icon-plus-sign'
		);
		foreach($iconArray as $path => $icon) {
		  $sp = Page::getByPath($path);
		  if (is_object($sp) && (!$sp->isError())) {
			$sp->setAttribute('icon_dashboard', $icon);
		  }
		}
	  }
	}
}
?>