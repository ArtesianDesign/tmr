<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<body id="<?php echo ($cView) ? $cView->bodyId : $c->getCollectionHandle(); ?>" class="<?php echo ($cView) ? $cView->bodyClasses : 'view'; ?>">
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>
	
	<div id="wrapper">
	
  	<div id="main_navigation" class="row">
      <div class="twelve columns">
        <?php echo $cView->nav->site; /* creates a ul.nav */ ?>
      </div>
  	</div>
  	
    <?php
    $ha = new Area('Header');
    if ($ha->getTotalBlocksInArea() || $c->isEditMode()) {
    ?>
    <div id="header_area" class="row">
      <div class="twelve columns">
        <?php
        $ha->display($c);
        ?>
      </div>
    </div>
    <?php } //endif getTotalBlocksInArea() || $c->isEditMode() ?>