<?php          
/*
	Encrypted Email
	----------------
	@file 		encrypted_email.php
	@version 	2.0
	@date 		2011-07-05 20:06:31 -0400 (Tue, 5 Jul 2011)
	@author 	Jack Lightbody <jack.lightbody@gmail.com>
	@license 	MIT Open Source
	Copyright (c) 2011 Jack Lightbody
*/
defined('C5_EXECUTE') or die(_("Access Denied."));

class EncryptedEmailHelper{
	public function encryptEmailAddress($email, $link){
		$emailAddress=str_rot13 ($email);
		$encryptedAddress='<script type="text/javascript">document.write("<n uers=\"znvygb:'.$emailAddress.'\" ery=\"absbyybj\">".replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}))</script>'.$link.'</a>';
		return $encryptedAddress;
	}
}