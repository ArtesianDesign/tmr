<?php      
	defined('C5_EXECUTE') or die(_("Access Denied."));
	class EmailObfuscatorBlockController extends BlockController {
		

		protected $btTable = 'btEmailObfuscator';
		protected $btInterfaceWidth = "350";
		protected $btInterfaceHeight = "300";
		
		
				/** 
		 * Used for localization. If we want to localize the name/description we have to include this
		 */
		public function getBlockTypeDescription() {
			return t("Hides your email from bots.");
		}
		
		public function getBlockTypeName() {
			return t("Email Obfuscator");
		}
	}
	
?>