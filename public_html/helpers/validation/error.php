<?php defined('C5_EXECUTE') or die(_('Access Denied.'));

class ValidationErrorHelper extends Concrete5_Helper_Validation_Error {

	/** 
	 * Outputs the HTML of an error list, with the correct style attributes/classes. This is a convenience method.
	 */
	public function output() {
		if ($this->has()) {
			echo '<div class="alert-box alert">';
			foreach($this->getList() as $error) {
				echo '<div>' . $error . '</div>';
			}
			echo '<a href="#" class="close">&times;</a>';
			echo '</div>';
		}
	}

}