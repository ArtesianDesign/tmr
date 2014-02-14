<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

/*
Parent Area by John Liddiard (aka JohntheFish)
This is extensively based on the "Global Areas" addon by Mnkras
http://www.concrete5.org/marketplace/addons/global-areas/

This software is licensed under the terms described in the concrete5.org marketplace. 
Please find the add-on there for the latest license copy.
*/


class JlParentAreaPackage extends Package {

     protected $pkgHandle = 'jl_parent_area';
     protected $appVersionRequired = '5.5';
     protected $pkgVersion = '1.1'; 

     public function getPackageDescription() {
		return t('Pull areas from parent page or other ancestors into the page.');
	}

     public function getPackageName() {
         return t('Parent Area');
     }
     
     public function install() {
 		$pkg = parent::install();
		BlockType::installBlockTypeFromPackage("parent_area", $pkg);
		
		Loader::model('jl_parent_area_settings','jl_parent_area');
		$p = new JlParentAreaSettings;
		$p->set_defaults();				
     }

 
}