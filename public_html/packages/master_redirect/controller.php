<?php defined('C5_EXECUTE') or die(_("Access Denied."));
/**
 * Class that is used to redirect based on a page attribute
 * @package Page Redirect
 * @author From the combined works of Michael Krasnow <mnkras@gmail.com>
 * @category Packages
 * @copyright  Copyright (c) 2012 Michael Krasnow. (http://www.mnkras.com)
 */

class MasterRedirectPackage extends Package {

	protected $pkgHandle = 'master_redirect';
	protected $appVersionRequired = '5.6';
	protected $pkgVersion = '0.1';
	
	public function getPackageDescription() {
		return t("Makes available a page selector attribute with many redirect options.");
	}
	
	public function getPackageName() {
		return t("Master Redirect");
	}
	
	public function install() {
		$pkg = parent::install();
		$this->verifyAttributeType();
		$this->confirmAttributeAssociation();
	}
	
	public function on_start() {
		$url = Loader::helper('concrete/urls')->getPackageURL(Package::getByHandle('master_redirect'));
		Events::extend('on_start', 'MasterRedirect', 'checkRedirect', DIRNAME_PACKAGES . '/' . $this->pkgHandle . '/models/master_redirect.php');
	}

	public function verifyAttributeType() {
		$pageRedirectAttributeType = AttributeType::getByHandle('page_redirect');
		if(!is_object($pageRedirectAttributeType) || !intval($pageRedirectAttributeType->getAttributeTypeID())){ 
			$collectionCategory = AttributeKeyCategory::getByHandle('collection');
			$pageRedirectAttributeType = AttributeType::add('page_redirect', t('Page Redirect'), Package::getByHandle($this->pkgHandle));
			$collectionCategory->associateAttributeKeyType(AttributeType::getByHandle('page_redirect'));
		}
	}

	public function confirmAttributeAssociation() {
		$ak = CollectionAttributeKey::getByHandle('page_redirect');
		if (!is_object($ak) || !intval($ak->getAttributeID())) {
			CollectionAttributeKey::add('page_redirect', array('akHandle' => 'page_redirect', 'akName' => t('Page Redirect'), 'akIsSearchable' => true), Package::getByHandle($this->pkgHandle));
		}
	}

}