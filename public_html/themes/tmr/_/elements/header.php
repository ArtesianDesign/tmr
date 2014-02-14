<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<body id="<?php echo ($cView) ? $cView->bodyId : $c->getCollectionHandle(); ?>" class="<?php echo ($cView) ? $cView->bodyClasses : 'view'; ?>">
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
<?php /*
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>
*/?>
	
	<div id="wrapper">
	
  	<div id="row_header" class="row">
      <div class="twelve columns">
        <div id="header" class="panel">
          <div id="header_photo">
            <?php 
            if ($cView->headingSlideshow) {
              echo $cView->headingSlideshow;
            } else {
              echo '<div style="height:300px;"></div>';
            } ?>
          </div>
          <div id="logo">
            <?php
            if ($ls = Stack::getByName('Logo')) {
              $ls->display();
            } else {
              echo '<h1>' . SITE . '</h1>';
            }
            ?>
          </div>
          <div id="main_nav_container">
            <div id="main_nav_inner" class="clearfix">
            <?php echo $cView->nav->site; /* creates a ul.nav */ ?>
            </div>
          </div>
          <div id="header_intro_text">
            <?php
            if ($it = Stack::getByName('Header Intro Text')) {
              $it->display();
            } 
            ?>
          </div>
          
        </div>
      </div>
  	</div>
  	