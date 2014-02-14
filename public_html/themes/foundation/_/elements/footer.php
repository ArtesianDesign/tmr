<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
    <footer>
    	<div class="row">
      	<div class="twelve columns">
        	<?php
        	$f = new GlobalArea('Footer');
        	$f->display($c);
        	?>
        </div>
      </div>
      <div class="row">
        <div id="copyright" class="twelve columns">
          &copy; 2011-<?php echo date('Y') . ' ' . SITE ?>. All rights reserved.
        </div>
      </div>
    </footer>
    
  </div><!-- #wrapper -->