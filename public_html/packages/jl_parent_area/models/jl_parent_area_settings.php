<?php    
defined('C5_EXECUTE') or die("Access Denied.");

/*
Parent Area by John Liddiard (aka JohntheFish)
This is extensively based on the "Global Areas" addon by Mnkras
http://www.concrete5.org/marketplace/addons/global-areas/

This software is licensed under the terms described in the concrete5.org marketplace. 
Please find the add-on there for the latest license copy.
*/

if (!class_exists('JlParentAreaSettings')){
class JlParentAreaSettings {

	// Getters
	public function get_use_limit(){
		if (defined('PARENT_AREA_USE_LIMIT')){
			return PARENT_AREA_USE_LIMIT;
		}
	
		$pkg  = Package::getByHandle('jl_parent_area');
		return $pkg->config('PARENT_AREA_USE_LIMIT');
	}

	// Setters
	public function set_use_limit($val){
		$pkg  = Package::getByHandle('jl_parent_area');
		return $pkg->saveConfig('PARENT_AREA_USE_LIMIT',$val);
	}

	// Defaults
	public function set_defaults() {
		$this->set_use_limit(10);
	}

}
}
