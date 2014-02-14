<?php          

defined('C5_EXECUTE') or die(_("Access Denied."));

class JacksEmailObfuscatorPackage extends Package {

	protected $pkgHandle = 'jacks_email_obfuscator';
	protected $appVersionRequired = '5.3.1';
	protected $pkgVersion = '2.0';
	
	public function getPackageDescription() {
		return t("Hides your email from bots.");
	}
	
	public function getPackageName() {
		return t("Email Obfuscator");
	}
	
	public function install() {
		$pkg = parent::install();
		
		// install block		
		BlockType::installBlockTypeFromPackage('email_obfuscator', $pkg);
		
	}
	

}