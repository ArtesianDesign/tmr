<?php   
defined('C5_EXECUTE') or die("Access Denied.");

/*
Parent Area by John Liddiard (aka JohntheFish)
This is extensively based on the "Global Areas" addon by Mnkras
http://www.concrete5.org/marketplace/addons/global-areas/

This software is licensed under the terms described in the concrete5.org marketplace. 
Please find the add-on there for the latest license copy.
*/

class JlParentAreaRecursionTrapHelper {

	/*
	Check/set a count of the number of times called in a single page showing
	*/
	public function check_trap() {

		$limit = $this -> get_limit();

		// -1 = no limit
		if ($limit<0) {
			return false;	
		}

		if ($this->get_count() > $limit) {	
			throw new Exception (t("Error: maximum Parent Area count of \"%s\" exceededs limit of \"%s\". Have you created a recursive chain of ancestors and/or stacks and/or global areas?", $this -> get_count(), $limit ));
			return true;	
		}

		// limit enabled, but not exceeded
		$this->incr_count();
		return false;
	} 

	public function get_limit(){
		Loader::model('jl_parent_area_settings','jl_parent_area');
		$pas = new JlParentAreaSettings;
		return $pas -> get_use_limit();
	}

	public function get_count(){
		global $jl_parent_area_recursion_trap_cval;
		return $jl_parent_area_recursion_trap_cval;
	}

	public function incr_count(){
		global $jl_parent_area_recursion_trap_cval;
		$jl_parent_area_recursion_trap_cval ++;
		return $jl_parent_area_recursion_trap_cval;
	}

}
