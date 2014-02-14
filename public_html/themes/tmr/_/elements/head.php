<?php defined('C5_EXECUTE') or die('Access Denied.');
$c = Page::getCurrentPage();
$u = new User();
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />
  
  <!-- Start of Facebook Meta Tags by shailan  -->
  <meta property="og:title" content="<?php if ($cView->heading) echo $cView->heading; ?>"/>
  <meta property="og:type" content="website" /> 
  <meta property="og:url" content="<?php echo BASE_URL . $c->getCollectionPath(); ?>" /> 
  <?php if ($c->cID <= 1) { ?>
  <meta property="og:image" content="<?php  echo BASE_URL . $this->getThemePath() . '/_/img/icon-large-01.jpg'; ?>" />
  <?php } ?>
  <meta property="og:site_name" content="<?php echo SITE; ?>"/> 
  <meta property="og:description" content="<?php echo $cView->description; ?>" />
  <!-- End of Facebook Meta Tags -->
  
  <?php if (!$u->isLoggedIn()) { // we must load dem jQueries firstmost?>
  <script src="<?php echo $this->getThemePath(); ?>/_/js/libs/jquery.js"></script>
  <?php } ?>
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
	<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/_/css/typography.css">
  <link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/_/css/fonts.css">
  <link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/_/js/libs/fancybox/jquery.fancybox.css">
	<link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic|Oswald" rel="stylesheet" type="text/css">
  <link rel="apple-touch-icon" href="<?php echo $this->getThemePath(); ?>/_/img/apple-touch-icon.png"/>
<?php } //endif ?>

  <script src="<?php echo $this->getThemePath(); ?>/_/js/libs/foundation/modernizr.foundation.js"></script>
  
</head>
