<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage(); ?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />
  
	<?php Loader::element('header_required'); ?>
	
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/_/css/foundation.min.css">
  <link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/_/css/app.css">
<?php if ($c->isEditMode()) { ?>
	<link rel="stylesheet" href="<?php echo $this->getStyleSheet('typography.css')?>">
<?php } else { ?>
	<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/_/css/style.css">
	<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/_/css/fonts.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700,400italic|Oswald' rel='stylesheet' type='text/css'>
<?php } //endif ?>
  <script src="<?php echo $this->getThemePath(); ?>/_/js/libs/foundation/modernizr.foundation.js"></script>
	
</head>
