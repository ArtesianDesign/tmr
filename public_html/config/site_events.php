<?php defined('C5_EXECUTE') or die(_('Access Denied.'));
Events::extend(
	'on_page_view', 
	'Artesian',
	'checkView',
	'models/artesian.php'
);